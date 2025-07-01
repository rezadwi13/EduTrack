<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Check if test user already exists before creating
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Run seeders that actually exist
        $this->call([
            UserSeeder::class,
            SiswaSeeder::class,
            GuruSeeder::class,
            MataPelajaranSeeder::class,
            JadwalPelajaranSeeder::class,
            NilaiSeeder::class,
            EkstrakurikulerSeeder::class,
            MenuPermissionSeeder::class,
            ConnectSiswaUserSeeder::class,
            UserRoleSeeder::class,
            GaleriSeeder::class,
            EkskulSeeder::class,
        ]);
    }
}
