@extends('admin.layouts.master')
@section('content')
<div class="bg-gray-100 min-h-screen py-4 px-4 sm:py-8 sm:px-6">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">

        <!-- HEADER (Responsive Layout) -->
        <div class="bg-green-500 px-6 py-4 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-white">
            <h2 class="text-lg sm:text-xl font-bold">ရောဂါအချက်အလက် ပြင်ဆင်ရန်</h2>
            <a href="{{ route('diseaseManagePage') }}" class="text-white hover:text-green-100 text-sm font-semibold transition-colors duration-200 self-start sm:self-auto">
                &larr; နောက်သို့
            </a>
        </div>

        <!-- FORM (Responsive Padding) -->
        <form action="{{ route('diseaseUpdate', $disease->id) }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-8 space-y-6">
            @csrf

            <!-- Animal Type Dropdown -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">တိရစ္ဆာန်အမျိုးအစား *</label>
                <select name="animal_type_id" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white transition-shadow duration-200 text-sm sm:text-base" required>
                    @foreach ($animalTypes as $type)
                        <option value="{{ $type->id }}" {{ $disease->animal_type_id == $type->id ? 'selected' : '' }}>
                            {{ $type->type_title }}
                        </option>
                    @endforeach
                </select>
                @error('animal_type_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Disease Title -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">ရောဂါအမည် ခေါင်းစဉ် *</label>
                <input type="text" name="disease_title" value="{{ old('disease_title', $disease->disease_title) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200 text-sm sm:text-base" required>
                @error('disease_title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">ရောဂါအကြောင်းအရာ ရှင်းလင်းချက်</label>
                <textarea name="disease_desc" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200 text-sm sm:text-base">{{ old('disease_desc', $disease->disease_desc) }}</textarea>
            </div>

            <!-- Image Upload & Preview -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">ရောဂါဓာတ်ပုံ</label>
                @if($disease->disease_img)
                    <div class="mb-3">
                        <img src="{{ asset('diseaseImage/' . $disease->disease_img) }}" class="h-24 sm:h-32 rounded-lg object-cover shadow-sm">
                        <span class="text-xs text-gray-400 mt-1 block">လက်ရှိအသုံးပြုထားသော ဓာတ်ပုံ</span>
                    </div>
                @endif
                <input type="file" name="disease_img" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200 text-sm sm:text-base file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                @error('disease_img') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Symptoms, Prevention, Treatment (Grid for multi-device aspect) -->
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-red-700 mb-2">ရောဂါလက္ခဏာများ</label>
                    <textarea name="symptoms" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200 text-sm sm:text-base">{{ old('symptoms', $disease->symptoms) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-blue-700 mb-2">ကာကွယ်ရန်နည်းလမ်းများ</label>
                    <textarea name="prevent" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200 text-sm sm:text-base">{{ old('prevent', $disease->prevent) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-green-700 mb-2">ကုသရန်နည်းလမ်းများ</label>
                    <textarea name="treated" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-shadow duration-200 text-sm sm:text-base">{{ old('treated', $disease->treated) }}</textarea>
                </div>
            </div>

            <!-- Action Buttons (Responsive Layout & Order) -->
            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center sm:justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('diseaseManagePage') }}" class="px-6 py-2.5 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold text-center transition-colors duration-200">
                    မလုပ်တော့ပါ
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-green-500 text-white hover:bg-green-600 text-sm font-semibold shadow-sm text-center transition-colors duration-200">
                    အချက်အလက် ပြင်ဆင်မည်
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
