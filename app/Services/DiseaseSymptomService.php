<?php

namespace App\Services;

class DiseaseSymptomService
{
    private array $diseases = [
        'cattle' => [
            [
                'id' => 'fmd',
                'name_en' => 'Foot and Mouth Disease (FMD)',
                'name_my' => 'ခြေနာ ပါးစပ်နာ',
                'symptoms' => ['fever', 'blisters_feet', 'blisters_mouth', 'loss_of_appetite', 'drooling', 'lameness', 'weight_loss', 'reduced_milk'],
                'causes' => 'Foot and Mouth Disease virus (FMDV) ကြောင့်ဖြစ်သည်။ Picornaviridae မျိုးနွယ်ဝင် RNA virus ဖြစ်သည်။ ကူးစက်မြန်ပြီး အဆင့်မြင့်ကူးစက်ရောဂါဖြစ်သည်။ ရောဂါကူးစက်ခံထားရသည့် တိရစ္ဆာန်များ၊ လူ၊ ပစ္စည်းကိရိယာများမှတဆင့် ကူးစက်နိုင်သည်။',
                'symptoms_detail' => '1. ခြေထောက်ရှိ ခြေချောင်းများ၊ ခြေသည်းကြားများတွင် အရည်ဖုများထွက်ခြင်း။ 2. ပါးစပ်အတွင်း၊ လျှာပေါ်တွင် အနာများဖြစ်ခြင်း။ 3. နို့အုံတွင် အရည်ဖုများထွက်ခြင်း။ 4. အစာစားနှုန်းကျခြင်း၊ ကိုယ်အလေးချိန်ကျခြင်း။ 5. နို့ထွက်နည်းခြင်း။ 6. အဖျားတက်ခြင်း။',
                'prevention' => '1. ကာကွယ်ဆေးထိုးခြင်း 2. ရောဂါကူးစက်ခံရသည့် တိရစ္ဆာန်များကို ခွဲခြားထားခြင်း 3. သန့်ရှင်းမှုထိန်းချုပ်ခြင်း 4. ပစ္စည်းကိရိယာများကို သန့်ရှင်းအောင်လုပ်ခြင်း 5. အဝင်အထွက်ထိန်းချုပ်ခြင်း',
                'treatment' => '1. အထူးကုသမှုမရှိပါ 2. ရောဂါလက္ခဏာပြေလည်စေရန် ထောက်ပံ့ကုသမှုပေးခြင်း 3. အနာကျက်စေရန် ဂရုစိုက်ခြင်း 4. ဘတ်တီးရီးယားကူးစက်မှုကို ကာကွယ်ရန် ဆေးပေးခြင်း',
                'complications' => '1. နှလုံးရောဂါ (ကလေးငယ်များတွင်) 2. နို့အုံရောင်ခြင်း 3. ခြေထောက်ပုံမှန်မဟုတ်ခြင်း',
                'transmission' => '1. ရောဂါကူးစက်ခံထားရသည့် တိရစ္ဆာန်များမှတဆင့် 2. လေမှတဆင့် 3. ပစ္စည်းကိရိယာများမှတဆင့်',
                'risk_factors' => '1. ကာကွယ်ဆေးမထိုးထားခြင်း 2. သန့်ရှင်းမှုထိန်းချုပ်မှုနည်းခြင်း 3. အဝင်အထွက်ထိန်းချုပ်မှုမရှိခြင်း',
                'urgency' => 'high',
            ],
            [
                'id' => 'brucellosis',
                'name_en' => 'Brucellosis',
                'name_my' => 'ဘရူဆဲလိုစစ်',
                'symptoms' => ['fever', 'abortion', 'infertility', 'joint_swelling', 'weight_loss', 'reduced_milk', 'retained_placenta'],
                'causes' => 'Brucella abortus ဘက်တီးရီးယားကြောင့်ဖြစ်သည်။ ဝမ်းပျက်ခြင်း၊ မျိုးပွားပြဿနာများဖြစ်စေသည်။ လူသို့ကူးစက်နိုင်သည့် zoonotic disease ဖြစ်သည်။',
                'symptoms_detail' => '1. ကိုယ်ဝန်ဆောင်အမိများတွင် ကိုယ်ဝန်ပျက်ကျခြင်း 2. ဝမ်းပျက်ခြင်း 3. အမြီးကျွံခြင်း 4. နို့ရည်အရောင်ပြောင်းခြင်း 5. အဆစ်ရောင်ခြင်း 6. အဖျားတက်ခြင်း 7. ကိုယ်အလေးချိန်ကျခြင်း',
                'prevention' => '1. ကာကွယ်ဆေးထိုးခြင်း 2. စစ်ဆေးခြင်းနှင့် ခွဲခြားခြင်း 3. နို့ချက်ခြင်းတွင် ဂရုစိုက်ခြင်း 4. သန့်ရှင်းမှုထိန်းချုပ်ခြင်း',
                'treatment' => '1. ကုသမှုမရှိပါ 2. ရောဂါရှိသည့်တိရစ္ဆာန်များကို ဖယ်ရှားခြင်း 3. ကာကွယ်ဆေးထိုးခြင်းသာ အကောင်းဆုံးဖြစ်သည်',
                'complications' => '1. ကိုယ်ဝန်ပျက်ကျခြင်း 2. မျိုးပွားပြဿနာများ 3. လူသို့ကူးစက်ခြင်း',
                'transmission' => '1. ဝမ်းပျက်ပစ္စည်းများမှတဆင့် 2. နို့ရည်မှတဆင့် 3. သွေးမှတဆင့်',
                'risk_factors' => '1. ကာကွယ်ဆေးမထိုးထားခြင်း 2. စစ်ဆေးမှုမပြုလုပ်ခြင်း 3. သန့်ရှင်းမှုနည်းခြင်း',
                'urgency' => 'high',
            ],
            [
                'id' => 'mastitis',
                'name_en' => 'Mastitis',
                'name_my' => 'နို့ရည်အမြှေးပါးရောဂါ',
                'symptoms' => ['swollen_udder', 'hot_udder', 'pain_udder', 'abnormal_milk', 'reduced_milk', 'fever', 'loss_of_appetite'],
                'causes' => 'ဘက်တီးရီးယားပိုးဝင်ခြင်းကြောင့်ဖြစ်သည်။ ညစ်ပတ်သည့်နို့စိုက်ခြင်း၊ ဒဏ်ရာရခြင်းတို့ကြောင့်ဖြစ်နိုင်သည်။',
                'symptoms_detail' => '1. နို့အုံရောင်ခြင်း၊ ပူနွေးခြင်း 2. နို့အုံနာကျင်ခြင်း 3. နို့ရည်အရောင်ပြောင်းခြင်း 4. နို့ရည်ထဲတွင် အဖြူနုရောင်အမျှင်များပါခြင်း 5. နို့ထွက်နည်းခြင်း 6. အဖျားတက်ခြင်း',
                'prevention' => '1. သန့်ရှင်းသည့်နို့စိုက်နည်း 2. နို့အုံသန့်ရှင်းမှုထိန်းချုပ်ခြင်း 3. ဒဏ်ရာမရစေရန်ဂရုစိုက်ခြင်း 4. ပုံမှန်နို့စစ်ဆေးခြင်း',
                'treatment' => '1. antibiotics ဆေးများဖြင့် ကုသခြင်း 2. နို့ညှစ်ခြင်း 3. အနာကျက်စေရန် ဂရုစိုက်ခြင်း',
                'complications' => '1. နို့အုံပျက်စီးခြင်း 2. နို့ထွက်နည်းခြင်း 3. အဆိပ်တက်ခြင်း',
                'transmission' => '1. နို့ညှစ်စက်မှတဆင့် 2. လက်များမှတဆင့် 3. ပတ်ဝန်းကျင်မှတဆင့်',
                'risk_factors' => '1. ညစ်ပတ်သည့်နို့စိုက်ခြင်း 2. ဒဏ်ရာရခြင်း 3. နို့ညှစ်စက်မှားခြင်း',
                'urgency' => 'medium',
            ],
            [
                'id' => 'lumpy_skin',
                'name_en' => 'Lumpy Skin Disease',
                'name_my' => 'အရည်ဖုရောဂါ',
                'symptoms' => ['skin_nodules', 'fever', 'swelling', 'weight_loss', 'reduced_milk', 'loss_of_appetite', 'eye_discharge'],
                'causes' => 'Lumpy Skin Disease Virus ကြောင့်ဖြစ်သည်။ ဖုန်ကောင်များမှတဆင့် ကူးစက်သည်။',
                'symptoms_detail' => '1. အရေပြားပေါ်တွင် အဖုကြီးများထွက်ခြင်း 2. အဖျားတက်ခြင်း 3. နို့ထွက်နည်းခြင်း 4. ကိုယ်အလေးချိန်ကျခြင်း 5. အစာမစားခြင်း 6. မျက်စိရောင်ခြင်း',
                'prevention' => '1. ကာကွယ်ဆေးထိုးခြင်း 2. ဖုန်ကောင်ထိန်းချုပ်ခြင်း 3. ရောဂါကူးစက်ခံထားရသည့် တိရစ္ဆာန်များကို ခွဲခြားထားခြင်း',
                'treatment' => '1. အထူးကုသမှုမရှိပါ 2. ဘတ်တီးရီးယားကူးစက်မှုကို ကာကွယ်ရန် ဆေးပေးခြင်း 3. အနာကျက်စေရန် ဂရုစိုက်ခြင်း',
                'complications' => '1. အရေပြားပျက်စီးခြင်း 2. နို့ထွက်နည်းခြင်း',
                'transmission' => '1. ဖုန်ကောင်များမှတဆင့် 2. တိုက်ရိုက်ထိတွေ့မှုမှတဆင့်',
                'risk_factors' => '1. ကာကွယ်ဆေးမထိုးထားခြင်း 2. ဖုန်ကောင်များများခြင်း',
                'urgency' => 'high',
            ],
            [
                'id' => 'respiratory',
                'name_en' => 'Respiratory Disease (Shipping Fever)',
                'name_my' => 'အသက်ရှူရောဂါ',
                'symptoms' => ['cough', 'nasal_discharge', 'fever', 'difficulty_breathing', 'loss_of_appetite', 'weight_loss', 'depression'],
                'causes' => 'Bovine Respiratory Disease complex ကြောင့်ဖြစ်သည်။ ဘက်တီးရီးယားနှင့် virus ပူးပေါင်းကူးစက်ခြင်းကြောင့်ဖြစ်သည်။',
                'symptoms_detail' => '1. အချက်ပေးခြင်း 2. နှာရည်ယိးခြင်း 3. အဖျားတက်ခြင်း 4. အသက်ရှူကျပ်ခြင်း 5. အစာမစားခြင်း 6. ကိုယ်အလေးချိန်ကျခြင်း 7. စိတ်ကျခြင်း',
                'prevention' => '1. ကာကွယ်ဆေးထိုးခြင်း 2. stress လျှော့ချခြင်း 3. သန့်ရှင်းမှုထိန်းချုပ်ခြင်း 4. လေဝင်လေထွက်ကောင်းခြင်း',
                'treatment' => '1. antibiotics ဆေးများဖြင့် ကုသခြင်း 2. အဖျားကျစေရန်ဆေးပေးခြင်း 3. အစားအစာပြောင်းလဲခြင်း',
                'complications' => '1. အဆုတ်ရောင်ခြင်း 2. သေဆုံးခြင်း',
                'transmission' => '1. လေမှတဆင့် 2. တိုက်ရိုက်ထိတွေ့မှုမှတဆင့်',
                'risk_factors' => '1. stress များခြင်း 2. လေဝင်လေထွက်မကောင်းခြင်း 3. ကာကွယ်ဆေးမထိုးထားခြင်း',
                'urgency' => 'high',
            ],
        ],
        'poultry' => [
            [
                'id' => 'newcastle',
                'name_en' => 'Newcastle Disease',
                'name_my' => 'နယူးကားစလ်ရောဂါ',
                'symptoms' => ['respiratory_distress', 'twisted_neck', 'green_diarrhea', 'paralysis', 'loss_of_appetite', 'swollen_head', 'depression'],
                'causes' => 'Newcastle Disease Virus (NDV) ကြောင့်ဖြစ်သည်။ လေမှတဆင့်ကူးစက်နိုင်သည်။ အလွန်ကူးစက်မြန်ပြီး သေဆုံးနှုန်းမြင့်သည်။',
                'symptoms_detail' => '1. အသံထွက်ခြင်း 2. အမြီးနှင့်ခြေထောက်ကွေးခြင်း 3. ဦးနှောက်ပုံမှန်မဟုတ်ခြင်း 4. ဝမ်းပျက်ခြင်း 5. အစာမစားခြင်း 6. အဖျားတက်ခြင်း',
                'prevention' => '1. ကာကွယ်ဆေးထိုးခြင်း 2. ကျက်ခြံသန့်ရှင်းမှုထိန်းချုပ်ခြင်း 3. အဝင်အထွက်ထိန်းချုပ်ခြင်း',
                'treatment' => '1. အထူးကုသမှုမရှိပါ 2. ကာကွယ်ဆေးထိုးခြင်းသာ အကောင်းဆုံးဖြစ်သည်',
                'complications' => '1. အစုလိုက်သေဆုံးခြင်း 2. ကိုယ်အလေးချိန်ကျခြင်း',
                'transmission' => '1. လေမှတဆင့် 2. ပစ္စည်းကိရိယာများမှတဆင့်',
                'risk_factors' => '1. ကာကွယ်ဆေးမထိုးထားခြင်း 2. ကျက်ခြံညစ်ပတ်ခြင်း',
                'urgency' => 'high',
            ],
            [
                'id' => 'avian_flu',
                'name_en' => 'Avian Influenza (Bird Flu)',
                'name_my' => 'ငှက်တုပ်ကွေး',
                'symptoms' => ['sudden_death', 'swollen_head', 'purple_comb', 'respiratory_distress', 'green_diarrhea', 'loss_of_appetite', 'drop_in_production'],
                'causes' => 'Influenza A virus ကြောင့်ဖြစ်သည်။ လူသို့ကူးစက်နိုင်သည့် အန္တရာယ်ရှိသည်။',
                'symptoms_detail' => '1. အစာမစားခြင်း 2. အသံထွက်ခြင်း 3. မျက်စိရောင်ခြင်း 4. ဝမ်းပျက်ခြင်း 5. ရုတ်တရက်သေဆုံးခြင်း 6. အသက်ရှူကျပ်ခြင်း',
                'prevention' => '1. ကျက်ခြံပိတ်ဆို့ခြင်း 2. သတ္တဝါများနှင့် ထိတွေ့မှုရှောင်ခြင်း 3. ကာကွယ်ဆေးထိုးခြင်း',
                'treatment' => '1. အထူးကုသမှုမရှိပါ 2. ရောဂါဖြစ်ပွားပါက အစုလိုက်ဖျက်သိမ်းရန်လိုအပ်သည်',
                'complications' => '1. အစုလိုက်သေဆုံးခြင်း 2. လူသို့ကူးစက်ခြင်း',
                'transmission' => '1. လေမှတဆင့် 2. ညစ်ပတ်သည့်ရေမှတဆင့်',
                'risk_factors' => '1. ကာကွယ်ဆေးမထိုးထားခြင်း 2. သတ္တဝါများနှင့် ထိတွေ့ခြင်း',
                'urgency' => 'high',
            ],
            [
                'id' => 'coccidiosis',
                'name_en' => 'Coccidiosis',
                'name_my' => 'ကော့စစ်ဒီယိုစစ်',
                'symptoms' => ['bloody_diarrhea', 'weight_loss', 'loss_of_appetite', 'depression', 'ruffled_feathers', 'weakness', 'sudden_death'],
                'causes' => 'Coccidia parasites ကြောင့်ဖြစ်သည်။ ညစ်ပတ်သည့်အစားအစာနှင့်ရေမှတဆင့်ကူးစက်သည်။',
                'symptoms_detail' => '1. ဝမ်းပျက်ခြင်း (သွေးပါခြင်း) 2. အစာမစားခြင်း 3. ကိုယ်အလေးချိန်ကျခြင်း 4. အဖျားတက်ခြင်း 5. အားနည်းခြင်း',
                'prevention' => '1. ကျက်ခြံသန့်ရှင်းမှုထိန်းချုပ်ခြင်း 2. ရေသန့်ရေသောက်ပေးခြင်း 3. ကာကွယ်ဆေးသုံးခြင်း',
                'treatment' => '1. Coccidiostat ဆေးများဖြင့် ကုသခြင်း 2. ရေနှင့်အစားအစာ ဂရုစိုက်ချက်ခြင်း',
                'complications' => '1. အစုလိုက်သေဆုံးခြင်း 2. ကိုယ်အလေးချိန်ကျခြင်း',
                'transmission' => '1. ညစ်ပတ်သည့်အစားအစာမှတဆင့် 2. ရေမှတဆင့်',
                'risk_factors' => '1. ကျက်ခြံညစ်ပတ်ခြင်း 2. ရေသန့်ရေမသောက်ခြင်း',
                'urgency' => 'medium',
            ],
            [
                'id' => 'bronchitis',
                'name_en' => 'Infectious Bronchitis',
                'name_my' => 'အသက်ရှူလမ်းကြောင်းရောဂါ',
                'symptoms' => ['coughing', 'sneezing', 'nasal_discharge', 'watery_eyes', 'drop_in_production', 'poor_shell_quality', 'depression'],
                'causes' => 'Coronavirus ကြောင့်ဖြစ်သည်။ လေမှတဆင့်ကူးစက်သည်။',
                'symptoms_detail' => '1. အသက်ရှူကျပ်ခြင်း 2. နှာရည်ယိးခြင်း 3. အစာမစားခြင်း 4. အမြီးကျွံခြင်း 5. အသံထွက်ခြင်း',
                'prevention' => '1. ကာကွယ်ဆေးထိုးခြင်း 2. ကျက်ခြံသန့်ရှင်းမှုထိန်းချုပ်ခြင်း 3. အဝင်အထွက်ထိန်းချုပ်ခြင်း',
                'treatment' => '1. antibioticsဖြင့် secondary infection ကိုကုသခြင်း 2. ကျန်းမာရေးထိန်းချုပ်ခြင်း',
                'complications' => '1. အသက်ရှူကျပ်ခြင်း 2. အမြီးကျွံခြင်း',
                'transmission' => '1. လေမှတဆင့် 2. ပစ္စည်းကိရိယာများမှတဆင့်',
                'risk_factors' => '1. ကာကွယ်ဆေးမထိုးထားခြင်း 2. ကျက်ခြံညစ်ပတ်ခြင်း',
                'urgency' => 'medium',
            ],
        ],
        'pig' => [
            [
                'id' => 'asf',
                'name_en' => 'African Swine Fever (ASF)',
                'name_my' => 'အာဖရိကဝက်အမြီးနာ',
                'symptoms' => ['high_fever', 'skin_lesions', 'bloody_nose', 'bloody_diarrhea', 'sudden_death', 'loss_of_appetite', 'weakness'],
                'causes' => 'African Swine Fever Virus (ASFV) ကြောင့်ဖြစ်သည်။ အလွန်ကူးစက်မြန်ပြီး အန္တရာယ်ကြီးသည်။ ကုသမှုမရှိပါ။',
                'symptoms_detail' => '1. အဖျားတက်ခြင်း 2. အရေပြားအမဲစက်ထင်ခြင်း 3. သွေးထွက်ခြင်း 4. အစာမစားခြင်း 5. ရုတ်တရက်သေဆုံးခြင်း 6. အသက်ရှူကျပ်ခြင်း',
                'prevention' => '1. ကာကွယ်ဆေးမရှိပါ 2. ဝက်များကို ထိန်းချုပ်ထားခြင်း 3. ပတ်ဝန်းကျင်သန့်ရှင်းမှုထိန်းချုပ်ခြင်း',
                'treatment' => '1. ကုသမှုမရှိပါ 2. ရောဂါဖြစ်ပွားပါက အစုလိုက်ဖျက်သိမ်းရန်လိုအပ်သည်',
                'complications' => '1. အစုလိုက်သေဆုံးခြင်း 2. စီးပွားဆုံးရှုံးခြင်း',
                'transmission' => '1. တိုက်ရိုက်ထိတွေ့မှုမှတဆင့် 2. ညစ်ပတ်သည့်အစားအစာမှတဆင့်',
                'risk_factors' => '1. ကာကွယ်ဆေးမထိုးထားခြင်း 2. သန့်ရှင်းမှုနည်းခြင်း',
                'urgency' => 'high',
            ],
            [
                'id' => 'csf',
                'name_en' => 'Classical Swine Fever (CSF)',
                'name_my' => 'ရိုးရိုးဝက်အမြီးနာ',
                'symptoms' => ['high_fever', 'loss_of_appetite', 'skin_lesions', 'diarrhea', 'vomiting', 'weakness', 'abortion'],
                'causes' => 'Classical Swine Fever Virus ကြောင့်ဖြစ်သည်။ ကူးစက်မြန်ပြီး သေဆုံးနှုန်းမြင့်သည်။',
                'symptoms_detail' => '1. အဖျားတက်ခြင်း 2. ဝမ်းပျက်ခြင်း 3. အရေပြားအမဲစက်ထင်ခြင်း 4. အစာမစားခြင်း 5. အသက်ရှူကျပ်ခြင်း',
                'prevention' => '1. ကာကွယ်ဆေးထိုးခြင်း 2. ဝက်များကို ထိန်းချုပ်ထားခြင်း 3. သန့်ရှင်းမှုထိန်းချုပ်ခြင်း',
                'treatment' => '1. ကုသမှုမရှိပါ 2. ကာကွယ်ဆေးထိုးခြင်းသာ အကောင်းဆုံးဖြစ်သည်',
                'complications' => '1. အစုလိုက်သေဆုံးခြင်း 2. မျိုးပွားပြဿနာများ',
                'transmission' => '1. တိုက်ရိုက်ထိတွေ့မှုမှတဆင့် 2. ညစ်ပတ်သည့်အစားအစာမှတဆင့်',
                'risk_factors' => '1. ကာကွယ်ဆေးမထိုးထားခြင်း 2. သန့်ရှင်းမှုနည်းခြင်း',
                'urgency' => 'high',
            ],
            [
                'id' => 'prrs',
                'name_en' => 'Porcine Reproductive and Respiratory Syndrome (PRRS)',
                'name_my' => 'ဝက်မျိုးပွားနှင့်အသက်ရှူရောဂါ',
                'symptoms' => ['respiratory_distress', 'abortion', 'mummified_piglets', 'weak_piglets', 'ear_cyanosis', 'loss_of_appetite', 'depression'],
                'causes' => 'PRRS virus ကြောင့်ဖြစ်သည်။ မျိုးပွားပြဿနာများနှင့် အသက်ရှူကျပ်ခြင်းဖြစ်စေသည်။',
                'symptoms_detail' => '1. ဝမ်းပျက်ခြင်း 2. အသက်ရှူကျပ်ခြင်း 3. အမြီးကျွံခြင်း 4. ကလေးငယ်သေဆုံးခြင်း 5. အဖျားတက်ခြင်း',
                'prevention' => '1. ကာကွယ်ဆေးထိုးခြင်း 2. biosecurity ထိန်းချုပ်ခြင်း 3. သန့်ရှင်းမှုထိန်းချုပ်ခြင်း',
                'treatment' => '1. အထူးကုသမှုမရှိပါ 2. secondary infection ကိုကုသခြင်း',
                'complications' => '1. အသက်ရှူကျပ်ခြင်း 2. မျိုးပွားပြဿနာများ',
                'transmission' => '1. တိုက်ရိုက်ထိတွေ့မှုမှတဆင့် 2. လေမှတဆင့်',
                'risk_factors' => '1. ကာကွယ်ဆေးမထိုးထားခြင်း 2. biosecurity မကောင်းခြင်း',
                'urgency' => 'high',
            ],
        ],
        'goat' => [
            [
                'id' => 'goat_pox',
                'name_en' => 'Goat Pox',
                'name_my' => 'ဆိတ်ကွဲနာ',
                'symptoms' => ['skin_lesions', 'fever', 'loss_of_appetite', 'weight_loss', 'eye_discharge', 'nasal_discharge', 'depression'],
                'causes' => 'Goat Pox Virus ကြောင့်ဖြစ်သည်။ ကူးစက်မြန်ပြီး အရေပြားပေါ်တွင် အဖုအပိမ့်များထွက်စေသည်။',
                'symptoms_detail' => '1. အရေပြားပေါ်တွင် အဖုအပိမ့်များထွက်ခြင်း 2. အဖျားတက်ခြင်း 3. အစာမစားခြင်း 4. ကိုယ်အလေးချိန်ကျခြင်း 5. မျက်စိရောင်ခြင်း',
                'prevention' => '1. ကာကွယ်ဆေးထိုးခြင်း 2. ရောဂါရှိသည့်တိရစ္ဆာန်များကို ခွဲခြားထားခြင်း 3. သန့်ရှင်းမှုထိန်းချုပ်ခြင်း',
                'treatment' => '1. အနာကျက်စေရန် ထောက်ပံ့ကုသမှုပေးခြင်း 2. ဘတ်တီးရီးယားကူးစက်မှုကိုကာကွယ်ခြင်း',
                'complications' => '1. ဘတ်တီးရီးယားကူးစက်ခြင်း 2. အရေပြားပျက်စီးခြင်း',
                'transmission' => '1. တိုက်ရိုက်ထိတွေ့မှုမှတဆင့် 2. လေမှတဆင့်',
                'risk_factors' => '1. ကာကွယ်ဆေးမထိုးထားခြင်း 2. သန့်ရှင်းမှုနည်းခြင်း',
                'urgency' => 'medium',
            ],
            [
                'id' => 'enterotoxemia',
                'name_en' => 'Enterotoxemia',
                'name_my' => 'ဝမ်းပျက်အဆိပ်တက်ရောဂါ',
                'symptoms' => ['sudden_death', 'diarrhea', 'bloating', 'fever', 'loss_of_appetite', 'weakness', 'neurological_signs'],
                'causes' => 'Clostridium perfringens ဘက်တီးရီးယားကြောင့်ဖြစ်သည်။ အစားအစာပြောင်းလဲခြင်းကြောင့်ဖြစ်နိုင်သည်။',
                'symptoms_detail' => '1. ရုတ်တရက်သေဆုံးခြင်း 2. ဝမ်းပျက်ခြင်း 3. ဗိုက်ဖောင်းခြင်း 4. အဖျားတက်ခြင်း 5. အစာမစားခြင်း',
                'prevention' => '1. ကာကွယ်ဆေးထိုးခြင်း 2. အစားအစာပြောင်းလဲမှုကို တဖြည်းဖြည်းလုပ်ဆောင်ခြင်း 3. ပုံမှန်အစားအစာကျွေးခြင်း',
                'treatment' => '1. အရေးပေါ်ကုသမှုပေးရန်လိုအပ်သည် 2. Clostridium antitoxin ပေးခြင်း',
                'complications' => '1. ရုတ်တရက်သေဆုံးခြင်း 2. အူမကြီးပျက်စီးခြင်း',
                'transmission' => '1. အစားအစာမှတဆင့် 2. ပတ်ဝန်းကျင်မှတဆင့်',
                'risk_factors' => '1. အစားအစာပြောင်းလဲမှုများခြင်း 2. ကာကွယ်ဆေးမထိုးထားခြင်း',
                'urgency' => 'high',
            ],
            [
                'id' => 'caseous_lymphadenitis',
                'name_en' => 'Caseous Lymphadenitis (CL)',
                'name_my' => 'အဆစ်ရောင်ရောဂါ',
                'symptoms' => ['swollen_lymph_nodes', 'abscesses', 'weight_loss', 'loss_of_appetite', 'fever', 'depression'],
                'causes' => 'Corynebacterium pseudotuberculosis ကြောင့်ဖြစ်သည်။ ဒဏ်ရာများမှတဆင့် ကူးစက်သည်။',
                'symptoms_detail' => '1. အဆစ်များရောင်ခြင်း 2. အဖုအပိမ့်များထွက်ခြင်း 3. အဖျားတက်ခြင်း 4. ကိုယ်အလေးချိန်ကျခြင်း',
                'prevention' => '1. သန့်ရှင်းမှုထိန်းချုပ်ခြင်း 2. ဒဏ်ရာများကို ဂရုစိုက်ကုသခြင်း 3. ကာကွယ်ဆေးထိုးခြင်း',
                'treatment' => '1. antibioticsဖြင့် ကုသခြင်း 2. အဖုများကို ဖွင့်ထုတ်ခြင်း',
                'complications' => '1. အဆစ်ပျက်စီးခြင်း 2. အရေပြားပျက်စီးခြင်း',
                'transmission' => '1. ဒဏ်ရာများမှတဆင့် 2. တိုက်ရိုက်ထိတွေ့မှုမှတဆင့်',
                'risk_factors' => '1. ဒဏ်ရာရခြင်း 2. သန့်ရှင်းမှုနည်းခြင်း',
                'urgency' => 'medium',
            ],
        ],
    ];

