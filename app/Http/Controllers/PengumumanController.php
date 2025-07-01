<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use App\Models\MenuPermission;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menuPermission = \App\Models\MenuPermission::where('menu_route', 'pengumuman.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();

        if (!$menuPermission || !$menuPermission->can_read) {
            abort(403, 'Unauthorized');
        }

        $query = Pengumuman::with('user');
        
        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Pencarian berdasarkan judul, isi, atau nama pembuat
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('isi', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        $pengumumen = $query->latest()->get();
        
        // Data untuk filter
        $kategoriList = ['Umum', 'Akademik', 'Kegiatan', 'Beasiswa', 'Lainnya'];
        $statusList = ['Aktif', 'Tidak Aktif'];

        return view('pengumuman.index', compact('pengumumen', 'menuPermission', 'kategoriList', 'statusList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'pengumuman.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('pengumuman.index')->with('error', 'Anda tidak memiliki izin untuk menambah pengumuman.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('pengumuman.index')->with('error', 'Siswa tidak dapat membuat pengumuman.');
        }

        $kategoriList = ['Umum', 'Akademik', 'Kegiatan', 'Beasiswa', 'Lainnya'];
        $statusList = ['Aktif', 'Tidak Aktif'];
        
        return view('pengumuman.create', compact('kategoriList', 'statusList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'pengumuman.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('pengumuman.index')->with('error', 'Anda tidak memiliki izin untuk menambah pengumuman.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('pengumuman.index')->with('error', 'Siswa tidak dapat membuat pengumuman.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|string|max:50',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'pengumuman.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('pengumuman.index')->with('error', 'Anda tidak memiliki izin untuk melihat detail pengumuman.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            if ($pengumuman->user_id !== auth()->id()) {
                return redirect()->route('pengumuman.index')->with('error', 'Anda hanya bisa melihat pengumuman yang Anda buat.');
            }
        }

        $pengumuman->load('user');
        
        return view('pengumuman.show', compact('pengumuman', 'menuPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'pengumuman.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('pengumuman.index')->with('error', 'Anda tidak memiliki izin untuk mengedit pengumuman.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('pengumuman.index')->with('error', 'Siswa tidak dapat mengedit pengumuman.');
        }

        if (auth()->user()->role === 'guru') {
            if ($pengumuman->user_id !== auth()->id()) {
                return redirect()->route('pengumuman.index')->with('error', 'Anda hanya bisa mengedit pengumuman yang Anda buat.');
            }
        }

        $kategoriList = ['Umum', 'Akademik', 'Kegiatan', 'Beasiswa', 'Lainnya'];
        $statusList = ['Aktif', 'Tidak Aktif'];
        
        return view('pengumuman.edit', compact('pengumuman', 'kategoriList', 'statusList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'pengumuman.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('pengumuman.index')->with('error', 'Anda tidak memiliki izin untuk mengedit pengumuman.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('pengumuman.index')->with('error', 'Siswa tidak dapat mengedit pengumuman.');
        }

        if (auth()->user()->role === 'guru') {
            if ($pengumuman->user_id !== auth()->id()) {
                return redirect()->route('pengumuman.index')->with('error', 'Anda hanya bisa mengedit pengumuman yang Anda buat.');
            }
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|string|max:50',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $pengumuman->update($request->all());

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        // Check delete permission
        $menuPermission = MenuPermission::where('menu_route', 'pengumuman.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_delete) {
            return redirect()->route('pengumuman.index')->with('error', 'Anda tidak memiliki izin untuk menghapus pengumuman.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('pengumuman.index')->with('error', 'Siswa tidak dapat menghapus pengumuman.');
        }

        if (auth()->user()->role === 'guru') {
            if ($pengumuman->user_id !== auth()->id()) {
                return redirect()->route('pengumuman.index')->with('error', 'Anda hanya bisa menghapus pengumuman yang Anda buat.');
            }
        }

        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    /**
     * Show pengumuman for siswa view
     */
    public function indexSiswa(Request $request)
    {
        // Check menu permission
        $menuPermission = \App\Models\MenuPermission::where('menu_route', 'pengumuman_siswa')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Role-based access control
        if (auth()->user()->role !== 'siswa') {
            return redirect()->route('pengumuman.index');
        }

        $query = Pengumuman::with('user')->where('status', 'Aktif');
        
        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        // Pencarian berdasarkan judul atau isi
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('isi', 'LIKE', "%{$search}%");
            });
        }
        
        $pengumumen = $query->latest()->get();
        
        // Data untuk filter
        $kategoriList = ['Umum', 'Akademik', 'Kegiatan', 'Beasiswa', 'Lainnya'];
        
        return view('pengumuman.index-siswa', compact('pengumumen', 'menuPermission', 'kategoriList'));
    }
}
