<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\JadwalPelajaran;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        // Jika ingin konten dashboard berbeda, bisa gunakan $role di blade
        return view('dashboard', compact('role'));
    }
} 