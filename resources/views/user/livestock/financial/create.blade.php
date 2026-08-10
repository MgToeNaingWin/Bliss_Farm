{{-- resources/views/user/livestock/financial/create.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">ငွေပေးချေမှုအသစ်ထည့်ရန်</h2>
            </div>

            <form method="POST" action="{{ route('user.financial.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">အမျိုးအစား <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">ရွေးပါ</option>
                            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>ဝင်ငွေ</option>
                            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>ထွက်ငွေ</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">အမျိုးအစားခွဲ <span class="text-red-500">*</span></label>
                        <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">ရွေးပါ</option>
                            <optgroup label="ဝင်ငွေ">
                                @foreach($incomeCategories as $category)
                                    <option value="{{ $category }}" class="income-category" {{ old('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="ထွက်ငွေ">
                                @foreach($expenseCategories as $category)
                                    <option value="{{ $category }}" class="expense-category" {{ old('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sub Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">အမျိုးအစားခွဲ (အသေးစိတ်)</label>
                        <input type="text" name="sub_category" value="{{ old('sub_category') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('sub_category')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ပမာဏ (MMK) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">နေ့စွဲ <span class="text-red-500">*</span></label>
                        <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('transaction_date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ငွေပေးချေမှုနည်းလမ်း</label>
                        <select name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">ရွေးပါ</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method }}" {{ old('payment_method') == $method ? 'selected' : '' }}>
                                    {{ $method }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reference Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ကိုးကားနံပါတ်</label>
                        <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('reference_number')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Livestock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">တိရစ္ဆာန်</label>
                        <select name="livestock_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">ရွေးပါ</option>
                            @foreach($livestocks as $id => $name)
                                <option value="{{ $id }}" {{ old('livestock_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('livestock_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">အခြေအနေ <span class="text-red-500">*</span></label>
                        <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>ပြီးစီး</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>ဆောင်ရွက်ဆဲ</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ပယ်ဖျက်</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">ဖော်ပြချက် <span class="text-red-500">*</span></label>
                        <input type="text" name="description" value="{{ old('description') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">မှတ်ချက်</label>
                        <textarea name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6 border-t pt-6">
                    <a href="{{ route('user.financial.records') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        ပယ်ဖျက်
                    </a>
                    <button type="submit" class="ml-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fa-solid fa-save mr-2"></i> သိမ်းဆည်းရန်
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const categorySelect = document.getElementById('category');

        // Show only relevant categories based on type selection
        typeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            const options = categorySelect.options;

            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (option.value === '') continue;

                const isIncome = option.classList.contains('income-category');
                const isExpense = option.classList.contains('expense-category');

                if (selectedType === 'income' && isIncome) {
                    option.style.display = '';
                } else if (selectedType === 'expense' && isExpense) {
                    option.style.display = '';
                } else if (selectedType === '') {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }

            // Reset selection if hidden
            if (categorySelect.value) {
                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                if (selectedOption.style.display === 'none') {
                    categorySelect.value = '';
                }
            }
        });

        // Trigger change to set initial state
        typeSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
