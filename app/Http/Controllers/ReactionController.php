<?php

namespace App\Http\Controllers;

use App\Models\DiseaseInfo;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function toggle(Request $request, DiseaseInfo $disease)
    {
        $request->validate([
            'type' => 'required|in:like,helpful,thanks',
        ]);

        $existing = Reaction::where('user_id', auth()->id())
            ->where('disease_info_id', $disease->id)
            ->where('type', $request->type)
            ->first();

        if ($existing) {
            $existing->delete();
            $active = null;
        } else {
            Reaction::where('user_id', auth()->id())
                ->where('disease_info_id', $disease->id)
                ->delete();

            Reaction::create([
                'user_id' => auth()->id(),
                'disease_info_id' => $disease->id,
                'type' => $request->type,
            ]);
            $active = $request->type;
        }

        $reactions = [
            'like' => $disease->reactions()->where('type', 'like')->count(),
            'helpful' => $disease->reactions()->where('type', 'helpful')->count(),
            'thanks' => $disease->reactions()->where('type', 'thanks')->count(),
        ];

        return response()->json(['reactions' => $reactions, 'active' => $active]);
    }
}