    private array $allSymptoms = [
        // General symptoms
        'fever' => ['label' => 'အဖျားတက်ခြင်း', 'icon' => '🌡️', 'category' => 'general'],
        'loss_of_appetite' => ['label' => 'အစာမစားခြင်း', 'icon' => '🍽️', 'category' => 'general'],
        'weight_loss' => ['label' => 'ကိုယ်အလေးချိန်ကျခြင်း', 'icon' => '⚖️', 'category' => 'general'],
        'depression' => ['label' => 'စိတ်ကျခြင်း', 'icon' => '😞', 'category' => 'general'],
        'weakness' => ['label' => 'အားနည်းခြင်း', 'icon' => '💪', 'category' => 'general'],
        'sudden_death' => ['label' => 'ရုတ်တရက်သေဆုံးခြင်း', 'icon' => '💀', 'category' => 'general'],

        // Skin symptoms
        'skin_lesions' => ['label' => 'အရေပြားပေါ် အဖုများထွက်ခြင်း', 'icon' => '🔴', 'category' => 'skin'],
        'skin_nodules' => ['label' => 'အရေပြားပေါ် အဖုကြီးများထွက်ခြင်း', 'icon' => '⚫', 'category' => 'skin'],
        'blisters_feet' => ['label' => 'ခြေထောက်ရှိ အရည်ဖုများ', 'icon' => '🦶', 'category' => 'skin'],
        'blisters_mouth' => ['label' => 'ပါးစပ်အတွင်း အနာများ', 'icon' => '👄', 'category' => 'skin'],

        // Respiratory symptoms
        'cough' => ['label' => 'အချက်ပေးခြင်း', 'icon' => '😷', 'category' => 'respiratory'],
        'coughing' => ['label' => 'အချက်ပေးခြင်း', 'icon' => '😷', 'category' => 'respiratory'],
        'sneezing' => ['label' => 'နှားချောင်းဆိုးခြင်း', 'icon' => '🤧', 'category' => 'respiratory'],
        'nasal_discharge' => ['label' => 'နှာရည်ယိးခြင်း', 'icon' => '👃', 'category' => 'respiratory'],
        'difficulty_breathing' => ['label' => 'အသက်ရှူကျပ်ခြင်း', 'icon' => '😤', 'category' => 'respiratory'],
        'respiratory_distress' => ['label' => 'အသက်ရှူကျပ်ခြင်း', 'icon' => '😤', 'category' => 'respiratory'],

        // Digestive symptoms
        'diarrhea' => ['label' => 'ဝမ်းပျက်ခြင်း', 'icon' => '💧', 'category' => 'digestive'],
        'green_diarrhea' => ['label' => 'အစိမ်းရောင်ဝမ်းပျက်ခြင်း', 'icon' => '💚', 'category' => 'digestive'],
        'bloody_diarrhea' => ['label' => 'သွေးပါဝမ်းပျက်ခြင်း', 'icon' => '🩸', 'category' => 'digestive'],
        'vomiting' => ['label' => 'အန်ခြင်း', 'icon' => '🤮', 'category' => 'digestive'],
        'bloating' => ['label' => 'ဗိုက်ဖောင်းခြင်း', 'icon' => '🎈', 'category' => 'digestive'],
        'drooling' => ['label' => 'တံထွားခြင်း', 'icon' => '💦', 'category' => 'digestive'],

        // Reproductive symptoms
        'abortion' => ['label' => 'ကိုယ်ဝန်ပျက်ကျခြင်း', 'icon' => '⚠️', 'category' => 'reproductive'],
        'infertility' => ['label' => 'မျိုးမပွားနိုင်ခြင်း', 'icon' => '❌', 'category' => 'reproductive'],
        'retained_placenta' => ['label' => 'အမြီးကျွံခြင်း', 'icon' => '🤰', 'category' => 'reproductive'],
        'mummified_piglets' => ['label' => 'ကလေးငယ်သေဆုံးခြင်း', 'icon' => '😢', 'category' => 'reproductive'],
        'weak_piglets' => ['label' => 'ကလေးငယ်အားနည်းခြင်း', 'icon' => '👶', 'category' => 'reproductive'],

        // Udder symptoms
        'swollen_udder' => ['label' => 'နို့အုံရောင်ခြင်း', 'icon' => '🔴', 'category' => 'udder'],
        'hot_udder' => ['label' => 'နို့အုံပူခြင်း', 'icon' => '🔥', 'category' => 'udder'],
        'pain_udder' => ['label' => 'နို့အုံနာကျင်ခြင်း', 'icon' => '😣', 'category' => 'udder'],
        'abnormal_milk' => ['label' => 'နို့ရည်ပုံမှန်မဟုတ်ခြင်း', 'icon' => '🥛', 'category' => 'udder'],
        'reduced_milk' => ['label' => 'နို့ထွက်နည်းခြင်း', 'icon' => '📉', 'category' => 'udder'],

        // Neurological symptoms
        'twisted_neck' => ['label' => 'လည်ပင်းကွေးခြင်း', 'icon' => '🔄', 'category' => 'neurological'],
        'paralysis' => ['label' => 'အာရုံကြောပျက်ခြင်း', 'icon' => '🦴', 'category' => 'neurological'],
        'neurological_signs' => ['label' => 'ဦးနှောက်ပုံမှန်မဟုတ်ခြင်း', 'icon' => '🧠', 'category' => 'neurological'],

        // Eye symptoms
        'eye_discharge' => ['label' => 'မျက်စိရည်ယိးခြင်း', 'icon' => '👁️', 'category' => 'eye'],
        'watery_eyes' => ['label' => 'မျက်စိရေစိုခြင်း', 'icon' => '💧', 'category' => 'eye'],
        'swollen_head' => ['label' => 'ဦးခေါင်းရောင်ခြင်း', 'icon' => '🤯', 'category' => 'eye'],

        // Other symptoms
        'lameness' => ['label' => 'ခြေပြတ်ခြင်း', 'icon' => '🦵', 'category' => 'other'],
        'joint_swelling' => ['label' => 'အဆစ်ရောင်ခြင်း', 'icon' => '🦿', 'category' => 'other'],
        'swollen_lymph_nodes' => ['label' => 'အဆစ်ရောင်ခြင်း', 'icon' => '🔴', 'category' => 'other'],
        'abscesses' => ['label' => 'အဖုများထွက်ခြင်း', 'icon' => '⭕', 'category' => 'other'],
        'skin_nodules' => ['label' => 'အရေပြားပေါ် အဖုကြီးများ', 'icon' => '⚫', 'category' => 'other'],
        'purple_comb' => ['label' => 'အမြီးပြာခြင်း', 'icon' => '🟣', 'category' => 'other'],
        'ear_cyanosis' => ['label' => 'နားအရေပြားပြာခြင်း', 'icon' => '👂', 'category' => 'other'],
        'drop_in_production' => ['label' => 'ထုတ်လုပ်မှုကျခြင်း', 'icon' => '📊', 'category' => 'other'],
        'poor_shell_quality' => ['label' => 'ဥအိမ်အရည်အသွေးကျခြင်း', 'icon' => '🥚', 'category' => 'other'],
        'ruffled_feathers' => ['label' => 'အမွှေးပါးများကော့ခြင်း', 'icon' => '🪶', 'category' => 'other'],
    ];

