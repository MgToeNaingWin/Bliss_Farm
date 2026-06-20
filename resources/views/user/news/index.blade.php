@extends('user.layouts.master')
@section('bdy')


<!-- <div class="relative w-screen h-screen overflow-hidden bg-black">
    <div id="carousel-slides" class="flex h-full transition-transform duration-500 ease-in-out" style="transform: translateX(0%);">

        <div class="min-w-full h-full relative">
            <img src="{{asset('masterImages/cowsi.jpeg')}}" alt="Slide 1" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to from-black/70 via-transparent to-transparent flex items-end p-8 md:p-16">
                <div class="text-white max-w-xl">
                    <h3 class="text-3xl md:text-5xl font-extrabold mb-2 tracking-tight">Beautiful Mountains</h3>
                    <p class="text-base md:text-lg text-gray-200">Explore the vast, untouched wilderness and find your next great outdoor adventure.</p>
                </div>
            </div>
        </div>

        <div class="min-w-full h-full relative">
            <img src="https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=1920&auto=format&fit=crop&q=80" alt="Slide 2" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to- from-black/70 via-transparent to-transparent flex items-end p-8 md:p-16">
                <div class="text-white max-w-xl">
                    <h3 class="text-3xl md:text-5xl font-extrabold mb-2 tracking-tight">Misty Forests</h3>
                    <p class="text-base md:text-lg text-gray-200">Disconnect from the noise and get lost in nature's quietest morning sanctuaries.</p>
                </div>
            </div>
        </div>

        <div class="min-w-full h-full relative">
            <img src="https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?w=1920&auto=format&fit=crop&q=80" alt="Slide 3" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to from-black/70 via-transparent to-transparent flex items-end p-8 md:p-16">
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
<div class="flex items-center justify-center min-h-screen bg-slate-900 p-6">
    <div class="w-full max-w-sm bg-slate-800 border border-slate-700/50 rounded-2xl shadow-xl hover:shadow-2xl hover:border-slate-600/50 transition-all duration-300 overflow-hidden group">
        
        <div class="h-28 bg-gradient-to from-violet-600 to-indigo-600 relative">
            <span class="absolute top-4 right-4 bg-slate-900/40 backdrop-blur-md text-violet-200 text-xs font-medium px-2.5 py-1 rounded-full border border-violet-500/20">
                Available
            </span>
        </div>

        
        <div class="px-6 pb-6 text-center">
            
            <div class="relative w-24 h-24 mx-auto -mt-12 mb-4 rounded-full ring-4 ring-slate-800 overflow-hidden bg-slate-700">
                <img
                    src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&h=256&fit=crop"
                    alt="Sarah Jenkins"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            </div>

            
            <h2 class="text-xl font-bold text-slate-100 tracking-tight">Sarah Jenkins</h2>
            <p class="text-sm font-medium text-violet-400 mb-3">Senior Product Designer</p>

            <p class="text-sm text-slate-400 leading-relaxed mb-5">
                Crafting scalable design systems and intuitive user experiences. Formerly at Stripe and Airbnb.
            </p>

            
            <div class="flex flex-wrap justify-center gap-1.5 mb-6">
                <span class="text-xs font-medium bg-slate-700/50 text-slate-300 px-2.5 py-1 rounded-md border border-slate-600/30">UI/UX</span>
                <span class="text-xs font-medium bg-slate-700/50 text-slate-300 px-2.5 py-1 rounded-md border border-slate-600/30">Figma</span>
                <span class="text-xs font-medium bg-slate-700/50 text-slate-300 px-2.5 py-1 rounded-md border border-slate-600/30">Tailwind</span>
                <span class="text-xs font-medium bg-slate-700/50 text-slate-300 px-2.5 py-1 rounded-md border border-slate-600/30">React</span>
            </div>

            
            <div class="flex gap-3">
                <button class="flex-1 bg-violet-600 hover:bg-violet-500 active:bg-violet-700 text-white text-sm font-semibold py-2.5 px-4 rounded-xl shadow-lg shadow-violet-600/20 transition-colors duration-200">
                    Follow
                </button>
                <button class="flex-1 bg-slate-700 hover:bg-slate-600 active:bg-slate-700 text-slate-200 text-sm font-semibold py-2.5 px-4 rounded-xl border border-slate-600/50 transition-colors duration-200">
                    Message
                </button>
            </div>
        </div>
    </div>
</div>
-->
<div class="relative w-screen  h-screen bg-cover bg-center bg-no-repeat" style="background-color: oklch(39.1% 0.09 240.876)">

    <div class="pt-25 px-9">
        @foreach ($news as $new)

        <a href="" class="block p-4  border-white border-2 rounded-lg m-2  bg-blue-200">
            <div class="font-bold text-blace">{{ $new->title }}</div>
            <div class="div flex items-center justify-between gap-4">
    <p class="text-white mb-0">{{ $new->description }}</p>
    <x-danger-button class="whitespace-nowrap">See More</x-danger-button>
</div>


        </a>
        @endforeach
    </div>

    <div class=" inset-0 bg-black/50"></div>
    @endsection