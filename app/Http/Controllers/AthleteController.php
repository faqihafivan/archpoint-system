<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AthleteController extends Controller
{
    /**
     * Display a listing of the athletes.
     */
    public function index()
    {
        $this->authorizeAdmin();

        $athletes = Athlete::with('user')->get();
        return view('athletes.index', compact('athletes'));
    }

    /**
     * Show the form for editing the specified athlete.
     */
    public function edit(Athlete $athlete)
    {
        $this->authorizeAdmin();

        return view('athletes.edit', compact('athlete'));
    }

    /**
     * Update the specified athlete in storage.
     */
    public function update(Request $request, Athlete $athlete)
    {
        $this->authorizeAdmin();

        $user = $athlete->user;

        $request->validate([
            'username' => ['required', 'string', 'max:50', 'alpha_num', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            
            // Biodata
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'alamat' => ['required', 'string'],
            'nomor_hp' => ['required', 'string', 'max:20'],
            'tahun_bergabung' => ['required', 'integer', 'min:2000', 'max:' . date('Y')],
            'divisi' => ['required', 'string', 'in:Recurve,Compound,Standard Bow'],
            'kategori' => ['required', 'string', 'in:U-5,U-10,U-15,U-18,U-20,Senior,Umum'],
            'foto_profil' => ['nullable', 'image', 'max:2048'], // max 2MB
        ]);

        DB::transaction(function () use ($request, $user, $athlete) {
            // Update User details
            $userData = [
                'name' => $request->nama_lengkap,
                'username' => $request->username,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
            }
            $user->update($userData);

            // Handle Profile Photo Upload
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
                    $fotoPath = $request->file('foto_profil')->store('profiles', 'public');
                }
            }

            // Update Athlete details
            $athlete->update([
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'nomor_hp' => $request->nomor_hp,
                'tahun_bergabung' => $request->tahun_bergabung,
                'divisi' => $request->divisi,
                'kategori' => $request->kategori,
                'foto_profil' => $fotoPath,
            ]);
        });

        return redirect()->route('athletes.index')->with('success', 'Data atlet berhasil diperbarui!');
    }

    /**
     * Remove the specified athlete from storage.
     */
    public function destroy(Athlete $athlete)
    {
        $this->authorizeAdmin();

        $user = $athlete->user;

        // Delete profile photo from storage if exists
        if ($athlete->foto_profil && Storage::disk('public')->exists($athlete->foto_profil)) {
            Storage::disk('public')->delete($athlete->foto_profil);
        }

        // Delete User (cascades to Athlete and Results)
        $user->delete();

        return redirect()->route('athletes.index')->with('success', 'Atlet berhasil dihapus!');
    }

    /**
     * Helper to verify if user is admin.
     */
    protected function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }
}
