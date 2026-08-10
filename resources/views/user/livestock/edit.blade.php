{{-- resources/views/livestock/edit.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
    <div class="py-10 bg-emerald-50/40 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-emerald-950">မွေးမြူရေးတိရစ္ဆာန် အချက်အလက် ပြင်ဆင်ရန်</h2>
                    <p class="text-sm text-emerald-700 mt-1">
                        {{ $livestock->name ?? $livestock->tag_number }} ၏ အချက်အလက်များကို ပြင်ဆင်နေပါသည်။
                    </p>
                </div>
                <a href="{{ route('user.livestock.index') }}" 
                   class="inline-flex items-center text-sm font-medium text-emerald-700 hover:text-emerald-900 transition-colors duration-150">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    စာရင်းသို့ ပြန်သွားမည်
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-lg shadow-emerald-900/5 sm:rounded-2xl border border-emerald-100">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('user.livestock.update', $livestock) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Tag Number -->
                            <div>
                                <label for="tag_number" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Tag နံပါတ် <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="tag_number" name="tag_number" 
                                       value="{{ old('tag_number', $livestock->tag_number) }}"
                                       placeholder="ဥပမာ - TAG-001"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150 @error('tag_number') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                       required>
                                @error('tag_number')
                                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">အမည် / ခေါ်အမည်</label>
                                <input type="text" id="name" name="name" 
                                       value="{{ old('name', $livestock->name) }}"
                                       placeholder="ဥပမာ - နီနီ"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-semibold text-gray-700 mb-1">
                                    အမျိုးအစား <span class="text-red-500">*</span>
                                </label>
                                <select id="type" name="type" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150 @error('type') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" required>
                                    <option value="">အမျိုးအစား ရွေးချယ်ပါ</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ old('type', $livestock->type) == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-1">
                                    လိင် <span class="text-red-500">*</span>
                                </label>
                                <select id="gender" name="gender" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150 @error('gender') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" required>
                                    <option value="">လိင် ရွေးချယ်ပါ</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender }}" {{ old('gender', $livestock->gender) == $gender ? 'selected' : '' }}>
                                            {{ ucfirst($gender) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gender')
                                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 mb-1">မွေးသက္ကရာဇ်</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" 
                                       value="{{ old('date_of_birth', $livestock->date_of_birth ? $livestock->date_of_birth->format('Y-m-d') : '') }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                            </div>

                            <!-- Breed -->
                            <div>
                                <label for="breed" class="block text-sm font-semibold text-gray-700 mb-1">မျိုးစိတ် / မျိုးနွယ်</label>
                                <input type="text" id="breed" name="breed" 
                                       value="{{ old('breed', $livestock->breed) }}"
                                       placeholder="ဥပမာ - Holstein"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                            </div>

                            <!-- Color -->
                            <div>
                                <label for="color" class="block text-sm font-semibold text-gray-700 mb-1">အရောင်</label>
                                <input type="text" id="color" name="color" 
                                       value="{{ old('color', $livestock->color) }}"
                                       placeholder="ဥပမာ - အဖြူ/အနက်"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                            </div>

                            <!-- Weight -->
                            <div>
                                <label for="weight" class="block text-sm font-semibold text-gray-700 mb-1">အလေးချိန် (ကီလိုဂရမ်)</label>
                                <input type="number" step="0.01" id="weight" name="weight" 
                                       value="{{ old('weight', $livestock->weight) }}"
                                       placeholder="0.00"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">
                                    အခြေအနေ <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150 @error('status') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" required>
                                    <option value="">အခြေအနေ ရွေးချယ်ပါ</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ old('status', $livestock->status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Parent (Mother) -->
                            <div>
                                <label for="parent_id" class="block text-sm font-semibold text-gray-700 mb-1">မိခင် (အမိ)</label>
                                <select id="parent_id" name="parent_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                                    <option value="">မိခင်ကို ရွေးချယ်ပါ</option>
                                    @foreach($parents as $id => $name)
                                        <option value="{{ $id }}" {{ old('parent_id', $livestock->parent_id) == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">မှတ်ချက်</label>
                                <textarea id="notes" name="notes" rows="3"
                                          placeholder="ထပ်ဆောင်း မှတ်ချက်များ ရေးသားပါ..."
                                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">{{ old('notes', $livestock->notes) }}</textarea>
                            </div>
                        </div>

                        <!-- Buttons Section -->
                        <div class="pt-4 border-t border-emerald-100 flex items-center justify-end space-x-3">
                            <a href="{{ route('user.livestock.index') }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-gray-100 border border-gray-300 rounded-lg font-medium text-xs text-gray-700 uppercase tracking-wider hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition duration-150 shadow-sm">
                                မလုပ်တော့ပါ
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-5 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-md hover:shadow-lg transition duration-150">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                ပြင်ဆင်ချက် သိမ်းဆည်းမည်
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection