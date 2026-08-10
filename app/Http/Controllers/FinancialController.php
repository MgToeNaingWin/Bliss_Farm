<?php

namespace App\Http\Controllers;

use App\Models\Livestock;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Carbon\Carbon;

class FinancialController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    /**
     * Display the financial dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Monthly stats
        $monthlyIncome = FinancialRecord::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $monthlyExpense = FinancialRecord::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $monthlyProfit = $monthlyIncome - $monthlyExpense;

        // Yearly stats
        $yearlyIncome = FinancialRecord::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $yearlyExpense = FinancialRecord::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $yearlyProfit = $yearlyIncome - $yearlyExpense;

        // Total stats
        $totalIncome = FinancialRecord::where('user_id', $user->id)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = FinancialRecord::where('user_id', $user->id)
            ->where('type', 'expense')
            ->sum('amount');

        $totalProfit = $totalIncome - $totalExpense;

        // Recent transactions
        $recentTransactions = FinancialRecord::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        // Monthly data for chart (last 12 months)
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->format('M');

            $income = FinancialRecord::where('user_id', $user->id)
                ->where('type', 'income')
                ->whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->sum('amount');

            $expense = FinancialRecord::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->sum('amount');

            $monthlyData[] = [
                'month' => $monthName,
                'income' => $income,
                'expense' => $expense,
                'profit' => $income - $expense
            ];
        }

        // Category breakdown
        $incomeCategories = FinancialRecord::where('user_id', $user->id)
            ->where('type', 'income')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        $expenseCategories = FinancialRecord::where('user_id', $user->id)
            ->where('type', 'expense')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        return view('user.livestock.financial.dashboard', compact(
            'monthlyIncome', 'monthlyExpense', 'monthlyProfit',
            'yearlyIncome', 'yearlyExpense', 'yearlyProfit',
            'totalIncome', 'totalExpense', 'totalProfit',
            'recentTransactions', 'monthlyData',
            'incomeCategories', 'expenseCategories',
            'currentMonth', 'currentYear'
        ));
    }

    /**
     * Display financial records with filters.
     */
    public function records(Request $request)
    {
        $query = FinancialRecord::where('user_id', Auth::id());

        // Filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%")
                  ->orWhere('reference_number', 'LIKE', "%{$search}%");
            });
        }

        $records = $query->latest()->paginate(15);

        // Get all categories for filter dropdown
        $categories = FinancialRecord::where('user_id', Auth::id())
            ->distinct()
            ->pluck('category');

        // Summary
        $totalIncome = $query->clone()->where('type', 'income')->sum('amount');
        $totalExpense = $query->clone()->where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        return view('user.livestock.financial.records', compact(
            'records', 'categories', 'totalIncome', 'totalExpense', 'netProfit'
        ));
    }

    /**
     * Show form to create financial record.
     */
    public function create()
    {
        $incomeCategories = ['Sale of Livestock', 'Sale of Products', 'Sale of By-products', 'Other Income'];
        $expenseCategories = ['Feed', 'Veterinary', 'Medicine', 'Equipment', 'Labor', 'Utilities', 'Transport', 'Other Expense'];
        $paymentMethods = ['Cash', 'Bank Transfer', 'Mobile Payment', 'Cheque', 'Other'];

        $livestocks = Livestock::where('user_id', Auth::id())
            ->where('status', 'active')
            ->pluck('name', 'id');

        return view('user.livestock.financial.create', compact(
            'incomeCategories', 'expenseCategories', 'paymentMethods', 'livestocks'
        ));
    }

    /**
     * Store a new financial record.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'livestock_id' => 'nullable|exists:livestocks,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        FinancialRecord::create([
            'user_id' => Auth::id(),
            'livestock_id' => $request->livestock_id,
            'type' => $request->type,
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            'description' => $request->description,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'notes' => $request->notes,
            'status' => $request->status
        ]);

        return redirect()->route('user.financial.records')
            ->with('success', 'Financial record added successfully.');
    }

    /**
     * Show financial record details.
     */
    public function show(FinancialRecord $record)
    {
        if (Auth::id() !== $record->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.livestock.financial.show', compact('record'));
    }

    /**
     * Edit financial record.
     */
    public function edit(FinancialRecord $record)
    {
        if (Auth::id() !== $record->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $incomeCategories = ['Sale of Livestock', 'Sale of Products', 'Sale of By-products', 'Other Income'];
        $expenseCategories = ['Feed', 'Veterinary', 'Medicine', 'Equipment', 'Labor', 'Utilities', 'Transport', 'Other Expense'];
        $paymentMethods = ['Cash', 'Bank Transfer', 'Mobile Payment', 'Cheque', 'Other'];

        $livestocks = Livestock::where('user_id', Auth::id())
            ->where('status', 'active')
            ->pluck('name', 'id');

        return view('user.livestock.financial.edit', compact(
            'record', 'incomeCategories', 'expenseCategories', 'paymentMethods', 'livestocks'
        ));
    }

    /**
     * Update financial record.
     */
    public function update(Request $request, FinancialRecord $record)
    {
        if (Auth::id() !== $record->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'livestock_id' => 'nullable|exists:livestocks,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $record->update([
            'livestock_id' => $request->livestock_id,
            'type' => $request->type,
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            'description' => $request->description,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'notes' => $request->notes,
            'status' => $request->status
        ]);

        return redirect()->route('user.financial.records')
            ->with('success', 'Financial record updated successfully.');
    }

    /**
     * Delete financial record.
     */
    public function destroy(FinancialRecord $record)
    {
        if (Auth::id() !== $record->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $record->delete();

        return redirect()->route('user.financial.records')
            ->with('success', 'Financial record deleted successfully.');
    }

    /**
     * Show monthly report.
     */
    public function monthlyReport(Request $request)
    {
        $user = Auth::user();
        $selectedMonth = $request->month ?? Carbon::now()->month;
        $selectedYear = $request->year ?? Carbon::now()->year;

        // Get records for selected month
        $records = FinancialRecord::where('user_id', $user->id)
            ->whereMonth('transaction_date', $selectedMonth)
            ->whereYear('transaction_date', $selectedYear)
            ->get();

        // Summary
        $totalIncome = $records->where('type', 'income')->sum('amount');
        $totalExpense = $records->where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        // Daily breakdown
        $dailyData = $records->groupBy(function($record) {
            return $record->transaction_date->format('Y-m-d');
        })->map(function($items) {
            return [
                'income' => $items->where('type', 'income')->sum('amount'),
                'expense' => $items->where('type', 'expense')->sum('amount')
            ];
        });

        // Category breakdown
        $incomeByCategory = $records->where('type', 'income')
            ->groupBy('category')
            ->map(function($items) {
                return $items->sum('amount');
            });

        $expenseByCategory = $records->where('type', 'expense')
            ->groupBy('category')
            ->map(function($items) {
                return $items->sum('amount');
            });

        // Month name
        $monthName = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->format('F Y');

        return view('user.livestock.financial.monthly-report', compact(
            'records', 'totalIncome', 'totalExpense', 'netProfit',
            'dailyData', 'incomeByCategory', 'expenseByCategory',
            'monthName', 'selectedMonth', 'selectedYear'
        ));
    }

    /**
     * Show yearly report.
     */
    public function yearlyReport(Request $request)
    {
        $user = Auth::user();
        $selectedYear = $request->year ?? Carbon::now()->year;

        // Get records for selected year
        $records = FinancialRecord::where('user_id', $user->id)
            ->whereYear('transaction_date', $selectedYear)
            ->get();

        // Summary
        $totalIncome = $records->where('type', 'income')->sum('amount');
        $totalExpense = $records->where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        // Monthly breakdown
        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthRecords = $records->filter(function($record) use ($month) {
                return $record->transaction_date->month == $month;
            });

            $monthlyData[] = [
                'month' => Carbon::createFromDate($selectedYear, $month, 1)->format('M'),
                'income' => $monthRecords->where('type', 'income')->sum('amount'),
                'expense' => $monthRecords->where('type', 'expense')->sum('amount'),
                'profit' => $monthRecords->where('type', 'income')->sum('amount') -
                           $monthRecords->where('type', 'expense')->sum('amount')
            ];
        }

        // Category breakdown for whole year
        $incomeByCategory = $records->where('type', 'income')
            ->groupBy('category')
            ->map(function($items) {
                return $items->sum('amount');
            });

        $expenseByCategory = $records->where('type', 'expense')
            ->groupBy('category')
            ->map(function($items) {
                return $items->sum('amount');
            });

        // Get available years for dropdown
        $availableYears = FinancialRecord::where('user_id', $user->id)
            ->selectRaw('DISTINCT YEAR(transaction_date) as year')
            ->pluck('year')
            ->sort()
            ->values();

        // If no records exist, use current year
        if ($availableYears->isEmpty()) {
            $availableYears = collect([Carbon::now()->year]);
        }

        return view('user.livestock.financial.yearly-report', compact(
            'records', 'totalIncome', 'totalExpense', 'netProfit',
            'monthlyData', 'incomeByCategory', 'expenseByCategory',
            'selectedYear', 'availableYears'
        ));
    }

    /**
     * Export financial report as PDF (Optional).
     */
    public function exportPDF(Request $request)
    {
        // This is a placeholder - you would need to install a PDF package like DomPDF
        // Example: composer require barryvdh/laravel-dompdf

        $user = Auth::user();
        $type = $request->type ?? 'monthly';
        $year = $request->year ?? Carbon::now()->year;
        $month = $request->month ?? Carbon::now()->month;

        // Get data based on type
        if ($type == 'monthly') {
            $records = FinancialRecord::where('user_id', $user->id)
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', $year)
                ->get();
            $title = 'Monthly Report - ' . Carbon::createFromDate($year, $month, 1)->format('F Y');
        } else {
            $records = FinancialRecord::where('user_id', $user->id)
                ->whereYear('transaction_date', $year)
                ->get();
            $title = 'Yearly Report - ' . $year;
        }

        $totalIncome = $records->where('type', 'income')->sum('amount');
        $totalExpense = $records->where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        // Return view for PDF
        return view('user.livestock.financial.export-pdf', compact(
            'records', 'totalIncome', 'totalExpense', 'netProfit', 'title', 'type'
        ));

        // If using DomPDF, you would do:
        // $pdf = \PDF::loadView('user.livestock.financial.export-pdf', compact(...));
        // return $pdf->download('financial-report.pdf');
    }

    /**
     * Get financial summary for API (Optional).
     */
    public function summary()
    {
        $user = Auth::user();

        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();
        $yearStart = Carbon::now()->startOfYear();

        $summary = [
            'today' => [
                'income' => FinancialRecord::where('user_id', $user->id)
                    ->where('type', 'income')
                    ->whereDate('transaction_date', $today)
                    ->sum('amount'),
                'expense' => FinancialRecord::where('user_id', $user->id)
                    ->where('type', 'expense')
                    ->whereDate('transaction_date', $today)
                    ->sum('amount'),
            ],
            'week' => [
                'income' => FinancialRecord::where('user_id', $user->id)
                    ->where('type', 'income')
                    ->whereBetween('transaction_date', [$weekStart, Carbon::now()])
                    ->sum('amount'),
                'expense' => FinancialRecord::where('user_id', $user->id)
                    ->where('type', 'expense')
                    ->whereBetween('transaction_date', [$weekStart, Carbon::now()])
                    ->sum('amount'),
            ],
            'month' => [
                'income' => FinancialRecord::where('user_id', $user->id)
                    ->where('type', 'income')
                    ->whereBetween('transaction_date', [$monthStart, Carbon::now()])
                    ->sum('amount'),
                'expense' => FinancialRecord::where('user_id', $user->id)
                    ->where('type', 'expense')
                    ->whereBetween('transaction_date', [$monthStart, Carbon::now()])
                    ->sum('amount'),
            ],
            'year' => [
                'income' => FinancialRecord::where('user_id', $user->id)
                    ->where('type', 'income')
                    ->whereBetween('transaction_date', [$yearStart, Carbon::now()])
                    ->sum('amount'),
                'expense' => FinancialRecord::where('user_id', $user->id)
                    ->where('type', 'expense')
                    ->whereBetween('transaction_date', [$yearStart, Carbon::now()])
                    ->sum('amount'),
            ],
            'total' => [
                'income' => FinancialRecord::where('user_id', $user->id)
                    ->where('type', 'income')
                    ->sum('amount'),
                'expense' => FinancialRecord::where('user_id', $user->id)
                    ->where('type', 'expense')
                    ->sum('amount'),
            ]
        ];

        // Add profit calculations
        foreach ($summary as $key => $data) {
            $summary[$key]['profit'] = $data['income'] - $data['expense'];
        }

        return response()->json($summary);
    }
}
