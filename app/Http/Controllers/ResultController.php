<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    /**
     * Display a listing of the results for the logged-in athlete.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Prevent admin from viewing this page as it's athlete-only
        if ($user->role !== 'atlet') {
            return redirect()->route('dashboard')->with('error', 'Hanya atlet yang dapat mengakses halaman riwayat pertandingan.');
        }

        $athlete = $user->athlete;
        $results = $athlete->results()->orderBy('tanggal', 'desc')->get();

        return view('results.index', compact('results', 'athlete'));
    }

    /**
     * Store a newly created match result in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'atlet') {
            abort(403, 'Unauthorized action.');
        }

        $athlete = $user->athlete;

        $request->validate([
            'event_name' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'score' => ['required', 'integer', 'min:0', 'max:1000'],
            'hasil_pertandingan' => ['required', 'string', 'in:Tidak Juara,Juara 1,Juara 2,Juara 3'],
        ]);

        Result::create([
            'athlete_id' => $athlete->id,
            'event_name' => $request->event_name,
            'lokasi' => $request->lokasi,
            'tanggal' => $request->tanggal,
            'score' => $request->score,
            'hasil_pertandingan' => $request->hasil_pertandingan,
        ]);

        return redirect()->route('results.index')->with('success', 'Hasil pertandingan berhasil disimpan!');
    }
}
