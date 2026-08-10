{{-- resources/views/user/livestock/financial/yearly-report.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fa-solid fa-calendar-year text-blue-600 mr-2"></i>
                နှစ်စဉ်အစီရင်ခံစာ - {{ $selectedYear }}
            </h2>
            <div class="flex flex-wrap items-center gap-2">
                <form method="GET" class="flex items-center gap-2">
                    <select name="year" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        <i class="fa-solid fa-search"></i> ရှာဖွေရန်
                    </button>
                </form>
                <a href="{{ route('user.financial.records') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> ပြန်သွားရန်
                </a>
                <button onclick="window.print()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                    <i class="fa-solid fa-print mr-2"></i> ပုံနှိပ်ရန်
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-r from-green-100 to-green-200 rounded-lg p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">စုစုပေါင်း ဝင်ငွေ</div>
                        <div class="text-2xl font-bold text-green-700">{{ number_format($totalIncome, 2) }} MMK</div>
                    </div>
                    <i class="fa-solid fa-arrow-up text-2xl text-green-500"></i>
                </div>
            </div>
            <div class="bg-gradient-to-r from-red-100 to-red-200 rounded-lg p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">စုစုပေါင်း ထွက်ငွေ</div>
                        <div class="text-2xl font-bold text-red-700">{{ number_format($totalExpense, 2) }} MMK</div>
                    </div>
                    <i class="fa-solid fa-arrow-down text-2xl text-red-500"></i>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">အသားတင် အမြတ်</div>
                        <div class="text-2xl font-bold {{ $netProfit >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                            {{ number_format($netProfit, 2) }} MMK
                        </div>
                    </div>
                    <i class="fa-solid {{ $netProfit >= 0 ? 'fa-circle-check' : 'fa-circle-exclamation' }} text-2xl {{ $netProfit >= 0 ? 'text-blue-500' : 'text-red-500' }}"></i>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-100 to-purple-200 rounded-lg p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">စုစုပေါင်း ငွေပေးချေမှု</div>
                        <div class="text-2xl font-bold text-purple-700">{{ $records->count() }}</div>
                    </div>
                    <i class="fa-solid fa-receipt text-2xl text-purple-500"></i>
                </div>
            </div>
        </div>

        <!-- Monthly Chart -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fa-solid fa-chart-bar text-blue-600 mr-2"></i>
                လစဉ် ဝင်ငွေ/ထွက်ငွေ - {{ $selectedYear }}
            </h3>
            <div class="h-80">
                <canvas id="yearlyChart"></canvas>
            </div>
        </div>

        <!-- Monthly Breakdown Table -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fa-solid fa-table text-blue-600 mr-2"></i>
                    လစဉ် အသေးစိတ်
                </h3>
                <span class="text-sm text-gray-500">စုစုပေါင်း လများ: ၁၂</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">လ</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ဝင်ငွေ</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ထွက်ငွေ</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">အမြတ်</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">အခြေအနေ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($monthlyData as $data)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $data['month'] }}</td>
                                <td class="px-6 py-4 text-sm text-right text-green-600">
                                    {{ number_format($data['income'], 2) }} MMK
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-red-600">
                                    {{ number_format($data['expense'], 2) }} MMK
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-semibold {{ $data['profit'] >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                    {{ number_format($data['profit'], 2) }} MMK
                                </td>
                                <td class="px-6 py-4 text-sm text-center">
                                    @if($data['profit'] > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fa-solid fa-arrow-up mr-1"></i> အမြတ်
                                        </span>
                                    @elseif($data['profit'] < 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fa-solid fa-arrow-down mr-1"></i> အရှုံး
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fa-solid fa-minus mr-1"></i> ပြေလည်
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 font-bold">
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">စုစုပေါင်း</td>
                            <td class="px-6 py-4 text-sm text-right text-green-700">{{ number_format($totalIncome, 2) }} MMK</td>
                            <td class="px-6 py-4 text-sm text-right text-red-700">{{ number_format($totalExpense, 2) }} MMK</td>
                            <td class="px-6 py-4 text-sm text-right {{ $netProfit >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                                {{ number_format($netProfit, 2) }} MMK
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if($netProfit > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-200 text-green-800">
                                        <i class="fa-solid fa-trophy mr-1"></i> အမြတ်ရှိ
                                    </span>
                                @elseif($netProfit < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-200 text-red-800">
                                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> အရှုံးရှိ
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">
                                        <i class="fa-solid fa-equals mr-1"></i> ပြေလည်
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Income by Category -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-green-800 mb-4">
                    <i class="fa-solid fa-circle-plus text-green-600 mr-2"></i>
                    ဝင်ငွေ အမျိုးအစားအလိုက်
                </h3>
                @if($incomeByCategory->count() > 0)
                    <div class="space-y-2">
                        @foreach($incomeByCategory as $category => $amount)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">
                                    <i class="fa-solid fa-tag text-green-400 mr-2"></i>
                                    {{ $category }}
                                </span>
                                <span class="font-semibold text-green-600">{{ number_format($amount, 2) }} MMK</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between items-center py-2 font-bold border-t-2 border-green-300 mt-2 pt-2">
                            <span class="text-gray-800">စုစုပေါင်း</span>
                            <span class="text-green-700">{{ number_format($incomeByCategory->sum(), 2) }} MMK</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-circle-exclamation text-4xl text-gray-300 mb-2 block"></i>
                        ဝင်ငွေမရှိသေးပါ
                    </div>
                @endif
            </div>

            <!-- Expense by Category -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-red-800 mb-4">
                    <i class="fa-solid fa-circle-minus text-red-600 mr-2"></i>
                    ထွက်ငွေ အမျိုးအစားအလိုက်
                </h3>
                @if($expenseByCategory->count() > 0)
                    <div class="space-y-2">
                        @foreach($expenseByCategory as $category => $amount)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">
                                    <i class="fa-solid fa-tag text-red-400 mr-2"></i>
                                    {{ $category }}
                                </span>
                                <span class="font-semibold text-red-600">{{ number_format($amount, 2) }} MMK</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between items-center py-2 font-bold border-t-2 border-red-300 mt-2 pt-2">
                            <span class="text-gray-800">စုစုပေါင်း</span>
                            <span class="text-red-700">{{ number_format($expenseByCategory->sum(), 2) }} MMK</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-circle-exclamation text-4xl text-gray-300 mb-2 block"></i>
                        ထွက်ငွေမရှိသေးပါ
                    </div>
                @endif
            </div>
        </div>

        <!-- Transaction List -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fa-solid fa-list-ul text-blue-600 mr-2"></i>
                    ငွေပေးချေမှုစာရင်း
                </h3>
                <span class="text-sm text-gray-500">စုစုပေါင်း: {{ $records->count() }} ခု</span>
            </div>
            @if($records->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">နေ့စွဲ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">အမျိုးအစား</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">အမျိုးအစားခွဲ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ဖော်ပြချက်</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ပမာဏ</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">အခြေအနေ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($records as $record)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $record->transaction_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $record->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $record->type == 'income' ? 'ဝင်ငွေ' : 'ထွက်ငွေ' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $record->category }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $record->description }}</td>
                                    <td class="px-6 py-4 text-sm text-right font-semibold {{ $record->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($record->amount, 2) }} MMK
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $record->status == 'completed' ? 'bg-green-100 text-green-800' :
                                               ($record->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $record->status == 'completed' ? 'ပြီးစီး' :
                                               ($record->status == 'pending' ? 'ဆောင်ရွက်ဆဲ' : 'ပယ်ဖျက်') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <i class="fa-solid fa-receipt text-5xl text-gray-300 mb-3 block"></i>
                    <p>ငွေပေးချေမှုမရှိသေးပါ</p>
                    <a href="{{ route('user.financial.create') }}" class="inline-block mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                        <i class="fa-solid fa-plus mr-2"></i> ငွေပေးချေမှုအသစ်ထည့်ရန်
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('yearlyChart').getContext('2d');

        const monthlyData = @json($monthlyData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [
                    {
                        label: 'ဝင်ငွေ',
                        data: monthlyData.map(item => item.income),
                        backgroundColor: 'rgba(34, 197, 94, 0.6)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 2,
                        borderRadius: 4,
                    },
                    {
                        label: 'ထွက်ငွေ',
                        data: monthlyData.map(item => item.expense),
                        backgroundColor: 'rgba(239, 68, 68, 0.6)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 2,
                        borderRadius: 4,
                    },
                    {
                        label: 'အမြတ်',
                        data: monthlyData.map(item => item.profit),
                        type: 'line',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' +
                                    new Intl.NumberFormat().format(context.raw) + ' MMK';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat().format(value) + ' MMK';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
        .shadow {
            box-shadow: none !important;
        }
        .bg-white {
            background: white !important;
        }
        body {
            background: white !important;
        }
        .max-w-7xl {
            max-width: 100% !important;
        }
        .py-12 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }
        .mb-6 {
            margin-bottom: 1rem !important;
        }
    }
</style>
@endsection
