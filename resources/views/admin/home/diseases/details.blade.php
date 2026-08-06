@extends('admin.layouts.master')
@section('content')
<div class="bg-gray-100 min-h-screen py-4 px-3 sm:py-8 sm:px-6">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">

        <!-- HEADER -->
        <div class="bg-green-500 px-5 py-4 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-white">
            <h2 class="text-base sm:text-xl font-bold text-center sm:text-left">ရောဂါအချက်အလက် အသေးစိတ်ကြည့်ရှုခြင်း</h2>
            <a href="{{ route('diseaseManagePage') }}" class="text-white hover:text-green-100 text-xs sm:text-sm font-semibold transition-colors duration-200 self-center sm:self-auto border border-white/30 px-3 py-1 rounded-lg sm:border-0 sm:p-0">
                &larr; စီမံခန့်ခွဲမှုစာမျက်နှာသို့
            </a>
        </div>

        <!-- MAIN CONTENT CONTAINER -->
        <div class="p-4 sm:p-8 space-y-6 sm:space-y-8">

            <!-- TOP SECTION: Title, Category & Image Grid (Mobile Responsive Optimized) -->
            <div class="flex flex-col md:flex-row gap-6 items-start pb-6 border-b border-gray-100">

                <!-- Info Section -->
                <div class="w-full md:w-7xl flex-1 space-y-4 order-2 md:order-1">
                    <div>
                        <span class="inline-block bg-green-100 text-green-800 text-[11px] px-2.5 py-1 rounded-full font-bold mb-2">
                            {{ $disease->animalType->type_title ?? 'အမျိုးအစားမသိရ' }}
                        </span>
                        <h1 class="text-lg sm:text-2xl font-black text-gray-900 break-words leading-snug">
                            {{ $disease->disease_title }}
                        </h1>
                    </div>

                    <div class="space-y-1">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">ရောဂါအကြောင်းအရာ ရှင်းလင်းချက်</h3>
                        <p class="text-gray-600 text-xs sm:text-base leading-relaxed break-words whitespace-pre-line bg-gray-50/50 p-3 sm:p-0 rounded-xl sm:bg-transparent">
                            {{ $disease->disease_desc ?? 'ရှင်းလင်းချက် မရှိပါ။' }}
                        </p>
                    </div>

                    <!-- Meta Info (Date) -->
                    <div class="text-[11px] text-gray-400 flex items-center gap-2 pt-2">
                        <span class="font-bold">ထည့်သွင်းသည့်ရက်စွဲ -</span>
                        <span>{{ $disease->created_at ? $disease->created_at->format('d/m/Y (H:i A)') : 'ရက်စွဲမရှိပါ' }}</span>
                    </div>
                </div>

                <!-- Image Section (Mobile Top Order) -->
                <div class="w-full md:w-64 flex-shrink-0 order-1 md:order-2">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">ရောဂါဓာတ်ပုံ</h3>
                    @if($disease->disease_img)
                        <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-gray-50 max-h-48 md:max-h-56 aspect-[16/9] md:aspect-auto">
                            <img src="{{ asset('diseaseImage/' . $disease->disease_img) }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-32 flex items-center justify-center text-gray-400 text-xs font-semibold bg-gray-50 border border-dashed border-gray-200 rounded-xl px-4 text-center">
                            [ ဓာတ်ပုံတင်ထားခြင်းမရှိပါ ]
                        </div>
                    @endif
                </div>
            </div>

            <!-- ALL DETAILS PILLARS (Including Extra Fields) -->
            <div class="space-y-5 sm:space-y-6">

                <!-- 1. Symptoms -->
                <div class="bg-red-50/40 rounded-xl border border-red-100 p-4 sm:p-5">
                    <div class="flex items-center space-x-2 mb-3 text-red-700">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <h2 class="text-xs sm:text-sm font-bold uppercase tracking-wide">ရောဂါလက္ခဏာများ (What To Look For)</h2>
                    </div>
                    <p class="text-gray-700 text-xs sm:text-base leading-relaxed break-words whitespace-pre-line bg-white p-3 sm:p-4 rounded-lg border border-red-50 shadow-sm">
                        {{ $disease->symptoms ?? 'သတ်မှတ်ဖော်ပြထားခြင်း မရှိပါ။' }}
                    </p>
                </div>

                <!-- 2. Prevention -->
                <div class="bg-blue-50/40 rounded-xl border border-blue-100 p-4 sm:p-5">
                    <div class="flex items-center space-x-2 mb-3 text-blue-700">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <h2 class="text-xs sm:text-sm font-bold uppercase tracking-wide">ကာကွယ်ရန်နည်းလမ်းများ (Prevention)</h2>
                    </div>
                    <p class="text-gray-700 text-xs sm:text-base leading-relaxed break-words whitespace-pre-line bg-white p-3 sm:p-4 rounded-lg border border-blue-50 shadow-sm">
                        {{ $disease->prevent ?? 'သတ်မှတ်ဖော်ပြထားခြင်း မရှိပါ။' }}
                    </p>
                </div>

                <!-- 3. Treatment -->
                <div class="bg-green-50/40 rounded-xl border border-green-100 p-4 sm:p-5">
                    <div class="flex items-center space-x-2 mb-3 text-green-700">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        <h2 class="text-xs sm:text-sm font-bold uppercase tracking-wide">ကုသရန်နည်းလမ်းများ (Treatment)</h2>
                    </div>
                    <p class="text-gray-700 text-xs sm:text-base leading-relaxed break-words whitespace-pre-line bg-white p-3 sm:p-4 rounded-lg border border-green-50 shadow-sm">
                        {{ $disease->treated ?? 'သတ်မှတ်ဖော်ပြထားခြင်း မရှိပါ။' }}
                    </p>
                </div>

                <!-- ➕ EXTRA FIELD 1: Causes (ရောဂါဖြစ်ပွားရသော အကြောင်းရင်းများ) -->
                <div class="bg-amber-50/40 rounded-xl border border-amber-100 p-4 sm:p-5">
                    <div class="flex items-center space-x-2 mb-3 text-amber-800">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h2 class="text-xs sm:text-sm font-bold uppercase tracking-wide">ရောဂါဖြစ်ပွားရသော အကြောင်းရင်းများ (Causes)</h2>
                    </div>
                    <p class="text-gray-700 text-xs sm:text-base leading-relaxed break-words whitespace-pre-line bg-white p-3 sm:p-4 rounded-lg border border-amber-50 shadow-sm">
                        {{ $disease->causes ?? 'သတ်မှတ်ဖော်ပြထားခြင်း မရှိပါ။' }}
                    </p>
                </div>

                <!-- ➕ EXTRA FIELD 2: Precautions (အထူးသတိပြုရန်အချက်များ) -->
                <div class="bg-purple-50/40 rounded-xl border border-purple-100 p-4 sm:p-5">
                    <div class="flex items-center space-x-2 mb-3 text-purple-800">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-xs sm:text-sm font-bold uppercase tracking-wide">အထူးသတိပြုရန်အချက်များ (Precautions)</h2>
                    </div>
                    <p class="text-gray-700 text-xs sm:text-base leading-relaxed break-words whitespace-pre-line bg-white p-3 sm:p-4 rounded-lg border border-purple-50 shadow-sm">
                        {{ $disease->precautions ?? 'သတ်မှတ်ဖော်ပြထားခြင်း မရှိပါ။' }}
                    </p>
                </div>

            </div>

            <!-- ACTION FOOTER BUTTONS (Updated to Green-500 Context) -->
            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center sm:justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('diseaseManagePage') }}" class="px-6 py-2.5 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs sm:text-sm font-semibold text-center transition-colors duration-200">
                    နောက်သို့ ပြန်သွားမည်
                </a>
                <a href="{{ route('diseaseEditPage', $disease->id) }}" class="px-6 py-2.5 rounded-lg bg-green-500 text-white hover:bg-green-600 text-xs sm:text-sm font-semibold shadow-sm text-center transition-colors duration-200">
                    ဒေတာ ပြင်ဆင်မည်
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
