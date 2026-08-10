{{-- resources/views/user/livestock/financial/monthly-report.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fa-solid fa-calendar-check text-blue-600 mr-2"></i>
                လစဉ်အစီရင်ခံစာ - {{ $monthName }}
            </h2>
            <div class="flex flex-wrap items-center gap-2">
                <form method="GET" class="flex items-center gap-2">
                    <select name="month" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::createFromDate($selectedYear, $m, 1)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @for($y = date('Y') - 5; $y <= date('Y'); $y++)
                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
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
        </div>

        <!-- Daily Chart -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fa-solid fa-chart-line text-blue-600 mr-2"></i>
                နေ့စဉ် ဝင်ငွေ/ထွက်ငွေ
            </h3>
            <div class="h-64">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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
        const ctx = document.getElementById('dailyChart').getContext('2d');

        const dailyData = @json($dailyData);
        const labels = Object.keys(dailyData);
        const incomeData = labels.map(date => dailyData[date].income);
        const expenseData = labels.map(date => dailyData[date].expense);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'ဝင်ငွေ',
                        data: incomeData,
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                        pointRadius: 3,
                    },
                    {
                        label: 'ထွက်ငွေ',
                        data: expenseData,
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                        pointRadius: 3,
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
