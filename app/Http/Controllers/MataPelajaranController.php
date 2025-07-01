<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\MenuPermission;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check menu permission
        $menuPermission = MenuPermission::where('menu_route', 'mata-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = MataPelajaran::with(['jadwalPelajaran.guru']);
        
        // Role-based filtering
        if (auth()->user()->role === 'guru') {
            // Guru hanya bisa melihat mata pelajaran yang dia ajar
            $query->whereHas('jadwalPelajaran', function($q) {
                $q->where('guru_id', auth()->id());
            });
        }
        
        // Filter berdasarkan semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        
        // Pencarian berdasarkan nama, kode, atau deskripsi
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('kode', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }
        
        $mataPelajarans = $query->get();
        
        // Data untuk filter
        $semesterList = ['1', '2'];
        
        return view('mata_pelajaran.index', compact('mataPelajarans', 'menuPermission', 'semesterList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'mata-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk menambah mata pelajaran.');
        }

        $semesterList = ['1', '2'];
        
        return view('mata_pelajaran.create', compact('semesterList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'mata-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk menambah mata pelajaran.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mata_pelajarans,kode',
            'semester' => 'required|in:1,2',
            'deskripsi' => 'nullable|string',
            'sks' => 'nullable|integer|min:1|max:10',
        ]);

        MataPelajaran::create($request->all());

        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MataPelajaran $mataPelajaran)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'mata-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk melihat detail mata pelajaran.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            $isTeaching = $mataPelajaran->jadwalPelajaran()
                ->where('guru_id', auth()->id())
                ->exists();
            
            if (!$isTeaching) {
                return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak mengajar mata pelajaran ini.');
            }
        }

        $mataPelajaran->load(['jadwalPelajaran.guru', 'nilai.siswa']);
        
        return view('mata_pelajaran.show', compact('mataPelajaran', 'menuPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataPelajaran $mataPelajaran)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'mata-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk mengedit mata pelajaran.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            $isTeaching = $mataPelajaran->jadwalPelajaran()
                ->where('guru_id', auth()->id())
                ->exists();
            
            if (!$isTeaching) {
                return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak mengajar mata pelajaran ini.');
            }
        }

        $semesterList = ['1', '2'];
        
        return view('mata_pelajaran.edit', compact('mataPelajaran', 'semesterList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'mata-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk mengedit mata pelajaran.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            $isTeaching = $mataPelajaran->jadwalPelajaran()
                ->where('guru_id', auth()->id())
                ->exists();
            
            if (!$isTeaching) {
                return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak mengajar mata pelajaran ini.');
            }
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mata_pelajarans,kode,' . $mataPelajaran->id,
            'semester' => 'required|in:1,2',
            'deskripsi' => 'nullable|string',
            'sks' => 'nullable|integer|min:1|max:10',
        ]);

        $mataPelajaran->update($request->all());

        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataPelajaran $mataPelajaran)
    {
        // Check delete permission
        $menuPermission = MenuPermission::where('menu_route', 'mata-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_delete) {
            return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk menghapus mata pelajaran.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            $isTeaching = $mataPelajaran->jadwalPelajaran()
                ->where('guru_id', auth()->id())
                ->exists();
            
            if (!$isTeaching) {
                return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak mengajar mata pelajaran ini.');
            }
        }

        $mataPelajaran->delete();

        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    /**
     * Show siswa for specific mata pelajaran
     */
    public function showSiswa(MataPelajaran $mataPelajaran)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'mata-pelajaran.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('mata-pelajaran.index')->with('error', 'Anda tidak memiliki izin untuk melihat siswa mata pelajaran.');
        }

        // Pastikan hanya guru yang mengajar mata pelajaran ini yang bisa akses
        if (auth()->user()->role === 'guru') {
            $isTeaching = $mataPelajaran->jadwalPelajaran()
                ->where('guru_id', auth()->id())
                ->exists();
            
            if (!$isTeaching) {
                abort(403, 'Anda tidak mengajar mata pelajaran ini.');
            }
        }

        // Ambil kelas yang diajar untuk mata pelajaran ini
        $kelasList = $mataPelajaran->jadwalPelajaran()
            ->when(auth()->user()->role === 'guru', function($query) {
                $query->where('guru_id', auth()->id());
            })
            ->distinct()
            ->pluck('kelas')
            ->toArray();

        // Ambil siswa berdasarkan kelas
        $siswaList = \App\Models\Siswa::whereIn('kelas', $kelasList)
            ->with('ekstrakurikulers')
            ->get();

        return view('mata_pelajaran.siswa', compact('mataPelajaran', 'siswaList', 'kelasList'));
    }
}
