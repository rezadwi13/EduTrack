@extends('layouts.app')

@section('content')
@php
    $menuPermission = \App\Models\MenuPermission::where('menu_route', 'nilai.index')
        ->where('role', auth()->user()->role)
        ->where('is_active', 1)
        ->first();
@endphp
@if(auth()->user()->role === 'guru')
<div class="py-8">
    <div class="max-w-5xl mx-auto">
        <form method="GET" class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="kelas" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($kelasList as $k)
                            <option value="{{ $k }}" {{ $kelas == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                    <select name="mapel_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($mapelList as $mapel)
                            <option value="{{ $mapel->id }}" {{ $mapelId == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <select name="semester" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @for($i=1;$i<=6;$i++)
                            <option value="{{ $i }}" {{ $semester == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i>
                        Tampilkan
                    </button>
                    <a href="{{ route('nilai.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
        <div class="flex gap-2 mb-4">
            <a href="{{ route('nilai.export-excel-guru', request()->only(['kelas', 'mapel_id', 'semester'])) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                <i class="fas fa-file-excel"></i> Export to Excel
            </a>
            <a href="{{ route('nilai.export-pdf-guru', request()->only(['kelas', 'mapel_id', 'semester'])) }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                <i class="fas fa-file-pdf"></i> Export to PDF
            </a>
        </div>
        <div class="bg-white rounded-lg shadow p-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($siswas as $i => $siswa)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $i+1 }}</td>
                        <td class="px-6 py-4">{{ $siswa->nama }}</td>
                        <td class="px-6 py-4">{{ $siswa->nis }}</td>
                        <td class="px-6 py-4">
                            {{ $nilais[$siswa->id]->nilai ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if(isset($nilais[$siswa->id]))
                                <a href="{{ route('nilai.edit', $nilais[$siswa->id]) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @else
                                <a href="{{ route('nilai.create', ['siswa_id' => $siswa->id, 'kelas' => $kelas, 'mapel_id' => $mapelId, 'semester' => $semester]) }}" class="text-green-600 hover:text-green-800" title="Tambah Nilai">
                                    <i class="fas fa-plus"></i> Tambah Nilai
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-line text-blue-600"></i>
                    Data Nilai Siswa
                </h1>
                @if($menuPermission && $menuPermission->can_create && auth()->user()->role !== 'siswa')
                <a href="{{ route('nilai.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus"></i>
                    Tambah Nilai
                </a>
                @endif
            </div>

            <!-- Search and Filter Form -->
            <form method="GET" class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="kelas" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($kelasList as $k)
                                <option value="{{ $k }}" {{ $kelas == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                        <select name="mapel_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($mapelList as $mapel)
                                <option value="{{ $mapel->id }}" {{ $mapelId == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <select name="semester" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @for($i=1;$i<=6;$i++)
                                <option value="{{ $i }}" {{ $semester == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Tampilkan
                        </button>
                        <a href="{{ route('nilai.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Nilai</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $nilais->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-graduate text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Siswa</p>
                            <p class="text-2xl font-bold text-green-900">{{ $nilais->pluck('siswa_id')->unique()->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-book text-purple-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-600">Mata Pelajaran</p>
                            <p class="text-2xl font-bold text-purple-900">{{ $nilais->pluck('mata_pelajaran_id')->unique()->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-star text-orange-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-orange-600">Rata-rata</p>
                            <p class="text-2xl font-bold text-orange-900">{{ number_format($nilais->avg('nilai'), 1) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($nilais as $nilai)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class="fas fa-user-graduate text-blue-500 mr-2"></i>
                                    <div>
                                        <div class="font-medium">{{ $nilai->siswa->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $nilai->siswa->nis }} | {{ $nilai->siswa->kelas }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class="fas fa-book text-green-500 mr-2"></i>
                                    <div>
                                        <div class="font-medium">{{ $nilai->mataPelajaran->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $nilai->mataPelajaran->kode }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $nilai->semester == '1' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                                    Semester {{ $nilai->semester }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="font-bold text-lg">{{ $nilai->nilai }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php
                                    $grade = '';
                                    $color = '';
                                    if ($nilai->nilai >= 90) {
                                        $grade = 'A';
                                        $color = 'bg-green-100 text-green-800';
                                    } elseif ($nilai->nilai >= 80) {
                                        $grade = 'B';
                                        $color = 'bg-blue-100 text-blue-800';
                                    } elseif ($nilai->nilai >= 70) {
                                        $grade = 'C';
                                        $color = 'bg-yellow-100 text-yellow-800';
                                    } elseif ($nilai->nilai >= 60) {
                                        $grade = 'D';
                                        $color = 'bg-orange-100 text-orange-800';
                                    } else {
                                        $grade = 'E';
                                        $color = 'bg-red-100 text-red-800';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ $grade }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div class="max-w-xs truncate" title="{{ $nilai->keterangan }}">
                                    {{ $nilai->keterangan ?: '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex justify-center space-x-2">
                                    @if($menuPermission && $menuPermission->can_read)
                                    <a href="{{ route('nilai.show', $nilai) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif
                                    @if($menuPermission && $menuPermission->can_update && auth()->user()->role !== 'siswa')
                                    <a href="{{ route('nilai.edit', $nilai) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if($menuPermission && $menuPermission->can_delete && auth()->user()->role !== 'siswa')
                                    <form action="{{ route('nilai.destroy', $nilai) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus nilai ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center py-8">
                                    <i class="fas fa-chart-line text-gray-400 text-4xl mb-3"></i>
                                    <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada nilai</p>
                                    <p class="text-sm text-gray-500">
                                        @if(auth()->user()->role === 'guru')
                                            Belum ada nilai untuk mata pelajaran yang Anda ajar.
                                        @elseif(auth()->user()->role === 'siswa')
                                            Belum ada nilai yang tersedia untuk Anda.
                                        @else
                                            Belum ada data nilai yang tersedia.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(request('search') && $nilais->count() == 0)
                <div class="text-center py-8">
                    <i class="fas fa-search text-gray-400 text-4xl mb-3"></i>
                    <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada hasil</p>
                    <p class="text-sm text-gray-500">Tidak ada nilai yang cocok dengan pencarian "{{ request('search') }}"</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endif
@endsection