<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ekstrakurikuler;

class EkskulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ekskuls = [
            [
                'nama' => 'Paskibra',
                'deskripsi' => 'Ekstrakurikuler Pasukan Pengibar Bendera.'
            ],
            [
                'nama' => 'PMR',
                'deskripsi' => 'Ekstrakurikuler Palang Merah Remaja.'
            ],
            [
                'nama' => 'KIR',
                'deskripsi' => 'Ekstrakurikuler Kelompok Ilmiah Remaja.'
            ],
        ];
        foreach ($ekskuls as $ekskul) {
            Ekstrakurikuler::create($ekskul);
        }
        $this->command->info('Data ekskul berhasil ditambahkan!');
    }
}
