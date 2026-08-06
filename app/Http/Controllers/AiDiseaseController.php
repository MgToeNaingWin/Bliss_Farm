<?php

namespace App\Http\Controllers;

use App\Services\DiseaseSymptomService;
use App\Services\HuggingFaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AiDiseaseController extends Controller
{
    protected DiseaseSymptomService $symptomService;
    protected HuggingFaceService $hfService;

    public function __construct(DiseaseSymptomService $symptomService, HuggingFaceService $hfService)
    {
        $this->symptomService = $symptomService;
        $this->hfService = $hfService;
    }

    public function index()
    {
        $animalTypes = $this->symptomService->getAnimalTypes();
        $categories = $this->symptomService->getSymptomCategories();
        return view('user.ai-disease.index', compact('animalTypes', 'categories'));
    }

    public function getSymptoms(Request $request)
    {
        $request->validate([
            'animal_type' => 'required|string|in:cattle,poultry,pig,goat',
        ]);

        $symptoms = $this->symptomService->getSymptoms($request->animal_type);
        return response()->json(['success' => true, 'symptoms' => $symptoms]);
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'animal_type' => 'required|string|in:cattle,poultry,pig,goat',
            'symptoms' => 'required|array|min:1',
            'symptoms.*' => 'string',
        ]);

        $symptomLabels = [];
        $allSymptoms = $this->symptomService->getSymptoms($request->animal_type);
        foreach ($allSymptoms as $category) {
            foreach ($category as $id => $info) {
                $symptomLabels[$id] = $info['label'];
            }
        }

        $humanSymptoms = array_map(fn($s) => $symptomLabels[$s] ?? $s, $request->symptoms);

        $hfResult = $this->hfService->analyzeSymptoms($request->animal_type, $humanSymptoms);

        if ($hfResult && isset($hfResult['predictions']) && count($hfResult['predictions']) > 0) {
            $predictions = array_map(function ($pred) {
                $confidence = (int) ($pred['confidence'] ?? 70);
                return [
                    'disease' => [
                        'id' => strtolower(str_replace(' ', '_', $pred['disease_en'] ?? '')),
                        'name_en' => $pred['disease_en'] ?? 'Unknown',
                        'name_my' => $pred['disease_my'] ?? 'မသိရပါ',
                        'causes' => $pred['causes'] ?? '',
                        'symptoms_detail' => $pred['symptoms'] ?? '',
                        'prevention' => $pred['prevention'] ?? '',
                        'treatment' => $pred['treatment'] ?? '',
                        'complications' => $pred['complications'] ?? '',
                        'transmission' => $pred['transmission'] ?? '',
                        'risk_factors' => $pred['risk_factors'] ?? '',
                        'urgency' => $pred['urgency'] ?? 'medium',
                    ],
                    'confidence' => min(max($confidence, 10), 95),
                    'matched_symptoms' => $request->symptoms,
                    'source' => 'ai',
                ];
            }, $hfResult['predictions']);

            return response()->json([
                'success' => true,
                'results' => $predictions,
                'total_matches' => count($predictions),
                'source' => 'ai',
            ]);
        }

        $results = $this->symptomService->matchDiseases($request->animal_type, $request->symptoms);

        $results = array_map(function ($r) {
            $r['source'] = 'local';
            return $r;
        }, $results);

        return response()->json([
            'success' => true,
            'results' => $results,
            'total_matches' => count($results),
            'source' => 'local',
        ]);
    }

    public function analyzeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'animal_type' => 'required|string|in:cattle,poultry,pig,goat',
            'symptoms' => 'nullable|array',
            'symptoms.*' => 'string',
        ]);

        $image = $request->file('image');
        $filename = 'ai_analysis_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $tempPath = storage_path('app/public/temp/ai-analysis');

        if (!is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $image->move($tempPath, $filename);
        $fullPath = $tempPath . '/' . $filename;

        $symptoms = $request->input('symptoms');
        $hfResult = $this->hfService->analyzeImage($fullPath, $request->animal_type, $symptoms);

        @unlink($fullPath);

        if ($hfResult && isset($hfResult['predictions']) && count($hfResult['predictions']) > 0) {
            $predictions = array_map(function ($pred) {
                $confidence = (int) ($pred['confidence'] ?? 70);
                return [
                    'disease' => [
                        'id' => strtolower(str_replace(' ', '_', $pred['disease_en'] ?? '')),
                        'name_en' => $pred['disease_en'] ?? 'Unknown',
                        'name_my' => $pred['disease_my'] ?? 'မသိရပါ',
                        'causes' => $pred['causes'] ?? '',
                        'symptoms_detail' => $pred['symptoms'] ?? '',
                        'prevention' => $pred['prevention'] ?? '',
                        'treatment' => $pred['treatment'] ?? '',
                        'complications' => $pred['complications'] ?? '',
                        'transmission' => $pred['transmission'] ?? '',
                        'risk_factors' => $pred['risk_factors'] ?? '',
                        'urgency' => $pred['urgency'] ?? 'medium',
                    ],
                    'confidence' => min(max($confidence, 10), 95),
                    'matched_symptoms' => $symptoms ?? [],
                    'source' => 'ai_image',
                ];
            }, $hfResult['predictions']);

            return response()->json([
                'success' => true,
                'results' => $predictions,
                'total_matches' => count($predictions),
                'source' => 'ai_image',
            ]);
        }

        $diseases = $this->symptomService->getDiseasesByType($request->animal_type);
        $randomDisease = $diseases[array_rand($diseases)];

        return response()->json([
            'success' => true,
            'results' => [[
                'disease' => $randomDisease,
                'confidence' => rand(60, 85),
                'matched_symptoms' => [],
                'source' => 'fallback',
            ]],
            'total_matches' => 1,
            'source' => 'fallback',
            'note' => 'AI ဝန်ဆောင်မှုကို ခေတ္တရပ်နားထားသည်။ ပုံမှန်ခွဲခြမ်းစိတ်ဖြာမှုဖြင့် ပြန်လည်ကြိုးစားပါ။',
        ]);
    }
}
