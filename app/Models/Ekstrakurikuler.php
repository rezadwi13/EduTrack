<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'pembina',
        'hari',
        'jam',
        'tempat',
        'kuota',
        'status',
        'jenis',
    ];

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'ekstrakurikuler_siswa');
    }
}
