@extends('admin.layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl antialiased text-gray-800">

    <!-- Main Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- ဘယ်ဘက်ကော်လံ - ပရိုဖိုင်ကတ် (Read-only Display) -->
        <div class="lg:col-span-4 w-full sticky top-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center transition-all duration-300 hover:shadow-md">

                <!-- ပရိုဖိုင်ပုံပြသခြင်း -->
                <div class="relative group">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}"
                             class="w-36 h-36 object-cover border-4 border-green-500 rounded-full shadow-md transition-transform duration-300 group-hover:scale-105"
                             alt="ပရိုဖိုင်ပုံ">
                    @else
                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                             class="w-36 h-36 object-cover border-4 border-green-500 rounded-full shadow-md transition-transform duration-300 group-hover:scale-105"
                             alt="ပရိုဖိုင်ပုံအလွတ်">
                    @endif
                    <!-- Verified စတစ်ကာ -->
                    <span class="absolute bottom-1 right-2 bg-green-500 rounded-full p-2 border-4 border-white shadow-sm" title="အတည်ပြုပြီး">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-white h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </span>
                </div>

                <!-- အမည်နှင့် အဆင့်အတန်း -->
                <div class="text-center mt-5 w-full">
                    <h2 class="text-xl font-bold text-gray-900 truncate px-2" title="{{ $user->name }}">{{ $user->name }}</h2>
                    <span class="mt-2 text-xs font-semibold tracking-wide uppercase px-3 py-1 bg-green-50 text-green-700 rounded-full inline-flex items-center gap-1 border border-green-100">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        {{ $user->role === 'admin' ? 'အက်ဒမင်' : 'အသုံးပြုသူ' }}
                    </span>

                    <p class="text-xs text-gray-500 mt-3 flex items-center justify-center gap-1.5 bg-gray-50 rounded-lg py-2 px-3 mx-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="truncate">
                            @if($user->township || $user->region)
                                {{ $user->township }}{{ $user->township && $user->region ? '၊ ' : '' }}{{ $user->region }}
                            @else
                                နေရပ်လိပ်စာ မရှိပါ
                            @endif
                        </span>
                    </p>
                </div>

                <!-- ကိုယ်ရေးအချက်အလက် စာရင်း -->
                <div class="w-full mt-6 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <span>ကိုယ်ရေးအချက်အလက်များ</span>
                    </h4>
                    <div class="space-y-3.5 text-sm">
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-400 flex-shrink-0">အမည်</span>
                            <span class="text-gray-900 font-medium text-right break-words">{{ $user->name }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-400 flex-shrink-0">အဆင့်အတန်း</span>
                            <span class="text-green-600 font-semibold capitalize bg-green-50/50 px-2 py-0.5 rounded text-xs border border-green-100/50">{{ $user->role }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-400 flex-shrink-0">အီးမေးလ်</span>
                            <span class="text-gray-900 font-medium text-right break-all">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-400 flex-shrink-0">ဖုန်းနံပါတ်</span>
                            <span class="text-gray-900 font-medium text-right">{{ $user->phone ?? '-' }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-400 flex-shrink-0">ပြည်နယ်/တိုင်း</span>
                            <span class="text-gray-900 font-medium text-right">{{ $user->region ?? '-' }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-400 flex-shrink-0">မြို့နယ်</span>
                            <span class="text-gray-900 font-medium text-right">{{ $user->township ?? '-' }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-400 flex-shrink-0">ရပ်ကွက်/ရွာ</span>
                            <span class="text-gray-900 font-medium text-right break-words">{{ $user->village ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ညာဘက်ကော်လံ - Form များစုစည်းမှု -->
        <div class="lg:col-span-8 w-full flex flex-col gap-6">

            <!-- ၁။ ပရိုဖိုင်အချက်အလက် ပြင်ဆင်ရန် Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                    <span class="w-1.5 h-6 bg-green-500 rounded-full"></span>
                    <h3 class="text-xl font-bold text-gray-900">ပရိုဖိုင်အချက်အလက် ပြင်ဆင်ခြင်း</h3>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Responsive Inputs Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- အမည် -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">အမည် အပြည့်အစုံ</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full px-3.5 py-2 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:outline-none transition-all duration-200 text-sm" required>
                        </div>

                        <!-- အီးမေးလ် -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">အီးမေးလ် လိပ်စာ</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full px-3.5 py-2 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:outline-none transition-all duration-200 text-sm" required>
                        </div>

                        <!-- ဖုန်းနံပါတ် -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">ဖုန်းနံပါတ်</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="w-full px-3.5 py-2 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:outline-none transition-all duration-200 text-sm">
                        </div>

                        <!-- ပြည်နယ်/တိုင်း -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">တိုင်းဒေသကြီး / ပြည်နယ်</label>
                            <input type="text" name="region" value="{{ old('region', $user->region) }}"
                                   class="w-full px-3.5 py-2 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:outline-none transition-all duration-200 text-sm">
                        </div>

                        <!-- မြို့နယ် -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">မြို့နယ်</label>
                            <input type="text" name="township" value="{{ old('township', $user->township) }}"
                                   class="w-full px-3.5 py-2 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:outline-none transition-all duration-200 text-sm">
                        </div>

                        <!-- ရပ်ကွက်/ကျေးရွာ -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">ရပ်ကွက် / ကျေးရွာ</label>
                            <input type="text" name="village" value="{{ old('village', $user->village) }}"
                                   class="w-full px-3.5 py-2 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:outline-none transition-all duration-200 text-sm">
                        </div>
                    </div>

                    <!-- ဓာတ်ပုံတင်ရန် နေရာ -->
                    <div class="bg-gray-50/50 rounded-xl p-4 border border-dashed border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ပရိုဖိုင်ဓာတ်ပုံ အသစ်တင်ရန်</label>
                        <input type="file" name="profile_photo"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition-all duration-200 cursor-pointer">
                        <p class="text-xs text-gray-400 mt-2">လက်ခံမည့် ဖိုင်အမျိုးအစားများ - JPG, PNG, GIF (ဖိုင်ဆိုဒ် အများဆုံး 2MB အထိ)</p>
                    </div>

                    <!-- သိမ်းဆည်းရန် ခလုတ် -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="w-full sm:w-auto px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow-md transition-all duration-150 focus:outline-none focus:ring-4 focus:ring-green-500/20">
                            ပြင်ဆင်မှုများကို သိမ်းဆည်းမည်
                        </button>
                    </div>
                </form>
            </div>

            <!-- ၂။ စကားဝှက် ပြင်ဆင်ရန် Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                    <span class="w-1.5 h-6 bg-amber-500 rounded-full"></span>
                    <h3 class="text-xl font-bold text-gray-900">လုံခြုံရေးနှင့် စကားဝှက် ပြောင်းလဲခြင်း</h3>
                </div>

                <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- လက်ရှိစကားဝှက် -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">လက်ရှိ အသုံးပြုနေသော စကားဝှက်</label>
                        <input type="password" name="current_password"
                               class="w-full px-3.5 py-2 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:outline-none transition-all duration-200 text-sm" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- စကားဝှက်အသစ် -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">စကားဝှက်အသစ် (အနည်းဆုံး ၈ လုံး)</label>
                            <input type="password" name="password"
                                   class="w-full px-3.5 py-2 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:outline-none transition-all duration-200 text-sm" required>
                        </div>

                        <!-- စကားဝှက်အသစ်အား အတည်ပြုခြင်း -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">စကားဝှက်အသစ်ကို တစ်ကြိမ်ပြန်ရိုက်ပါ</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full px-3.5 py-2 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:outline-none transition-all duration-200 text-sm" required>
                        </div>
                    </div>

                    <!-- စကားဝှက်ပြောင်းလဲရန် ခလုတ် -->
                    <div class="flex justify-end pt-2">
                        <button type="submit"
                                class="w-full sm:w-auto px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow-md transition-all duration-150 focus:outline-none focus:ring-4 focus:ring-green-500/20">
                            စကားဝှက် အသစ်လဲလှယ်မည်
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // ၁။ ပြင်ဆင်မှု အောင်မြင်သောအခါ SweetAlert ပြသခြင်း
        @if(session('sweet_success'))
            Swal.fire({
                title: 'အောင်မြင်ပါသည်!',
                text: "{{ session('sweet_success') }}",
                icon: 'success',
                confirmButtonText: 'ကောင်းပြီ',
                confirmButtonColor: '#22c55e' // green-500
            });
        @endif

        // ၂။ Validation Error များရှိပါက SweetAlert ဖြင့် ပြသခြင်း
        @if ($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '• {{ $error }}\n';
            @endforeach

            Swal.fire({
                title: 'သတိပေးချက်!',
                text: errorMessages,
                icon: 'error',
                confirmButtonText: 'ပြန်လည်စစ်ဆေးမည်',
                confirmButtonColor: '#ef4444' // red-500
            });
        @endif
    });
</script>
@endsection
