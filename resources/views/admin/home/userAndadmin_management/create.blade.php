@extends('admin.layouts.master')

@section('content')
<div class="container mx-auto px-4 py-6 sm:py-8 max-w-3xl antialiased text-gray-800">
    <!-- Back Button & Header -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}?tab=admin" class="inline-flex items-center gap-2 text-xs sm:text-sm text-gray-500 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            စာရင်းသို့ပြန်သွားရန်
        </a>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight mt-3">အက်ဒမင်အကောင့်အသစ် ဖွင့်လှစ်ခြင်း</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">စနစ်အား ထိန်းချုပ်မည့် အက်ဒမင်အသစ်တစ်ဦး၏ အချက်အလက်များကို ဖြည့်သွင်းပါ။</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-4 sm:p-6 space-y-6">
            @csrf

            <!-- Section 1: Account Info -->
            <div class="border-b border-gray-100 pb-5">
                <h3 class="font-semibold text-gray-900 text-sm mb-4">အခြေခံအချက်အလက် (Account Info)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">အမည် <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border-gray-200 px-3 py-2.5 sm:py-2 text-sm focus:border-green-500 focus:ring-green-500/20 @error('name') border-red-400 @enderror" placeholder="မောင်မောင်">
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">အီးမေးလ်လိပ်စာ <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border-gray-200 px-3 py-2.5 sm:py-2 text-sm focus:border-green-500 focus:ring-green-500/20 @error('email') border-red-400 @enderror" placeholder="example@gmail.com">
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">ဖုန်းနံပါတ်</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-xl border-gray-200 px-3 py-2.5 sm:py-2 text-sm focus:border-green-500 focus:ring-green-500/20" placeholder="၀၉xxxxxxxxx">
                    </div>
                </div>
            </div>

            <!-- Section 2: Password -->
            <div class="border-b border-gray-100 pb-5">
                <h3 class="font-semibold text-gray-900 text-sm mb-4">လုံခြုံရေး (Password)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">လျှို့ဝှက်နံပါတ် <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="w-full rounded-xl border-gray-200 px-3 py-2.5 sm:py-2 text-sm focus:border-green-500 focus:ring-green-500/20 @error('password') border-red-400 @enderror" placeholder="အနည်းဆုံး ၈ လုံး">
                        @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">လျှို့ဝှက်နံပါတ် အတည်ပြုခြင်း <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" class="w-full rounded-xl border-gray-200 px-3 py-2.5 sm:py-2 text-sm focus:border-green-500 focus:ring-green-500/20" placeholder="နောက်တစ်ကြိမ် ပြန်ရိုက်ပါ">
                    </div>
                </div>
            </div>

            <!-- Section 3: Address -->
            <div>
                <h3 class="font-semibold text-gray-900 text-sm mb-4">နေရပ်လိပ်စာ (Address)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">တိုင်းဒေသကြီး / ပြည်နယ်</label>
                        <input type="text" name="region" value="{{ old('region') }}" class="w-full rounded-xl border-gray-200 px-3 py-2.5 sm:py-2 text-sm focus:border-green-500 focus:ring-green-500/20" placeholder="ရန်ကုန်">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">မြို့နယ်</label>
                        <input type="text" name="township" value="{{ old('township') }}" class="w-full rounded-xl border-gray-200 px-3 py-2.5 sm:py-2 text-sm focus:border-green-500 focus:ring-green-500/20" placeholder="ကမာရွတ်">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">ရပ်ကွက် / ကျေးရွာ</label>
                        <input type="text" name="village" value="{{ old('village') }}" class="w-full rounded-xl border-gray-200 px-3 py-2.5 sm:py-2 text-sm focus:border-green-500 focus:ring-green-500/20" placeholder="လှည်းတန်း">
                    </div>
                </div>
            </div>

            <!-- Form Action Buttons -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}?tab=admin" class="w-full sm:w-auto text-center px-4 py-2.5 sm:py-2 border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">ပယ်ဖျက်မည်</a>
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-2 bg-green-600 text-white text-sm font-semibold rounded-xl hover:bg-green-500 shadow-sm transition-colors">သိမ်းဆည်းမည်</button>
            </div>
        </form>
    </div>
</div>
@endsection
