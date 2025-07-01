<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Users (if not exists)
        $adminUsers = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Administrator',
                'email' => 'administrator@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'System Admin',
                'email' => 'system@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        ];

        foreach ($adminUsers as $adminData) {
            User::firstOrCreate(
                ['email' => $adminData['email']],
                $adminData
            );
        }

        // Create Guru Users (if not exists)
        $guruUsers = [
            [
                'name' => 'Guru Matematika',
                'email' => 'guru.matematika@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ],
            [
                'name' => 'Guru Bahasa Indonesia',
                'email' => 'guru.bahasa@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ],
            [
                'name' => 'Guru Bahasa Inggris',
                'email' => 'guru.inggris@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ],
            [
                'name' => 'Guru Fisika',
                'email' => 'guru.fisika@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ],
            [
                'name' => 'Guru Kimia',
                'email' => 'guru.kimia@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ],
        ];

        foreach ($guruUsers as $guruData) {
            $guru = User::firstOrCreate(
                ['email' => $guruData['email']],
                $guruData
            );
            
            // Create corresponding Guru record (if not exists)
            Guru::firstOrCreate(
                ['user_id' => $guru->id],
                [
                    'user_id' => $guru->id,
                    'name' => $guru->name,
                    'mata_pelajaran' => explode(' ', $guru->name)[1] ?? 'Umum',
                    'no_hp' => '08123456789',
                    'alamat' => 'Jl. Guru No. 1',
                ]
            );
        }

        // Create Siswa Users (if not exists)
        $siswaUsers = [
            [
                'name' => 'Ahmad Siswa',
                'email' => 'ahmad.siswa@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Siti Siswi',
                'email' => 'siti.siswi@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Budi Siswa',
                'email' => 'budi.siswa@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Dewi Siswi',
                'email' => 'dewi.siswi@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Eko Siswa',
                'email' => 'eko.siswa@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Fina Siswi',
                'email' => 'fina.siswi@edutrack.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ],
        ];

        foreach ($siswaUsers as $index => $siswaData) {
            $siswa = User::firstOrCreate(
                ['email' => $siswaData['email']],
                $siswaData
            );
            
            // Create corresponding Siswa record (if not exists)
            Siswa::firstOrCreate(
                ['user_id' => $siswa->id],
                [
                    'user_id' => $siswa->id,
                    'nama' => $siswa->name,
                    'nis' => '2024' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'kelas' => ['X', 'XI', 'XII'][$index % 3],
                    'jenis_kelamin' => $index % 2 == 0 ? 'Laki-laki' : 'Perempuan',
                    'email' => $siswa->email,
                    'no_hp' => '0812345678' . ($index + 1),
                ]
            );
        }

        $this->command->info('User roles seeded successfully!');
        $this->command->info('Admin: ' . count($adminUsers) . ' users');
        $this->command->info('Guru: ' . count($guruUsers) . ' users');
        $this->command->info('Siswa: ' . count($siswaUsers) . ' users');
        
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('Admin: admin@edutrack.com / password');
        $this->command->info('Admin: administrator@edutrack.com / password');
        $this->command->info('Admin: system@edutrack.com / password');
        $this->command->info('Guru: guru.matematika@edutrack.com / password');
        $this->command->info('Guru: guru.bahasa@edutrack.com / password');
        $this->command->info('Guru: guru.inggris@edutrack.com / password');
        $this->command->info('Guru: guru.fisika@edutrack.com / password');
        $this->command->info('Guru: guru.kimia@edutrack.com / password');
        $this->command->info('Siswa: ahmad.siswa@edutrack.com / password');
        $this->command->info('Siswa: siti.siswi@edutrack.com / password');
        $this->command->info('Siswa: budi.siswa@edutrack.com / password');
        $this->command->info('Siswa: dewi.siswi@edutrack.com / password');
        $this->command->info('Siswa: eko.siswa@edutrack.com / password');
        $this->command->info('Siswa: fina.siswi@edutrack.com / password');
    }
} 