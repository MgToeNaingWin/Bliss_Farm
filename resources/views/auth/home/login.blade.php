@extends('auth.layouts.master')
@section('content')

<!-- Outer Container with Full Gradient Background -->
<div class="relative w-full max-w-4xl min-h-[520px] rounded-3xl overflow-hidden shadow-2xl shadow-emerald-950/30 bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900 flex flex-col md:flex-row my-auto">

    <!-- Decorative Glows -->
    <div class="absolute -top-12 -left-12 w-48 h-48 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-16 -right-16 w-60 h-60 bg-teal-400/15 rounded-full blur-3xl pointer-events-none"></div>

    <!-- ── LEFT PANEL: Welcome Banner Content (35% Width) ── -->
    <div class="w-full md:w-[35%] p-6 sm:p-8 flex flex-col justify-between items-center text-center text-white z-10">

        <!-- Top Content (Logo + Texts Positioned at the Top) -->
        <div class="flex flex-col items-center gap-3 mt-2">
            <div class="p-2 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-lg">
                <img src="{{ asset('masterImages/logo.png') }}"
                     class="h-12 w-12 rounded-xl object-cover">
            </div>
            <div>
                <h2 class="text-xl font-black tracking-tight text-emerald-100">ပြန်လည်ကြိုဆိုပါသည်!</h2>

                <!-- Logo အောက်မှ Description စာသား -->
                <p class="text-xs text-emerald-100/90 mt-2 leading-relaxed">
                    Bliss Farm မှ ကြိုဆိုပါသည်။ စိုက်ပျိုးရေးနှင့် မွေးမြူရေးဆိုင်ရာ ဝန်ဆောင်မှုများကို ဆက်လက်အသုံးပြုရန် အကောင့်ဝင်ရောက်ပါ။
                </p>
            </div>
        </div>

        <!-- Bottom Register Link -->
        <div class="w-full mt-6 mb-2">
            <p class="text-[11px] text-emerald-200/80 mb-2">အကောင့်မရှိသေးပါက</p>
            <a href="{{ route('register') }}"
               class="inline-block w-full bg-white/10 hover:bg-white/20 text-white font-bold text-xs text-center py-2.5 px-4 rounded-xl border border-white/30 backdrop-blur-md transition duration-200 shadow-sm">
                အကောင့်သစ်ဖွင့်ရန်
            </a>
        </div>
    </div>

    <!-- ── RIGHT PANEL: Login Form with Curved Shape Cutout (65% Width) ── -->
    <div class="w-full md:w-[65%] relative z-10 flex flex-col justify-center">

        <!-- White Background Overlay with Curved Wave Edge -->
        <form action="{{ route('login') }}" method="POST"
              class="w-full h-full bg-stone-50/95 backdrop-blur-md rounded-t-[40px] md:rounded-t-none md:rounded-l-[80px] shadow-2xl p-6 sm:p-10 flex flex-col justify-center gap-3.5">
            @csrf

            <!-- Centered Title Section -->
            <div class="mb-1 text-center">
                <h1 class="text-2xl font-extrabold text-emerald-950 tracking-tight">အကောင့်ဝင်ရန်</h1>
                <p class="text-xs text-stone-500 mt-0.5">သင့်အီးမေးလ်နှင့် စကားဝှက်ကို ဖြည့်သွင်းပါ</p>
            </div>

            <!-- Email Input Field -->
            <div>
                <label class="block text-[11px] font-bold text-stone-600 mb-1">အီးမေးလ်</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="အီးမေးလ် ရိုက်ထည့်ပါ"
                       class="text-xs rounded-xl px-3.5 py-2.5 transition duration-200 border border-stone-200 w-full bg-white focus:border-emerald-500 focus:outline-none focus:ring-0 shadow-sm @error('email') border-red-500 @enderror">
                @error('email')
                    <small class="text-red-500 text-[11px] mt-1 block">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password Input Field -->
            <div>
                <label class="block text-[11px] font-bold text-stone-600 mb-1">စကားဝှက်</label>
                <input type="password" name="password" placeholder="စကားဝှက် ရိုက်ထည့်ပါ"
                       class="text-xs rounded-xl px-3.5 py-2.5 transition duration-200 border border-stone-200 w-full bg-white focus:border-emerald-500 focus:outline-none focus:ring-0 shadow-sm @error('password') border-red-500 @enderror">
                @error('password')
                    <small class="text-red-500 text-[11px] mt-1 block">{{ $message }}</small>
                @enderror
            </div>

            <!-- Full Width Green Login Button (Matching Register Style) -->
            <div class="mt-1 w-full">
                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2.5 px-4 text-xs rounded-xl transition duration-200 shadow-md">
                    အကောင့်ဝင်မည်
                </button>
            </div>

            <!-- Divider -->
            <div class="relative flex py-0.5 items-center">
                <div class="flex-grow border-t border-stone-200"></div>
                <span class="flex-shrink mx-3 text-stone-400 text-[10px] uppercase font-bold">သို့မဟုတ်</span>
                <div class="flex-grow border-t border-stone-200"></div>
            </div>

            <!-- Equal Horizontal Bottom Action Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <!-- Guest Route Link -->
                <a href="/home"
                   class="bg-amber-400 hover:bg-amber-500 text-emerald-950 font-bold text-center py-2.5 px-3 text-xs rounded-xl transition duration-200 shadow-sm flex items-center justify-center">
                    <i class="fa-solid fa-user-clock mr-1.5"></i> ဧည့်သည်အဖြစ် ဝင်ရန်
                </a>

                <!-- Social Login Button -->
                <x-social-login-button href="{{ route('socialLogin', 'google') }}">
                    <i class="fa-brands fa-google me-1.5"></i> Google ဖြင့် ဝင်ရန်
                </x-social-login-button>
            </div>

            <!-- Mobile Only Register Link -->
            <div class="flex md:hidden justify-center items-center mt-1">
                <p class="text-center text-xs text-stone-500">အကောင့်မရှိသေးပါက -</p>
                <a href="{{ route('register') }}" class="ms-1.5 text-xs font-bold text-emerald-700 hover:underline">အကောင့်သစ်ဖွင့်ရန်</a>
            </div>

        </form>
    </div>

</div>
@endsection
