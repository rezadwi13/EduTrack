<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $kelasList = ['X', 'XI', 'XII'];
        $jenisKelamin = ['Laki-laki', 'Perempuan'];
        $noUrut = 1;
        foreach ($kelasList as $kelas) {
            for ($i = 1; $i <= 3; $i++) {
                $nis = $kelas . '00' . $i;
                $user = User::create([
                    'name' => 'Siswa ' . $kelas . ' ' . $i,
                    'email' => $nis . '@siswa.com',
                    'password' => Hash::make('password'),
                    'role' => 'siswa',
                ]);
                Siswa::create([
                    'nama' => 'Siswa ' . $kelas . ' ' . $i,
                    'nis' => $nis,
                    'kelas' => $kelas,
                    'jenis_kelamin' => $jenisKelamin[$i % 2],
                    'alamat' => 'Alamat ' . $noUrut,
                    'no_hp' => '0812345678' . $noUrut,
                    'user_id' => $user->id,
                ]);
                $noUrut++;
            }
        }
    }
} 