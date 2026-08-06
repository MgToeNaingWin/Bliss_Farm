<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bliss Farm - မွေးမြူရေးနှင့် စိုက်ပျိုးရေးသတင်းကဏ္ဍ</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <!-- Font Awesome (v6) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite('resources/css/app.css')

    @stack('head')

    @vite('resources/js/app.js')

    <style>
        /* ── Alpine.js Cloak ── */
        [x-cloak] { display: none !important; }

        /* ── Base Font ── */
        *, body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        /* ── Scrollbar Hide ── */
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── Navbar Styles ── */
        .navbar {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .navbar.scrolled {
            background: rgba(6, 95, 70, 0.97) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
        }

        /* ── Nav Link Underline Effect ── */
        .nav-link {
            position: relative;
            transition: color 0.25s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #fbbf24;
            border-radius: 999px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            transform: translateX(-50%);
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 60%;
        }
        .nav-link.active {
            color: #fbbf24 !important;
        }

        /* ── Mobile Menu Animation ── */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                        opacity 0.3s ease;
            opacity: 0;
        }
        .mobile-menu.open {
            max-height: 600px;
            opacity: 1;
        }

        /* ── Hamburger Morph ── */
        .hamburger-line {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            transform-origin: center;
        }
        .hamburger-btn.open .hamburger-line:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }
        .hamburger-btn.open .hamburger-line:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }
        .hamburger-btn.open .hamburger-line:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        /* ── Logo Hover ── */
        .logo-img {
            transition: transform 0.3s ease;
        }
        .logo-img:hover {
            transform: scale(1.08) rotate(6deg);
        }

        /* ── CTA Button Glow ── */
        .nav-cta {
            transition: all 0.3s ease;
        }
        .nav-cta:hover {
            box-shadow: 0 4px 20px rgba(251, 191, 36, 0.35);
            transform: translateY(-1px);
        }

        /* ── Reduced Motion ── */
        @media (prefers-reduced-motion: reduce) {
            .navbar, .nav-link::after, .mobile-menu, .hamburger-line, .logo-img, .nav-cta {
                transition: none !important;
            }
        }
    </style>
</head>

