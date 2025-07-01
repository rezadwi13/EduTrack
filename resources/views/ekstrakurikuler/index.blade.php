@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-running text-blue-600"></i>
                    Data Ekstrakurikuler
                </h1>
                @php
                    $menuPermission = \App\Models\MenuPermission::where('menu_route', 'ekstrakurikuler.index')
                        ->where('role', auth()->user()->role)
                        ->where('is_active', 1)
                        ->first();
                @endphp
                @if($menuPermission && $menuPermission->can_create)
                <a href="{{ route('ekstrakurikuler.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus"></i>
                    Tambah Ekstrakurikuler
                </a>
                @endif
            </div>

            <!-- Search and Filter Form -->
            <form action="{{ route('ekstrakurikuler.index') }}" method="GET" class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Nama, deskripsi, atau pembina..." 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                        <select name="jenis" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Jenis</option>
                            @foreach($jenisList as $jenis)
                                <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            @foreach($statusList as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Cari
                        </button>
                        <a href="{{ route('ekstrakurikuler.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
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
                            <i class="fas fa-running text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Ekstrakurikuler</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $ekstrakurikulers->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Aktif</p>
                            <p class="text-2xl font-bold text-green-900">{{ $ekstrakurikulers->where('status', 'Aktif')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-red-600">Tidak Aktif</p>
                            <p class="text-2xl font-bold text-red-900">{{ $ekstrakurikulers->where('status', 'Tidak Aktif')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-purple-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-600">Total Peserta</p>
                            <p class="text-2xl font-bold text-purple-900">{{ $ekstrakurikulers->sum(function($ek) { return $ek->siswa->count(); }) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ekstrakurikuler Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($ekstrakurikulers as $ekstrakurikuler)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $ekstrakurikuler->nama }}</h3>
                                <div class="flex items-center gap-2 mb-2">
                                    @php
                                        $jenisColors = [
                                            'Olahraga' => 'bg-blue-100 text-blue-800',
                                            'Seni' => 'bg-purple-100 text-purple-800',
                                            'Akademik' => 'bg-green-100 text-green-800',
                                            'Keagamaan' => 'bg-yellow-100 text-yellow-800',
                                            'Lainnya' => 'bg-gray-100 text-gray-800'
                                        ];
                                        $color = $jenisColors[$ekstrakurikuler->jenis] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                        {{ $ekstrakurikuler->jenis }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ekstrakurikuler->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $ekstrakurikuler->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-user-tie text-blue-500 mr-2 w-4"></i>
                                <span class="font-medium">Pembina:</span>
                                <span class="ml-1">{{ $ekstrakurikuler->pembina }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar text-green-500 mr-2 w-4"></i>
                                <span class="font-medium">Jadwal:</span>
                                <span class="ml-1">{{ $ekstrakurikuler->hari }}, {{ $ekstrakurikuler->jam }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt text-red-500 mr-2 w-4"></i>
                                <span class="font-medium">Tempat:</span>
                                <span class="ml-1">{{ $ekstrakurikuler->tempat }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-users text-purple-500 mr-2 w-4"></i>
                                <span class="font-medium">Peserta:</span>
                                <span class="ml-1">{{ $ekstrakurikuler->siswa->count() }}
                                    @if($ekstrakurikuler->kuota)
                                        / {{ $ekstrakurikuler->kuota }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if($ekstrakurikuler->deskripsi)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $ekstrakurikuler->deskripsi }}</p>
                        </div>
                        @endif

                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="flex space-x-2">
                                @if($menuPermission && $menuPermission->can_read)
                                <a href="{{ route('ekstrakurikuler.show', $ekstrakurikuler) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium" title="Detail">
                                    <i class="fas fa-eye mr-1"></i>
                                    Detail
                                </a>
                                @endif
                                @if($menuPermission && $menuPermission->can_update)
                                <a href="{{ route('ekstrakurikuler.edit', $ekstrakurikuler) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium" title="Edit">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                @endif
                            </div>
                            @if($menuPermission && $menuPermission->can_delete)
                            <form action="{{ route('ekstrakurikuler.destroy', $ekstrakurikuler) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus ekstrakurikuler ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium" title="Hapus">
                                    <i class="fas fa-trash-alt mr-1"></i>
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <i class="fas fa-running text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada ekstrakurikuler</h3>
                        <p class="text-gray-500">Belum ada data ekstrakurikuler yang tersedia.</p>
                    </div>
                </div>
                @endforelse
            </div>

            @if(request('search') && $ekstrakurikulers->count() == 0)
                <div class="text-center py-8">
                    <i class="fas fa-search text-gray-400 text-4xl mb-3"></i>
                    <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada hasil</p>
                    <p class="text-sm text-gray-500">Tidak ada ekstrakurikuler yang cocok dengan pencarian "{{ request('search') }}"</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection