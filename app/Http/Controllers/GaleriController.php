<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\MenuPermission;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check menu permission
        $menuPermission = MenuPermission::where('menu_route', 'galeri.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = Galeri::with('user');
        
        // Role-based filtering
        if (auth()->user()->role === 'guru') {
            // Guru hanya bisa melihat galeri yang dia buat
            $query->where('user_id', auth()->id());
        }
        
        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        // Pencarian berdasarkan judul, deskripsi, atau nama pembuat
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        $galeris = $query->latest()->get();
        
        // Data untuk filter
        $kategoriList = ['Kegiatan', 'Acara', 'Lomba', 'Kunjungan', 'Lainnya'];
        
        return view('galeri.index', compact('galeris', 'menuPermission', 'kategoriList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'galeri.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('galeri.index')->with('error', 'Anda tidak memiliki izin untuk menambah galeri.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('galeri.index')->with('error', 'Siswa tidak dapat menambah galeri.');
        }

        $kategoriList = ['Kegiatan', 'Acara', 'Lomba', 'Kunjungan', 'Lainnya'];
        
        return view('galeri.create', compact('kategoriList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'galeri.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('galeri.index')->with('error', 'Anda tidak memiliki izin untuk menambah galeri.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('galeri.index')->with('error', 'Siswa tidak dapat menambah galeri.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:50',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gambarPath = $request->file('gambar')->store('galeri', 'public');

        Galeri::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'gambar' => $gambarPath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'galeri.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('galeri.index')->with('error', 'Anda tidak memiliki izin untuk melihat detail galeri.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            if ($galeri->user_id !== auth()->id()) {
                return redirect()->route('galeri.index')->with('error', 'Anda hanya bisa melihat galeri yang Anda buat.');
            }
        }

        $galeri->load('user');
        
        return view('galeri.show', compact('galeri', 'menuPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'galeri.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('galeri.index')->with('error', 'Anda tidak memiliki izin untuk mengedit galeri.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('galeri.index')->with('error', 'Siswa tidak dapat mengedit galeri.');
        }

        if (auth()->user()->role === 'guru') {
            if ($galeri->user_id !== auth()->id()) {
                return redirect()->route('galeri.index')->with('error', 'Anda hanya bisa mengedit galeri yang Anda buat.');
            }
        }

        $kategoriList = ['Kegiatan', 'Acara', 'Lomba', 'Kunjungan', 'Lainnya'];
        
        return view('galeri.edit', compact('galeri', 'kategoriList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'galeri.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('galeri.index')->with('error', 'Anda tidak memiliki izin untuk mengedit galeri.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('galeri.index')->with('error', 'Siswa tidak dapat mengedit galeri.');
        }

        if (auth()->user()->role === 'guru') {
            if ($galeri->user_id !== auth()->id()) {
                return redirect()->route('galeri.index')->with('error', 'Anda hanya bisa mengedit galeri yang Anda buat.');
            }
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'kategori']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($galeri->gambar) {
                Storage::disk('public')->delete($galeri->gambar);
            }
            
            // Upload gambar baru
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        // Check delete permission
        $menuPermission = MenuPermission::where('menu_route', 'galeri.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_delete) {
            return redirect()->route('galeri.index')->with('error', 'Anda tidak memiliki izin untuk menghapus galeri.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('galeri.index')->with('error', 'Siswa tidak dapat menghapus galeri.');
        }

        if (auth()->user()->role === 'guru') {
            if ($galeri->user_id !== auth()->id()) {
                return redirect()->route('galeri.index')->with('error', 'Anda hanya bisa menghapus galeri yang Anda buat.');
            }
        }

        // Hapus gambar dari storage
        if ($galeri->gambar) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil dihapus.');
    }

    /**
     * Show galeri for siswa view
     */
    public function indexSiswa(Request $request)
    {
        // Check menu permission
        $menuPermission = MenuPermission::where('menu_route', 'galeri_siswa')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Role-based access control
        if (auth()->user()->role !== 'siswa') {
            return redirect()->route('galeri.index');
        }

        $query = Galeri::with('user');
        
        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        // Pencarian berdasarkan judul atau deskripsi
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }
        
        $galeris = $query->latest()->get();
        
        // Data untuk filter
        $kategoriList = ['Kegiatan', 'Acara', 'Lomba', 'Kunjungan', 'Lainnya'];
        
        return view('galeri.siswa', compact('galeris', 'menuPermission', 'kategoriList'));
    }
}
