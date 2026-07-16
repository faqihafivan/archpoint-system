<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'athlete' => $request->user()->athlete,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:50', 'alpha_num', 'unique:users,username,' . $user->id],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            ]);

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);
        } else {
            // Athlete
            $athlete = $user->athlete;
            
            $request->validate([
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'nomor_hp' => ['required', 'string', 'max:20'],
                'foto_profil' => ['nullable', 'image', 'max:2048'],
            ]);

            $user->update([
                'email' => $request->email,
            ]);

            // Handle Profile Photo Upload via Intervention Image
            $fotoPath = $athlete->foto_profil;
            if ($request->hasFile('foto_profil')) {
                // Delete old photo if exists
                if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }

                try {
                    $file = $request->file('foto_profil');
                    $manager = new ImageManager(new Driver());
                    $image = $manager->decode($file->getRealPath());
                    $image->cover(300, 300);
                    
                    $filename = time() . '_' . uniqid() . '.jpg';
                    $destFolder = storage_path('app/public/profiles');
                    if (!file_exists($destFolder)) {
                        mkdir($destFolder, 0755, true);
                    }
                    $image->save($destFolder . '/' . $filename);
                    $fotoPath = 'profiles/' . $filename;
                } catch (\Exception $e) {
                    // Fallback storage
                    $fotoPath = $request->file('foto_profil')->store('profiles', 'public');
                }
            }

            $athlete->update([
                'nomor_hp' => $request->nomor_hp,
                'foto_profil' => $fotoPath,
            ]);
        }

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete photo if exists
        if ($user->athlete && $user->athlete->foto_profil && Storage::disk('public')->exists($user->athlete->foto_profil)) {
            Storage::disk('public')->delete($user->athlete->foto_profil);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
