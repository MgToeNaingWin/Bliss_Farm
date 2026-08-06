@extends('user.layouts.master')

@section('bdy')
<style>
    /* ── Override Master Layout Font ── */
    #bdy, #bdy * {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
    }
    #bdy .font-display,
    #bdy h1, #bdy h2, #bdy h3 {
        font-family: 'Bricolage Grotesque', 'Helvetica Neue', Helvetica, sans-serif !important;
    }
    #bdy .font-accent {
        font-family: 'Playfair Display', Georgia, serif !important;
    }

    /* ── Design Tokens ── */
    :root {
        --farm-green-deep: #022c22;
        --farm-green: #065f46;
        --farm-green-mid: #047857;
        --farm-green-light: #10b981;
        --farm-amber: #b45309;
        --farm-amber-mid: #d97706;
        --farm-amber-light: #f59e0b;
        --farm-amber-glow: #fbbf24;
        --farm-cream: #f7f5f0;
        --farm-cream-warm: #f5f0e8;
        --farm-stone: #78716c;
    }

    /* ── Smooth Scroll ── */
    html { scroll-behavior: smooth; }

    /* ── Scroll Reveal Animations ── */
    .reveal {
        opacity: 0;
        transform: translateY(60px);
        transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
    .reveal-left {
        opacity: 0;
        transform: translateX(-80px);
        transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .reveal-left.active {
        opacity: 1;
        transform: translateX(0);
    }
    .reveal-right {
        opacity: 0;
        transform: translateX(80px);
        transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .reveal-right.active {
        opacity: 1;
        transform: translateX(0);
    }
    .reveal-scale {
        opacity: 0;
        transform: scale(0.85);
        transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .reveal-scale.active {
        opacity: 1;
        transform: scale(1);
    }

    /* ── Stagger Delay Utilities ── */
    .delay-100 { transition-delay: 0.1s; }
    .delay-200 { transition-delay: 0.2s; }
    .delay-300 { transition-delay: 0.3s; }
    .delay-400 { transition-delay: 0.4s; }
    .delay-500 { transition-delay: 0.5s; }

    /* ── Parallax Hero ── */
    .hero-parallax {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    /* ── Floating Animation ── */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }
    .animate-float {
        animation: float 4s ease-in-out infinite;
    }
    .animate-float-slow {
        animation: float 6s ease-in-out infinite;
    }

    /* ── Pulse Glow ── */
    @keyframes pulseGlow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0.4); }
        50% { box-shadow: 0 0 0 12px rgba(217, 119, 6, 0); }
    }
    .pulse-glow {
        animation: pulseGlow 2.5s ease-in-out infinite;
    }

    /* ── Gradient Text ── */
    .gradient-text {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 40%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .gradient-text-green {
        background: linear-gradient(135deg, #34d399 0%, #10b981 40%, #047857 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ── Wave Divider ── */
    .wave-divider {
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }
    .wave-divider svg {
        display: block;
        width: 100%;
        height: 80px;
    }

    /* ── Section Number Badge ── */
    .section-number {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
    }

    /* ── Scroll Progress Bar ── */
    .scroll-progress {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #047857, #fbbf24);
        z-index: 100;
        transition: width 0.15s ease;
    }

    /* ── Counter Animation ── */
    .counter-box {
        position: relative;
        overflow: hidden;
    }
    .counter-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.6s ease;
    }
    .counter-box:hover::before {
        left: 100%;
    }

    /* ── Card Hover Lift ── */
    .card-lift {
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
    }
    .card-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(5, 150, 105, 0.1);
    }

    /* ── Reduced Motion ── */
    @media (prefers-reduced-motion: reduce) {
        .reveal, .reveal-left, .reveal-right, .reveal-scale {
            opacity: 1;
            transform: none;
            transition: none;
        }
        .animate-float, .animate-float-slow { animation: none; }
        .hero-parallax { background-attachment: scroll; }
    }
</style>

<!-- ═══════════════════ SCROLL PROGRESS BAR ═══════════════════ -->
<div class="scroll-progress" id="scrollProgress"></div>

<!-- ═══════════════════ HERO SECTION ═══════════════════ -->
<section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0 hero-parallax"
         style="background-image: url('{{ asset('masterImages/cows-green-field.avif') }}');">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-950/80 via-emerald-950/60 to-emerald-950/90"></div>
    </div>

    <!-- Floating Decorative Elements -->
    <div class="absolute top-20 left-10 w-3 h-3 bg-amber-400 rounded-full animate-float opacity-40"></div>
    <div class="absolute top-40 right-20 w-2 h-2 bg-white rounded-full animate-float-slow opacity-30"></div>
    <div class="absolute bottom-40 left-1/4 w-4 h-4 bg-amber-300 rounded-full animate-float opacity-20"></div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-5xl mx-auto px-6 text-center pt-24 pb-32">
        <!-- Eyebrow Badge -->
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-5 py-2 mb-8">
            <span class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></span>
            <span class="font-accent text-amber-300 text-sm italic tracking-wide">Bliss Farm Portal</span>
        </div>

        <!-- Main Headline -->
        <h1 class="font-display text-4xl sm:text-5xl md:text-7xl font-extrabold text-white leading-[1.1] mb-6 tracking-tight">
            မွေးမြူရေးနှင့်
            <span class="gradient-text">စိုက်ပျိုးရေး</span>
            <br>သတင်းနှင့် ဗဟုသုတ
        </h1>

        <!-- Subtitle -->
        <p class="text-white/60 text-base sm:text-lg max-w-2xl mx-auto mb-10 leading-relaxed font-light">
            ခေတ်မီမွေးမြူရေး နည်းစနစ်များ၊ တိရစ္ဆာန်ရောဂါ ကာကွယ်ကုသရေး လမ်းညွှန်များနှင့်
            နေ့စဉ်ပြောင်းလဲနေသော မွေးမြူရေးထုတ်ကုန်များ၏ ဈေးကွက်ပေါက်ဈေးနှုန်းများကို
            တစ်နေရာတည်းတွင် လေ့လာဖတ်ရှုနိုင်ပါသည်။
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap justify-center gap-4">
            <a href="#features"
               class="group bg-amber-500 hover:bg-amber-400 text-emerald-950 font-extrabold px-8 py-4 rounded-full text-base shadow-xl shadow-amber-500/25 transition-all duration-300 inline-flex items-center gap-2 pulse-glow">
                စတင်ရှာဖွေရန်
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
            <a href="{{ route('diseaseList') }}"
               class="bg-white/10 hover:bg-white/20 text-white font-bold px-8 py-4 rounded-full text-base border border-white/20 backdrop-blur-sm transition-all duration-300">
                ရောဂါအချက်အလက်
            </a>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="wave-divider">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none" fill="#f7f5f0">
            <path d="M0,40 C150,80 350,0 600,40 C850,80 1050,0 1200,40 L1200,80 L0,80 Z"></path>
        </svg>
    </div>
</section>

<!-- ═══════════════════ STATS SECTION ═══════════════════ -->
<section id="stats" class="relative py-20" style="background: var(--farm-cream);">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Stat 1 -->
            <div class="reveal delay-100 counter-box bg-white rounded-2xl p-6 text-center shadow-sm border border-emerald-100/50 card-lift">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-heart-pulse text-emerald-600 text-xl"></i>
                </div>
                <div class="text-3xl font-extrabold text-emerald-900 mb-1" data-target="150">0</div>
                <div class="text-xs text-stone-400 font-medium">ရောဂါများ</div>
            </div>
            <!-- Stat 2 -->
            <div class="reveal delay-200 counter-box bg-white rounded-2xl p-6 text-center shadow-sm border border-emerald-100/50 card-lift">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-newspaper text-amber-600 text-xl"></i>
                </div>
                <div class="text-3xl font-extrabold text-emerald-900 mb-1" data-target="80">0</div>
                <div class="text-xs text-stone-400 font-medium">သတင်းဆောင်းပါး</div>
            </div>
            <!-- Stat 3 -->
            <div class="reveal delay-300 counter-box bg-white rounded-2xl p-6 text-center shadow-sm border border-emerald-100/50 card-lift">
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-paw text-red-500 text-xl"></i>
                </div>
                <div class="text-3xl font-extrabold text-emerald-900 mb-1" data-target="12">0</div>
                <div class="text-xs text-stone-400 font-medium">တိရစ္ဆာန်အမျိုးအစား</div>
            </div>
            <!-- Stat 4 -->
            <div class="reveal delay-400 counter-box bg-white rounded-2xl p-6 text-center shadow-sm border border-emerald-100/50 card-lift">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-users text-blue-500 text-xl"></i>
                </div>
                <div class="text-3xl font-extrabold text-emerald-900 mb-1" data-target="500">0</div>
                <div class="text-xs text-stone-400 font-medium">အသုံးပြုသူများ</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════ FEATURES SECTION ═══════════════════ -->
<section id="features" class="relative py-24 overflow-hidden" style="background: var(--farm-cream);">
    <!-- Section Header -->
    <div class="max-w-6xl mx-auto px-6 mb-16">
        <div class="reveal text-center">
            <span class="font-accent inline-block text-amber-700 text-sm italic tracking-widest mb-3">ဝန်ဆောင်မှုများ</span>
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-emerald-950 mb-4 tracking-tight">
                Bliss Farm <span class="gradient-text">ဝန်ဆောင်မှု</span> များ
            </h2>
            <p class="text-stone-500 max-w-xl mx-auto text-sm leading-relaxed">မွေးမြူရေးလုပ်ငန်းနှင့်ပတ်သက်သည့် အရေးကြီးဆုံး အချက်အလက်များကို တစ်နေရာတည်းတွင် ရှာဖွုနိုင်ပါသည်</p>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Feature 1: Disease Info -->
            <div class="reveal-left delay-100 group bg-white rounded-3xl p-8 shadow-sm border border-emerald-100/50 card-lift relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 rounded-full -translate-y-16 translate-x-16 opacity-50"></div>
                <div class="relative">
                    <div class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-hand-holding-medical"></i>
                    </div>
                    <h3 class="font-display text-xl font-extrabold text-emerald-950 mb-3 tracking-tight">တိရစ္ဆာန်ရောဂါ အချက်အလက်</h3>
                    <p class="text-stone-500 text-sm leading-relaxed mb-6">
                        ကြက်၊ ဝက်၊ နွား စသည့် မွေးမြူရေးတိရစ္ဆာန်များတွင် ဖြစ်ပွားတတ်သော ကူးစက်ရောဂါလက္ခဏာများနှင့် ကာကွယ်ကုသနည်းလမ်းညွှန်များ။
                    </p>
                    <a href="{{ route('diseaseList') }}" class="inline-flex items-center gap-2 text-red-500 font-bold text-sm group-hover:gap-3 transition-all duration-300">
                        ဝင်ရောက်ကြည့်ရှုရန်
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Feature 2: News -->
            <div class="reveal delay-200 group bg-white rounded-3xl p-8 shadow-sm border border-emerald-100/50 card-lift relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full -translate-y-16 translate-x-16 opacity-50"></div>
                <div class="relative">
                    <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <h3 class="font-display text-xl font-extrabold text-emerald-950 mb-3 tracking-tight">သတင်းနှင့် ဗဟုသုတ</h3>
                    <p class="text-stone-500 text-sm leading-relaxed mb-6">
                        တောင်သူလယ်သမားများနှင့် မွေးမြူရေးလုပ်ငန်းရှင်များအတွက် အသုံးဝင်မည့် ခေတ်မီစိုက်ပျိုးနည်းစနစ်များနှင့် နည်းပညာဆောင်းပါးများ။
                    </p>
                    <a href="/news" class="inline-flex items-center gap-2 text-amber-600 font-bold text-sm group-hover:gap-3 transition-all duration-300">
                        ဝင်ရောက်ဖတ်ရှုရန်
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Feature 3: Market -->
            <div class="reveal-right delay-300 group bg-white rounded-3xl p-8 shadow-sm border border-emerald-100/50 card-lift relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -translate-y-16 translate-x-16 opacity-50"></div>
                <div class="relative">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>
                    <h3 class="font-display text-xl font-extrabold text-emerald-950 mb-3 tracking-tight">မွေးမြူရေးဈေးကွက်</h3>
                    <p class="text-stone-500 text-sm leading-relaxed mb-6">
                        နေ့စဉ် အချိန်နှင့်တပြေးညီ ပြောင်းလဲနေသော အသားတိုးကြက်၊ ဥစားကြက်၊ ဝက် နှင့် နွား ဈေးနှုန်းပေါက်ဈေး အချက်အလက်များ။
                    </p>
                    <a href="/market" class="inline-flex items-center gap-2 text-emerald-700 font-bold text-sm group-hover:gap-3 transition-all duration-300">
                        ဈေးနှုန်းများ စစ်ဆေးရန်
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════ SCROLLYTELLING: HOW IT WORKS ═══════════════════ -->
<section id="how-it-works" class="relative py-24 bg-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23047857' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>

    <div class="max-w-6xl mx-auto px-6">
        <!-- Section Header -->
        <div class="reveal text-center mb-20">
            <span class="font-accent inline-block text-amber-700 text-sm italic tracking-widest mb-3">အဆင့်များ</span>
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-emerald-950 mb-4 tracking-tight">
                ဘယ်လို <span class="gradient-text">အလုပ်လုပ်</span>သလဲ
            </h2>
            <p class="text-stone-500 max-w-xl mx-auto text-sm leading-relaxed">ရိုးရှင်းသည့် အဆင့် ၃ ဆင့်ဖြင့် သင့်မွေးမြူရေးလုပ်ငန်းအတွက် လိုအပ်သည့် အချက်အလက်များကို ရယူပါ</p>
        </div>

        <!-- Steps -->
        <div class="relative">
            <!-- Vertical Line (desktop only) -->
            <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-emerald-200 via-amber-200 to-emerald-200 -translate-x-1/2"></div>

            <!-- Step 1 -->
            <div class="reveal-left relative flex flex-col md:flex-row items-center gap-8 md:gap-16 mb-20">
                <div class="md:w-1/2 md:text-right">
                    <div class="section-number bg-emerald-100 text-emerald-700 md:ml-auto mb-4 md:mb-0">01</div>
                    <h3 class="font-display text-xl font-extrabold text-emerald-950 mb-2 tracking-tight">တိရစ္ဆာန် ရွေးချယ်ပါ</h3>
                    <p class="text-stone-500 text-sm leading-relaxed">သင့်မွေးမြူနေသည့် တိရစ္ဆာန်အမျိုးအစားကို ရွေးချယ်ပြီး သက်ဆိုင်ရာ ရောဂါများကို စူးစမ်းပါ။</p>
                </div>
                <div class="hidden md:flex w-12 h-12 bg-white border-4 border-emerald-400 rounded-full items-center justify-center z-10 shadow-md">
                    <i class="fa-solid fa-paw text-emerald-600"></i>
                </div>
                <div class="md:w-1/2">
                    <div class="bg-emerald-50 rounded-3xl p-8 border border-emerald-100">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="bg-white rounded-xl p-4 text-center shadow-sm"><span class="text-2xl">🐔</span><p class="text-[10px] text-stone-400 mt-1">ကြက်</p></div>
                            <div class="bg-white rounded-xl p-4 text-center shadow-sm"><span class="text-2xl">🐄</span><p class="text-[10px] text-stone-400 mt-1">နွား</p></div>
                            <div class="bg-white rounded-xl p-4 text-center shadow-sm"><span class="text-2xl">🐖</span><p class="text-[10px] text-stone-400 mt-1">ဝက်</p></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="reveal-right relative flex flex-col md:flex-row-reverse items-center gap-8 md:gap-16 mb-20">
                <div class="md:w-1/2 md:text-left">
                    <div class="section-number bg-amber-100 text-amber-700 mb-4 md:mb-0">02</div>
                    <h3 class="font-display text-xl font-extrabold text-emerald-950 mb-2 tracking-tight">ရောဂါ စစ်ဆေးပါ</h3>
                    <p class="text-stone-500 text-sm leading-relaxed">လက္ခဏာများကို ကြည့်ရှုပြီး ရောဂါကို ခွဲခြမ်းစိတ်ဖြာပါ။ ကာကွယ်နည်းနှင့် ကုသနည်းများကို လေ့လာပါ။</p>
                </div>
                <div class="hidden md:flex w-12 h-12 bg-white border-4 border-amber-400 rounded-full items-center justify-center z-10 shadow-md">
                    <i class="fa-solid fa-magnifying-glass text-amber-600"></i>
                </div>
                <div class="md:w-1/2">
                    <div class="bg-amber-50 rounded-3xl p-8 border border-amber-100">
                        <div class="space-y-3">
                            <div class="bg-white rounded-xl p-3 flex items-center gap-3 shadow-sm">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center"><i class="fa-solid fa-temperature-high text-red-500 text-xs"></i></div>
                                <span class="text-sm text-stone-700">အဖျားတက်ခြင်း</span>
                            </div>
                            <div class="bg-white rounded-xl p-3 flex items-center gap-3 shadow-sm">
                                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center"><i class="fa-solid fa-droplet text-amber-500 text-xs"></i></div>
                                <span class="text-sm text-stone-700">အစာစားနည်းခြင်း</span>
                            </div>
                            <div class="bg-white rounded-xl p-3 flex items-center gap-3 shadow-sm">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fa-solid fa-virus text-blue-500 text-xs"></i></div>
                                <span class="text-sm text-stone-700">ကူးစက်ရောဂါလက္ခဏာ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="reveal-left relative flex flex-col md:flex-row items-center gap-8 md:gap-16">
                <div class="md:w-1/2 md:text-right">
                    <div class="section-number bg-emerald-100 text-emerald-700 md:ml-auto mb-4 md:mb-0">03</div>
                    <h3 class="font-display text-xl font-extrabold text-emerald-950 mb-2 tracking-tight">ကုသနည်း ရှာဖွေပါ</h3>
                    <p class="text-stone-500 text-sm leading-relaxed">ကုသနည်းနှင့် ကာကွယ်နည်းများကို အသေးစိတ်ဖတ်ရှုပြီး သင့်တိရစ္ဆာန်များကို ကျန်းမာအောင် ထိန်းသိမ်းပါ။</p>
                </div>
                <div class="hidden md:flex w-12 h-12 bg-white border-4 border-emerald-400 rounded-full items-center justify-center z-10 shadow-md">
                    <i class="fa-solid fa-pills text-emerald-600"></i>
                </div>
                <div class="md:w-1/2">
                    <div class="bg-emerald-50 rounded-3xl p-8 border border-emerald-100">
                        <div class="space-y-3">
                            <div class="bg-white rounded-xl p-3 flex items-center gap-3 shadow-sm">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center"><i class="fa-solid fa-syringe text-emerald-600 text-xs"></i></div>
                                <span class="text-sm text-stone-700">ကုသနည်းလမ်းညွှန်</span>
                            </div>
                            <div class="bg-white rounded-xl p-3 flex items-center gap-3 shadow-sm">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center"><i class="fa-solid fa-shield-virus text-emerald-600 text-xs"></i></div>
                                <span class="text-sm text-stone-700">ကာကွယ်နည်းများ</span>
                            </div>
                            <div class="bg-white rounded-xl p-3 flex items-center gap-3 shadow-sm">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center"><i class="fa-solid fa-book-medical text-emerald-600 text-xs"></i></div>
                                <span class="text-sm text-stone-700">အသေးစိတ်လမ်းညွှန်</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════ IMAGE BANNER / CTA ═══════════════════ -->
<section id="cta" class="relative py-24 overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('masterImages/cowsi.jpeg') }}" class="w-full h-full object-cover" alt="Farm">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/90 via-emerald-950/75 to-emerald-950/90"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
        <div class="reveal-scale">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-5 py-2 mb-8">
                <i class="fa-solid fa-seedling text-emerald-400"></i>
                <span class="text-white/90 text-sm font-bold">Bliss Farm နှင့် ပူးပေါင်းပါ</span>
            </div>

            <h2 class="font-display text-3xl sm:text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6 tracking-tight">
                သင့်မွေးမြူရေးလုပ်ငန်းကို
                <span class="gradient-text">ခေတ်မီ</span>
                အောင် ကူညီပါမည်
            </h2>

            <p class="text-white/60 text-base sm:text-lg max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                အကောင့်သစ်ဖွင့်ပြီး ပိုမိုစုံလင်သော ဝန်ဆောင်မှုများနှင့် သတင်းအချက်အလက်များကို ရယူပါ။
            </p>

            @if(!auth()->user())
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-emerald-950 font-extrabold px-10 py-4 rounded-full text-base shadow-xl shadow-amber-500/25 transition-all duration-300 pulse-glow">
                    <i class="fa-solid fa-user-plus"></i>
                    အကောင့်ဖွင့်ရန်
                </a>
            @endif
        </div>
    </div>
</section>

<!-- ═══════════════════ JAVASCRIPT ═══════════════════ -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ── Scroll Progress Bar ──
    const progressBar = document.getElementById('scrollProgress');
    window.addEventListener('scroll', function() {
        const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const progress = (scrollTop / scrollHeight) * 100;
        progressBar.style.width = progress + '%';
    });

    // ── Intersection Observer for Scroll Reveal ──
    const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');

    const revealObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(function(el) {
        revealObserver.observe(el);
    });

    // ── Counter Animation ──
    const counters = document.querySelectorAll('[data-target]');
    let counterAnimated = false;

    const counterObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting && !counterAnimated) {
                counterAnimated = true;
                counters.forEach(function(counter) {
                    const target = parseInt(counter.getAttribute('data-target'));
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    let current = 0;

                    function updateCounter() {
                        current += increment;
                        if (current < target) {
                            counter.textContent = Math.floor(current) + '+';
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target + '+';
                        }
                    }
                    updateCounter();
                });
            }
        });
    }, { threshold: 0.5 });

    if (counters.length > 0) {
        counterObserver.observe(counters[0].closest('.grid'));
    }

    // ── Navbar Background on Scroll ──
    const nav = document.querySelector('nav');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            nav.classList.add('shadow-2xl');
        } else {
            nav.classList.remove('shadow-2xl');
        }
    });

});
</script>
@endsection
