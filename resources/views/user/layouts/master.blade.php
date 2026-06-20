<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bliss_Farm</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Pliant:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
        }
    </style>
</head>

<body class="overflow-x-hidden m-0 p-0 ">
    <div
        class="absolute top-0 left-0 right-0 z-50 items-center flex justify-between bg-nav-color p-2 shadow-2xl rounded-full mt-5 border-2 border-amber-50 w-[95%] mx-auto">
        <div class="rounded-full">
            <a href="/home">
                <img src="{{asset('masterImages/logo.png')}}" class="h-12 w-12 border-green-600 border-2 rounded-full ms-5">
            </a>
        </div>
        <ul class="items-center flex justify-center me-5 align-middle">
            <li class="mx-5 text-white font-bold text-lg cursor-pointer">
                <a href="/disease-info"
                    class="{{ request()->is('disease-info') ? 'border-b-2 border-amber-50' : 'border-b-2 border-transparent hover:border-amber-50' }} duration-300 ease-in-out transition pb-1">
                    Disease-Info
                </a>
            </li>
            <li class="mx-5 text-white font-bold text-lg cursor-pointer">
                <a href="/news"
                    class="{{ request()->is('news') ? 'border-b-2 border-amber-50' : 'border-b-2 border-transparent hover:border-amber-50' }} duration-300 ease-in-out transition pb-1">
                    NEWS
                </a>
            </li>
            <li class="mx-5 text-white font-bold text-lg cursor-pointer">
                <a href="/market"
                    class="{{ request()->is('market') ? 'border-b-2 border-amber-50' : 'border-b-2 border-transparent hover:border-amber-50' }} duration-300 ease-in-out transition pb-1">
                    Market
                </a>
            </li>
            <li class=" ms-5 animate-glow text-white font-bold text-lg cursor-pointer bg-yellow-300 px-3 py-1 rounded-full">
                @if(auth()->user())
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <input type="submit" value="Logout" class=" border-transparent hover:border-amber-50 duration-300 ease-in-out transition pb-1 text-olive-500">
                </input>
                </form>
                @else
                  <a href="{{route('register')}}" class="border-transparent hover:border-amber-50 duration-300 ease-in-out transition pb-1 text-olive-500">
                    Sign Up
                </a>
                @endif

{{-- >>>>>>> restore-auth-branch --}}
            </li>
        </ul>
    </div>


    @yield('content')

    <div>
        @yield('bdy')
    </div>
</body>
<script>
    const slidesContainer = document.getElementById('carousel-slides');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const indicators = document.querySelectorAll('.indicator');

    let currentIndex = 0;
    const totalSlides = slidesContainer.children.length;
    let autoPlayTimer;

    function updateCarousel(index) {
        if (index >= totalSlides) currentIndex = 0;
        else if (index < 0) currentIndex = totalSlides - 1;
        else currentIndex = index;

        // Slide the track horizontally
        slidesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;

        // Synchronize indicator dot active styles
        indicators.forEach((dot, i) => {
            if (i === currentIndex) {
                dot.classList.remove('bg-white/40');
                dot.classList.add('bg-white', 'scale-110');
            } else {
                dot.classList.remove('bg-white', 'scale-110');
                dot.classList.add('bg-white/40');
            }
        });

        // Reset timer on user interaction so it doesn't instantly flip slides
        resetAutoPlay();
    }

    // Auto Play Controls
    function startAutoPlay() {
        autoPlayTimer = setInterval(() => {
            updateCarousel(currentIndex + 1);
        }, 6000); // Transitions every 6 seconds
    }

    function resetAutoPlay() {
        clearInterval(autoPlayTimer);
        startAutoPlay();
    }

    // Event Listeners
    nextBtn.addEventListener('click', () => updateCarousel(currentIndex + 1));
    prevBtn.addEventListener('click', () => updateCarousel(currentIndex - 1));

    indicators.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const slideIndex = parseInt(e.target.getAttribute('data-slide'));
            updateCarousel(slideIndex);
        });
    });

    // Initialize layout and timers
    updateCarousel(0);
</script>

</html>
