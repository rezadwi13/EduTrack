<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Galeri;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galeris = [
            [
                'judul' => 'Kegiatan Upacara',
                'deskripsi' => 'Dokumentasi upacara bendera hari Senin.',
                'gambar' => 'upacara.jpg',
                'user_id' => 1,
            ],
            [
                'judul' => 'Lomba Futsal',
                'deskripsi' => 'Tim futsal sekolah meraih juara 1 tingkat kota.',
                'gambar' => 'futsal.jpg',
                'user_id' => 1,
            ],
            [
                'judul' => 'Pentas Seni',
                'deskripsi' => 'Penampilan seni musik dan tari oleh siswa.',
                'gambar' => 'pentas_seni.jpg',
                'user_id' => 1,
            ],
        ];
        foreach ($galeris as $galeri) {
            Galeri::create($galeri);
        }
        $this->command->info('Data galeri berhasil ditambahkan!');
    }
}