<body class="flex flex-col min-h-full m-0 p-0 antialiased bg-[#f7f5f0]">

    <!-- ═══════════════════ NAVIGATION BAR ═══════════════════ -->
    <nav id="navbar" class="navbar fixed top-0 left-0 right-0 z-50 w-full sm:w-[96%] max-w-7xl mx-auto mt-0 sm:mt-3">
        <div class="flex items-center justify-between bg-emerald-900/90 backdrop-blur-xl px-4 sm:px-6 py-2.5 sm:rounded-2xl border border-emerald-700/30 shadow-lg shadow-emerald-950/10">

            <!-- ── Logo ── -->
            <a href="/home" class="flex items-center gap-3 shrink-0">
                <img src="{{ asset('masterImages/logo.png') }}"
                     alt="Bliss Farm"
                     class="logo-img h-9 w-9 sm:h-10 sm:w-10 rounded-xl border-2 border-amber-400/60 object-cover shadow-md">
                <span class="font-[Bricolage_Grotesque] text-white font-extrabold text-lg tracking-tight hidden sm:block">
                    Bliss Farm
                </span>
            </a>

            <!-- ── Desktop Navigation ── -->
            <div class="hidden lg:flex items-center gap-1 xl:gap-2">

                <!-- 1. Market Page (Public) -->
                <a href="/market"
                   class="nav-link {{ request()->is('market*') ? 'active' : '' }} px-3 py-2 text-white/80 hover:text-white font-semibold text-xs xl:text-sm rounded-xl transition duration-200 flex items-center gap-1.5">
                    <i class="fa-solid fa-chart-line text-emerald-400 text-xs"></i>
                    <span>ဈေးကွက်</span>
                </a>

                <!-- 2. Animal Disease Page (Public) -->
                <a href="{{ route('diseaseList') }}"
                   class="nav-link {{ request()->is('user/disease*') ? 'active' : '' }} px-3 py-2 text-white/80 hover:text-white font-semibold text-xs xl:text-sm rounded-xl transition duration-200 flex items-center gap-1.5">
                    <i class="fa-solid fa-heart-pulse text-emerald-400 text-xs"></i>
                    <span>တိရစ္ဆာန်ရောဂါ</span>
                </a>

                <!-- 3. AI Disease Check (Auth Required) -->
                <a href="{{ auth()->check() ? route('aiDisease.index') : route('login') }}"
                   class="nav-link {{ request()->is('ai-disease*') ? 'active' : '' }} px-3 py-2 text-white/80 hover:text-white font-semibold text-xs xl:text-sm rounded-xl transition duration-200 flex items-center gap-1.5">
                    <i class="fa-solid fa-robot text-amber-400 text-xs"></i>
                    <span>AI ရောဂါခွဲခြမ်း</span>
                </a>

                <!-- 4. News Page (Public) -->
                <a href="/news"
                   class="nav-link {{ request()->is('news*') ? 'active' : '' }} px-3 py-2 text-white/80 hover:text-white font-semibold text-xs xl:text-sm rounded-xl transition duration-200 flex items-center gap-1.5">
                    <i class="fa-solid fa-newspaper text-emerald-400 text-xs"></i>
                    <span>သတင်းများ</span>
                </a>

                <!-- 5. Marketplace Dropdown -->
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button @click="open = !open"
                            type="button"
                            class="nav-link {{ request()->is('posts*') || request()->is('sell*') ? 'active' : '' }} px-3 py-2 text-white/80 hover:text-white font-semibold text-xs xl:text-sm rounded-xl transition duration-200 flex items-center gap-1.5 focus:outline-none">
                        <i class="fa-solid fa-store text-amber-400 text-xs"></i>
                        <span>အရောင်းအဝယ်</span>
                        <i class="fa-solid fa-chevron-down text-[10px] opacity-70 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open"
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                         class="absolute left-0 mt-2 w-48 bg-emerald-950 border border-emerald-700/50 rounded-2xl shadow-2xl py-2 z-50 overflow-hidden">

                        <!-- ရောင်းရန်တင်မည် (Auth Required) -->
                        <a href="{{ auth()->check() ? route('postCreatePage') : route('login') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-emerald-100/90 hover:text-white hover:bg-emerald-800/50 transition">
                            <i class="fa-solid fa-plus-circle text-amber-400 w-4"></i>
                            <span>ရောင်းရန် တင်မည်</span>
                        </a>

                        <!-- အရောင်းပိုစ့်များ ကြည့်ရန် (Public) -->
                        <a href="{{ route('postListPage') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-emerald-100/90 hover:text-white hover:bg-emerald-800/50 transition">
                            <i class="fa-solid fa-list-ul text-amber-400 w-4"></i>
                            <span>အရောင်းပိုစ့်များ ကြည့်ရန်</span>
                        </a>
                    </div>
                </div>

                <!-- 6. Chat Feature (Auth Required) -->
                <a href="{{ auth()->check() ? route('chat.index') : route('login') }}"
                   class="nav-link {{ request()->is('chat*') ? 'active' : '' }} px-3 py-2 text-white/80 hover:text-white font-semibold text-xs xl:text-sm rounded-xl transition duration-200 flex items-center gap-1.5">
                    <i class="fa-solid fa-comments text-amber-400 text-xs"></i>
                    <span>စကားပြောရန်</span>
                </a>

            </div>

            <!-- ── Desktop Auth / Profile Dropdown ── -->
            <div class="hidden lg:flex items-center gap-2 shrink-0">
                @if(auth()->user())
                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                        <button @click="open = !open"
                                type="button"
                                class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-white/10 transition duration-200 focus:outline-none">
                            <div class="w-8 h-8 bg-amber-400/20 rounded-full flex items-center justify-center overflow-hidden border border-amber-400/40 shrink-0">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-user text-amber-400 text-xs"></i>
                                @endif
                            </div>
                            <span class="text-white/90 text-xs xl:text-sm font-semibold max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-white/60 text-[10px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="open"
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                             class="absolute right-0 mt-2 w-56 bg-emerald-950 border border-emerald-700/50 rounded-2xl shadow-2xl py-2 z-50 overflow-hidden">

                            <div class="px-4 py-2.5 border-b border-emerald-800/60 bg-emerald-900/30">
                                <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-emerald-200/60 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('profilePage') ?? '#' }}"
                                   class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-medium text-emerald-100/90 hover:text-white hover:bg-emerald-800/50 transition">
                                    <i class="fa-solid fa-id-card text-amber-400/80 w-4"></i>
                                    <span>ကိုယ်ရေးအချက်အလက်</span>
                                </a>

                                <a href="{{ route('editProfilePage') }}"
                                   class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-medium text-emerald-100/90 hover:text-white hover:bg-emerald-800/50 transition">
                                    <i class="fa-solid fa-user-pen text-amber-400/80 w-4"></i>
                                    <span>ပြင်ဆင်ရန်</span>
                                </a>
                            </div>

                            <div class="border-t border-emerald-800/60 pt-1 mt-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-medium text-red-300 hover:text-red-200 hover:bg-red-500/10 transition text-left">
                                        <i class="fa-solid fa-right-from-bracket w-4"></i>
                                        <span>ထွက်ရန်</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="text-white/80 hover:text-white text-xs xl:text-sm font-semibold px-3 py-2 rounded-xl transition duration-200">
                        ဝင်ရောက်ရန်
                    </a>
                    <a href="{{ route('register') }}"
                       class="nav-cta bg-amber-400 hover:bg-amber-300 text-emerald-950 font-extrabold text-xs xl:text-sm px-4 py-2 rounded-xl shadow-md transition duration-200">
                        အကောင့်ဖွင့်ရန်
                    </a>
                @endif
            </div>

            <!-- ── Mobile Hamburger ── -->
            <button id="hamburger-btn"
                    class="hamburger-btn lg:hidden flex flex-col justify-center items-center w-9 h-9 rounded-xl hover:bg-white/10 transition duration-200 focus:outline-none"
                    aria-label="Toggle Menu">
                <span class="hamburger-line block w-5 h-[2px] bg-white rounded-full mb-[5px]"></span>
                <span class="hamburger-line block w-5 h-[2px] bg-white rounded-full mb-[5px]"></span>
                <span class="hamburger-line block w-5 h-[2px] bg-white rounded-full"></span>
            </button>
        </div>

        <!-- ── Mobile Menu ── -->
        <div id="mobile-menu" class="mobile-menu lg:hidden mx-2 mt-2 bg-emerald-900/95 backdrop-blur-xl rounded-2xl border border-emerald-700/30 shadow-xl overflow-hidden">
            <div class="p-4 space-y-1">

                <!-- ဈေးကွက် (Public) -->
                <a href="/market"
                   class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/5 rounded-xl font-semibold text-sm transition duration-200 {{ request()->is('market*') ? 'bg-white/10 text-amber-400' : '' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center text-sm {{ request()->is('market*') ? 'text-amber-400' : 'text-emerald-400' }}"></i>
                    ဈေးကွက်
                </a>

                <!-- တိရစ္ဆာန်ရောဂါ (Public) -->
                <a href="{{ route('diseaseList') }}"
                   class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/5 rounded-xl font-semibold text-sm transition duration-200 {{ request()->is('user/disease*') ? 'bg-white/10 text-amber-400' : '' }}">
                    <i class="fa-solid fa-heart-pulse w-5 text-center text-sm {{ request()->is('user/disease*') ? 'text-amber-400' : 'text-emerald-400' }}"></i>
                    တိရစ္ဆာန်ရောဂါ
                </a>

                <!-- AI ရောဂါခွဲခြမ်း (Auth Required) -->
                <a href="{{ auth()->check() ? route('aiDisease.index') : route('login') }}"
                   class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/5 rounded-xl font-semibold text-sm transition duration-200 {{ request()->is('ai-disease*') ? 'bg-white/10 text-amber-400' : '' }}">
                    <i class="fa-solid fa-robot w-5 text-center text-sm text-amber-400"></i>
                    AI ရောဂါခွဲခြမ်း
                </a>

                <!-- သတင်းနှင့် ဗဟုသုတ (Public) -->
                <a href="/news"
                   class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/5 rounded-xl font-semibold text-sm transition duration-200 {{ request()->is('news*') ? 'bg-white/10 text-amber-400' : '' }}">
                    <i class="fa-solid fa-newspaper w-5 text-center text-sm {{ request()->is('news*') ? 'text-amber-400' : 'text-emerald-400' }}"></i>
                    သတင်းနှင့် ဗဟုသုတ
                </a>

                <!-- အရောင်းအဝယ် Dropdown -->
                <div x-data="{ open: false }" class="rounded-xl overflow-hidden">
                    <button @click="open = !open"
                            type="button"
                            class="w-full flex items-center justify-between px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/5 font-semibold text-sm transition duration-200">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-store w-5 text-center text-sm text-amber-400"></i>
                            <span>အရောင်းအဝယ်</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-cloak class="pl-12 pr-4 py-2 space-y-2 bg-emerald-950/40 border-l-2 border-amber-400/50 my-1">
                        <!-- ရောင်းရန် တင်မည် (Auth Required) -->
                        <a href="{{ auth()->check() ? route('postCreatePage') : route('login') }}"
                           class="flex items-center gap-2.5 text-xs text-white/80 hover:text-amber-400 py-1 transition">
                            <i class="fa-solid fa-plus-circle text-amber-400/80"></i>
                            <span>ရောင်းရန် တင်မည်</span>
                        </a>

                        <!-- အရောင်းပိုစ့်များ ကြည့်ရန် (Public) -->
                        <a href="{{ route('postListPage') }}"
                           class="flex items-center gap-2.5 text-xs text-white/80 hover:text-amber-400 py-1 transition">
                            <i class="fa-solid fa-list-ul text-amber-400/80"></i>
                            <span>အရောင်းပိုစ့်များ ကြည့်ရန်</span>
                        </a>
                    </div>
                </div>

                <!-- စကားပြောရန် (Auth Required) -->
                <a href="{{ auth()->check() ? route('chat.index') : route('login') }}"
                   class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/5 rounded-xl font-semibold text-sm transition duration-200 {{ request()->is('chat*') ? 'bg-white/10 text-amber-400' : '' }}">
                    <i class="fa-solid fa-comments w-5 text-center text-sm {{ request()->is('chat*') ? 'text-amber-400' : 'text-emerald-400' }}"></i>
                    စကားပြောရန်
                </a>

                <div class="border-t border-emerald-700/50 my-2"></div>

                @if(auth()->user())
                    <div class="px-4 py-2 mb-2 bg-emerald-950/40 rounded-xl border border-emerald-800/40">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-9 h-9 bg-amber-400/20 rounded-full flex items-center justify-center overflow-hidden border border-amber-400/40 shrink-0">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-user text-amber-400 text-xs"></i>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                                <p class="text-white/40 text-xs truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <div class="space-y-1 pt-1 border-t border-emerald-800/40">
                            <a href="{{ route('profilePage') ?? '#' }}" class="flex items-center gap-2 py-1.5 text-xs text-emerald-200 hover:text-white">
                                <i class="fa-solid fa-id-card text-amber-400 text-xs w-4"></i>
                                <span>ကိုယ်ရေးအချက်အလက်</span>
                            </a>
                            <a href="{{ route('editProfilePage') }}" class="flex items-center gap-2 py-1.5 text-xs text-emerald-200 hover:text-white">
                                <i class="fa-solid fa-user-pen text-amber-400 text-xs w-4"></i>
                                <span>ပြင်ဆင်ရန်</span>
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl font-semibold text-sm transition duration-200">
                            <i class="fa-solid fa-right-from-bracket w-5 text-center text-sm"></i>
                            အကောင့်မှထွက်ရန်
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/5 rounded-xl font-semibold text-sm transition duration-200">
                        <i class="fa-solid fa-right-to-bracket w-5 text-center text-sm text-emerald-400"></i>
                        အကောင့်ဝင်ရန်
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex items-center gap-3 px-4 py-2.5 bg-amber-400 text-emerald-950 hover:bg-amber-300 rounded-xl font-extrabold text-sm transition duration-200 mt-1">
                        <i class="fa-solid fa-user-plus w-5 text-center text-sm"></i>
                        အကောင့်ဖွင့်ရန်
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- ═══════════════════ MAIN CONTENT ═══════════════════ -->
    <main class="flex-grow pt-20 md:pt-24 pb-12">
        @yield('bdy')
    </main>

    <!-- ═══════════════════ FOOTER ═══════════════════ -->
    <footer class="bg-emerald-950 text-white/50 text-xs py-6 text-center border-t border-emerald-900/50 mt-auto">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('masterImages/logo.png') }}" class="h-6 w-6 rounded-lg object-cover opacity-60">
                    <span class="font-[Bricolage_Grotesque] font-bold text-white/70">Bliss Farm</span>
                </div>
                <p class="text-white/40">&copy; {{ date('Y') }} Bliss Farm. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- ═══════════════════ SCRIPTS ═══════════════════ -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // ── Navbar Scroll Effect ──
        const navbar = document.getElementById('navbar');
        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            lastScroll = currentScroll;
        });

        // ── Mobile Menu Toggle ──
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        hamburgerBtn.addEventListener('click', function() {
            this.classList.toggle('open');
            mobileMenu.classList.toggle('open');
        });

        // Close mobile menu on link click
        mobileMenu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                hamburgerBtn.classList.remove('open');
                mobileMenu.classList.remove('open');
            });
        });

        // Close mobile menu on outside click
        document.addEventListener('click', function(e) {
            if (!hamburgerBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                hamburgerBtn.classList.remove('open');
                mobileMenu.classList.remove('open');
            }
        });

    });
    </script>
</body>

</html>
