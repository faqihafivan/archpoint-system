<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Athlete;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }

        return $this->athleteDashboard();
    }

    /**
     * Load admin dashboard data and view.
     */
    protected function adminDashboard()
    {
        $totalAthletes = Athlete::count();
        $totalMatches = Result::count();
        $bestScore = Result::max('score') ?? 0;
        
        $totalJuara = Result::whereIn('hasil_pertandingan', ['Juara 1', 'Juara 2', 'Juara 3'])->count();

        // Club-wide score progress (average score per match date)
        $scoreProgress = Result::selectRaw("DATE_FORMAT(tanggal, '%d %b %y') as date_label, tanggal, AVG(score) as avg_score")
            ->groupBy('date_label', 'tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Top 10 Leaderboard
        $topAthletes = Athlete::withMax('results', 'score')
            ->orderBy('results_max_score', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.admin', compact(
            'totalAthletes',
            'totalMatches',
            'bestScore',
            'totalJuara',
            'scoreProgress',
            'topAthletes'
        ));
    }

    /**
     * Load athlete dashboard data and view.
     */
    protected function athleteDashboard()
    {
        $user = Auth::user();
        
        // Find or create athlete fallback to prevent errors
        $athlete = $user->athlete;
        
        if (!$athlete) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Athlete profile not found.']);
        }

        // Stats
        $bestScore = $athlete->results()->max('score') ?? 0;
        $avgScore = round($athlete->results()->avg('score') ?? 0, 1);
        $totalMatches = $athlete->results()->count();
        $totalJuara = $athlete->results()->whereIn('hasil_pertandingan', ['Juara 1', 'Juara 2', 'Juara 3'])->count();

        // Calculate club ranking (based on best score)
        $allRanked = Athlete::withMax('results', 'score')
            ->orderBy('results_max_score', 'desc')
            ->get();
        
        $rankingKlub = 0;
        foreach ($allRanked as $index => $item) {
            if ($item->id === $athlete->id) {
                $rankingKlub = $index + 1;
                break;
            }
        }

        // Personal score progress
        $personalProgress = $athlete->results()
            ->orderBy('tanggal', 'asc')
            ->get(['tanggal', 'score', 'event_name']);

        // Recent matches (last 5)
        $latestResults = $athlete->results()
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.athlete', compact(
            'athlete',
            'bestScore',
            'avgScore',
            'totalMatches',
            'totalJuara',
            'rankingKlub',
            'personalProgress',
            'latestResults'
        ));
    }
}
