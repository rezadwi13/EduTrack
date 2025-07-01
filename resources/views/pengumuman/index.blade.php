@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-bullhorn text-blue-600"></i>
                    Data Pengumuman
                </h1>
                @php
                    $menuPermission = \App\Models\MenuPermission::where('menu_route', 'pengumuman.index')
                        ->where('role', auth()->user()->role)
                        ->where('is_active', 1)
                        ->first();
                @endphp
                @if($menuPermission && $menuPermission->can_create && auth()->user()->role !== 'siswa')
                <a href="{{ route('pengumuman.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus"></i>
                    Tambah Pengumuman
                </a>
                @endif
            </div>

            <!-- Search and Filter Form -->
            <form action="{{ route('pengumuman.index') }}" method="GET" class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Judul, isi, atau pembuat..." 
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
                        <a href="{{ route('pengumuman.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
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
                            <i class="fas fa-bullhorn text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Pengumuman</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $pengumumen->count() }}</p>
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
                            <p class="text-2xl font-bold text-green-900">{{ $pengumumen->where('status', 'Aktif')->count() }}</p>
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
                            <p class="text-2xl font-bold text-red-900">{{ $pengumumen->where('status', 'Tidak Aktif')->count() }}</p>
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
                            <p class="text-2xl font-bold text-purple-900">{{ $pengumumen->pluck('user_id')->unique()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengumuman List -->
            <div class="space-y-6">
                @forelse($pengumumen as $pengumuman)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $pengumuman->judul }}</h3>
                                <div class="flex items-center gap-2 mb-3">
                                    @php
                                        $kategoriColors = [
                                            'Umum' => 'bg-blue-100 text-blue-800',
                                            'Akademik' => 'bg-green-100 text-green-800',
                                            'Kegiatan' => 'bg-purple-100 text-purple-800',
                                            'Beasiswa' => 'bg-yellow-100 text-yellow-800',
                                            'Lainnya' => 'bg-gray-100 text-gray-800'
                                        ];
                                        $color = $kategoriColors[$pengumuman->kategori] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                        {{ $pengumuman->kategori }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pengumuman->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pengumuman->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="prose max-w-none mb-4">
                            <div class="text-gray-700 line-clamp-3">
                                {!! nl2br(e($pengumuman->isi)) !!}
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <i class="fas fa-user text-blue-500 mr-1"></i>
                                    <span>{{ $pengumuman->user->name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-green-500 mr-1"></i>
                                    <span>{{ $pengumuman->created_at->format('d M Y H:i') }}</span>
                                </div>
                                @if($pengumuman->tanggal_mulai && $pengumuman->tanggal_selesai)
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-purple-500 mr-1"></i>
                                    <span>{{ $pengumuman->tanggal_mulai->format('d/m/Y') }} - {{ $pengumuman->tanggal_selesai->format('d/m/Y') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="flex space-x-2">
                                {{-- Baca Selengkapnya dihapus --}}
                            </div>
                            <div class="flex space-x-2">
                                @if($menuPermission && $menuPermission->can_update && auth()->user()->role !== 'siswa')
                                <a href="{{ route('pengumuman.edit', $pengumuman) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium" title="Edit">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                        @endif
                                @if($menuPermission && $menuPermission->can_delete && auth()->user()->role !== 'siswa')
                                <form action="{{ route('pengumuman.destroy', $pengumuman) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pengumuman ini?')">
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
                <div class="text-center py-12">
                    <i class="fas fa-bullhorn text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pengumuman</h3>
                    <p class="text-gray-500">
                        @if(auth()->user()->role === 'guru')
                            Belum ada pengumuman yang Anda buat.
                        @else
                            Belum ada data pengumuman yang tersedia.
                        @endif
                    </p>
                </div>
                @endforelse
            </div>

            @if(request('search') && $pengumumen->count() == 0)
                <div class="text-center py-8">
                    <i class="fas fa-search text-gray-400 text-4xl mb-3"></i>
                    <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada hasil</p>
                    <p class="text-sm text-gray-500">Tidak ada pengumuman yang cocok dengan pencarian "{{ request('search') }}"</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection