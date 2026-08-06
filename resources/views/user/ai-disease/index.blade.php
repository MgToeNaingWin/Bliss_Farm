@extends('user.layouts.master')

@section('bdy')
<style>
    .reveal { opacity: 0; transform: translateY(20px); transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }
    .symptom-chip { transition: all 0.2s ease; cursor: pointer; }
    .symptom-chip:hover { transform: translateY(-2px); }
    .symptom-chip.selected { background: #059669; color: white; border-color: #059669; }
    .result-card { animation: slideUp 0.5s ease forwards; }
    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .gradient-text { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 40%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .upload-zone { transition: all 0.3s ease; }
    .upload-zone.dragover { border-color: #059669; background: #ecfdf5; transform: scale(1.02); }
    .upload-zone:hover { border-color: #10b981; background: #f0fdf4; }
    .tab-btn.active { background: #059669; color: white; }
    @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; transition: none; } }
</style>

<!-- ══ HERO ══ -->
<section class="relative overflow-hidden">
    <div class="relative bg-gradient-to-br from-emerald-800 via-emerald-900 to-emerald-950 text-white rounded-b-[2rem] px-6 sm:px-10 py-8 sm:py-10 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
        <div class="absolute -right-20 -top-20 w-72 h-72 bg-amber-400/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 max-w-4xl">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/15 rounded-full px-3 py-1 mb-3">
                <i class="fa-solid fa-robot text-amber-300 text-[10px]"></i>
                <span class="font-[Playfair_Display] text-amber-200 text-xs italic">AI Disease Detection</span>
            </div>
            <h1 class="font-[Bricolage_Grotesque] text-2xl sm:text-3xl font-extrabold leading-tight tracking-tight">
                AI <span class="gradient-text">ရောဂါခွဲခြမ်းစိတ်ဖြာခြင်း</span>
            </h1>
            <p class="text-emerald-100/60 text-sm mt-2 max-w-xl">ပုံတင်၍ သို့မဟုတ် လက္ခဏာများရွေးချယ်၍ ရောဂါအမျိုးအစား၊ အကြောင်းရင်း၊ ကာကွယ်နည်းနှင့် ကုသနည်းများကို ခွဲခြမ်းစိတ်ဖြာပါ။</p>
        </div>
    </div>
</section>

<!-- ══ MAIN CONTENT ══ -->
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-4 relative z-10 pb-16">

    <!-- Step 1: Animal Type Selection -->
    <div class="reveal bg-white border border-stone-100 rounded-2xl p-6 sm:p-8 shadow-sm mt-6">
        <h2 class="font-[Bricolage_Grotesque] text-lg font-bold text-stone-800 mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-emerald-100 text-emerald-700 rounded-lg flex items-center justify-center text-sm font-bold">၁</span>
            တိရစ္ဆာန်အမျိုးအစား ရွေးပါ
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach($animalTypes as $key => $type)
                <label class="animal-type-option relative cursor-pointer">
                    <input type="radio" name="animal_type" value="{{ $key }}" class="peer hidden" {{ $key === 'cattle' ? 'checked' : '' }}>
                    <div class="border-2 border-stone-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 rounded-2xl p-5 text-center transition-all hover:border-emerald-300 hover:shadow-md">
                        <span class="text-4xl block mb-2">{{ $type['icon'] }}</span>
                        <span class="text-sm font-bold text-stone-700 peer-checked:text-emerald-700">{{ $type['name'] }}</span>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Step 2: Choose Method (Image or Symptoms) -->
    <div class="reveal bg-white border border-stone-100 rounded-2xl p-6 sm:p-8 shadow-sm mt-6">
        <h2 class="font-[Bricolage_Grotesque] text-lg font-bold text-stone-800 mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-emerald-100 text-emerald-700 rounded-lg flex items-center justify-center text-sm font-bold">၂</span>
            ခွဲခြမ်းစိတ်ဖြာပုံ ရွေးပါ
        </h2>

        <!-- Tab Buttons -->
        <div class="flex gap-2 mb-6">
            <button type="button" id="tabImage" class="tab-btn active flex-1 sm:flex-none px-6 py-3 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-2 border-2 border-emerald-500">
                <i class="fa-solid fa-image"></i> ပုံဖြင့် ခွဲခြမ်းရန်
            </button>
            <button type="button" id="tabSymptoms" class="tab-btn flex-1 sm:flex-none px-6 py-3 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-2 border-2 border-stone-200 text-stone-600 hover:border-emerald-300">
                <i class="fa-solid fa-list-check"></i> လက္ခဏာဖြင့် ခွဲခြမ်းရန်
            </button>
        </div>

        <!-- Tab: Image Upload -->
        <div id="panelImage" class="tab-panel">
            <form id="imageForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="animal_type" id="imageAnimalType" value="cattle">

                <div id="uploadZone" class="upload-zone border-2 border-dashed border-stone-200 rounded-2xl p-8 text-center cursor-pointer transition-all">
                    <input type="file" name="image" id="imageInput" accept="image/*" class="hidden">
                    <div id="uploadPlaceholder">
                        <div class="w-16 h-16 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-stone-700 mb-1">တိရစ္ဆာန်ပုံကို ဤနေရာတွင် ဆွဲထည့်ပါ</p>
                        <p class="text-xs text-stone-400">သို့မဟုတ် ကလစ်နှိပ်၍ ရွေးချယ်ပါ</p>
                        <p class="text-[10px] text-stone-300 mt-2">JPG, PNG (အများဆုံး 5MB)</p>
                    </div>
                    <div id="imagePreview" class="hidden">
                        <img id="previewImg" src="" alt="Preview" class="max-h-64 mx-auto rounded-xl object-contain">
                        <button type="button" id="removeImage" class="mt-3 text-xs text-red-500 hover:text-red-600 font-semibold">
                            <i class="fa-solid fa-trash mr-1"></i> ဖျက်ရန်
                        </button>
                    </div>
                </div>

                <button type="submit" id="imageAnalyzeBtn" disabled
                        class="mt-4 w-full bg-emerald-700 hover:bg-emerald-600 disabled:bg-stone-300 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-magnifying-glass"></i> ပုံဖြင့် ခွဲခြမ်းရန်
                </button>
            </form>
        </div>

        <!-- Tab: Symptom Selection -->
        <div id="panelSymptoms" class="tab-panel hidden">
            <p class="text-xs text-stone-500 mb-4">တိရစ္ဆာန်တွင် တွေ့နေရသည့် လက္ခဏာများကို နှိပ်၍ ရွေးချယ်ပါ (အနည်းဆုံး ၁ ခု ရွေးရန်လိုအပ်သည်)</p>

            <div id="symptomsLoading" class="text-center py-8">
                <div class="w-12 h-12 border-4 border-emerald-200 border-t-emerald-600 rounded-full mx-auto mb-3 animate-spin"></div>
                <p class="text-sm text-stone-500">လက္ခဏာများ ရယူနေသည်...</p>
            </div>

            <div id="symptomsList" class="hidden space-y-5"></div>

            <button id="symptomAnalyzeBtn" disabled
                    class="mt-4 w-full bg-emerald-700 hover:bg-emerald-600 disabled:bg-stone-300 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-magnifying-glass"></i> လက္ခဏာဖြင့် ခွဲခြမ်းရန်
                <span id="selectedCount" class="bg-white/20 text-xs px-2 py-0.5 rounded-full">(၀)</span>
            </button>
        </div>
    </div>

    {{-- Loading State --}}
    <div id="loadingState" class="hidden mt-6">
        <div class="bg-white border border-stone-100 rounded-2xl p-8 text-center shadow-sm">
            <div class="w-16 h-16 border-4 border-emerald-200 border-t-emerald-600 rounded-full mx-auto mb-4 animate-spin"></div>
            <p class="text-sm font-semibold text-stone-700">ရောဂါများကို ခွဲခြမ်းစိတ်ဖြာနေသည်...</p>
        </div>
    </div>

    {{-- Image Result --}}
    <div id="imageResult" class="hidden mt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-[Bricolage_Grotesque] text-lg font-bold text-stone-800 flex items-center gap-2">
                <i class="fa-solid fa-image text-emerald-600"></i> ပုံခွဲခြမ်းစိတ်ဖြာမှု ရလဒ်
            </h2>
            <button onclick="resetImageForm()" class="text-xs text-stone-500 hover:text-emerald-600 font-semibold flex items-center gap-1">
                <i class="fa-solid fa-rotate-right"></i> အသစ်တင်ရန်
            </button>
        </div>
        <div id="imageResultContent"></div>
    </div>

    {{-- Symptom Results --}}
    <div id="symptomResults" class="hidden mt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-[Bricolage_Grotesque] text-lg font-bold text-stone-800 flex items-center gap-2">
                <i class="fa-solid fa-chart-bar text-emerald-600"></i> လက္ခဏာခွဲခြမ်းစိတ်ဖြာမှု ရလဒ်များ
            </h2>
            <button onclick="resetSymptomForm()" class="text-xs text-stone-500 hover:text-emerald-600 font-semibold flex items-center gap-1">
                <i class="fa-solid fa-rotate-right"></i> အသစ်ရှာဖွေရန်
            </button>
        </div>
        <div id="symptomResultsList" class="space-y-4"></div>
    </div>

    {{-- Disclaimer --}}
    <div class="mt-8 bg-amber-50/60 border border-amber-200 rounded-2xl p-4 flex items-start gap-3">
        <span class="text-xl mt-0.5 shrink-0">💡</span>
        <div class="text-xs sm:text-sm text-amber-900 leading-relaxed">
            <span class="font-bold">သတိပြုရန် -</span> ဤခွဲခြမ်းစိတ်ဖြာမှုသည် ကနဦးလမ်းညွှန်အတွက်သာဖြစ်ပါသည်။ ပိုတိကျသည့် ရလဒ်အတွက် ပုံနှင့် လက္ခဏာနှစ်ခုလုံးကို အသုံးပြုပါ။ တိကျသည့် ရောဂါရှာဖွေခြင်းအတွက် တိရစ္ဆာန်ဆေးကုဆရာဝန်နှင့် တိုင်ပင်ပါ။
        </div>
    </div>
</div>

<script>
var selectedSymptoms = [];
var currentTab = 'image';

document.addEventListener('DOMContentLoaded', function() {
    // Reveal animation
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) { if (e.isIntersecting) e.target.classList.add('active'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(function(el) { observer.observe(el); });

    // Tab switching
    document.getElementById('tabImage').addEventListener('click', function() { switchTab('image'); });
    document.getElementById('tabSymptoms').addEventListener('click', function() { switchTab('symptoms'); });

    // Animal type change
    document.querySelectorAll('input[name="animal_type"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.getElementById('imageAnimalType').value = this.value;
            loadSymptoms(this.value);
            selectedSymptoms = [];
            updateSymptomButton();
        });
    });

    // Image upload handlers
    setupImageUpload();

    // Load initial symptoms
    loadSymptoms('cattle');
});

function switchTab(tab) {
    currentTab = tab;
    var tabImage = document.getElementById('tabImage');
    var tabSymptoms = document.getElementById('tabSymptoms');
    var panelImage = document.getElementById('panelImage');
    var panelSymptoms = document.getElementById('panelSymptoms');

    if (tab === 'image') {
        tabImage.classList.add('active');
        tabImage.classList.add('border-emerald-500');
        tabImage.classList.remove('border-stone-200');
        tabSymptoms.classList.remove('active');
        tabSymptoms.classList.remove('border-emerald-500');
        tabSymptoms.classList.add('border-stone-200');
        panelImage.classList.remove('hidden');
        panelSymptoms.classList.add('hidden');
    } else {
        tabSymptoms.classList.add('active');
        tabSymptoms.classList.add('border-emerald-500');
        tabSymptoms.classList.remove('border-stone-200');
        tabImage.classList.remove('active');
        tabImage.classList.remove('border-emerald-500');
        tabImage.classList.add('border-stone-200');
        panelSymptoms.classList.remove('hidden');
        panelImage.classList.add('hidden');
    }
}

// Image Upload Functions
function setupImageUpload() {
    var uploadZone = document.getElementById('uploadZone');
    var imageInput = document.getElementById('imageInput');
    var imageAnalyzeBtn = document.getElementById('imageAnalyzeBtn');
    var uploadPlaceholder = document.getElementById('uploadPlaceholder');
    var imagePreview = document.getElementById('imagePreview');
    var previewImg = document.getElementById('previewImg');
    var removeImage = document.getElementById('removeImage');

    uploadZone.addEventListener('click', function() { imageInput.click(); });

    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });

    uploadZone.addEventListener('dragleave', function() {
        uploadZone.classList.remove('dragover');
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        var files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            handleImageSelect(files[0]);
        }
    });

    imageInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) handleImageSelect(e.target.files[0]);
    });

    removeImage.addEventListener('click', function(e) {
        e.stopPropagation();
        imageInput.value = '';
        uploadPlaceholder.classList.remove('hidden');
        imagePreview.classList.add('hidden');
        imageAnalyzeBtn.disabled = true;
    });

    function handleImageSelect(file) {
        if (!file.type.startsWith('image/')) return;
        if (file.size > 5 * 1024 * 1024) { alert('ဖိုင်အရွယ်အစား 5MB ထက်မကျော်ရန်လိုအပ်ပါသည်။'); return; }
        var reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            uploadPlaceholder.classList.add('hidden');
            imagePreview.classList.remove('hidden');
            imageAnalyzeBtn.disabled = false;
        };
        reader.readAsDataURL(file);
    }

    document.getElementById('imageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var btn = document.getElementById('imageAnalyzeBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin"></i> ခွဲခြမ်းနေသည်...';
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('imageResult').classList.add('hidden');

        fetch('{{ route("aiDisease.analyzeImage") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            document.getElementById('loadingState').classList.add('hidden');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> ပုံဖြင့် ခွဲခြမ်းရန်';
            if (data.success) displayImageResult(data);
        })
        .catch(function() {
            document.getElementById('loadingState').classList.add('hidden');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> ပုံဖြင့် ခွဲခြမ်းရန်';
            alert('ခွဲခြမ်းစိတ်ဖြာရာတွင် အမှားတစ်ခုဖြစ်ပေါ်ခဲ့ပါသည်။');
        });
    });
}

function displayImageResult(data) {
    var container = document.getElementById('imageResultContent');
    var results = data.results || [];
    var html = '';

    if (data.note) {
        html += `<div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4"><p class="text-xs text-amber-700"><i class="fa-solid fa-circle-info mr-1"></i> ${data.note}</p></div>`;
    }

    var sourceLabel = data.source === 'ai_image' ? 'AI ပုံခွဲခြမ်းမှု' : 'ခွဲခြမ်းမှု';
    html += `<div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3 mb-4 flex items-center gap-2"><span class="w-2 h-2 bg-emerald-500 rounded-full"></span><p class="text-xs text-emerald-700 font-semibold">${sourceLabel}</p></div>`;

    results.forEach(function(result, index) {
        var disease = result.disease;
        var confidence = result.confidence;
        var urgencyColor = disease.urgency === 'high' ? 'red' : 'amber';
        var urgencyText = disease.urgency === 'high' ? 'အရေးပေါ်' : 'အလယ်အလတ်';

        html += `
        <div class="result-card bg-white border border-stone-100 rounded-2xl overflow-hidden shadow-sm mb-4" style="animation-delay: ${index * 0.1}s">
            <div class="p-5 border-b border-stone-100 bg-gradient-to-r from-emerald-50 to-white">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-0.5 rounded-md">${confidence}% ခန့်မှန်းချက်</span>
                            <span class="bg-${urgencyColor}-100 text-${urgencyColor}-700 text-[10px] font-bold px-2 py-0.5 rounded-md">${urgencyText}</span>
                        </div>
                        <h3 class="font-[Bricolage_Grotesque] text-xl font-bold text-stone-900">${disease.name_my}</h3>
                        <p class="text-sm text-stone-500">${disease.name_en}</p>
                    </div>
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center shrink-0"><span class="text-xl font-bold text-emerald-700">${index + 1}</span></div>
                </div>
            </div>
            <div class="p-5 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-blue-50/50 rounded-xl p-4"><h4 class="text-xs font-bold text-blue-800 mb-2">အကြောင်းရင်း</h4><p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">${disease.causes}</p></div>
                    <div class="bg-purple-50/50 rounded-xl p-4"><h4 class="text-xs font-bold text-purple-800 mb-2">ကုသနည်း</h4><p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">${disease.treatment}</p></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-emerald-50/50 rounded-xl p-4"><h4 class="text-xs font-bold text-emerald-800 mb-2">ကာကွယ်နည်း</h4><p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">${disease.prevention}</p></div>
                    <div class="bg-cyan-50/50 rounded-xl p-4"><h4 class="text-xs font-bold text-cyan-800 mb-2">ကူးစက်ပုံ</h4><p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">${disease.transmission}</p></div>
                </div>
                <div class="bg-orange-50/50 rounded-xl p-4"><h4 class="text-xs font-bold text-orange-800 mb-2">နောက်ဆက်တွဲပြဿနာများ</h4><p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">${disease.complications}</p></div>
            </div>
        </div>`;
    });

    container.innerHTML = html;
    document.getElementById('imageResult').classList.remove('hidden');
    document.getElementById('imageResult').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function resetImageForm() {
    document.getElementById('imageForm').reset();
    document.getElementById('imageInput').value = '';
    document.getElementById('uploadPlaceholder').classList.remove('hidden');
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('imageAnalyzeBtn').disabled = true;
    document.getElementById('imageResult').classList.add('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Symptom Functions
var categoryLabels = {
    'general': 'အထွေထွေလက္ခဏာများ', 'skin': 'အရေပြားဆိုင်ရာ', 'respiratory': 'အသက်ရှူလမ်းကြောင်းဆိုင်ရာ',
    'digestive': 'ခြေတည်ငြိမ်မှုဆိုင်ရာ', 'reproductive': 'မျိုးပွားဆိုင်ရာ', 'udder': 'နို့အုံဆိုင်ရာ',
    'neurological': 'ဦးနှောက်/အာရုံကြောဆိုင်ရာ', 'eye': 'မျက်စိဆိုင်ရာ', 'other': 'အခြား'
};

function loadSymptoms(animalType) {
    var loading = document.getElementById('symptomsLoading');
    var list = document.getElementById('symptomsList');
    loading.classList.remove('hidden');
    list.classList.add('hidden');

    fetch('{{ route("aiDisease.symptoms") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: JSON.stringify({ animal_type: animalType })
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        loading.classList.add('hidden');
        if (data.success) { renderSymptoms(data.symptoms); list.classList.remove('hidden'); }
    })
    .catch(function() {
        loading.classList.add('hidden');
        list.innerHTML = '<p class="text-center text-stone-500 text-sm py-4">လက္ခဏာများ ရယူ၍ မရပါ။</p>';
        list.classList.remove('hidden');
    });
}

function renderSymptoms(symptoms) {
    var container = document.getElementById('symptomsList');
    container.innerHTML = '';
    Object.keys(symptoms).forEach(function(category) {
        var categoryDiv = document.createElement('div');
        categoryDiv.className = 'mb-4';
        var categoryLabel = document.createElement('h3');
        categoryLabel.className = 'text-xs font-bold text-stone-500 uppercase tracking-wider mb-2 flex items-center gap-2';
        categoryLabel.innerHTML = '<span class="w-2 h-2 bg-emerald-500 rounded-full"></span> ' + (categoryLabels[category] || category);
        categoryDiv.appendChild(categoryLabel);
        var chipsDiv = document.createElement('div');
        chipsDiv.className = 'flex flex-wrap gap-2';
        Object.keys(symptoms[category]).forEach(function(symptomId) {
            var symptom = symptoms[category][symptomId];
            var chip = document.createElement('button');
            chip.type = 'button';
            chip.className = 'symptom-chip inline-flex items-center gap-1.5 bg-stone-50 border border-stone-200 text-stone-600 px-3 py-2 rounded-xl text-xs font-semibold hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 transition-all';
            chip.setAttribute('data-id', symptomId);
            chip.innerHTML = '<span>' + symptom.icon + '</span> ' + symptom.label;
            chip.addEventListener('click', function() {
                this.classList.toggle('selected');
                if (this.classList.contains('selected')) { selectedSymptoms.push(symptomId); }
                else { selectedSymptoms = selectedSymptoms.filter(function(s) { return s !== symptomId; }); }
                updateSymptomButton();
            });
            chipsDiv.appendChild(chip);
        });
        categoryDiv.appendChild(chipsDiv);
        container.appendChild(categoryDiv);
    });
}

function updateSymptomButton() {
    var btn = document.getElementById('symptomAnalyzeBtn');
    var count = document.getElementById('selectedCount');
    count.textContent = '(' + selectedSymptoms.length + ')';
    btn.disabled = selectedSymptoms.length === 0;
}

document.getElementById('symptomAnalyzeBtn').addEventListener('click', function() {
    if (selectedSymptoms.length === 0) return;
    var animalType = document.querySelector('input[name="animal_type"]:checked').value;
    var btn = document.getElementById('symptomAnalyzeBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin"></i> ခွဲခြမ်းနေသည်...';
    document.getElementById('loadingState').classList.remove('hidden');
    document.getElementById('symptomResults').classList.add('hidden');

    fetch('{{ route("aiDisease.analyze") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: JSON.stringify({ animal_type: animalType, symptoms: selectedSymptoms })
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        document.getElementById('loadingState').classList.add('hidden');
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> လက္ခဏာဖြင့် ခွဲခြမ်းရန် <span id="selectedCount" class="bg-white/20 text-xs px-2 py-0.5 rounded-full">(0)</span>';
        updateSymptomButton();
        if (data.success) displaySymptomResults(data.results, data.source);
    })
    .catch(function() {
        document.getElementById('loadingState').classList.add('hidden');
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> လက္ခဏာဖြင့် ခွဲခြမ်းရန် <span id="selectedCount" class="bg-white/20 text-xs px-2 py-0.5 rounded-full">(0)</span>';
        updateSymptomButton();
    });
});

function displaySymptomResults(results, source) {
    var container = document.getElementById('symptomResultsList');
    container.innerHTML = '';

    var sourceLabel = source === 'ai' ? 'AI ခွဲခြမ်းမှု' : 'ဒေတာဘောင် ခွဲခြမ်းမှု';
    var sourceColor = source === 'ai' ? 'emerald' : 'blue';
    container.innerHTML += `<div class="bg-${sourceColor}-50 border border-${sourceColor}-200 rounded-xl p-3 mb-4 flex items-center gap-2"><span class="w-2 h-2 bg-${sourceColor}-500 rounded-full"></span><p class="text-xs text-${sourceColor}-700 font-semibold">${sourceLabel}</p></div>`;

    if (results.length === 0) {
        container.innerHTML += '<div class="bg-stone-50 border border-stone-100 rounded-2xl p-8 text-center"><p class="text-stone-500 text-sm">ကိုက်ညီသည့် ရောဂါ မတွေ့ပါ။ လက္ခဏာပိုမိုရွေးချယ်၍ ထပ်ကြိုးစားပါ။</p></div>';
        document.getElementById('symptomResults').classList.remove('hidden');
        return;
    }
    results.forEach(function(result, index) {
        var disease = result.disease;
        var card = document.createElement('div');
        card.className = 'result-card bg-white border border-stone-100 rounded-2xl overflow-hidden shadow-sm';
        card.style.animationDelay = (index * 0.1) + 's';
        card.innerHTML = `
            <div class="p-5 border-b border-stone-100 bg-gradient-to-r from-emerald-50 to-white">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-0.5 rounded-md">${result.confidence}% ကိုက်ညီမှု</span>
                            <span class="bg-${disease.urgency === 'high' ? 'red' : 'amber'}-100 text-${disease.urgency === 'high' ? 'red' : 'amber'}-700 text-[10px] font-bold px-2 py-0.5 rounded-md">${disease.urgency === 'high' ? 'အရေးပေါ်' : 'အလယ်အလတ်'}</span>
                        </div>
                        <h3 class="font-[Bricolage_Grotesque] text-lg font-bold text-stone-900">${disease.name_my}</h3>
                        <p class="text-xs text-stone-500">${disease.name_en}</p>
                    </div>
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center shrink-0"><span class="text-xl font-bold text-emerald-700">${index + 1}</span></div>
                </div>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <h4 class="text-xs font-bold text-stone-500 mb-2">ကိုက်ညီသည့် လက္ခဏာများ (${result.match_count}/${result.total_symptoms})</h4>
                    <div class="w-full bg-stone-100 rounded-full h-2 mb-2"><div class="bg-emerald-500 h-2 rounded-full" style="width: ${result.confidence}%"></div></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-blue-50/50 rounded-xl p-4"><h4 class="text-xs font-bold text-blue-800 mb-2">အကြောင်းရင်း</h4><p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">${disease.causes}</p></div>
                    <div class="bg-purple-50/50 rounded-xl p-4"><h4 class="text-xs font-bold text-purple-800 mb-2">ကုသနည်း</h4><p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">${disease.treatment}</p></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-emerald-50/50 rounded-xl p-4"><h4 class="text-xs font-bold text-emerald-800 mb-2">ကာကွယ်နည်း</h4><p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">${disease.prevention}</p></div>
                    <div class="bg-cyan-50/50 rounded-xl p-4"><h4 class="text-xs font-bold text-cyan-800 mb-2">ကူးစက်ပုံ</h4><p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">${disease.transmission}</p></div>
                </div>
                <div class="bg-orange-50/50 rounded-xl p-4"><h4 class="text-xs font-bold text-orange-800 mb-2">နောက်ဆက်တွဲပြဿနာများ</h4><p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">${disease.complications}</p></div>
            </div>
        `;
        container.appendChild(card);
    });
    document.getElementById('symptomResults').classList.remove('hidden');
    document.getElementById('symptomResults').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function resetSymptomForm() {
    selectedSymptoms = [];
    document.querySelectorAll('.symptom-chip').forEach(function(chip) { chip.classList.remove('selected'); });
    updateSymptomButton();
    document.getElementById('symptomResults').classList.add('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endsection
