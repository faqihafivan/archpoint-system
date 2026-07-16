<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'user_id',
    'nomor_id',
    'nama_lengkap',
    'tempat_lahir',
    'tanggal_lahir',
    'alamat',
    'nomor_hp',
    'tahun_bergabung',
    'divisi',
    'kategori',
    'foto_profil'
])]
class Athlete extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Generate the next automated Athlete ID (e.g. ARC-0001, ARC-0002)
     */
    public static function generateAthleteId(): string
    {
        $latest = self::orderBy('id', 'desc')->first();
        if (!$latest) {
            return 'ARC-0001';
        }
        
        // Extract number from ARC-XXXX
        $num = (int) substr($latest->nomor_id, 4);
        $nextNum = $num + 1;
        return 'ARC-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
    }
}
