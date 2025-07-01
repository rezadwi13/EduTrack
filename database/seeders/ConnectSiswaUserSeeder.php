<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;

class ConnectSiswaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users with role siswa that don't have connected siswa
        $users = User::where('role', 'siswa')
            ->whereNotIn('id', Siswa::whereNotNull('user_id')->pluck('user_id'))
            ->get();

        // Get siswa without user_id
        $siswaWithoutUser = Siswa::whereNull('user_id')->get();

        // Connect them
        foreach ($users as $index => $user) {
            if (isset($siswaWithoutUser[$index])) {
                $siswaWithoutUser[$index]->update(['user_id' => $user->id]);
                $this->command->info("Connected user {$user->name} with siswa {$siswaWithoutUser[$index]->nama}");
            }
        }

        $this->command->info('Siswa-User connection completed!');
    }
} 

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;

class ConnectSiswaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users with role siswa that don't have connected siswa
        $users = User::where('role', 'siswa')
            ->whereNotIn('id', Siswa::whereNotNull('user_id')->pluck('user_id'))
            ->get();

        // Get siswa without user_id
        $siswaWithoutUser = Siswa::whereNull('user_id')->get();

        // Connect them
        foreach ($users as $index => $user) {
            if (isset($siswaWithoutUser[$index])) {
                $siswaWithoutUser[$index]->update(['user_id' => $user->id]);
                $this->command->info("Connected user {$user->name} with siswa {$siswaWithoutUser[$index]->nama}");
            }
        }

        $this->command->info('Siswa-User connection completed!');
    }
} 
 