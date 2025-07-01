<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use App\Models\Siswa;
use App\Models\MenuPermission;

class EkstrakurikulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check menu permission
        $menuPermission = MenuPermission::where('menu_route', 'ekstrakurikuler.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = Ekstrakurikuler::with(['siswa']);
        
        // Filter berdasarkan jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Pencarian berdasarkan nama, deskripsi, atau pembina
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                  ->orWhere('pembina', 'LIKE', "%{$search}%");
            });
        }
        
        $ekstrakurikulers = $query->get();
        
        // Data untuk filter
        $jenisList = ['Olahraga', 'Seni', 'Akademik', 'Keagamaan', 'Lainnya'];
        $statusList = ['Aktif', 'Tidak Aktif'];
        
        return view('ekstrakurikuler.index', compact('ekstrakurikulers', 'menuPermission', 'jenisList', 'statusList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'ekstrakurikuler.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Anda tidak memiliki izin untuk menambah ekstrakurikuler.');
        }

        $jenisList = ['Olahraga', 'Seni', 'Akademik', 'Keagamaan', 'Lainnya'];
        $statusList = ['Aktif', 'Tidak Aktif'];
        
        return view('ekstrakurikuler.create', compact('jenisList', 'statusList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'ekstrakurikuler.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Anda tidak memiliki izin untuk menambah ekstrakurikuler.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|string|max:50',
            'pembina' => 'required|string|max:255',
            'hari' => 'required|string|max:20',
            'jam' => 'required|string|max:20',
            'tempat' => 'required|string|max:255',
            'kuota' => 'nullable|integer|min:1',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Ekstrakurikuler::create($request->all());

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ekstrakurikuler $ekstrakurikuler)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'ekstrakurikuler.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Anda tidak memiliki izin untuk melihat detail ekstrakurikuler.');
        }

        $ekstrakurikuler->load(['siswa']);
        
        return view('ekstrakurikuler.show', compact('ekstrakurikuler', 'menuPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'ekstrakurikuler.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Anda tidak memiliki izin untuk mengedit ekstrakurikuler.');
        }

        $jenisList = ['Olahraga', 'Seni', 'Akademik', 'Keagamaan', 'Lainnya'];
        $statusList = ['Aktif', 'Tidak Aktif'];
        
        return view('ekstrakurikuler.edit', compact('ekstrakurikuler', 'jenisList', 'statusList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'ekstrakurikuler.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Anda tidak memiliki izin untuk mengedit ekstrakurikuler.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|string|max:50',
            'pembina' => 'required|string|max:255',
            'hari' => 'required|string|max:20',
            'jam' => 'required|string|max:20',
            'tempat' => 'required|string|max:255',
            'kuota' => 'nullable|integer|min:1',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $ekstrakurikuler->update($request->all());

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        // Check delete permission
        $menuPermission = MenuPermission::where('menu_route', 'ekstrakurikuler.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_delete) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Anda tidak memiliki izin untuk menghapus ekstrakurikuler.');
        }

        $ekstrakurikuler->delete();

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }

    /**
     * Show siswa for specific ekstrakurikuler
     */
    public function showSiswa(Ekstrakurikuler $ekstrakurikuler)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'ekstrakurikuler.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Anda tidak memiliki izin untuk melihat siswa ekstrakurikuler.');
        }

        $ekstrakurikuler->load(['siswa']);
        
        return view('ekstrakurikuler.siswa', compact('ekstrakurikuler', 'menuPermission'));
    }

    /**
     * Show ekstrakurikuler for siswa view
     */
    public function indexSiswa(Request $request)
    {
        // Check menu permission
        $menuPermission = \App\Models\MenuPermission::where('menu_route', 'ekstrakurikuler_siswa')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Role-based access control
        if (auth()->user()->role !== 'siswa') {
            return redirect()->route('ekstrakurikuler.index');
        }

        $siswa = Siswa::where('user_id', auth()->id())->first();
        
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $query = Ekstrakurikuler::with(['siswa']);
        
        // Filter berdasarkan jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Pencarian berdasarkan nama, deskripsi, atau pembina
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                  ->orWhere('pembina', 'LIKE', "%{$search}%");
            });
        }
        
        $ekstrakurikulers = $query->get();
        
        // Data untuk filter
        $jenisList = ['Olahraga', 'Seni', 'Akademik', 'Keagamaan', 'Lainnya'];
        $statusList = ['Aktif', 'Tidak Aktif'];
        // Tambahkan array id ekstrakurikuler yang diikuti siswa
        $ekstraDiikuti = $siswa->ekstrakurikulers->pluck('id')->toArray();
        return view('ekstrakurikuler.index-siswa', compact('ekstrakurikulers', 'siswa', 'menuPermission', 'jenisList', 'statusList', 'ekstraDiikuti'));
    }

    /**
     * Add siswa to ekstrakurikuler
     */
    public function addSiswa(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'ekstrakurikuler.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Anda tidak memiliki izin untuk menambah siswa ke ekstrakurikuler.');
        }

        // Role-based access control
        if (auth()->user()->role !== 'siswa') {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Hanya siswa yang dapat mendaftar ekstrakurikuler.');
        }

        $siswa = Siswa::where('user_id', auth()->id())->first();
        
        if (!$siswa) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Cek apakah sudah terdaftar
        if ($ekstrakurikuler->siswa->contains($siswa->id)) {
            return redirect()->route('ekstrakurikuler.index-siswa')->with('error', 'Anda sudah terdaftar di ekstrakurikuler ini.');
        }

        // Cek kuota
        if ($ekstrakurikuler->kuota && $ekstrakurikuler->siswa->count() >= $ekstrakurikuler->kuota) {
            return redirect()->route('ekstrakurikuler.index-siswa')->with('error', 'Kuota ekstrakurikuler sudah penuh.');
        }

        $ekstrakurikuler->siswa()->attach($siswa->id);

        return redirect()->route('ekstrakurikuler.index-siswa')->with('success', 'Berhasil mendaftar ekstrakurikuler.');
    }

    /**
     * Remove siswa from ekstrakurikuler
     */
    public function removeSiswa(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'ekstrakurikuler.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Anda tidak memiliki izin untuk menghapus siswa dari ekstrakurikuler.');
        }

        // Role-based access control
        if (auth()->user()->role !== 'siswa') {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Hanya siswa yang dapat keluar dari ekstrakurikuler.');
        }

        $siswa = Siswa::where('user_id', auth()->id())->first();
        
        if (!$siswa) {
            return redirect()->route('ekstrakurikuler.index')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Cek apakah terdaftar
        if (!$ekstrakurikuler->siswa->contains($siswa->id)) {
            return redirect()->route('ekstrakurikuler.index-siswa')->with('error', 'Anda tidak terdaftar di ekstrakurikuler ini.');
        }

        $ekstrakurikuler->siswa()->detach($siswa->id);

        return redirect()->route('ekstrakurikuler.index-siswa')->with('success', 'Berhasil keluar dari ekstrakurikuler.');
    }

    public function daftarSiswa($ekstrakurikulerId)
    {
        $siswa = \App\Models\Siswa::where('user_id', auth()->id())->first();
        if (!$siswa) {
            return redirect()->route('ekstrakurikuler_siswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        $ekstrakurikuler = \App\Models\Ekstrakurikuler::findOrFail($ekstrakurikulerId);

        // Cek apakah sudah terdaftar
        if ($ekstrakurikuler->siswa->contains($siswa->id)) {
            return redirect()->route('ekstrakurikuler_siswa')->with('error', 'Anda sudah terdaftar di ekstrakurikuler ini.');
        }

        // Cek kuota
        if ($ekstrakurikuler->kuota && $ekstrakurikuler->siswa->count() >= $ekstrakurikuler->kuota) {
            return redirect()->route('ekstrakurikuler_siswa')->with('error', 'Kuota ekstrakurikuler sudah penuh.');
        }

        $ekstrakurikuler->siswa()->attach($siswa->id);

        return redirect()->route('ekstrakurikuler_siswa')->with('success', 'Berhasil mendaftar ekstrakurikuler.');
    }
}
