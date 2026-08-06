<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bliss Farm Admin Dashboard</title>

    {{-- fontawesome cdn link  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Pliant:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        *, body {
            font-family: 'helvetica', sans-serif !important;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="min-h-screen">

    <!-- Mobile Sidebar Backdrop (Overlay) -->
    <div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black/40 transition-opacity duration-300 hidden xl:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="bg-gradient-to-br from-green-700 to-green-800 -translate-x-80 fixed inset-y-0 left-0 z-50 h-screen w-72 transition-transform duration-300 xl:translate-x-0 shadow-lg">
        <div class="relative border-b border-white/10">
            <a class="flex items-center justify-between gap-4 py-6 px-8" href="#/">
                <h6 class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-white">
                    <span>သုခခြံ</span> စီမံခန့်ခွဲမှု Dashboard
                </h6>
                <img src="{{ asset('masterImages/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-full border border-white/20 object-cover">
            </a>

            <!-- Mobile Close Button -->
            <button id="sidebar-close-btn" class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded-lg text-white/70 hover:text-white hover:bg-white/10 xl:hidden focus:outline-none" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Sidebar Navigation List -->
        <div class="mx-4 my-6 overflow-y-auto h-[calc(100vh-120px)] pr-1">
            <ul class="mb-4 flex flex-col gap-1">
                <!-- Dashboard -->
                <li>
                    <a href="{{route('adminHome')}}">
                        <button class="middle none font-sans font-bold transition-all text-xs py-3 rounded-lg w-full flex items-center gap-4 px-4 capitalize focus:outline-none {{ request()->is('admin/dashboard') || request()->is('#') ? 'bg-white/20 text-white shadow-sm' : 'text-white hover:bg-white/10' }}" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-inherit">
                                <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"></path>
                                <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"></path>
                            </svg>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium">ပင်မစာမျက်နှာ</p>
                        </button>
                    </a>
                </li>

                <!-- News -->
                <li>
                    <a href="{{ route('newsCreatePage') }}">
                        <button class="middle none font-sans font-bold transition-all text-xs py-3 rounded-lg w-full flex items-center gap-4 px-4 capitalize focus:outline-none {{ request()->routeIs('newsCreatePage') ? 'bg-white/20 text-white shadow-sm' : 'text-white hover:bg-white/10' }}" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium">သတင်းများ</p>
                        </button>
                    </a>
                </li>

                <!-- Diseases -->
                <li>
                    <a href="{{ route('diseaseCreatePage') }}">
                        <button class="middle none font-sans font-bold transition-all text-xs py-3 rounded-lg w-full flex items-center gap-4 px-4 capitalize focus:outline-none {{ request()->routeIs('diseaseCreatePage') ? 'bg-white/20 text-white shadow-sm' : 'text-white hover:bg-white/10' }}" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0 1 12 12.75Zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 0 1-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.208 1.44.125 2.104.52 4.136 1.153 6.06M12 12.75a2.25 2.25 0 0 0 2.248-2.354M12 12.75a2.25 2.25 0 0 1-2.248-2.354M12 8.25c.995 0 1.971-.08 2.922-.236.403-.066.74-.358.795-.762a3.778 3.778 0 0 0-.399-2.25M12 8.25c-.995 0-1.97-.08-2.922-.236-.402-.066-.74-.358-.795-.762a3.734 3.734 0 0 1 .4-2.253M12 8.25a2.25 2.25 0 0 0-2.248 2.146M12 8.25a2.25 2.25 0 0 1 2.248 2.146M8.683 5a6.032 6.032 0 0 1-1.155-1.002c.07-.63.27-1.222.574-1.747m.581 2.749A3.75 3.75 0 0 1 15.318 5m0 0c.427-.283.815-.62 1.155-.999a4.471 4.471 0 0 0-.575-1.752M4.921 6a24.048 24.048 0 0 0-.392 3.314c1.668.546 3.416.914 5.223 1.082M19.08 6c.205 1.08.337 2.187.392 3.314a23.882 23.882 0 0 1-5.223 1.082" />
                            </svg>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium">ရောဂါများ</p>
                        </button>
                    </a>
                </li>

                <!-- Profile -->
                <li>
                    <a href="{{route('admin.profile.index')}}">
                        <button class="middle none font-sans font-bold transition-all text-xs py-3 rounded-lg w-full flex items-center gap-4 px-4 capitalize focus:outline-none {{ request()->is('admin/profile') ? 'bg-white/20 text-white shadow-sm' : 'text-white hover:bg-white/10' }}" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-inherit">
                                <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium">ကိုယ်ရေးအချက်အလက်</p>
                        </button>
                    </a>
                </li>
                 <li>
                    <a href="{{route('admin.users.create')}}">
                        <button class="middle none font-sans font-bold transition-all text-xs py-3 rounded-lg text-white hover:bg-white/10 w-full flex items-center gap-4 px-4 capitalize focus:outline-none" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-inherit">
                                <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                            </svg>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium">အကောင့်များစီမံရန်</p>
                        </button>
                    </a>
                </li>

                <!-- Tables -->
                <li>
                    <a href="#">
                        <button class="middle none font-sans font-bold transition-all text-xs py-3 rounded-lg w-full flex items-center gap-4 px-4 capitalize focus:outline-none {{ request()->is('admin/tables') ? 'bg-white/20 text-white shadow-sm' : 'text-white hover:bg-white/10' }}" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-inherit">
                                <path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium">ဇယားများ</p>
                        </button>
                    </a>
                </li>

                <!-- Notifications -->
                <li>
                    <a href="#">
                        <button class="middle none font-sans font-bold transition-all text-xs py-3 rounded-lg w-full flex items-center gap-4 px-4 capitalize focus:outline-none {{ request()->is('admin/notifications') ? 'bg-white/20 text-white shadow-sm' : 'text-white hover:bg-white/10' }}" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-inherit">
                                <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium">အကြောင်းကြားချက်များ</p>
                        </button>
                    </a>
                </li>
            </ul>

            <!-- Auth Section -->
            <ul class="mb-4 flex flex-col gap-1">
                {{-- <li class="mx-3.5 mt-4 mb-2">
                    <p class="block antialiased font-sans text-sm leading-normal text-white font-black uppercase opacity-75">အကောင့်ဝင်ရောက်ခြင်း စာမျက်နှာများ</p>
                </li> --}}
                <li>
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button type="submit" class="middle none font-sans font-bold transition-all text-xs py-3 rounded-lg text-white hover:bg-white/10 w-full flex items-center gap-4 px-4 capitalize focus:outline-none" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-inherit">
                                <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium">အကောင့်မှထွက်ရန်</p>
                        </button>
                    </form>
                </li>

            </ul>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="xl:ml-72 min-h-screen flex flex-col">

        <!-- TOP NAVIGATION BAR -->
        <header class="bg-white border-b border-gray-100 py-4 px-6 flex items-center justify-between shadow-sm sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <!-- Mobile Toggle Button -->
                <button id="sidebar-open-btn" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 xl:hidden focus:outline-none" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-lg font-bold text-gray-800 tracking-tight">Bliss Farm</h1>
            </div>

            <!-- Profile Info at top-right (Dynamic) -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-semibold text-gray-700">
                        {{ Auth::check() ? Auth::user()->name : 'Salinas Admin' }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ Auth::check() ? Auth::user()->email : 'salinas@blissfarm.com' }}
                    </p>
                </div>

                @if(Auth::check() && Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                         alt="{{ Auth::user()->name }}"
                         class="h-9 w-9 rounded-full object-cover border border-gray-200">
                @else
                    <img src="{{ asset('masterImages/logo.png') }}"
                         alt="Default Logo"
                         class="h-9 w-9 rounded-full object-cover border border-gray-200">
                @endif
            </div>
        </header>

        <!-- Dynamic Content Section -->
        <main class="p-4 sm:p-6 flex-grow">
            @yield('content')
            @include('sweetalert::alert')
        </main>

    </div>
</div>

<!-- SIMPLE SIDEBAR TOGGLE SCRIPT -->
<script>
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    const openBtn = document.getElementById('sidebar-open-btn');
    const closeBtn = document.getElementById('sidebar-close-btn');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-80');
        sidebar.classList.add('translate-x-0');
        backdrop.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-80');
        backdrop.classList.add('hidden');
    }

    openBtn.addEventListener('click', openSidebar);
    closeBtn.addEventListener('click', closeSidebar);
    backdrop.addEventListener('click', closeSidebar);
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Laravel Sessions triggered SweetAlert Notification -->
    @if(session('sweet_success'))
    <script>
        Swal.fire({
            title: "အောင်မြင်ပါသည်။",
            text: "{{ session('sweet_success') }}",
            icon: "success",
            confirmButtonText: "ပိတ်မည်",
            confirmButtonColor: "#16a34a",
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-4 py-2 text-sm font-semibold'
            }
        });
    </script>
    @endif

    @if(session('sweet_error'))
    <script>
        Swal.fire({
            title: "သတိပေးချက်!",
            text: "{{ session('sweet_error') }}",
            icon: "error",
            confirmButtonText: "နားလည်ပြီ",
            confirmButtonColor: "#d33",
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-4 py-2 text-sm font-semibold'
            }
        });
    </script>
    @endif

</body>
</html>
