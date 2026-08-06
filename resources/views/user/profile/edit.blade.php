{{--
    User Profile Page
    - Extends the master layout shared (uses @yield('bdy'))
    - Change 'layouts.app' below to match your actual master layout view name
    - Fields map to the `users` migration: name, email, phone, region,
      township, village, profile_photo, role, email_verified_at, created_at
--}}
@extends('user.layouts.master')

@section('bdy')
<div class="max-w-5xl mx-auto px-4 sm:px-6">

    {{-- ═══════════════ FLASH MESSAGE ═══════════════ --}}
    @if (session('status'))
        <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold px-4 py-3 rounded-xl">
            <i class="fa-solid fa-circle-check text-emerald-500"></i>
            {{ session('status') }}
        </div>
    @endif

    {{-- ═══════════════ PROFILE HEADER ═══════════════ --}}
    <div class="relative bg-emerald-900 rounded-2xl overflow-hidden shadow-lg shadow-emerald-950/10 mb-6">
        {{-- decorative background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 via-emerald-900 to-emerald-950"></div>
        <div class="absolute -right-10 -top-10 w-56 h-56 bg-amber-400/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-8 -bottom-8 w-40 h-40 bg-emerald-400/10 rounded-full blur-2xl"></div>

        <div class="relative px-6 sm:px-8 py-8 sm:py-10 flex flex-col sm:flex-row items-center sm:items-end gap-5">
            {{-- Avatar --}}
            <div class="relative shrink-0">
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
                <button type="button"
                        onclick="document.getElementById('photo-input').click()"
                        class="absolute -bottom-2 -right-2 w-9 h-9 bg-amber-400 hover:bg-amber-300 text-emerald-950 rounded-full flex items-center justify-center shadow-md border-2 border-emerald-900 transition">
                    <i class="fa-solid fa-camera text-xs"></i>
                </button>
            </div>

            {{-- Name & meta --}}
            <div class="text-center sm:text-left flex-grow">
                <h1 class="font-[Bricolage_Grotesque] text-white text-2xl sm:text-3xl font-extrabold">
                    {{ auth()->user()->name }}
                </h1>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-2">
                    <span class="inline-flex items-center gap-1.5 bg-amber-400/15 text-amber-300 text-xs font-bold px-3 py-1 rounded-full border border-amber-400/20">
                        <i class="fa-solid fa-shield-halved text-[10px]"></i>
                        {{ auth()->user()->role === 'admin' ? 'စီမံခန့်ခွဲသူ' : 'အသုံးပြုသူ' }}
                    </span>
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
                <p class="text-emerald-200/60 text-xs mt-2">
                    အကောင့်ဖွင့်ခဲ့သည့်နေ့ - {{ auth()->user()->created_at->format('d M, Y') }}
                </p>
            </div>
        </div>
    </div>

    {{-- ═══════════════ TABS ═══════════════ --}}
    <div x-data="{ tab: 'info' }" class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Sidebar nav ── --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm p-2 sticky top-24 space-y-1">
                <button @click="tab = 'info'"
                        :class="tab === 'info' ? 'bg-emerald-900 text-white' : 'text-emerald-900 hover:bg-emerald-50'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <i class="fa-solid fa-id-card w-4 text-center"></i>
                    ကိုယ်ရေးအချက်အလက်
                </button>
                <button @click="tab = 'location'"
                        :class="tab === 'location' ? 'bg-emerald-900 text-white' : 'text-emerald-900 hover:bg-emerald-50'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <i class="fa-solid fa-location-dot w-4 text-center"></i>
                    နေရပ်လိပ်စာ
                </button>
                <button @click="tab = 'security'"
                        :class="tab === 'security' ? 'bg-emerald-900 text-white' : 'text-emerald-900 hover:bg-emerald-50'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <i class="fa-solid fa-lock w-4 text-center"></i>
                    လုံခြုံရေး
                </button>
            </div>
        </div>

        {{-- ── Content ── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- ═══════ Personal Info ═══════ --}}
            <div x-show="tab === 'info'" x-cloak class="bg-white rounded-2xl border border-emerald-100 shadow-sm p-6 sm:p-7">
                <h2 class="font-[Bricolage_Grotesque] text-emerald-950 text-lg font-extrabold mb-1">ကိုယ်ရေးအချက်အလက်</h2>
                <p class="text-emerald-900/50 text-xs mb-6">သင့်အကောင့်၏ အခြေခံအချက်အလက်များကို ပြင်ဆင်နိုင်ပါသည်</p>

                <form action="{{ route('profileEdit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('POST')
                    <input id="photo-input" type="file" name="profile_photo" accept="image/*" class="hidden">

                    <div>
                        <label class="block text-emerald-950 text-sm font-bold mb-1.5">အမည်</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-sm text-emerald-950 transition">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-emerald-950 text-sm font-bold mb-1.5">အီးမေးလ်</label>
                        <div class="relative">
                            <input type="email" value="{{ auth()->user()->email }}" disabled
                                   class="w-full px-4 py-2.5 rounded-xl border border-emerald-100 bg-emerald-50/50 text-emerald-900/50 text-sm cursor-not-allowed">
                            <i class="fa-solid fa-lock absolute right-4 top-1/2 -translate-y-1/2 text-emerald-900/30 text-xs"></i>
                        </div>
                        <p class="text-emerald-900/40 text-xs mt-1">အီးမေးလ်ကို ပြောင်းလဲ၍မရပါ</p>
                    </div>

                    <div>
                        <label class="block text-emerald-950 text-sm font-bold mb-1.5">ဖုန်းနံပါတ်</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                               placeholder="09xxxxxxxxx"
                               class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-sm text-emerald-950 transition">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                            အချက်အလက်များ သိမ်းဆည်းရန်
                        </button>
                    </div>
                </form>
            </div>

            {{-- ═══════ Location ═══════ --}}
            <div x-show="tab === 'location'" x-cloak class="bg-white rounded-2xl border border-emerald-100 shadow-sm p-6 sm:p-7">
                <h2 class="font-[Bricolage_Grotesque] text-emerald-950 text-lg font-extrabold mb-1">နေရပ်လိပ်စာ</h2>
                <p class="text-emerald-900/50 text-xs mb-6">ဒေသဆိုင်ရာ အချက်အလက်များ (ရပ်ကွက်/တိုင်းဒေသကြီး)</p>

                <form action="{{ route('profileEdit') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('POST')

                    <div>
                        <label class="block text-emerald-950 text-sm font-bold mb-1.5">တိုင်းဒေသကြီး / ပြည်နယ်</label>
                        <input type="text" name="region" value="{{ old('region', auth()->user()->region) }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-sm text-emerald-950 transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-emerald-950 text-sm font-bold mb-1.5">မြို့နယ်</label>
                            <input type="text" name="township" value="{{ old('township', auth()->user()->township) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-sm text-emerald-950 transition">
                        </div>
                        <div>
                            <label class="block text-emerald-950 text-sm font-bold mb-1.5">ရပ်ကွက် / ကျေးရွာ</label>
                            <input type="text" name="village" value="{{ old('village', auth()->user()->village) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-sm text-emerald-950 transition">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                            လိပ်စာ သိမ်းဆည်းရန်
                        </button>
                    </div>
                </form>
            </div>

            {{-- ═══════ Security ═══════ --}}
            <div x-show="tab === 'security'" x-cloak class="bg-white rounded-2xl border border-emerald-100 shadow-sm p-6 sm:p-7">
                <h2 class="font-[Bricolage_Grotesque] text-emerald-950 text-lg font-extrabold mb-1">စကားဝှက် ပြောင်းလဲရန်</h2>
                <p class="text-emerald-900/50 text-xs mb-6">လုံခြုံရေးအတွက် စကားဝှက်ကို ပုံမှန်ပြောင်းလဲပါ</p>

                <form action="{{ route('profileEdit') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('POST')

                    <div>
                        <label class="block text-emerald-950 text-sm font-bold mb-1.5">လက်ရှိစကားဝှက်</label>
                        <input type="password" name="current_password"
                               class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-sm text-emerald-950 transition">
                        @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-emerald-950 text-sm font-bold mb-1.5">စကားဝှက်အသစ်</label>
                        <input type="password" name="password"
                               class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-sm text-emerald-950 transition">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-emerald-950 text-sm font-bold mb-1.5">စကားဝှက်အသစ် အတည်ပြုရန်</label>
                        <input type="password" name="password_confirmation"
                               class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-sm text-emerald-950 transition">
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">
                            <i class="fa-solid fa-key mr-1.5"></i>
                            စကားဝှက် ပြောင်းလဲရန်
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-emerald-100">
                    <div class="flex items-start gap-3 bg-red-50 border border-red-100 rounded-xl p-4">
                        <i class="fa-solid fa-triangle-exclamation text-red-400 mt-0.5"></i>
                        <div>
                            <p class="text-red-700 font-bold text-sm">အကောင့်ဖျက်သိမ်းရန်</p>
                            <p class="text-red-600/70 text-xs mt-0.5">အကောင့်ဖျက်သိမ်းပါက ဒေတာအားလုံး ထာဝရ ပျက်စီးသွားမည်ဖြစ်ပါသည်</p>
                            <button class="mt-3 text-red-600 hover:text-red-700 text-xs font-bold border border-red-200 hover:border-red-300 px-3 py-1.5 rounded-lg transition">
                                အကောင့်ဖျက်ရန်
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Live preview of newly selected profile photo before upload --}}
<script>
    document.getElementById('photo-input')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const form = e.target.closest('form');
        if (form) form.submit();
    });
</script>
{{-- SweetAlert JS Inclusion --}}
    @include('sweetalert::alert')

    {{-- Live preview & auto-submit script --}}
    <script>
        document.getElementById('photo-input')?.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const form = e.target.closest('form');
            if (form) form.submit();
        });
    </script>
@endsection
