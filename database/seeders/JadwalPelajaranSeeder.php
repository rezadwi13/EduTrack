<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\User;

class JadwalPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil guru yang sudah ada
        $guru = User::where('role', 'guru')->first();
        
        if (!$guru) {
            $this->command->info('Tidak ada guru yang ditemukan. Buat guru terlebih dahulu.');
            return;
        }

        // Ambil mata pelajaran yang sudah ada
        $mataPelajaran = MataPelajaran::first();
        
        if (!$mataPelajaran) {
            $this->command->info('Tidak ada mata pelajaran yang ditemukan. Buat mata pelajaran terlebih dahulu.');
            return;
        }

        $jadwalData = [
            [
                'hari' => 'Senin',
                'jam_mulai' => '07:00',
                'jam_selesai' => '08:30',
                'kelas' => 'X',
                'mata_pelajaran_id' => $mataPelajaran->id,
                'guru_id' => $guru->id,
            ],
            [
                'hari' => 'Senin',
                'jam_mulai' => '08:30',
                'jam_selesai' => '10:00',
                'kelas' => 'XI',
                'mata_pelajaran_id' => $mataPelajaran->id,
                'guru_id' => $guru->id,
            ],
            [
                'hari' => 'Selasa',
                'jam_mulai' => '07:00',
                'jam_selesai' => '08:30',
                'kelas' => 'XII',
                'mata_pelajaran_id' => $mataPelajaran->id,
                'guru_id' => $guru->id,
            ],
            [
                'hari' => 'Rabu',
                'jam_mulai' => '10:00',
                'jam_selesai' => '11:30',
                'kelas' => 'X',
                'mata_pelajaran_id' => $mataPelajaran->id,
                'guru_id' => $guru->id,
            ],
        ];

        foreach ($jadwalData as $jadwal) {
            JadwalPelajaran::create($jadwal);
        }

        $this->command->info('Data jadwal pelajaran berhasil ditambahkan!');
    }
} 