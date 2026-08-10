{{-- resources/views/user/livestock/financial/records.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">ငွေပေးချေမှုစာရင်း</h2>
            <a href="{{ route('user.financial.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="fa-solid fa-plus mr-2"></i> အသစ်ထည့်ရန်
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-green-100 rounded-lg p-4 shadow">
                <div class="text-sm text-gray-600">စုစုပေါင်း ဝင်ငွေ</div>
                <div class="text-xl font-bold text-green-700">{{ number_format($totalIncome, 2) }} MMK</div>
            </div>
            <div class="bg-red-100 rounded-lg p-4 shadow">
                <div class="text-sm text-gray-600">စုစုပေါင်း ထွက်ငွေ</div>
                <div class="text-xl font-bold text-red-700">{{ number_format($totalExpense, 2) }} MMK</div>
            </div>
            <div class="bg-blue-100 rounded-lg p-4 shadow">
                <div class="text-sm text-gray-600">အသားတင် အမြတ်</div>
                <div class="text-xl font-bold text-blue-700">{{ number_format($netProfit, 2) }} MMK</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('user.financial.records') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">အမျိုးအစား</label>
                    <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">အားလုံး</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>ဝင်ငွေ</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>ထွက်ငွေ</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">အမျိုးအစားခွဲ</label>
                    <select name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">အားလုံး</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">မှ</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">သို့</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="md:col-span-4 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fa-solid fa-search mr-2"></i> ရှာဖွေရန်
                    </button>
                    <a href="{{ route('user.financial.records') }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        <i class="fa-solid fa-undo mr-2"></i> ပြန်လည်သတ်မှတ်
                    </a>
                </div>
            </form>
        </div>

        <!-- Records Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">နေ့စွဲ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">အမျိုးအစား</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">အမျိုးအစားခွဲ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ဖော်ပြချက်</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ပမာဏ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">အခြေအနေ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($records as $record)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $record->transaction_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $record->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $record->type == 'income' ? 'ဝင်ငွေ' : 'ထွက်ငွေ' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $record->category }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $record->description }}</td>
                                <td class="px-6 py-4 text-sm font-semibold {{ $record->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($record->amount, 2) }} MMK
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $record->status == 'completed' ? 'bg-green-100 text-green-800' :
                                           ($record->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $record->status == 'completed' ? 'ပြီးစီး' :
                                           ($record->status == 'pending' ? 'ဆောင်ရွက်ဆဲ' : 'ပယ်ဖျက်') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <a href="{{ route('user.financial.edit', $record) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <form action="{{ route('user.financial.destroy', $record) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">ငွေပေးချေမှုမရှိသေးပါ</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4">
                {{ $records->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
