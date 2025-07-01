<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\MenuPermission;
use PDF;

class JadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check menu permission
        $menuPermission = MenuPermission::where('menu_route', 'jadwal-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = JadwalPelajaran::with(['mataPelajaran', 'guru']);
        
        // Jika user adalah guru, filter berdasarkan jadwal yang dia ajar
        if (auth()->user()->role === 'guru') {
            $query->where('guru_id', auth()->id());
        }
        
        // Ambil daftar kelas unik untuk filter
        $kelasList = JadwalPelajaran::when(auth()->user()->role === 'guru', function($query) {
                $query->where('guru_id', auth()->id());
            })
            ->distinct()
            ->pluck('kelas')
            ->filter()
            ->sort()
            ->values();
        
        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        
        // Filter berdasarkan hari
        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }
        
        // Pencarian berdasarkan kelas, hari, mata pelajaran, atau guru
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kelas', 'LIKE', "%{$search}%")
                  ->orWhere('hari', 'LIKE', "%{$search}%")
                  ->orWhereHas('mataPelajaran', function($q) use ($search) {
                      $q->where('nama', 'LIKE', "%{$search}%")
                        ->orWhere('kode', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('guru', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        $jadwals = $query->get();
        
        // Data untuk filter
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        return view('jadwal_pelajaran.index', compact('jadwals', 'menuPermission', 'kelasList', 'hariList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'jadwal-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk menambah jadwal pelajaran.');
        }

        $mataPelajarans = MataPelajaran::all();
        $gurus = User::where('role', 'guru')->get();
        $kelasList = ['X', 'XI', 'XII'];
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        return view('jadwal_pelajaran.create', compact('mataPelajarans', 'gurus', 'kelasList', 'hariList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'jadwal-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk menambah jadwal pelajaran.');
        }

        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id' => 'required|exists:users,id',
            'kelas' => 'required|string|max:10',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:50',
        ]);

        // Cek konflik jadwal
        $konflik = JadwalPelajaran::where('kelas', $request->kelas)
            ->where('hari', $request->hari)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->exists();

        if ($konflik) {
            return back()->withErrors(['jam_mulai' => 'Jadwal konflik dengan jadwal yang sudah ada.'])->withInput();
        }

        JadwalPelajaran::create($request->all());

        return redirect()->route('jadwal-pelajaran.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalPelajaran $jadwalPelajaran)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'jadwal-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk melihat detail jadwal pelajaran.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            if ($jadwalPelajaran->guru_id !== auth()->id()) {
                return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak mengajar jadwal ini.');
            }
        }

        $jadwalPelajaran->load(['mataPelajaran', 'guru']);
        
        return view('jadwal_pelajaran.show', compact('jadwalPelajaran', 'menuPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'jadwal-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk mengedit jadwal pelajaran.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            if ($jadwalPelajaran->guru_id !== auth()->id()) {
                return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak mengajar jadwal ini.');
            }
        }

        $mataPelajarans = MataPelajaran::all();
        $gurus = User::where('role', 'guru')->get();
        $kelasList = ['X', 'XI', 'XII'];
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        return view('jadwal_pelajaran.edit', compact('jadwalPelajaran', 'mataPelajarans', 'gurus', 'kelasList', 'hariList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'jadwal-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk mengedit jadwal pelajaran.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            if ($jadwalPelajaran->guru_id !== auth()->id()) {
                return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak mengajar jadwal ini.');
            }
        }

        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id' => 'required|exists:users,id',
            'kelas' => 'required|string|max:10',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:50',
        ]);

        // Cek konflik jadwal (kecuali jadwal yang sedang diedit)
        $konflik = JadwalPelajaran::where('id', '!=', $jadwalPelajaran->id)
            ->where('kelas', $request->kelas)
            ->where('hari', $request->hari)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->exists();

        if ($konflik) {
            return back()->withErrors(['jam_mulai' => 'Jadwal konflik dengan jadwal yang sudah ada.'])->withInput();
        }

        $jadwalPelajaran->update($request->all());

        return redirect()->route('jadwal-pelajaran.index')->with('success', 'Jadwal pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        // Check delete permission
        $menuPermission = MenuPermission::where('menu_route', 'jadwal-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_delete) {
            return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk menghapus jadwal pelajaran.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            if ($jadwalPelajaran->guru_id !== auth()->id()) {
                return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak mengajar jadwal ini.');
            }
        }

        $jadwalPelajaran->delete();

        return redirect()->route('jadwal-pelajaran.index')->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }

    /**
     * Show siswa for specific jadwal pelajaran
     */
    public function showSiswa(JadwalPelajaran $jadwalPelajaran)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'jadwal-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk melihat siswa jadwal pelajaran.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            if ($jadwalPelajaran->guru_id !== auth()->id()) {
                return redirect()->route('jadwal-pelajaran.index')->with('error', 'Anda tidak mengajar jadwal ini.');
            }
        }

        // Ambil siswa berdasarkan kelas
        $siswaList = \App\Models\Siswa::where('kelas', $jadwalPelajaran->kelas)
            ->with('ekstrakurikulers')
            ->get();

        return view('jadwal_pelajaran.siswa', compact('jadwalPelajaran', 'siswaList'));
    }

    public function siswa()
    {
        $user = auth()->user();
        $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();

        $jadwals = collect();
        $kelas = null;
        if ($siswa) {
            $kelas = $siswa->kelas;
            $jadwals = \App\Models\JadwalPelajaran::with(['mataPelajaran', 'guru'])
                ->where('kelas', $kelas)
                ->get();
        }

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Buat koleksi jadwal per hari untuk kebutuhan tampilan
        $jadwalPerHari = collect();
        foreach ($hariList as $hari) {
            $jadwalPerHari[$hari] = $jadwals->where('hari', $hari);
        }

        // Kirim $siswa ke view, dan handle jika $siswa null
        return view('jadwal_pelajaran.siswa', compact('jadwals', 'kelas', 'hariList', 'siswa', 'jadwalPerHari'));
    }

    public function exportPdf()
    {
        $user = auth()->user();
        $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();
        $jadwals = collect();
        $kelas = null;
        if ($siswa) {
            $kelas = $siswa->kelas;
            $jadwals = \App\Models\JadwalPelajaran::with(['mataPelajaran', 'guru'])
                ->where('kelas', $kelas)
                ->get();
        }
        $pdf = PDF::loadView('jadwal_pelajaran.pdf', compact('jadwals', 'kelas', 'siswa'));
        return $pdf->download('jadwal-pelajaran.pdf');
    }
}
