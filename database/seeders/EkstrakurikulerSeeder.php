<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ekstrakurikuler;

class EkstrakurikulerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ekstrakurikulers = [
            [
                'nama' => 'Basket',
                'deskripsi' => 'Ekstrakurikuler basket untuk mengembangkan keterampilan olahraga dan kerja tim.',
            ],
            [
                'nama' => 'Futsal',
                'deskripsi' => 'Ekstrakurikuler futsal untuk melatih keterampilan sepak bola dalam ruangan.',
            ],
            [
                'nama' => 'Pramuka',
                'deskripsi' => 'Ekstrakurikuler pramuka untuk melatih kepemimpinan dan keterampilan survival.',
            ],
            [
                'nama' => 'Rohis',
                'deskripsi' => 'Ekstrakurikuler Rohani Islam untuk memperdalam pengetahuan agama.',
            ],
            [
                'nama' => 'English Club',
                'deskripsi' => 'Ekstrakurikuler bahasa Inggris untuk meningkatkan kemampuan berkomunikasi dalam bahasa Inggris.',
            ],
            [
                'nama' => 'Jurnalistik',
                'deskripsi' => 'Ekstrakurikuler jurnalistik untuk melatih keterampilan menulis dan fotografi.',
            ],
            [
                'nama' => 'Seni Musik',
                'deskripsi' => 'Ekstrakurikuler seni musik untuk mengembangkan bakat musik dan vokal.',
            ],
            [
                'nama' => 'Robotik',
                'deskripsi' => 'Ekstrakurikuler robotik untuk mempelajari teknologi dan pemrograman.',
            ],
        ];

        foreach ($ekstrakurikulers as $ekstrakurikuler) {
            Ekstrakurikuler::create($ekstrakurikuler);
        }

        $this->command->info('Data ekstrakurikuler berhasil ditambahkan!');
    }
} 