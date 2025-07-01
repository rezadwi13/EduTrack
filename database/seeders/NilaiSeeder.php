<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\MataPelajaran;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = Siswa::all();
        $mataPelajarans = MataPelajaran::all();
        
        if ($siswas->isEmpty() || $mataPelajarans->isEmpty()) {
            $this->command->info('Siswa atau Mata Pelajaran tidak ditemukan. Silakan jalankan seeder lain terlebih dahulu.');
            return;
        }
        
        $semesters = ['1', '2', '3', '4', '5', '6'];
        
        foreach ($siswas as $siswa) {
            foreach ($mataPelajarans as $mataPelajaran) {
                foreach ($semesters as $semester) {
                    // Generate nilai acak antara 70-95
                    $nilai = rand(70, 95);
                    
                    Nilai::create([
                        'siswa_id' => $siswa->id,
                        'mata_pelajaran_id' => $mataPelajaran->id,
                        'nilai' => $nilai,
                        'semester' => $semester,
                    ]);
                }
            }
        }
        
        $this->command->info('Data nilai berhasil ditambahkan!');
    }
} 