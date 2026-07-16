<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Shared Dashboards (Controller redirects internally based on role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Shared Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Athlete-only routes (Match results)
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::post('/results', [ResultController::class, 'store'])->name('results.store');
    
    // Admin-only routes (Athlete management)
    Route::resource('athletes', AthleteController::class)->except(['create', 'store', 'show']);
});

require __DIR__.'/auth.php';
