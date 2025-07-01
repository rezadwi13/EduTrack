<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\User;
use App\Models\MenuPermission;
use Illuminate\Support\Facades\Hash;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check menu permission
        $menuPermission = MenuPermission::where('menu_route', 'guru.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = Guru::with('user');
        
        // Filter berdasarkan mata pelajaran
        if ($request->filled('mata_pelajaran')) {
            $query->mataPelajaran($request->mata_pelajaran);
        }
        
        // Filter berdasarkan jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->jenisKelamin($request->jenis_kelamin);
        }
        
        // Pencarian berdasarkan NIP, nama, email, atau mata pelajaran
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nip', 'LIKE', "%{$search}%")
                  ->orWhere('nama', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'LIKE', "%{$search}%");
            });
        }
        
        $gurus = $query->get();
        
        // Data untuk filter
        $mataPelajaranList = Guru::distinct()->pluck('mata_pelajaran')->filter()->sort()->toArray();
        $jenisKelaminList = ['Laki-laki', 'Perempuan'];
        
        return view('guru.index', compact('gurus', 'menuPermission', 'mataPelajaranList', 'jenisKelaminList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'guru.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('guru.index')->with('error', 'Anda tidak memiliki izin untuk menambah guru.');
        }

        $jenisKelaminList = ['Laki-laki', 'Perempuan'];
        $mataPelajaranList = MataPelajaran::orderBy('nama')->pluck('nama')->toArray();
        
        return view('guru.create', compact('jenisKelaminList', 'mataPelajaranList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'guru.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('guru.index')->with('error', 'Anda tidak memiliki izin untuk menambah guru.');
        }

        $request->validate([
            'nip' => 'required|string|max:50|unique:gurus,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:gurus,email',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'mata_pelajaran' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Buat user account untuk guru
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        // Buat data guru
        Guru::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'mata_pelajaran' => $request->mata_pelajaran,
            'user_id' => $user->id,
        ]);

        return redirect()->route('guru.index')
            ->with('success', 'Guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'guru.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('guru.index')->with('error', 'Anda tidak memiliki izin untuk melihat detail guru.');
        }

        $guru->load(['user', 'jadwalPelajaran.mataPelajaran']);
        
        return view('guru.show', compact('guru', 'menuPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'guru.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('guru.index')->with('error', 'Anda tidak memiliki izin untuk mengedit guru.');
        }

        $jenisKelaminList = ['Laki-laki', 'Perempuan'];
        $mataPelajaranList = MataPelajaran::orderBy('nama')->pluck('nama')->toArray();
        
        return view('guru.edit', compact('guru', 'jenisKelaminList', 'mataPelajaranList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'guru.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('guru.index')->with('error', 'Anda tidak memiliki izin untuk mengedit guru.');
        }

        $request->validate([
            'nip' => 'required|string|max:50|unique:gurus,nip,' . $guru->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:gurus,email,' . $guru->id,
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'mata_pelajaran' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update data guru
        $guru->update($request->except('password'));

        // Update user account jika ada
        if ($guru->user) {
            $guru->user->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);
            
            if ($request->filled('password')) {
                $guru->user->update([
                    'password' => Hash::make($request->password)
                ]);
            }
        }

        return redirect()->route('guru.index')
            ->with('success', 'Guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        // Check delete permission
        $menuPermission = MenuPermission::where('menu_route', 'guru.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_delete) {
            return redirect()->route('guru.index')->with('error', 'Anda tidak memiliki izin untuk menghapus guru.');
        }

        // Hapus user account jika ada
        if ($guru->user) {
            $guru->user->delete();
        }
        
        // Hapus data guru
        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Guru berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $query = Guru::query();
        if ($request->filled('mata_pelajaran')) {
            $query->where('mata_pelajaran', $request->mata_pelajaran);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        $gurus = $query->get();
        $data = $gurus->map(function($guru) {
            return [
                'NIP' => $guru->nip,
                'Nama' => $guru->nama,
                'Email' => $guru->email,
                'Mata Pelajaran' => $guru->mata_pelajaran,
                'Jenis Kelamin' => $guru->jenis_kelamin,
                'No HP' => $guru->no_hp,
            ];
        })->toArray();
        $headings = ['NIP', 'Nama', 'Email', 'Mata Pelajaran', 'Jenis Kelamin', 'No HP'];
        return Excel::download(new \App\Exports\ArrayExport($data, $headings), 'data-guru.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Guru::query();
        if ($request->filled('mata_pelajaran')) {
            $query->where('mata_pelajaran', $request->mata_pelajaran);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        $gurus = $query->get();
        $pdf = PDF::loadView('guru.pdf', compact('gurus'));
        return $pdf->download('data-guru.pdf');
    }
}
