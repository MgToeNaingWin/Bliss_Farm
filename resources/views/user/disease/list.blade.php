@extends('user.layouts.master')

@section('bdy')
<style>
    /* ── Scroll Reveal ── */
    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
    .reveal-up { transition-delay: 0.1s; }
    .reveal-up-2 { transition-delay: 0.2s; }
    .reveal-up-3 { transition-delay: 0.3s; }

    /* ── Filter Tab ── */
    .filter-tab {
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .filter-tab.active {
        background: #065f46;
        color: #fbbf24;
        box-shadow: 0 4px 15px rgba(6, 95, 70, 0.25);
    }
    .filter-tab:not(.active):hover {
        background: white;
        border-color: #d1d5db;
    }

    /* ── Card Hover ── */
    .disease-card {
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
    }
    .disease-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(6, 95, 70, 0.1);
    }

    /* ── Gradient Text ── */
    .gradient-text {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 40%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ── Search Focus ── */
    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.3);
    }

    /* ── Reduced Motion ── */
    @media (prefers-reduced-motion: reduce) {
        .reveal { opacity: 1; transform: none; transition: none; }
    }
</style>

<!-- ═══════════════════ HERO SECTION ═══════════════════ -->
<section class="relative overflow-hidden">
    <div class="relative bg-gradient-to-br from-emerald-800 via-emerald-900 to-emerald-950 text-white rounded-b-[2rem] px-6 sm:px-10 py-8 sm:py-10 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
        <div class="absolute -right-20 -top-20 w-72 h-72 bg-amber-400/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-4xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/15 rounded-full px-3 py-1 mb-3">
                    <i class="fa-solid fa-shield-virus text-emerald-300 text-[10px]"></i>
                    <span class="font-[Playfair_Display] text-emerald-200 text-xs italic">Health & Prevention</span>
                </div>
                <h1 class="font-[Bricolage_Grotesque] text-2xl sm:text-3xl font-extrabold leading-tight tracking-tight">
                    တိရစ္ဆာန်ရောဂါ <span class="gradient-text">ကာကွယ်ကုသရေး</span>
                </h1>
            </div>
            <!-- Search Bar -->
            <form action="{{ route('diseaseList') }}" method="GET" class="w-full sm:w-80 shrink-0">
                <div class="relative flex items-center">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-stone-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="ရောဂါရှာဖွေရန်..."
                           class="search-input w-full pl-10 pr-20 py-2.5 bg-white text-stone-800 rounded-xl text-sm focus:outline-none border-2 border-transparent transition-all placeholder-stone-400">
                    <button type="submit" class="absolute right-1.5 bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-[11px] px-3 py-1.5 rounded-lg transition shadow-sm">
                        ရှာဖွေ
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('diseaseList') }}" class="inline-flex items-center gap-1 text-emerald-300/70 text-[11px] mt-1.5 hover:text-white transition">
                        <i class="fa-solid fa-xmark"></i> ဖျက်ရန်
                    </a>
                @endif
            </form>
        </div>
    </div>
</section>

