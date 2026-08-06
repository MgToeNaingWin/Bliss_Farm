<?php

namespace App\Http\Controllers;

use App\Models\AnimalType;
use App\Models\DiseaseInfo;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    // Tier 1: တိရစ္ဆာန် အမျိုးအစားအားလုံးနှင့် ရောဂါအားလုံးကို ပြသရန် (Disease Home Page)
    public function index(Request $request)
    {
        $animalTypes = AnimalType::all();

        $query = DiseaseInfo::with('animalType');

        // တိရစ္ဆာန်အမျိုးအစားအလိုက် Filter
        if ($request->filled('animal')) {
            $query->where('animal_type_id', $request->animal);
        }

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('disease_title', 'like', '%' . $search . '%')
                  ->orWhere('disease_desc', 'like', '%' . $search . '%')
                  ->orWhere('symptoms', 'like', '%' . $search . '%');
            });
        }

        $diseases = $query->latest()->paginate(9)->withQueryString();

        return view('user.disease.list', compact('animalTypes', 'diseases'));
    }

    // Tier 2
    public function showAnimalDiseases($id)
    {
        $animalType = AnimalType::findOrFail($id);
        $diseases = DiseaseInfo::where('animal_type_id', $id)->withCount('comments')->latest()->paginate(9)->withQueryString();

        return view('user.disease.animal_diseases', compact('animalType', 'diseases'));
    }

    // Tier 3
    public function showDiseaseDetail($id)
    {
        $disease = DiseaseInfo::with('animalType')->findOrFail($id);

        // View count: only once per user (or per session for guests)
        $sessionKey = 'disease_viewed_' . $disease->id;
        if (!session()->has($sessionKey)) {
            $disease->increment('view_count');
            session()->put($sessionKey, true);
        }

        // Load comments with user
        $comments = $disease->comments()->with('user')->latest()->get();

        // Reaction counts
        $reactions = [
            'like' => $disease->reactions()->where('type', 'like')->count(),
            'helpful' => $disease->reactions()->where('type', 'helpful')->count(),
            'thanks' => $disease->reactions()->where('type', 'thanks')->count(),
        ];

        // Check if current user reacted
        $userReaction = null;
        if (auth()->check()) {
            $userReaction = $disease->reactions()
                ->where('user_id', auth()->id())
                ->value('type');
        }

        // Sidebar: Related diseases (same animal type, excluding current)
        $relatedDiseases = DiseaseInfo::where('animal_type_id', $disease->animal_type_id)
            ->where('id', '!=', $disease->id)
            ->withCount('comments')
            ->latest()
            ->take(5)
            ->get();

        // Sidebar: Top viewed diseases
        $topViewed = DiseaseInfo::where('id', '!=', $disease->id)
            ->withCount('comments')
            ->orderByDesc('view_count')
            ->take(5)
            ->get();

        return view('user.disease.detail', compact('disease', 'comments', 'reactions', 'userReaction', 'relatedDiseases', 'topViewed'));
    }
}
