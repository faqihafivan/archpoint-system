<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Athlete;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'alpha_num', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
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

        $user = DB::transaction(function () use ($request) {
            // 1. Create User
            $user = User::create([
                'name' => $request->nama_lengkap,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'atlet',
            ]);

            // 2. Handle Photo Upload via Intervention Image
            $fotoPath = null;
            if ($request->hasFile('foto_profil')) {
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
                    // Fallback to storing raw file if Intervention fails
                    $fotoPath = $request->file('foto_profil')->store('profiles', 'public');
                }
            }

            // 3. Generate Athlete ID
            $nomorId = Athlete::generateAthleteId();

            // 4. Create Athlete
            Athlete::create([
                'user_id' => $user->id,
                'nomor_id' => $nomorId,
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

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