    public function getSymptoms(string $animalType): array
    {
        $relevantSymptomIds = [];
        foreach ($this->diseases[$animalType] ?? [] as $disease) {
            $relevantSymptomIds = array_merge($relevantSymptomIds, $disease['symptoms']);
        }
        $relevantSymptomIds = array_unique($relevantSymptomIds);

        $symptoms = [];
        foreach ($relevantSymptomIds as $id) {
            if (isset($this->allSymptoms[$id])) {
                $symptoms[$id] = $this->allSymptoms[$id];
            }
        }

        // Group by category
        $grouped = [];
        foreach ($symptoms as $id => $symptom) {
            $category = $symptom['category'];
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][$id] = $symptom;
        }

        return $grouped;
    }

    public function matchDiseases(string $animalType, array $selectedSymptoms): array
    {
        $diseases = $this->diseases[$animalType] ?? [];
        $results = [];

        foreach ($diseases as $disease) {
            $diseaseSymptoms = $disease['symptoms'];
            $matches = array_intersect($selectedSymptoms, $diseaseSymptoms);
            $matchCount = count($matches);
            $totalSymptoms = count($diseaseSymptoms);

            if ($matchCount > 0) {
                $confidence = round(($matchCount / $totalSymptoms) * 100, 1);
                $results[] = [
                    'disease' => $disease,
                    'confidence' => min($confidence, 95),
                    'matched_symptoms' => array_values($matches),
                    'match_count' => $matchCount,
                    'total_symptoms' => $totalSymptoms,
                ];
            }
        }

        // Sort by confidence (highest first)
        usort($results, function ($a, $b) {
            return $b['confidence'] <=> $a['confidence'];
        });

        return $results;
    }

    public function getAnimalTypes(): array
    {
        return [
            'cattle' => ['name' => 'နွား', 'icon' => '🐄'],
            'poultry' => ['name' => 'ကြက်', 'icon' => '🐔'],
            'pig' => ['name' => 'ဝက်', 'icon' => '🐷'],
            'goat' => ['name' => 'ဆိတ်', 'icon' => '🐐'],
        ];
    }

    public function getDiseasesByType(string $animalType): array
    {
        return $this->diseases[$animalType] ?? [];
    }

    public function getSymptomCategories(): array
    {
        return [
            'general' => 'အထွေထွေလက္ခဏာများ',
            'skin' => 'အရေပြားဆိုင်ရာ',
            'respiratory' => 'အသက်ရှူလမ်းကြောင်းဆိုင်ရာ',
            'digestive' => 'ခြေတည်ငြိမ်မှုဆိုင်ရာ',
            'reproductive' => 'မျိုးပွားဆိုင်ရာ',
            'udder' => 'နို့အုံဆိုင်ရာ',
            'neurological' => 'ဦးနှောက်/အာရုံကြောဆိုင်ရာ',
            'eye' => 'မျက်စိဆိုင်ရာ',
            'other' => 'အခြား',
        ];
    }
}
