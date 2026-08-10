{{-- resources/views/user/livestock/financial/dashboard.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">ဘဏ္ဍာရေးစီမံခန့်ခွဲမှု</h2>
            <a href="{{ route('user.financial.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="fa-solid fa-plus mr-2"></i> အသစ်ထည့်ရန်
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-r from-green-100 to-green-200 rounded-lg p-6 shadow">
                <div class="text-sm text-gray-600">စုစုပေါင်း ဝင်ငွေ</div>
                <div class="text-2xl font-bold text-green-700">{{ number_format($totalIncome, 2) }} MMK</div>
            </div>
            <div class="bg-gradient-to-r from-red-100 to-red-200 rounded-lg p-6 shadow">
                <div class="text-sm text-gray-600">စုစုပေါင်း ထွက်ငွေ</div>
                <div class="text-2xl font-bold text-red-700">{{ number_format($totalExpense, 2) }} MMK</div>
            </div>
            <div class="bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg p-6 shadow">
                <div class="text-sm text-gray-600">စုစုပေါင်း အမြတ်</div>
                <div class="text-2xl font-bold text-blue-700">{{ number_format($totalProfit, 2) }} MMK</div>
            </div>
            <div class="bg-gradient-to-r from-purple-100 to-purple-200 rounded-lg p-6 shadow">
                <div class="text-sm text-gray-600">လစဉ် အမြတ် ({{ Carbon\Carbon::now()->format('M Y') }})</div>
                <div class="text-2xl font-bold text-purple-700">{{ number_format($monthlyProfit, 2) }} MMK</div>
            </div>
        </div>

        <!-- Monthly & Yearly Comparison -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">လစဉ် အခြေအနေ ({{ $currentMonth }}/{{ $currentYear }})</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ဝင်ငွေ</span>
                        <span class="font-semibold text-green-600">{{ number_format($monthlyIncome, 2) }} MMK</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ထွက်ငွေ</span>
                        <span class="font-semibold text-red-600">{{ number_format($monthlyExpense, 2) }} MMK</span>
                    </div>
                    <div class="flex justify-between border-t pt-2">
                        <span class="font-semibold text-gray-800">အမြတ်</span>
                        <span class="font-bold {{ $monthlyProfit >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                            {{ number_format($monthlyProfit, 2) }} MMK
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">နှစ်စဉ် အခြေအနေ ({{ $currentYear }})</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ဝင်ငွေ</span>
                        <span class="font-semibold text-green-600">{{ number_format($yearlyIncome, 2) }} MMK</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ထွက်ငွေ</span>
                        <span class="font-semibold text-red-600">{{ number_format($yearlyExpense, 2) }} MMK</span>
                    </div>
                    <div class="flex justify-between border-t pt-2">
                        <span class="font-semibold text-gray-800">အမြတ်</span>
                        <span class="font-bold {{ $yearlyProfit >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                            {{ number_format($yearlyProfit, 2) }} MMK
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Chart (Last 12 Months) -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">လစဉ် ဝင်ငွေ/ထွက်ငွေ (လွန်ခဲ့သော ၁၂ လ)</h3>
            <div class="h-64">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-green-800 mb-4">ဝင်ငွေ အမျိုးအစားအလိုက်</h3>
                @foreach($incomeCategories as $category)
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">{{ $category->category }}</span>
                        <span class="font-semibold text-green-600">{{ number_format($category->total, 2) }} MMK</span>
                    </div>
                @endforeach
                @if($incomeCategories->isEmpty())
                    <p class="text-gray-500 text-center py-4">ဝင်ငွေမရှိသေးပါ</p>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-red-800 mb-4">ထွက်ငွေ အမျိုးအစားအလိုက်</h3>
                @foreach($expenseCategories as $category)
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">{{ $category->category }}</span>
                        <span class="font-semibold text-red-600">{{ number_format($category->total, 2) }} MMK</span>
                    </div>
                @endforeach
                @if($expenseCategories->isEmpty())
                    <p class="text-gray-500 text-center py-4">ထွက်ငွေမရှိသေးပါ</p>
                @endif
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">မကြာသေးမီက ငွေပေးချေမှုများ</h3>
                <a href="{{ route('user.financial.records') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    အားလုံးကြည့်ရန် →
                </a>
            </div>
            @if($recentTransactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">နေ့စွဲ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">အမျိုးအစား</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ဖော်ပြချက်</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ပမာဏ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentTransactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $transaction->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $transaction->type == 'income' ? 'ဝင်ငွေ' : 'ထွက်ငွေ' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $transaction->description }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($transaction->amount, 2) }} MMK
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">ငွေပေးချေမှုမရှိသေးပါ</p>
            @endif
        </div>

    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('monthlyChart').getContext('2d');

        const monthlyData = @json($monthlyData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [
                    {
                        label: 'ဝင်ငွေ',
                        data: monthlyData.map(item => item.income),
                        backgroundColor: 'rgba(34, 197, 94, 0.5)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'ထွက်ငွေ',
                        data: monthlyData.map(item => item.expense),
                        backgroundColor: 'rgba(239, 68, 68, 0.5)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'အမြတ်',
                        data: monthlyData.map(item => item.profit),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' MMK';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    });
</script>
@endsection
