@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-blue-600"></i>
                    Jadwal Pelajaran
                </h1>
                @php
                    $menuPermission = \App\Models\MenuPermission::where('menu_route', 'jadwal-pelajaran.index')
                        ->where('role', auth()->user()->role)
                        ->where('is_active', 1)
                        ->first();
                @endphp
                @if($menuPermission && $menuPermission->can_create)
                <a href="{{ route('jadwal-pelajaran.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus"></i>
                    Tambah Jadwal
                                    </a>
                                @endif
                        </div>

            <!-- Search and Filter Form -->
            <form action="{{ route('jadwal-pelajaran.index') }}" method="GET" class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Kelas, hari, mata pelajaran, atau guru..." 
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                        <select name="hari" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Hari</option>
                            @foreach($hariList as $hari)
                                <option value="{{ $hari }}" {{ request('hari') == $hari ? 'selected' : '' }}>
                                    {{ $hari }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Cari
                        </button>
                        <a href="{{ route('jadwal-pelajaran.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
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
                            <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Jadwal</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $jadwals->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Kelas</p>
                            <p class="text-2xl font-bold text-green-900">{{ $jadwals->pluck('kelas')->unique()->count() }}</p>
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
                            <p class="text-2xl font-bold text-purple-900">{{ $jadwals->pluck('mata_pelajaran_id')->unique()->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chalkboard-teacher text-orange-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-orange-600">Guru</p>
                            <p class="text-2xl font-bold text-orange-900">{{ $jadwals->pluck('guru_id')->unique()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jadwal Table -->
                        <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($jadwals as $jadwal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $jadwal->kelas }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $jadwal->hari }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-gray-400 mr-1"></i>
                                    {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class="fas fa-book text-blue-500 mr-2"></i>
                                    <div>
                                        <div class="font-medium">{{ $jadwal->mataPelajaran?->nama ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $jadwal->mataPelajaran?->kode ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-chalkboard-teacher text-green-500 mr-2"></i>
                                    {{ $jadwal->guru?->name ?? '-' }}
                                </div>
                                        </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex justify-center space-x-2">
                                    @if($menuPermission && $menuPermission->can_read)
                                    <a href="{{ route('jadwal-pelajaran.show', $jadwal) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif
                                    @if($menuPermission && $menuPermission->can_update)
                                    <a href="{{ route('jadwal-pelajaran.edit', $jadwal) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if($menuPermission && $menuPermission->can_delete)
                                    <form action="{{ route('jadwal-pelajaran.destroy', $jadwal) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
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
                                    <i class="fas fa-calendar-alt text-gray-400 text-4xl mb-3"></i>
                                    <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada jadwal</p>
                                    <p class="text-sm text-gray-500">
                                        @if(auth()->user()->role === 'guru')
                                            Belum ada jadwal pelajaran yang Anda ajar.
                                        @else
                                            Belum ada data jadwal pelajaran yang tersedia.
                                        @endif
                                    </p>
                                </div>
                                        </td>
                                    </tr>
                        @endforelse
                                </tbody>
                            </table>
                        </div>

            @if(request('search') && $jadwals->count() == 0)
                <div class="text-center py-8">
                    <i class="fas fa-search text-gray-400 text-4xl mb-3"></i>
                    <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada hasil</p>
                    <p class="text-sm text-gray-500">Tidak ada jadwal yang cocok dengan pencarian "{{ request('search') }}"</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection