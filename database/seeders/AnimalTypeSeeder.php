<?php

namespace Database\Seeders;

use App\Models\AnimalType;
use Illuminate\Database\Seeder;

class AnimalTypeSeeder extends Seeder
{
    public function run(): void
    {
        AnimalType::query()->delete();

        $types = [
            ['title' => 'ကြက်', 'desc' => 'အသားတိုးကြက်နှင့် ဥစားကြက်များ မွေးမြူခြင်း၊ ကြက်ဥထုတ်လုပ်ခြင်းနှင့် ကြက်အသားထုတ်လုပ်ခြင်း လုပ်ငန်းများ',
             'img' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=600&q=80'],
            ['title' => 'ဝက်', 'desc' => 'ဝက်များကို အသားထုတ်လုပ်ရေးအတွက် မွေးမြူခြင်းနှင့် ဝက်အစာထုတ်လုပ်ခြင်း လုပ်ငန်းများ',
             'img' => 'https://images.unsplash.com/photo-1604848698030-c434ba08ece1?w=600&q=80'],
            ['title' => 'နွား', 'desc' => 'နွားနို့ထုတ်လုပ်ခြင်း၊ အသားထုတ်လုပ်ခြင်းနှင့် နွားမျိုးကောင်းများ မွေးမြူခြင်း လုပ်ငန်းများ',
             'img' => 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=600&q=80'],
            ['title' => 'ဆိတ်', 'desc' => 'ဆိတ်အသားထုတ်လုပ်ခြင်း၊ ဆိတ်နို့ထုတ်လုပ်ခြင်းနှင့် ဆိတ်မွေးမြူခြင်း လုပ်ငန်းများ',
             'img' => 'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?w=600&q=80'],
            ['title' => 'ဘဲ', 'desc' => 'ဘဲများကို အသားနှင့် ဥထုတ်လုပ်ရေးအတွက် မွေးမြူခြင်း လုပ်ငန်းများ',
             'img' => 'https://images.unsplash.com/photo-1580405885664-46ff7225c391?w=600&q=80'],
            ['title' => 'ငါး', 'desc' => 'ရေငါးများကို ရေကန်၊ ဇလင်းနှင့် ရေတံခါးများတွင် မွေးမြူခြင်း လုပ်ငန်းများ',
             'img' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80'],
            ['title' => 'ကျွဲ', 'desc' => 'ကျွဲများကို လယ်ယာလုပ်ငန်းနှင့် အသားထုတ်လုပ်ရေးအတွက် မွေးမြူခြင်း လုပ်ငန်းများ',
             'img' => 'https://images.unsplash.com/photo-1527153857715-3908f2bae5e8?w=600&q=80'],
            ['title' => 'ဘဲဥ', 'desc' => 'ဘဲဥများကို အစားအစောကုန်အဖြစ် ထုတ်လုပ်ခြင်းနှင့် ဘဲဥအမြှုပ်ထုတ်လုပ်ခြင်း လုပ်ငန်းများ',
             'img' => 'https://images.unsplash.com/photo-1569288052389-dac9b00c9d89?w=600&q=80'],
        ];

        $dir = public_path('animalType');
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        foreach ($types as $i => $t) {
            $fileName = null;
            try {
                $content = file_get_contents($t['img']);
                if ($content !== false) {
                    $fileName = 'animal_' . ($i + 1) . '.jpg';
                    file_put_contents($dir . '/' . $fileName, $content);
                }
            } catch (\Exception $e) { $fileName = null; }

            AnimalType::create([
                'type_title' => $t['title'],
                'type_desc' => $t['desc'],
                'type_img' => $fileName,
            ]);
        }

        $this->command->info('✅ ' . count($types) . ' animal types with images seeded.');
    }
}
