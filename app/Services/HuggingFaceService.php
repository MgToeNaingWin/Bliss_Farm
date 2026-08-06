<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class HuggingFaceService
{
    private string $apiUrl = 'https://router.huggingface.co/v1/chat/completions';

    // Free text model for symptom analysis (via Groq)
    private string $textModel = 'openai/gpt-oss-20b:groq';

    // Free VLM for image analysis (via Z.ai)
    private string $vlmModel = 'zai-org/GLM-4.6V:zai-org';

    private string $systemPrompt = <<<'PROMPT'
You are an expert veterinary diagnostician specializing in livestock diseases in Myanmar (Burma). You have deep knowledge of cattle, poultry, pig, and goat diseases.

TASK: Given symptoms (and optionally an image), predict the top 3 most likely diseases.

RULES:
1. Reply with ONLY valid JSON. No markdown fences, no extra text.
2. All field values MUST be in Myanmar (Burmese) language, EXCEPT disease_en which is English.
3. Be specific and medically accurate. Use numbered lists in descriptions.
4. Confidence reflects true diagnostic probability (not arbitrary).
5. urgency: "high" = life-threatening/treat immediately, "medium" = serious/see vet soon, "low" = mild/monitor.

DISEASE KNOWLEDGE:
- Cattle: FMD, Brucellosis, Mastitis, Lumpy Skin Disease, Respiratory Disease (Shipping Fever), Anthrax, Blackleg, Foot Rot
- Poultry: Newcastle Disease, Avian Influenza (Bird Flu), Coccidiosis, Infectious Bronchitis, Marek's Disease, Fowl Pox, Colibacillosis
- Pig: African Swine Fever (ASF), Classical Swine Fever (CSF), PRRS, Erysipelas, Foot and Mouth Disease, Swine Influenza
- Goat: Goat Pox, Enterotoxemia, Caseous Lymphadenitis (CL), Foot and Mouth Disease, Brucellosis, PPR

JSON OUTPUT FORMAT:
{"predictions":[{"disease_en":"Disease Name","disease_my":"မြန်မာအမည်","confidence":85,"causes":"ဖြစ်စေသည့် အကြောင်းရင်း...","symptoms":"လက္ခဏာများ...","prevention":"ကာကွယ်နည်း...","treatment":"ကုသနည်း...","complications":"နောက်ဆက်တွဲ...","transmission":"ကူးစက်ပုံ...","risk_factors":"အန္တရာယ်အချက်...","urgency":"high"}]}
PROMPT;

    public function analyzeSymptoms(string $animalType, array $symptoms): ?array
    {
        $token = config('services.huggingface.token');
        if (!$token) {
            Log::warning('HF_TOKEN not configured');
            return null;
        }

        $animalTypeNames = [
            'cattle' => 'cattle (cow/bull)',
            'poultry' => 'poultry (chicken)',
            'pig' => 'pig',
            'goat' => 'goat',
        ];

        $animalName = $animalTypeNames[$animalType] ?? $animalType;
        $symptomList = implode(', ', $symptoms);

        $userMessage = "Animal type: {$animalName}\nObserved symptoms: {$symptomList}\n\nPredict the top 3 most likely diseases. Provide comprehensive Myanmar descriptions for each field. Be medically accurate.";

        return $this->callApi($this->textModel, $userMessage, $token, 30);
    }

    public function analyzeImage(string $imagePath, string $animalType, ?array $symptoms = null): ?array
    {
        $token = config('services.huggingface.token');
        if (!$token) {
            Log::warning('HF_TOKEN not configured');
            return null;
        }

        $imageData = file_get_contents($imagePath);
        if ($imageData === false) {
            Log::error('Failed to read image: ' . $imagePath);
            return null;
        }

        $base64Image = base64_encode($imageData);
        $mimeType = mime_content_type($imagePath) ?: 'image/jpeg';

        $animalTypeNames = [
            'cattle' => 'cattle (cow/bull)',
            'poultry' => 'poultry (chicken)',
            'pig' => 'pig',
            'goat' => 'goat',
        ];

        $animalName = $animalTypeNames[$animalType] ?? $animalType;

        $userMessage = "Animal type: {$animalName}\n\nAnalyze this image for livestock disease. Look for: skin lesions, nodules, discharge, swelling, abnormal coloring, lesions in mouth/feet, respiratory distress signs, diarrhea, feather/skin condition, behavioral abnormalities.";

        if ($symptoms && count($symptoms) > 0) {
            $userMessage .= "\n\nAdditional observed symptoms: " . implode(', ', $symptoms);
        }

        $userMessage .= "\n\nPredict the top 3 most likely diseases. Provide comprehensive Myanmar descriptions. Be medically accurate.";

        return $this->callApiWithImage($this->vlmModel, $userMessage, $base64Image, $mimeType, $token, 60);
    }

    private function callApi(string $model, string $userMessage, string $token, int $timeout): ?array
    {
        $payload = json_encode([
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $this->systemPrompt],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'max_tokens' => 4096,
            'temperature' => 0.2,
            'stream' => false,
        ]);

        return $this->executeCurl($payload, $token, $timeout);
    }

    private function callApiWithImage(string $model, string $userMessage, string $base64Image, string $mimeType, string $token, int $timeout): ?array
    {
        $payload = json_encode([
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $this->systemPrompt],
                ['role' => 'user', 'content' => [
                    ['type' => 'text', 'text' => $userMessage],
                    ['type' => 'image_url', 'image_url' => [
                        'url' => 'data:' . $mimeType . ';base64,' . $base64Image,
                    ]],
                ]],
            ],
            'max_tokens' => 4096,
            'temperature' => 0.2,
            'stream' => false,
        ]);

        return $this->executeCurl($payload, $token, $timeout);
    }

    private function executeCurl(string $payload, string $token, int $timeout): ?array
    {
        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
            ],
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($result === false || $error) {
            Log::error('HF API cURL error', ['error' => $error]);
            return null;
        }

        if ($httpCode !== 200) {
            Log::error('HF API HTTP error', ['status' => $httpCode, 'body' => substr($result, 0, 500)]);
            return null;
        }

        $data = json_decode($result, true);
        if (!$data) {
            Log::error('HF API JSON decode error', ['raw' => substr($result, 0, 500)]);
            return null;
        }

        return $this->parseResponse($data);
    }

    private function parseResponse(array $data): ?array
    {
        try {
            $content = $data['choices'][0]['message']['content'] ?? null;
            if (!$content) {
                return null;
            }

            $content = trim($content);
            if (str_starts_with($content, '```')) {
                $content = preg_replace('/^```json\s*/', '', $content);
                $content = preg_replace('/\s*```$/', '', $content);
            }

            $jsonStart = strpos($content, '{');
            $jsonEnd = strrpos($content, '}');
            if ($jsonStart !== false && $jsonEnd !== false) {
                $content = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);
            }

            $parsed = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('HF JSON parse error', ['content' => substr($content, 0, 500), 'error' => json_last_error_msg()]);
                return null;
            }

            return $parsed;
        } catch (\Exception $e) {
            Log::error('HF response parse exception', ['message' => $e->getMessage()]);
            return null;
        }
    }
}
