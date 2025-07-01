<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelajaran = MataPelajaran::all();
        $jenisKelamin = ['Laki-laki', 'Perempuan'];
        $noUrut = 1;
        foreach ($pelajaran as $i => $mapel) {
            $kode = $mapel->kode ?: 'guru' . ($i+1);
            $user = User::create([
                'name' => 'Guru ' . $mapel->nama,
                'email' => $kode . '@guru.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]);
            Guru::create([
                'nip' => 'NIP' . str_pad($i+1, 4, '0', STR_PAD_LEFT),
                'nama' => 'Guru ' . $mapel->nama,
                'email' => $kode . '@guru.com',
                'no_hp' => '0812345678' . $noUrut,
                'alamat' => 'Alamat Guru ' . $noUrut,
                'jenis_kelamin' => $jenisKelamin[$i % 2],
                'mata_pelajaran' => $mapel->nama,
                'user_id' => $user->id,
            ]);
            $noUrut++;
        }
    }
}
