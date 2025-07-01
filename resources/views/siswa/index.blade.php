@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-user-graduate text-blue-600"></i>
                    Data Siswa
                </h1>
                @php
                    $menuPermission = \App\Models\MenuPermission::where('menu_route', 'siswa.index')
                        ->where('role', auth()->user()->role)
                        ->where('is_active', 1)
                        ->first();
                @endphp
                @if($menuPermission && $menuPermission->can_create)
                <a href="{{ route('siswa.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus"></i>
                    Tambah Siswa
                </a>
                @endif
            </div>

            <!-- Search and Filter Form -->
            <form action="{{ route('siswa.index') }}" method="GET" class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="NIS, nama, atau kelas..." 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="kelas" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                                    {{ $kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua</option>
                            @foreach($jenisKelaminList as $jk)
                                <option value="{{ $jk }}" {{ request('jenis_kelamin') == $jk ? 'selected' : '' }}>
                                    {{ $jk }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Cari
                        </button>
                        <a href="{{ route('siswa.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
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

            <div class="flex gap-2 mb-4">
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
                <a href="{{ route('siswa.export-excel', request()->only(['kelas', 'jenis_kelamin'])) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>
                <a href="{{ route('siswa.export-pdf', request()->only(['kelas', 'jenis_kelamin'])) }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    <i class="fas fa-file-pdf"></i> Export to PDF
                </a>
                @elseif(auth()->user()->role === 'siswa')
                <a href="{{ route('siswa.export-pdf-siswa') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    <i class="fas fa-file-pdf"></i> Export to PDF
                </a>
                @endif
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-graduate text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Siswa</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $siswas->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-male text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Siswa Laki-laki</p>
                            <p class="text-2xl font-bold text-green-900">{{ $siswas->where('jenis_kelamin', 'Laki-laki')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-pink-50 border border-pink-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-female text-pink-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-pink-600">Siswa Perempuan</p>
                            <p class="text-2xl font-bold text-pink-900">{{ $siswas->where('jenis_kelamin', 'Perempuan')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-purple-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-600">Kelas</p>
                            <p class="text-2xl font-bold text-purple-900">{{ $siswas->pluck('kelas')->unique()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Siswa Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ekstrakurikuler</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($siswas as $siswa)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $siswa->nis }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $siswa->kelas }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $siswa->jenis_kelamin === 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    <i class="fas {{ $siswa->jenis_kelamin === 'Laki-laki' ? 'fa-male' : 'fa-female' }} mr-1"></i>
                                    {{ $siswa->jenis_kelamin }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($siswa->ekstrakurikulers->count() > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $siswa->ekstrakurikulers->count() }} ekstrakurikuler
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex justify-center space-x-2">
                                    @if($menuPermission && $menuPermission->can_read)
                                    <a href="{{ route('siswa.show', $siswa) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif
                                    @if($menuPermission && $menuPermission->can_update)
                                    <a href="{{ route('siswa.edit', $siswa) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if($menuPermission && $menuPermission->can_delete)
                                    <form action="{{ route('siswa.destroy', $siswa) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus siswa ini?')">
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
                                    <i class="fas fa-user-graduate text-gray-400 text-4xl mb-3"></i>
                                    <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada siswa</p>
                                    <p class="text-sm text-gray-500">
                                        @if(auth()->user()->role === 'guru')
                                            Belum ada siswa di kelas yang Anda ajar.
                                        @else
                                            Belum ada data siswa yang tersedia.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(request('search') && $siswas->count() == 0)
                <div class="text-center py-8">
                    <i class="fas fa-search text-gray-400 text-4xl mb-3"></i>
                    <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada hasil</p>
                    <p class="text-sm text-gray-500">Tidak ada siswa yang cocok dengan pencarian "{{ request('search') }}"</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 