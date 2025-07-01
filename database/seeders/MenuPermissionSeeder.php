<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuPermission;

class MenuPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua data sebelum seeding ulang
        MenuPermission::truncate();

        $menus = [
            // Admin menus
            [
                'menu_name' => 'dashboard',
                'menu_route' => 'dashboard',
                'menu_icon' => 'fas fa-tachometer-alt',
                'menu_label' => 'Dashboard',
                'role' => 'admin',
                'is_active' => true,
                'order' => 1
            ],
            [
                'menu_name' => 'users',
                'menu_route' => 'users.index',
                'menu_icon' => 'fas fa-users',
                'menu_label' => 'Users',
                'role' => 'admin',
                'is_active' => true,
                'order' => 2
            ],
            [
                'menu_name' => 'guru',
                'menu_route' => 'guru.index',
                'menu_icon' => 'fas fa-chalkboard-teacher',
                'menu_label' => 'Guru',
                'role' => 'admin',
                'is_active' => true,
                'order' => 3
            ],
            [
                'menu_name' => 'siswa',
                'menu_route' => 'siswa.index',
                'menu_icon' => 'fas fa-user-graduate',
                'menu_label' => 'Siswa',
                'role' => 'admin',
                'is_active' => true,
                'order' => 4
            ],
            [
                'menu_name' => 'nilai',
                'menu_route' => 'nilai.index',
                'menu_icon' => 'fas fa-chart-line',
                'menu_label' => 'Nilai',
                'role' => 'admin',
                'is_active' => true,
                'order' => 5
            ],
            [
                'menu_name' => 'mata_pelajaran',
                'menu_route' => 'mata-pelajaran.index',
                'menu_icon' => 'fas fa-book',
                'menu_label' => 'Mata Pelajaran',
                'role' => 'admin',
                'is_active' => true,
                'order' => 6
            ],
            [
                'menu_name' => 'jadwal_pelajaran',
                'menu_route' => 'jadwal-pelajaran.index',
                'menu_icon' => 'fas fa-calendar-alt',
                'menu_label' => 'Jadwal Pelajaran',
                'role' => 'admin',
                'is_active' => true,
                'order' => 7
            ],
            [
                'menu_name' => 'ekstrakurikuler',
                'menu_route' => 'ekstrakurikuler.index',
                'menu_icon' => 'fas fa-running',
                'menu_label' => 'Ekstrakurikuler',
                'role' => 'admin',
                'is_active' => true,
                'order' => 8
            ],
            [
                'menu_name' => 'pengumuman',
                'menu_route' => 'pengumuman.index',
                'menu_icon' => 'fas fa-bullhorn',
                'menu_label' => 'Pengumuman',
                'role' => 'admin',
                'is_active' => true,
                'order' => 9
            ],
            [
                'menu_name' => 'galeri',
                'menu_route' => 'galeri.index',
                'menu_icon' => 'fas fa-images',
                'menu_label' => 'Galeri',
                'role' => 'admin',
                'is_active' => true,
                'order' => 10
            ],
            [
                'menu_name' => 'menu_permissions',
                'menu_route' => 'menu-permissions.index',
                'menu_icon' => 'fas fa-cogs',
                'menu_label' => 'Menu Permissions',
                'role' => 'admin',
                'is_active' => true,
                'order' => 11
            ],

            // Guru menus
            [
                'menu_name' => 'dashboard',
                'menu_route' => 'dashboard',
                'menu_icon' => 'fas fa-tachometer-alt',
                'menu_label' => 'Dashboard',
                'role' => 'guru',
                'is_active' => true,
                'order' => 1
            ],
            [
                'menu_name' => 'nilai',
                'menu_route' => 'nilai.index',
                'menu_icon' => 'fas fa-chart-line',
                'menu_label' => 'Nilai',
                'role' => 'guru',
                'is_active' => true,
                'order' => 2
            ],
            [
                'menu_name' => 'mata_pelajaran',
                'menu_route' => 'mata-pelajaran.index',
                'menu_icon' => 'fas fa-book',
                'menu_label' => 'Mata Pelajaran',
                'role' => 'guru',
                'is_active' => true,
                'order' => 3
            ],
            [
                'menu_name' => 'jadwal_pelajaran',
                'menu_route' => 'jadwal-pelajaran.index',
                'menu_icon' => 'fas fa-calendar-alt',
                'menu_label' => 'Jadwal Pelajaran',
                'role' => 'guru',
                'is_active' => true,
                'order' => 4
            ],
            [
                'menu_name' => 'ekstrakurikuler',
                'menu_route' => 'ekstrakurikuler.index',
                'menu_icon' => 'fas fa-running',
                'menu_label' => 'Ekstrakurikuler',
                'role' => 'guru',
                'is_active' => true,
                'order' => 5
            ],
            [
                'menu_name' => 'pengumuman',
                'menu_route' => 'pengumuman.index',
                'menu_icon' => 'fas fa-bullhorn',
                'menu_label' => 'Pengumuman',
                'role' => 'guru',
                'is_active' => true,
                'order' => 6
            ],

            // Siswa menus
            [
                'menu_name' => 'dashboard',
                'menu_route' => 'dashboard',
                'menu_icon' => 'fas fa-tachometer-alt',
                'menu_label' => 'Dashboard',
                'role' => 'siswa',
                'is_active' => true,
                'order' => 1
            ],
            [
                'menu_name' => 'nilai_siswa',
                'menu_route' => 'nilai.siswa',
                'menu_icon' => 'fas fa-chart-line',
                'menu_label' => 'Nilai',
                'role' => 'siswa',
                'is_active' => true,
                'order' => 2
            ],
            [
                'menu_name' => 'jadwal_siswa',
                'menu_route' => 'jadwal-pelajaran.siswa',
                'menu_icon' => 'fas fa-calendar-alt',
                'menu_label' => 'Jadwal Pelajaran',
                'role' => 'siswa',
                'is_active' => true,
                'order' => 3
            ],
            [
                'menu_name' => 'ekstrakurikuler_siswa',
                'menu_route' => 'ekstrakurikuler.siswa',
                'menu_icon' => 'fas fa-running',
                'menu_label' => 'Ekstrakurikuler',
                'role' => 'siswa',
                'is_active' => true,
                'order' => 4
            ],
            [
                'menu_name' => 'pengumuman_siswa',
                'menu_route' => 'pengumuman_siswa',
                'menu_icon' => 'fas fa-bullhorn',
                'menu_label' => 'Pengumuman',
                'role' => 'siswa',
                'is_active' => true,
                'order' => 5
            ],
            [
                'menu_name' => 'galeri_siswa',
                'menu_route' => 'galeri_siswa',
                'menu_icon' => 'fas fa-images',
                'menu_label' => 'Galeri',
                'role' => 'siswa',
                'is_active' => true,
                'order' => 6
            ],
        ];

        foreach ($menus as $menu) {
            $can_create = true;
            $can_read = true;
            $can_update = true;
            $can_delete = true;
            if ($menu['role'] === 'guru') {
                $can_delete = false;
            } elseif ($menu['role'] === 'siswa') {
                $can_create = false;
                $can_update = false;
                $can_delete = false;
            }
            MenuPermission::create([
                'menu_name' => $menu['menu_name'],
                'menu_route' => $menu['menu_route'],
                'menu_icon' => $menu['menu_icon'],
                'menu_label' => $menu['menu_label'],
                'role' => $menu['role'],
                'is_active' => $menu['is_active'],
                'order' => $menu['order'],
                'can_create' => $can_create,
                'can_read' => $can_read,
                'can_update' => $can_update,
                'can_delete' => $can_delete,
            ]);
        }
    }
}
