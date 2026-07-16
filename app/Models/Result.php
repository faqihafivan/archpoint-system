<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'athlete_id',
    'event_name',
    'lokasi',
    'tanggal',
    'score',
    'hasil_pertandingan'
])]
class Result extends Model
{
    use HasFactory;

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}
