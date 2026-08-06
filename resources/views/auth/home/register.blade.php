@extends('auth.layouts.master')
@section('content')

<!-- Outer Container with Full Gradient Background -->
<div class="relative w-full max-w-4xl min-h-[520px] rounded-3xl overflow-hidden shadow-2xl shadow-emerald-950/30 bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900 flex flex-col md:flex-row my-auto">

    <!-- Decorative Glows -->
    <div class="absolute -top-12 -left-12 w-48 h-48 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-16 -right-16 w-60 h-60 bg-teal-400/15 rounded-full blur-3xl pointer-events-none"></div>

    <!-- ── LEFT PANEL: Banner Content (35% Width) ── -->
    <div class="w-full md:w-[35%] p-6 sm:p-8 flex flex-col justify-between items-center text-center text-white z-10">

        <!-- Top Content (Restored to Original Top Position) -->
        <div class="flex flex-col items-center gap-3 mt-2">
            <div class="p-2 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-lg">
                <img src="{{ asset('masterImages/logo.png') }}"
                     class="h-12 w-12 rounded-xl object-cover">
            </div>
            <div>
                <h2 class="text-xl font-black tracking-tight text-emerald-100">ကြိုဆိုပါသည်!</h2>

                <!-- Logo အောက်မှ Description စာသား -->
                <p class="text-xs text-emerald-100/90 mt-2 leading-relaxed">
                    စိုက်ပျိုးရေးနှင့် မွေးမြူရေးဆိုင်ရာ သတင်းအချက်အလက်များ၊ ဈေးကွက်ပေါက်ဈေးများနှင့် AI နည်းပညာများကို Bliss Farm တွင် လွယ်ကူစွာ လေ့လာနိုင်ပါပြီ။
                </p>
            </div>
        </div>

        <!-- Bottom Login Link -->
        <div class="w-full mt-6 mb-2">
            <p class="text-[11px] text-emerald-200/80 mb-2">အကောင့်ရှိပြီးသားဖြစ်ပါက</p>
            <a href="{{ route('login') }}"
               class="inline-block w-full bg-white/10 hover:bg-white/20 text-white font-bold text-xs text-center py-2.5 px-4 rounded-xl border border-white/30 backdrop-blur-md transition duration-200 shadow-sm">
                အကောင့်ဝင်ရန်
            </a>
        </div>
    </div>

    <!-- ── RIGHT PANEL: Form with Curved Shape Cutout (65% Width) ── -->
    <div class="w-full md:w-[65%] relative z-10 flex flex-col justify-center">

        <!-- White Background Overlay with Curved Wave Edge -->
        <form action="{{ route('register') }}" method="POST"
              class="w-full h-full bg-stone-50/95 backdrop-blur-md rounded-t-[40px] md:rounded-t-none md:rounded-l-[80px] shadow-2xl p-6 sm:p-10 flex flex-col justify-center gap-3.5">
            @csrf

            <!-- Form Title (Centered) -->
            <div class="mb-1 text-center">
                <h1 class="text-2xl font-extrabold text-emerald-950 tracking-tight">အကောင့်သစ်ဖွင့်ရန်</h1>
                <p class="text-xs text-stone-500 mt-0.5">ကျေးဇူးပြု၍ သင့်အချက်အလက်များကို ဖြည့်သွင်းပေးပါ</p>
            </div>

            <!-- Name + Email side by side -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Name Field -->
                <div>
                    <label class="block text-[11px] font-bold text-stone-600 mb-1">အသုံးပြုသူအမည်</label>
                    <input type="text" name="name" placeholder="အမည် ရိုက်ထည့်ပါ"
                           class="text-xs rounded-xl px-3.5 py-2.5 transition duration-200 border border-stone-200 w-full bg-white focus:border-emerald-500 focus:outline-none focus:ring-0 shadow-sm"
                           value="{{ old('name') }}">
                    @error('name')
                        <small class="text-red-500 text-[11px] mt-1 block">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label class="block text-[11px] font-bold text-stone-600 mb-1">အီးမေးလ်</label>
                    <input type="email" name="email" placeholder="အီးမေးလ် ရိုက်ထည့်ပါ"
                           class="text-xs rounded-xl px-3.5 py-2.5 transition duration-200 border border-stone-200 w-full bg-white focus:border-emerald-500 focus:outline-none focus:ring-0 shadow-sm"
                           value="{{ old('email') }}">
                    @error('email')
                        <small class="text-red-500 text-[11px] mt-1 block">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Password + Confirm Password side by side -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Password Field -->
                <div>
                    <label class="block text-[11px] font-bold text-stone-600 mb-1">စကားဝှက်</label>
                    <input type="password" name="password" placeholder="စကားဝှက် ရိုက်ထည့်ပါ"
                           class="text-xs rounded-xl px-3.5 py-2.5 transition duration-200 border border-stone-200 w-full bg-white focus:border-emerald-500 focus:outline-none focus:ring-0 shadow-sm">
                    @error('password')
                        <small class="text-red-500 text-[11px] mt-1 block">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label class="block text-[11px] font-bold text-stone-600 mb-1">စကားဝှက် အတည်ပြုပါ</label>
                    <input type="password" name="password_confirmation" placeholder="စကားဝှက် ပြန်ရိုက်ထည့်ပါ"
                           class="text-xs rounded-xl px-3.5 py-2.5 transition duration-200 border border-stone-200 w-full bg-white focus:border-emerald-500 focus:outline-none focus:ring-0 shadow-sm">
                    @error('password_confirmation')
                        <small class="text-red-500 text-[11px] mt-1 block">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Full Width Sign Up Button -->
            <div class="mt-1 w-full">
                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2.5 px-4 text-xs rounded-xl transition duration-200 shadow-md">
                    အကောင့်ဖွင့်မည်
                </button>
            </div>

            <!-- Divider -->
            <div class="relative flex py-0.5 items-center">
                <div class="flex-grow border-t border-stone-200"></div>
                <span class="flex-shrink mx-3 text-stone-400 text-[10px] uppercase font-bold">သို့မဟုတ်</span>
                <div class="flex-grow border-t border-stone-200"></div>
            </div>

            <!-- Bottom Action Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <!-- Guest Route Link -->
                <a href="/home"
                   class="bg-amber-400 hover:bg-amber-500 text-emerald-950 font-bold text-center py-2.5 px-3 text-xs rounded-xl transition duration-200 shadow-sm flex items-center justify-center">
                    <i class="fa-solid fa-user-clock mr-1.5"></i> ဧည့်သည်အဖြစ် ဝင်ရန်
                </a>

                <!-- Social Login Component -->
                <x-social-login-button href="{{ route('socialLogin', 'google') }}">
                    <i class="fa-brands fa-google me-1.5"></i> Google ဖြင့် ဝင်ရန်
                </x-social-login-button>
            </div>

        </form>
    </div>

</div>
@endsection
