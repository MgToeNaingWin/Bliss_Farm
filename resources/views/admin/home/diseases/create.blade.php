@extends('admin.layouts.master')
@section('content')
<div class="bg-gray-100 min-h-screen py-4 px-4 sm:py-8 sm:px-6">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">

        <!-- HEADER (Responsive & Alignments with Manage All button) -->
        <div class="bg-green-500 px-6 py-4 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-white">
            <h2 class="text-lg sm:text-xl font-bold">ရောဂါအချက်အလက်အသစ် ထည့်သွင်းရန်</h2>
            <div class="flex items-center gap-4">
                <!-- Manage All Button -->
                <a href="{{ route('diseaseManagePage') }}" class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    ရောဂါအားလုံး စီမံရန်
                </a>
                <span class="text-green-300 hidden sm:inline">|</span>
                <a href="{{ route('diseaseManagePage') }}" class="text-white hover:text-green-100 text-sm font-semibold transition-colors duration-200">
                    &larr; နောက်သို့
                </a>
            </div>
        </div>

        <!-- FORM (Responsive Padding) -->
        <form action="{{ route('diseaseStore') }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-8 space-y-6">
            @csrf

            <!-- Animal Type Dropdown -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">တိရစ္ဆာန်အမျိုးအစား</label>
                <!-- တိရစ္ဆာန်အမျိုးအစား ရွေးချယ်ရန် Option များကို Database ID သို့မဟုတ် စနစ်တကျ သတ်မှတ်ခြင်း -->
<select name="animal_type_id" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white">
    <option value="">တိရစ္ဆာန်အမျိုးအစား ရွေးချယ်ရန်</option>

    <!-- 💡 တန်ဖိုးများကို string အစား သက်ဆိုင်ရာ Database ID နံပါတ်များအဖြစ် ထည့်သွင်းပါ (ဥပမာပုံစံ) -->
    <option value="1" {{ old('animal_type_id') == '1' ? 'selected' : '' }}>နွား (Cow)</option>
    <option value="2" {{ old('animal_type_id') == '2' ? 'selected' : '' }}>ဆိတ် (Goat)</option>
    <option value="3" {{ old('animal_type_id') == '3' ? 'selected' : '' }}>ကြက် (Chicken)</option>
    <option value="4" {{ old('animal_type_id') == '4' ? 'selected' : '' }}>ဝက် (Pig)</option>
    <option value="5" {{ old('animal_type_id') == '5' ? 'selected' : '' }}>သိုး (Sheep)</option>
    <option value="6" {{ old('animal_type_id') == '6' ? 'selected' : '' }}>ငါး (Fish)</option>
</select>
                @error('animal_type_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Disease Title -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">ရောဂါအမည် ခေါင်းစဉ်</label>
                <input type="text" name="disease_title" value="{{ old('disease_title') }}" placeholder="ရောဂါအမည် ရေးထည့်ပါ" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200">
                @error('disease_title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">ရောဂါအကြောင်းအရာ ရှင်းလင်းချက်</label>
                <textarea name="disease_desc" rows="4" placeholder="ရောဂါနှင့်ပတ်သက်သည့် အကြောင်းအရာများ ရေးသားရန်" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200">{{ old('disease_desc') }}</textarea>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">ရောဂါဓာတ်ပုံ</label>
                <input type="file" name="disease_img" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                @error('disease_img') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Grid for Symptoms, Prevention, Treatment -->
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-red-700 mb-2">ရောဂါလက္ခဏာများ</label>
                    <textarea name="symptoms" rows="3" placeholder="တွေ့ရှိရမည့် ရောဂါလက္ခဏာများကို ရေးသားရန်" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200">{{ old('symptoms') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-blue-700 mb-2">ကာကွယ်ရန်နည်းလမ်းများ</label>
                    <textarea name="prevent" rows="3" placeholder="ကြိုတင်ကာကွယ်ရမည့် နည်းလမ်းများကို ရေးသားရန်" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200">{{ old('prevent') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-green-700 mb-2">ကုသရန်နည်းလမ်းများ</label>
                    <textarea name="treated" rows="3" placeholder="ကုသစောင့်ရှောက်ရမည့် နည်းလမ်းများကို ရေးသားရန်" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200">{{ old('treated') }}</textarea>
                </div>
            </div>

            <!-- Buttons (Responsive Flex-direction) -->
            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center sm:justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('diseaseManagePage') }}" class="px-6 py-2.5 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold text-center transition-colors duration-200">
                    မလုပ်တော့ပါ
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-green-500 text-white hover:bg-green-600 text-sm font-semibold shadow-sm text-center transition-colors duration-200">
                    အချက်အလက် သိမ်းဆည်းမည်
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
