<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\MenuPermission;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check menu permission
        $menuPermission = MenuPermission::where('menu_route', 'nilai.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = Nilai::with(['siswa', 'mataPelajaran']);
        
        // Role-based filtering
        if (auth()->user()->role === 'guru') {
            // Guru hanya bisa melihat nilai mata pelajaran yang dia ajar
            $mataPelajaranIds = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->pluck('mata_pelajaran_id')
                ->toArray();
            $query->whereIn('mata_pelajaran_id', $mataPelajaranIds);
        } elseif (auth()->user()->role === 'siswa') {
            // Siswa hanya bisa melihat nilai sendiri
            $siswaId = \App\Models\Siswa::where('user_id', auth()->id())->value('id');
            if ($siswaId) {
                $query->where('siswa_id', $siswaId);
            } else {
                $query->where('siswa_id', 0); // No data
            }
        }
        
        // Filter berdasarkan mata pelajaran
        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }
        
        // Filter berdasarkan semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        
        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }
        
        // Pencarian berdasarkan nama siswa, mata pelajaran, atau nilai
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('siswa', function($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('nis', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('mataPelajaran', function($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('kode', 'LIKE', "%{$search}%");
                })
                ->orWhere('nilai', 'LIKE', "%{$search}%");
            });
        }
        
        $nilais = $query->get()->keyBy('siswa_id');
        
        // Data untuk filter
        $mataPelajarans = MataPelajaran::when(auth()->user()->role === 'guru', function($query) {
            $mataPelajaranIds = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->pluck('mata_pelajaran_id')
                ->toArray();
            $query->whereIn('id', $mataPelajaranIds);
        })->get();
        
        $semesterList = ['1', '2'];
        $kelasList = [];
        
        if (auth()->user()->role === 'admin') {
            $kelasList = \App\Models\Siswa::distinct()->pluck('kelas')->sort()->toArray();
            $kelas = $request->kelas ?? null;
            $mapelList = \App\Models\MataPelajaran::all();
            $mapelId = $request->mapel_id ?? null;
            $semester = $request->semester ?? 1;
            $siswas = \App\Models\Siswa::all();
            return view('nilai.index', compact('nilais', 'menuPermission', 'mataPelajarans', 'semesterList', 'kelasList', 'mapelList', 'kelas', 'mapelId', 'semester', 'siswas'));
        } elseif (auth()->user()->role === 'guru') {
            $kelasList = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->sort()
                ->toArray();
            $kelas = $request->kelas ?? ($kelasList[0] ?? null);
            $mapelList = \App\Models\MataPelajaran::whereIn('id', \App\Models\JadwalPelajaran::where('guru_id', auth()->id())->pluck('mata_pelajaran_id'))->get();
            $mapelId = $request->mapel_id ?? ($mapelList[0]->id ?? null);
            $semester = $request->semester ?? 1;
            // Ambil daftar siswa untuk kelas yang dipilih guru
            $siswas = \App\Models\Siswa::when($kelas, function($query) use ($kelas) {
                $query->where('kelas', $kelas);
            })->get();
            return view('nilai.index', compact('nilais', 'menuPermission', 'kelasList', 'mapelList', 'kelas', 'mapelId', 'semester', 'siswas'));
        } else {
            return view('nilai.index', compact('nilais', 'menuPermission', 'mataPelajarans', 'semesterList', 'kelasList'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'nilai.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki izin untuk menambah nilai.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('nilai.index')->with('error', 'Siswa tidak dapat menambah nilai.');
        }

        $siswas = Siswa::when(auth()->user()->role === 'guru', function($query) {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            $query->whereIn('kelas', $kelasYangDiajar);
        })->get();
        
        $mataPelajarans = MataPelajaran::when(auth()->user()->role === 'guru', function($query) {
            $mataPelajaranIds = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->pluck('mata_pelajaran_id')
                ->toArray();
            $query->whereIn('id', $mataPelajaranIds);
        })->get();
        
        $semesterList = ['1', '2'];
        
        // Ambil daftar kelas dari siswa yang tersedia
        $kelas = $siswas->pluck('kelas')->unique()->sort()->values()->all();
        
        return view('nilai.create', compact('siswas', 'mataPelajarans', 'semesterList', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check create permission
        $menuPermission = MenuPermission::where('menu_route', 'nilai.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_create) {
            return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki izin untuk menambah nilai.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('nilai.index')->with('error', 'Siswa tidak dapat menambah nilai.');
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'semester' => 'required|in:1,2',
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Role-based validation
        if (auth()->user()->role === 'guru') {
            // Pastikan guru hanya bisa input nilai untuk siswa yang dia ajar
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            $siswa = Siswa::find($request->siswa_id);
            if (!in_array($siswa->kelas, $kelasYangDiajar)) {
                return back()->withErrors(['siswa_id' => 'Anda tidak mengajar siswa ini.'])->withInput();
            }

            // Pastikan guru hanya bisa input nilai untuk mata pelajaran yang dia ajar
            $mataPelajaranIds = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->pluck('mata_pelajaran_id')
                ->toArray();
            
            if (!in_array($request->mata_pelajaran_id, $mataPelajaranIds)) {
                return back()->withErrors(['mata_pelajaran_id' => 'Anda tidak mengajar mata pelajaran ini.'])->withInput();
            }
        }

        // Cek apakah nilai sudah ada
        $existingNilai = Nilai::where('siswa_id', $request->siswa_id)
            ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->where('semester', $request->semester)
            ->first();

        if ($existingNilai) {
            return back()->withErrors(['nilai' => 'Nilai untuk siswa, mata pelajaran, dan semester ini sudah ada.'])->withInput();
        }

        Nilai::create($request->all());

        // Redirect dengan filter sesuai data yang baru diinput
        $siswa = Siswa::find($request->siswa_id);
        return redirect()->route('nilai.index', [
            'kelas' => $siswa ? $siswa->kelas : null,
            'mapel_id' => $request->mata_pelajaran_id,
            'semester' => $request->semester
        ])->with('success', 'Nilai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nilai $nilai)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'nilai.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki izin untuk melihat detail nilai.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            if (!in_array($nilai->siswa->kelas, $kelasYangDiajar)) {
                return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki akses ke nilai ini.');
            }
        } elseif (auth()->user()->role === 'siswa') {
            if ($nilai->siswa->user_id !== auth()->id()) {
                return redirect()->route('nilai.index')->with('error', 'Anda hanya bisa melihat nilai pribadi.');
            }
        }

        $nilai->load(['siswa', 'mataPelajaran']);
        
        return view('nilai.show', compact('nilai', 'menuPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nilai $nilai)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'nilai.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki izin untuk mengedit nilai.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('nilai.index')->with('error', 'Siswa tidak dapat mengedit nilai.');
        }

        if (auth()->user()->role === 'guru') {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            if (!in_array($nilai->siswa->kelas, $kelasYangDiajar)) {
                return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki akses ke nilai ini.');
            }
        }

        $siswas = Siswa::when(auth()->user()->role === 'guru', function($query) {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            $query->whereIn('kelas', $kelasYangDiajar);
        })->get();
        
        $mataPelajarans = MataPelajaran::when(auth()->user()->role === 'guru', function($query) {
            $mataPelajaranIds = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->pluck('mata_pelajaran_id')
                ->toArray();
            $query->whereIn('id', $mataPelajaranIds);
        })->get();
        
        $semesterList = ['1', '2'];
        
        // Ambil daftar kelas dari siswa yang tersedia
        $kelas = $siswas->pluck('kelas')->unique()->sort()->values()->all();
        
        return view('nilai.edit', compact('nilai', 'siswas', 'mataPelajarans', 'semesterList', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nilai $nilai)
    {
        // Check update permission
        $menuPermission = MenuPermission::where('menu_route', 'nilai.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_update) {
            return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki izin untuk mengedit nilai.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('nilai.index')->with('error', 'Siswa tidak dapat mengedit nilai.');
        }

        if (auth()->user()->role === 'guru') {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            if (!in_array($nilai->siswa->kelas, $kelasYangDiajar)) {
                return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki akses ke nilai ini.');
            }
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'semester' => 'required|in:1,2',
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Role-based validation
        if (auth()->user()->role === 'guru') {
            // Pastikan guru hanya bisa edit nilai untuk siswa yang dia ajar
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            $siswa = Siswa::find($request->siswa_id);
            if (!in_array($siswa->kelas, $kelasYangDiajar)) {
                return back()->withErrors(['siswa_id' => 'Anda tidak mengajar siswa ini.'])->withInput();
            }

            // Pastikan guru hanya bisa edit nilai untuk mata pelajaran yang dia ajar
            $mataPelajaranIds = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->pluck('mata_pelajaran_id')
                ->toArray();
            
            if (!in_array($request->mata_pelajaran_id, $mataPelajaranIds)) {
                return back()->withErrors(['mata_pelajaran_id' => 'Anda tidak mengajar mata pelajaran ini.'])->withInput();
            }
        }

        // Cek apakah nilai sudah ada (kecuali nilai yang sedang diedit)
        $existingNilai = Nilai::where('id', '!=', $nilai->id)
            ->where('siswa_id', $request->siswa_id)
            ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->where('semester', $request->semester)
            ->first();

        if ($existingNilai) {
            return back()->withErrors(['nilai' => 'Nilai untuk siswa, mata pelajaran, dan semester ini sudah ada.'])->withInput();
        }

        $nilai->update($request->all());

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        // Check delete permission
        $menuPermission = MenuPermission::where('menu_route', 'nilai.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_delete) {
            return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki izin untuk menghapus nilai.');
        }

        // Role-based access control
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('nilai.index')->with('error', 'Siswa tidak dapat menghapus nilai.');
        }

        if (auth()->user()->role === 'guru') {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            if (!in_array($nilai->siswa->kelas, $kelasYangDiajar)) {
                return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki akses ke nilai ini.');
            }
        }

        $nilai->delete();

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }

    /**
     * Show nilai for specific siswa
     */
    public function showSiswa(Siswa $siswa)
    {
        // Check read permission
        $menuPermission = MenuPermission::where('menu_route', 'nilai.index')
            ->where('role', auth()->user()->role)
            ->where('is_active', 1)
            ->first();
            
        if (!$menuPermission || !$menuPermission->can_read) {
            return redirect()->route('nilai.index')->with('error', 'Anda tidak memiliki izin untuk melihat nilai siswa.');
        }

        // Role-based access control
        if (auth()->user()->role === 'guru') {
            $kelasYangDiajar = \App\Models\JadwalPelajaran::where('guru_id', auth()->id())
                ->distinct()
                ->pluck('kelas')
                ->toArray();
            
            if (!in_array($siswa->kelas, $kelasYangDiajar)) {
                return redirect()->route('nilai.index')->with('error', 'Anda tidak mengajar siswa ini.');
            }
        } elseif (auth()->user()->role === 'siswa') {
            if ($siswa->user_id !== auth()->id()) {
                return redirect()->route('nilai.index')->with('error', 'Anda hanya bisa melihat nilai pribadi.');
            }
        }

        $nilais = $siswa->nilai()->with('mataPelajaran')->get();
        
        return view('nilai.siswa', compact('siswa', 'nilais', 'menuPermission'));
    }

    public function siswa()
    {
        $user = auth()->user();
        $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();

        $nilais = collect();
        $rataRataKeseluruhan = null;
        $rataRataPerSemester = [];

        if ($siswa) {
            $nilais = \App\Models\Nilai::with(['mataPelajaran', 'guru'])
                ->where('siswa_id', $siswa->id)
                ->get();

            // Hitung rata-rata keseluruhan
            if ($nilais->count() > 0) {
                $rataRataKeseluruhan = round($nilais->avg('nilai'), 2);
            }

            // Hitung rata-rata per semester
            $rataRataPerSemester = $nilais->groupBy('semester')->map(function($group) {
                return round($group->avg('nilai'), 2);
            });
        }

        return view('nilai.siswa', compact('nilais', 'siswa', 'rataRataKeseluruhan', 'rataRataPerSemester'));
    }

    public function exportExcelGuru(Request $request)
    {
        $query = \App\Models\Nilai::with(['siswa', 'mataPelajaran']);
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }
        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        $nilais = $query->get();
        $data = $nilais->map(function($nilai) {
            return [
                'Nama Siswa' => $nilai->siswa->nama ?? '-',
                'NIS' => $nilai->siswa->nis ?? '-',
                'Kelas' => $nilai->siswa->kelas ?? '-',
                'Mata Pelajaran' => $nilai->mataPelajaran->nama ?? '-',
                'Semester' => $nilai->semester,
                'Nilai' => $nilai->nilai,
                'Keterangan' => $nilai->keterangan,
            ];
        })->toArray();
        $headings = ['Nama Siswa', 'NIS', 'Kelas', 'Mata Pelajaran', 'Semester', 'Nilai', 'Keterangan'];
        return \Excel::download(new \App\Exports\ArrayExport($data, $headings), 'data-nilai.xlsx');
    }

    public function exportPdfGuru(Request $request)
    {
        $query = \App\Models\Nilai::with(['siswa', 'mataPelajaran']);
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }
        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        $nilais = $query->get();
        $kelas = $request->kelas;
        $mapel = $request->mata_pelajaran_id ? \App\Models\MataPelajaran::find($request->mata_pelajaran_id) : null;
        $semester = $request->semester;
        $pdf = \PDF::loadView('nilai.pdf', compact('nilais', 'kelas', 'mapel', 'semester'));
        return $pdf->download('data-nilai.pdf');
    }
}
