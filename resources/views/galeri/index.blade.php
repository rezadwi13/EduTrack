@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-images text-blue-600"></i>
                    Galeri Foto
                </h1>
                @php
                    $menuPermission = \App\Models\MenuPermission::where('menu_route', 'galeri.index')
                        ->where('role', auth()->user()->role)
                        ->where('is_active', 1)
                        ->first();
                @endphp
                @if($menuPermission && $menuPermission->can_create && auth()->user()->role !== 'siswa')
                <a href="{{ route('galeri.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus"></i>
                    Tambah Foto
                    </a>
                @endif
            </div>

            <!-- Search and Filter Form -->
            <form action="{{ route('galeri.index') }}" method="GET" class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Judul, deskripsi, atau pembuat..." 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Cari
                        </button>
                        <a href="{{ route('galeri.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
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
                            <i class="fas fa-images text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Foto</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $galeris->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Hari Ini</p>
                            <p class="text-2xl font-bold text-green-900">{{ $galeris->where('created_at', '>=', now()->startOfDay())->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user text-purple-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-600">Pembuat</p>
                            <p class="text-2xl font-bold text-purple-900">{{ $galeris->pluck('user_id')->unique()->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-tags text-orange-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-orange-600">Kategori</p>
                            <p class="text-2xl font-bold text-orange-900">{{ $galeris->pluck('kategori')->unique()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Galeri Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($galeris as $galeri)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('storage/'.$galeri->gambar) }}" 
                             alt="{{ $galeri->judul }}" 
                             class="w-full h-48 object-cover">
                        <div class="absolute top-2 left-2">
                            @php
                                $kategoriColors = [
                                    'Kegiatan' => 'bg-blue-500',
                                    'Acara' => 'bg-green-500',
                                    'Lomba' => 'bg-purple-500',
                                    'Kunjungan' => 'bg-yellow-500',
                                    'Lainnya' => 'bg-gray-500'
                                ];
                                $color = $kategoriColors[$galeri->kategori] ?? 'bg-gray-500';
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white {{ $color }}">
                                {{ $galeri->kategori }}
                            </span>
                        </div>
                        <div class="absolute top-2 right-2">
                            {{-- Icon CRUD di atas dihapus, hanya tampil di bawah --}}
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-1">{{ $galeri->judul }}</h3>
                        @if($galeri->deskripsi)
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $galeri->deskripsi }}</p>
                        @endif
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <div class="flex items-center">
                                <i class="fas fa-user text-blue-500 mr-1"></i>
                                <span>{{ $galeri->user->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-green-500 mr-1"></i>
                                <span>{{ $galeri->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                            <div class="flex space-x-2">
                                @if($menuPermission && $menuPermission->can_read)
                                <a href="{{ route('galeri.show', $galeri) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium" title="Detail">
                                    <i class="fas fa-eye mr-1"></i>
                                    Detail
                                </a>
                                @endif
                                @if($menuPermission && $menuPermission->can_update && auth()->user()->role !== 'siswa')
                                <a href="{{ route('galeri.edit', $galeri) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium" title="Edit">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                @endif
                                @if($menuPermission && $menuPermission->can_delete && auth()->user()->role !== 'siswa')
                                <form action="{{ route('galeri.destroy', $galeri) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus foto ini?')">
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
                </div>
                @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <i class="fas fa-images text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada foto</h3>
                        <p class="text-gray-500">
                            @if(auth()->user()->role === 'guru')
                                Belum ada foto yang Anda upload.
                            @else
                                Belum ada data galeri yang tersedia.
                            @endif
                        </p>
                    </div>
                </div>
                @endforelse
            </div>

            @if(request('search') && $galeris->count() == 0)
                <div class="text-center py-8">
                    <i class="fas fa-search text-gray-400 text-4xl mb-3"></i>
                    <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada hasil</p>
                    <p class="text-sm text-gray-500">Tidak ada foto yang cocok dengan pencarian "{{ request('search') }}"</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
