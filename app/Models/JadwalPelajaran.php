<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $fillable = [
        'mata_pelajaran_id',
        'kelas', 
        'hari', 
        'jam_mulai', 
        'jam_selesai', 
        'guru_id'
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(\App\Models\MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function guru()
    {
        return $this->belongsTo(\App\Models\User::class, 'guru_id');
    }
}
