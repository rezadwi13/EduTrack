<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'no_hp',
        'alamat',
        'jenis_kelamin',
        'mata_pelajaran',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class, 'guru_id', 'user_id');
    }

    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class, 'user_id', 'user_id');
    }

    public function galeri()
    {
        return $this->hasMany(Galeri::class, 'user_id', 'user_id');
    }

    // Scope untuk mencari guru berdasarkan mata pelajaran
    public function scopeMataPelajaran($query, $mataPelajaran)
    {
        return $query->where('mata_pelajaran', 'LIKE', "%{$mataPelajaran}%");
    }

    // Scope untuk mencari guru berdasarkan jenis kelamin
    public function scopeJenisKelamin($query, $jenisKelamin)
    {
        return $query->where('jenis_kelamin', $jenisKelamin);
    }
}
