    {{--
    Read-Only User Profile Page
    Extends your shared master layout
--}}
@extends('user.layouts.master')

@section('bdy')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-6">

    {{-- ═══════════════ TOP BAR / BACK BUTTON ═══════════════ --}}
    {{-- <div class="mb-6 flex items-center justify-between">
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-2 bg-white hover:bg-emerald-50 text-emerald-900 border border-emerald-200 hover:border-emerald-300 font-semibold text-sm px-4 py-2 rounded-xl transition-all shadow-sm group">
            <i class="fa-solid fa-arrow-left text-xs text-emerald-700 group-hover:-translate-x-1 transition-transform"></i>
            <span>နောက်သို့</span>
        </a>
    </div> --}}

    {{-- ═══════════════ PROFILE HEADER CARD ═══════════════ --}}
    <div class="relative bg-emerald-900 rounded-2xl overflow-hidden shadow-lg shadow-emerald-950/10 mb-6">
        {{-- Decorative Background Gradients --}}
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 via-emerald-900 to-emerald-950"></div>
        <div class="absolute -right-10 -top-10 w-56 h-56 bg-amber-400/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-8 -bottom-8 w-40 h-40 bg-emerald-400/10 rounded-full blur-2xl"></div>

        <div class="relative px-6 sm:px-8 py-8 sm:py-10 flex flex-col sm:flex-row items-center sm:items-end gap-6">
            {{-- Avatar (Read-Only) --}}
            <div class="shrink-0">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl border-4 border-emerald-950/40 shadow-xl overflow-hidden bg-emerald-800">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                             alt="{{ auth()->user()->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fa-solid fa-user text-amber-400 text-4xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Main Metadata --}}
            <div class="text-center sm:text-left flex-grow">
                <h1 class="font-[Bricolage_Grotesque] text-white text-2xl sm:text-3xl font-extrabold">
                    {{ auth()->user()->name }}
                </h1>

                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-2">
                    {{-- Role Badge --}}
                    <span class="inline-flex items-center gap-1.5 bg-amber-400/15 text-amber-300 text-xs font-bold px-3 py-1 rounded-full border border-amber-400/20">
                        <i class="fa-solid fa-shield-halved text-[10px]"></i>
                        {{ auth()->user()->role === 'admin' ? 'စီမံခန့်ခွဲသူ' : 'အသုံးပြုသူ' }}
                    </span>

                    {{-- Email Verification Badge --}}
                    @if(auth()->user()->email_verified_at)
                        <span class="inline-flex items-center gap-1.5 bg-emerald-400/15 text-emerald-300 text-xs font-bold px-3 py-1 rounded-full border border-emerald-400/20">
                            <i class="fa-solid fa-circle-check text-[10px]"></i>
                            အီးမေးလ် အတည်ပြုပြီး
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 bg-red-400/15 text-red-300 text-xs font-bold px-3 py-1 rounded-full border border-red-400/20">
                            <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                            အီးမေးလ် အတည်မပြုရသေး
                        </span>
                    @endif
                </div>

                <p class="text-emerald-200/70 text-xs mt-3 flex items-center justify-center sm:justify-start gap-1.5">
                    <i class="fa-regular fa-calendar text-[11px]"></i>
                    အကောင့်ဖွင့်ခဲ့သည့်နေ့ - {{ auth()->user()->created_at?->format('d M, Y') ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    {{-- ═══════════════ READ-ONLY DETAILS GRID ═══════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Section 1: Basic Information --}}
        <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm p-6 sm:p-7">
            <div class="flex items-center gap-3 mb-5 border-b border-emerald-100 pb-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-800">
                    <i class="fa-solid fa-id-card text-sm"></i>
                </div>
                <div>
                    <h2 class="font-[Bricolage_Grotesque] text-emerald-950 text-base font-bold">ကိုယ်ရေးအချက်အလက်</h2>
                    <p class="text-emerald-900/50 text-xs">အခြေခံ အချက်အလက်များ</p>
                </div>
            </div>

            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-emerald-900/60 text-xs font-medium mb-0.5">အမည်</dt>
                    <dd class="text-emerald-950 font-semibold">{{ auth()->user()->name }}</dd>
                </div>

                <div>
                    <dt class="text-emerald-900/60 text-xs font-medium mb-0.5">အီးမေးလ်</dt>
                    <dd class="text-emerald-950 font-semibold">{{ auth()->user()->email }}</dd>
                </div>

                <div>
                    <dt class="text-emerald-900/60 text-xs font-medium mb-0.5">ဖုန်းနံပါတ်</dt>
                    <dd class="text-emerald-950 font-semibold">
                        {{ auth()->user()->phone ?? 'မရှိပါ' }}
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Section 2: Address Information --}}
        <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm p-6 sm:p-7">
            <div class="flex items-center gap-3 mb-5 border-b border-emerald-100 pb-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-800">
                    <i class="fa-solid fa-location-dot text-sm"></i>
                </div>
                <div>
                    <h2 class="font-[Bricolage_Grotesque] text-emerald-950 text-base font-bold">နေရပ်လိပ်စာ</h2>
                    <p class="text-emerald-900/50 text-xs">ဒေသဆိုင်ရာ အချက်အလက်များ</p>
                </div>
            </div>

            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-emerald-900/60 text-xs font-medium mb-0.5">တိုင်းဒေသကြီး / ပြည်နယ်</dt>
                    <dd class="text-emerald-950 font-semibold">
                        {{ auth()->user()->region ?? 'မရှိပါ' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-emerald-900/60 text-xs font-medium mb-0.5">မြို့နယ်</dt>
                    <dd class="text-emerald-950 font-semibold">
                        {{ auth()->user()->township ?? 'မရှိပါ' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-emerald-900/60 text-xs font-medium mb-0.5">ရပ်ကွက် / ကျေးရွာ</dt>
                    <dd class="text-emerald-950 font-semibold">
                        {{ auth()->user()->village ?? 'မရှိပါ' }}
                    </dd>
                </div>
            </dl>
        </div>

    </div>
</div>
@endsection
