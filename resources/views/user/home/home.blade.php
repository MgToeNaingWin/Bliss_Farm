@extends('user.layouts.master')
@section('content')

<div class="relative w-screen  h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1516467508483-a7212febe31a?auto=format&fit=crop&q=80&w=1200');">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 flex flex-col items-center justify-center h-screen text-center text-white px-4">

        <h1 class="text-4xl md:text-6xl font-bold tracking-wide leading-tight mb-4">
            Welcome to <span class="text-yellow-400">Bliss Farm</span>
        </h1>

        <p class="text-base md:text-xl text-gray-200 mb-8 max-w-2xl">
           Empowering veterinary care with advanced AI. We deliver instant, data-driven health insights to keep your beloved animals safe and healthy.
        </p>

        <div class="flex gap-4">
            <button class="bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-bold py-3 px-6 rounded-full transition duration-300 transform hover:scale-105">
                Find a Home
            </button>
            <button class="border-2 border-white hover:bg-white hover:text-slate-950 font-bold py-3 px-6 rounded-full transition duration-300 animate-glow">
                Consult With Ai
            </button>
        </div>

    </div>
</div>

@endsection
