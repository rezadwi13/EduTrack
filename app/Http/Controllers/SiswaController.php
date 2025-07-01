<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Ekstrakurikuler;
use App\Models\MenuPermission;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check menu permission
        $menuPermission = MenuPermission::where('menu_route', 'siswa.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = Siswa::with('ekstrakurikulers');
        
        if (auth()->user()->role === 'guru') {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            if (!empty($kelasYangDiajar)) {
                $query->whereIn('kelas', $kelasYangDiajar);
            }
        } elseif (auth()->user()->role === 'siswa') {
            $userId = auth()->id();
            $query->where('user_id', $userId);
        }
        
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nis', 'LIKE', "%{$search}%")
                  ->orWhere('kelas', 'LIKE', "%{$search}%");
            });
        }
        
        $siswas = $query->get();
        
        // Data untuk filter
        $kelasList = [];
        if (auth()->user()->role === 'admin') {
            $kelasList = Siswa::distinct()->pluck('kelas')->sort()->toArray();
        } elseif (auth()->user()->role === 'guru') {
            $kelasList = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->sort()
                ->toArray();
        }
        
        $jenisKelaminList = ['Laki-laki', 'Perempuan'];
        
        return view('siswa.index', compact('siswas', 'menuPermission', 'kelasList', 'jenisKelaminList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'siswa.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki izin untuk menambah siswa.');
        }

        $kelasList = ['X', 'XI', 'XII'];
        $jenisKelaminList = ['Laki-laki', 'Perempuan'];
        $users = \App\Models\User::where('role', 'siswa')->whereDoesntHave('siswa')->get();
        
        return view('siswa.create', compact('kelasList', 'jenisKelaminList', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'siswa.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki izin untuk menambah siswa.');
        }

        $request->validate([
            'nis' => 'required|string|max:50|unique:siswas,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Buat user baru
        $user = \App\Models\User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // Buat siswa dan hubungkan ke user
        Siswa::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'user_id' => $user->id,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan. Akun user juga telah dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'siswa.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki izin untuk melihat detail siswa.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            if (!in_array($siswa->kelas, $kelasYangDiajar)) {
                return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki akses ke data siswa ini.');
            }
        } elseif (auth()->user()->role === 'siswa') {
            if ($siswa->user_id !== auth()->id()) {
                return redirect()->route('siswa.index')->with('error', 'Anda hanya bisa melihat data pribadi.');
            }
        }

        $siswa->load(['user', 'ekstrakurikulers', 'nilai.mataPelajaran']);
        
        return view('siswa.show', compact('siswa', 'menuPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'siswa.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki izin untuk mengedit siswa.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            if (!in_array($siswa->kelas, $kelasYangDiajar)) {
                return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki akses ke data siswa ini.');
            }
        } elseif (auth()->user()->role === 'siswa') {
            if ($siswa->user_id !== auth()->id()) {
                return redirect()->route('siswa.index')->with('error', 'Anda hanya bisa mengedit data pribadi.');
            }
        }

        $kelasList = ['X', 'XI', 'XII'];
        $jenisKelaminList = ['Laki-laki', 'Perempuan'];
        $users = \App\Models\User::where('role', 'siswa')->where(function($q) use ($siswa) {
            $q->whereDoesntHave('siswa')->orWhere('id', $siswa->user_id);
        })->get();
        
        return view('siswa.edit', compact('siswa', 'kelasList', 'jenisKelaminList', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'siswa.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki izin untuk mengedit siswa.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            if (!in_array($siswa->kelas, $kelasYangDiajar)) {
                return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki akses ke data siswa ini.');
            }
        } elseif (auth()->user()->role === 'siswa') {
            if ($siswa->user_id !== auth()->id()) {
                return redirect()->route('siswa.index')->with('error', 'Anda hanya bisa mengedit data pribadi.');
            }
        }

        $request->validate([
            'nis' => 'required|string|max:50|unique:siswas,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        // Check delete permission
        $menuPermission = MenuPermission::where('menu_route', 'siswa.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_delete) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki izin untuk menghapus siswa.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            if (!in_array($siswa->kelas, $kelasYangDiajar)) {
                return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki akses ke data siswa ini.');
            }
        }

        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }

    /**
     * Show ekstrakurikuler for specific siswa
     */
    public function showEkstrakurikuler(Siswa $siswa)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'siswa.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki izin untuk melihat ekstrakurikuler siswa.');
        }

        $siswa->load('ekstrakurikulers');
        $ekstrakurikulers = \App\Models\Ekstrakurikuler::all();
        
        return view('siswa.ekstrakurikuler', compact('siswa', 'ekstrakurikulers', 'menuPermission'));
    }

    /**
     * Add ekstrakurikuler to siswa
     */
    public function addEkstrakurikuler(Request $request, Siswa $siswa)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'siswa.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki izin untuk menambah ekstrakurikuler.');
        }

        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikulers,id',
        ]);

        $siswa->ekstrakurikulers()->attach($request->ekstrakurikuler_id);

        return redirect()->route('siswa.ekstrakurikuler', $siswa)->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    /**
     * Remove ekstrakurikuler from siswa
     */
    public function removeEkstrakurikuler(Request $request, Siswa $siswa)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'siswa.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki izin untuk menghapus ekstrakurikuler.');
        }

        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikulers,id',
        ]);

        $siswa->ekstrakurikulers()->detach($request->ekstrakurikuler_id);

        return redirect()->route('siswa.ekstrakurikuler', $siswa)->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $query = \App\Models\Siswa::with('user');
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        $siswas = $query->get();
        $data = $siswas->map(function($siswa) {
            return [
                'Nama Lengkap' => $siswa->nama,
                'NIS' => $siswa->nis,
                'Kelas' => $siswa->kelas,
                'Jenis Kelamin' => $siswa->jenis_kelamin,
            ];
        })->toArray();
        return \Excel::download(new \App\Exports\ArrayExport($data), 'data-siswa.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = \App\Models\Siswa::with('user');
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        $siswas = $query->get();
        $kelasDipilih = $request->kelas;
        $pdf = PDF::loadView('siswa.pdf', compact('siswas', 'kelasDipilih'));
        return $pdf->download('data-siswa.pdf');
    }

    public function exportPdfSiswa(Request $request)
    {
        $user = auth()->user();
        $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();
        if (!$siswa) {
            abort(404, 'Data siswa tidak ditemukan');
        }
        $siswas = collect([$siswa]);
        $kelasDipilih = $siswa->kelas;
        $pdf = \PDF::loadView('siswa.pdf', compact('siswas', 'kelasDipilih'));
        return $pdf->download('data-siswa.pdf');
    }
}