<!-- ═══════════════════ MAIN CONTENT ═══════════════════ -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 space-y-10 pb-16">

    <!-- ══ Animal Type Filter Tabs ══ -->
    <div class="reveal">
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-4 sm:p-5">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-1 h-5 bg-emerald-600 rounded-full"></span>
                <h2 class="font-[Bricolage_Grotesque] text-sm font-bold text-stone-800">တိရစ္ဆာန်အမျိုးအစားအလိုက် ခွဲခြားကြည့်ရှုရန်</h2>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('diseaseList') }}{{ request('search') ? '?search='.request('search') : '' }}"
                   class="filter-tab {{ !request('animal') ? 'active' : '' }} bg-stone-50 text-stone-600 border border-stone-200 font-semibold px-4 py-2 rounded-xl text-sm inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-border-all text-xs"></i> အားလုံး
                </a>
                @foreach($animalTypes as $type)
                    <a href="{{ route('diseaseList') }}?animal={{ $type->id }}{{ request('search') ? '&search='.request('search') : '' }}"
                       class="filter-tab {{ request('animal') == $type->id ? 'active' : '' }} bg-stone-50 text-stone-600 border border-stone-200 font-semibold px-4 py-2 rounded-xl text-sm inline-flex items-center gap-1.5">
                        @if($type->type_img && file_exists(public_path('animalType/' . $type->type_img)))
                            <img src="{{ asset('animalType/' . $type->type_img) }}" class="w-4 h-4 rounded object-cover">
                        @endif
                        {{ $type->type_title }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ══ Search Result Info ══ -->
    @if(request('search'))
        <div class="reveal flex items-center gap-2 text-sm text-stone-500">
            <i class="fa-solid fa-circle-info text-emerald-600"></i>
            <span>"<span class="font-semibold text-stone-700">{{ request('search') }}</span>" ဖြင့် ရှာဖွေမှု ရလဒ် - <span class="font-bold text-emerald-700">{{ $diseases->count() }}</span> ခု</span>
        </div>
    @endif

    <!-- ══ Disease Cards Grid ══ -->
    @if($diseases->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($diseases as $index => $disease)
                <a href="{{ route('userDiseaseDetail', $disease->id) }}"
                   class="disease-card reveal bg-white border border-stone-100 rounded-2xl overflow-hidden shadow-sm group block"
                   style="transition-delay: {{ $index * 0.05 }}s">

                    <!-- Image -->
                    <div class="h-44 w-full overflow-hidden relative bg-stone-100">
                        @if($disease->disease_img && file_exists(public_path('diseaseImage/' . $disease->disease_img)))
                            <img src="{{ asset('diseaseImage/' . $disease->disease_img) }}"
                                 alt="{{ $disease->disease_title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-stone-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                                </svg>
                            </div>
                        @endif
                        <!-- Animal Type Badge -->
                        <span class="absolute top-3 right-3 bg-emerald-800/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-sm">
                            {{ $disease->animalType->type_title ?? 'N/A' }}
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="p-5 space-y-2.5">
                        <h3 class="font-[Bricolage_Grotesque] text-base font-bold text-stone-800 group-hover:text-emerald-700 transition-colors leading-snug line-clamp-2">
                            {{ $disease->disease_title }}
                        </h3>
                        <p class="text-stone-500 text-xs leading-relaxed line-clamp-2">
                            {{ Str::limit($disease->disease_desc, 100, '...') }}
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="px-5 pb-5 flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            <span class="text-[11px] text-stone-400 font-medium">{{ $disease->animalType->type_title ?? '' }}</span>
                        </div>
                        <span class="text-emerald-700 text-xs font-bold inline-flex items-center gap-1 group-hover:gap-2 transition-all duration-300">
                            အသေးစိတ်
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($diseases->hasPages())
            <div class="mt-8">
                {{ $diseases->withQueryString()->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-16 text-center">
            <div class="w-16 h-16 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </div>
            <h3 class="font-[Bricolage_Grotesque] text-lg font-bold text-stone-800 mb-1">ရောဂါများ မတွေ့ရှိပါ</h3>
            <p class="text-sm text-stone-500 mb-4">
                @if(request('search'))
                    "{{ request('search') }}" ဖြင့် ကိုက်ညီသည့် ရောဂါ မတွေ့ရှိပါ။
                @else
                    လက်ရှိတွင် ရောဂါအချက်အလက်များ မရှိသေးပါ။
                @endif
            </p>
            @if(request('search'))
                <a href="{{ route('diseaseList') }}" class="inline-flex items-center gap-2 bg-emerald-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-emerald-600 transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i> အားလုံးကို ပြန်ကြည့်ရန်
                </a>
            @endif
        </div>
    @endif

    <!-- ══ Emergency Hotline Banner ══ -->
    <div class="reveal bg-red-50 border border-red-100 rounded-2xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-start gap-4 text-center md:text-left flex-col md:flex-row items-center">
            <div class="w-12 h-12 bg-red-100 text-red-500 rounded-2xl flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-phone-volume"></i>
            </div>
            <div class="space-y-1">
                <h4 class="font-[Bricolage_Grotesque] text-stone-800 font-bold text-base">မွေးမြူရေးဆိုင်ရာ အရေးပေါ်ရောဂါ အကြောင်းကြားရန်</h4>
                <p class="text-stone-500 text-sm">သင့်ခြံအတွင်း တိရစ္ဆာန်များ ပုံမှန်မဟုတ်ဘဲ စုပြုံသေဆုံးခြင်း သို့မဟုတ် ကူးစက်ရောဂါသံသယရှိပါက ချက်ချင်း ဆက်သွယ်ပါ။</p>
            </div>
        </div>
        <a href="tel:0912345678"
           class="bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-sm transition-all duration-200 shrink-0 inline-flex items-center gap-2 hover:shadow-md">
            <i class="fa-solid fa-headset"></i>
            ၀၉-၁၂၃၄၅၆၇၈
        </a>
    </div>
</div>

<!-- ═══════════════════ JAVASCRIPT ═══════════════════ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(function(el) {
        observer.observe(el);
    });
});
</script>
@endsection
