<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = ['nama', 'nis', 'kelas', 'jenis_kelamin', 'user_id'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function ekstrakurikulers()
    {
        return $this->belongsToMany(Ekstrakurikuler::class, 'ekstrakurikuler_siswa');
    }
}
