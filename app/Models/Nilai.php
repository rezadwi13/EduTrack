<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'nilai',
        'semester',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(\App\Models\MataPelajaran::class);
    }

    public function guru()
    {
        return $this->belongsTo(\App\Models\Guru::class, 'guru_id');
    }
}
