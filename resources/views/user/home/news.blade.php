@extends('user.layouts.master')
@section('bdy')


<div class="relative w-screen h-screen overflow-hidden bg-black">
    <div id="carousel-slides" class="flex h-full transition-transform duration-500 ease-in-out" style="transform: translateX(0%);">

        <div class="min-w-full h-full relative">
            <img src="{{asset('masterImages/cowsi.jpeg')}}"alt="Slide 1" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-8 md:p-16">
                <div class="text-white max-w-xl">
                    <h3 class="text-3xl md:text-5xl font-extrabold mb-2 tracking-tight">Beautiful Mountains</h3>
                    <p class="text-base md:text-lg text-gray-200">Explore the vast, untouched wilderness and find your next great outdoor adventure.</p>
                </div>
            </div>
        </div>

        <div class="min-w-full h-full relative">
            <img src="https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=1920&auto=format&fit=crop&q=80" alt="Slide 2" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-8 md:p-16">
                <div class="text-white max-w-xl">
                    <h3 class="text-3xl md:text-5xl font-extrabold mb-2 tracking-tight">Misty Forests</h3>
                    <p class="text-base md:text-lg text-gray-200">Disconnect from the noise and get lost in nature's quietest morning sanctuaries.</p>
                </div>
            </div>
        </div>

        <div class="min-w-full h-full relative">
            <img src="https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?w=1920&auto=format&fit=crop&q=80" alt="Slide 3" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-8 md:p-16">
                <div class="text-white max-w-xl">
                    <h3 class="text-3xl md:text-5xl font-extrabold mb-2 tracking-tight">Serene Woodlands</h3>
                    <p class="text-base md:text-lg text-gray-200">Discover the peaceful rhythm of the old-growth trees rustling in the wind.</p>
                </div>
            </div>
        </div>

    </div>

    <button id="prev-btn" class="absolute top-1/2 left-6 -translate-y-1/2 bg-black/20 hover:bg-black/50 text-white p-3 rounded-full focus:outline-none transition backdrop-blur-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
    </button>

    <button id="next-btn" class="absolute top-1/2 right-6 -translate-y-1/2 bg-black/20 hover:bg-black/50 text-white p-3 rounded-full focus:outline-none transition backdrop-blur-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
    </button>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex space-x-3">
        <button class="indicator w-4 h-4 rounded-full bg-white transition-all duration-300 transform scale-110" data-slide="0"></button>
        <button class="indicator w-4 h-4 rounded-full bg-white/40 transition-all duration-300" data-slide="1"></button>
        <button class="indicator w-4 h-4 rounded-full bg-white/40 transition-all duration-300" data-slide="2"></button>
    </div>
</div>

@endsection