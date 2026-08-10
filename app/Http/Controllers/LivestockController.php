<?php

namespace App\Http\Controllers;

use App\Models\Livestock;
use App\Models\HealthRecord;
use App\Models\FeedingRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LivestockController extends Controller implements HasMiddleware
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
     * Display the livestock dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        $stats = [
            'total' => Livestock::where('user_id', $user->id)->count(),
            'active' => Livestock::where('user_id', $user->id)->where('status', 'active')->count(),
            'male' => Livestock::where('user_id', $user->id)->where('gender', 'male')->count(),
            'female' => Livestock::where('user_id', $user->id)->where('gender', 'female')->count(),
        ];

        $recentLivestocks = Livestock::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $types = Livestock::where('user_id', $user->id)
            ->selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');

        $healthStats = HealthRecord::whereHas('livestock', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->whereDate('next_due_date', '<=', now()->addDays(7))
          ->count();

        return view('user.livestock.dashboard', compact('stats', 'recentLivestocks', 'types', 'healthStats'));
    }

    /**
     * Display a listing of the livestock.
     */
    public function index(Request $request)
    {
        $query = Livestock::where('user_id', Auth::id());

        // Filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tag_number', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%")
                  ->orWhere('breed', 'LIKE', "%{$search}%");
            });
        }

        $livestocks = $query->latest()->paginate(10);
        $types = Livestock::where('user_id', Auth::id())->distinct()->pluck('type');

        // Get the active tab from query parameter, default to 'all'
        $activeTab = $request->get('tab', 'all');

        return view('user.livestock.index', compact('livestocks', 'types', 'activeTab'));
    }

    /**
     * Show the form for creating a new livestock.
     */
    public function create()
    {
        $types = ['cattle', 'sheep', 'goat', 'pig', 'horse', 'poultry', 'other'];
        $genders = ['male', 'female'];
        $statuses = ['active', 'sold', 'deceased', 'transferred'];
        $parents = Livestock::where('user_id', Auth::id())
            ->where('gender', 'female')
            ->where('status', 'active')
            ->pluck('name', 'id');

        return view('user.livestock.create', compact('types', 'genders', 'statuses', 'parents'));
    }

    /**
     * Store a newly created livestock in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_number' => 'required|string|unique:livestocks,tag_number',
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:cattle,sheep,goat,pig,horse,poultry,other',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date|before:today',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,sold,deceased,transferred',
            'parent_id' => 'nullable|exists:livestocks,id',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $livestock = Livestock::create([
            'tag_number' => $request->tag_number,
            'name' => $request->name,
            'type' => $request->type,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'breed' => $request->breed,
            'color' => $request->color,
            'weight' => $request->weight,
            'status' => $request->status,
            'parent_id' => $request->parent_id,
            'user_id' => Auth::id(),
            'notes' => $request->notes
        ]);

        return redirect()->route('user.livestock.show', $livestock)
            ->with('success', 'Livestock added successfully.');
    }

    /**
     * Display the specified livestock.
     */
    public function show(Livestock $livestock)
    {
        // Check if user owns this livestock
        if (Auth::id() !== $livestock->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $healthRecords = $livestock->healthRecords()->latest()->take(5)->get();
        $feedingRecords = $livestock->feedingRecords()->latest()->take(5)->get();

        return view('user.livestock.show', compact('livestock', 'healthRecords', 'feedingRecords'));
    }

    /**
     * Show the form for editing the specified livestock.
     */
    public function edit(Livestock $livestock)
    {
        // Check if user owns this livestock
        if (Auth::id() !== $livestock->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $types = ['cattle', 'sheep', 'goat', 'pig', 'horse', 'poultry', 'other'];
        $genders = ['male', 'female'];
        $statuses = ['active', 'sold', 'deceased', 'transferred'];
        $parents = Livestock::where('user_id', Auth::id())
            ->where('gender', 'female')
            ->where('status', 'active')
            ->where('id', '!=', $livestock->id)
            ->pluck('name', 'id');

        return view('user.livestock.edit', compact('livestock', 'types', 'genders', 'statuses', 'parents'));
    }

    /**
     * Update the specified livestock in storage.
     */
    public function update(Request $request, Livestock $livestock)
    {
        // Check if user owns this livestock
        if (Auth::id() !== $livestock->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'tag_number' => 'required|string|unique:livestocks,tag_number,' . $livestock->id,
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:cattle,sheep,goat,pig,horse,poultry,other',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date|before:today',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,sold,deceased,transferred',
            'parent_id' => 'nullable|exists:livestocks,id',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $livestock->update([
            'tag_number' => $request->tag_number,
            'name' => $request->name,
            'type' => $request->type,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'breed' => $request->breed,
            'color' => $request->color,
            'weight' => $request->weight,
            'status' => $request->status,
            'parent_id' => $request->parent_id,
            'notes' => $request->notes
        ]);

        return redirect()->route('user.livestock.show', $livestock)
            ->with('success', 'Livestock updated successfully.');
    }

    /**
     * Remove the specified livestock from storage.
     */
    public function destroy(Livestock $livestock)
    {
        // Check if user owns this livestock
        if (Auth::id() !== $livestock->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $livestock->delete();

        return redirect()->route('user.livestock.index')
            ->with('success', 'Livestock deleted successfully.');
    }

    /**
     * Display health records for the specified livestock.
     */
    public function healthRecords(Livestock $livestock)
    {
        // Check if user owns this livestock
        if (Auth::id() !== $livestock->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $healthRecords = $livestock->healthRecords()->latest()->paginate(10);

        return view('user.livestock.health-records', compact('livestock', 'healthRecords'));
    }

    /**
     * Add a health record for the specified livestock.
     */
    public function addHealthRecord(Request $request, Livestock $livestock)
    {
        // Check if user owns this livestock
        if (Auth::id() !== $livestock->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'record_date' => 'required|date',
            'type' => 'required|in:vaccination,treatment,checkup,surgery,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'medication' => 'nullable|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'next_due_date' => 'nullable|date|after:record_date',
            'cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        HealthRecord::create([
            'livestock_id' => $livestock->id,
            'record_date' => $request->record_date,
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'medication' => $request->medication,
            'dosage' => $request->dosage,
            'next_due_date' => $request->next_due_date,
            'administered_by' => Auth::id(),
            'cost' => $request->cost,
            'notes' => $request->notes
        ]);

        return redirect()->route('user.livestock.health-records', $livestock)
            ->with('success', 'Health record added successfully.');
    }

    /**
     * Display feeding records for the specified livestock.
     */
    public function feedingRecords(Livestock $livestock)
    {
        // Check if user owns this livestock
        if (Auth::id() !== $livestock->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $feedingRecords = $livestock->feedingRecords()->latest()->paginate(10);

        return view('user.livestock.feeding-records', compact('livestock', 'feedingRecords'));
    }

    /**
     * Add a feeding record for the specified livestock.
     */
    public function addFeedingRecord(Request $request, Livestock $livestock)
    {
        // Check if user owns this livestock
        if (Auth::id() !== $livestock->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'record_date' => 'required|date',
            'feed_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'feeding_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        FeedingRecord::create([
            'livestock_id' => $livestock->id,
            'record_date' => $request->record_date,
            'feed_type' => $request->feed_type,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'feeding_time' => $request->feeding_time,
            'notes' => $request->notes
        ]);

        return redirect()->route('user.livestock.feeding-records', $livestock)
            ->with('success', 'Feeding record added successfully.');
    }
}
