<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    /**
     * Display the leaderboard standings.
     */
    public function index(Request $request)
    {
        $divisi = $request->query('divisi');

        $query = Athlete::withMax('results', 'score');

        // Apply division filter if requested
        if ($divisi && in_array($divisi, ['Recurve', 'Compound', 'Standard Bow'])) {
            $query->where('divisi', $divisi);
        }

        $athletes = $query->orderBy('results_max_score', 'desc')->get();

        return view('leaderboard.index', compact('athletes', 'divisi'));
    }
}
