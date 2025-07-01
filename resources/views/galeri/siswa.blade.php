@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-images text-blue-600 mr-2"></i>
                        Galeri Sekolah
                    </h2>
                </div>

                <!-- Search Box -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('galeri_siswa') }}" class="flex gap-2">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari galeri..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('galeri_siswa') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <i class="fas fa-times mr-2"></i>
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                @if($galeris->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($galeris as $galeri)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                                <div class="aspect-w-16 aspect-h-9">
                                    <img src="{{ asset('storage/' . $galeri->gambar) }}" 
                                         alt="{{ $galeri->judul }}"
                                         class="w-full h-48 object-cover">
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                        {{ $galeri->judul }}
                                    </h3>
                                    @if($galeri->deskripsi)
                                        <p class="text-gray-600 text-sm mb-3">
                                            {{ Str::limit($galeri->deskripsi, 100) }}
                                        </p>
                                    @endif
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>
                                            <i class="fas fa-user mr-1"></i>
                                            {{ $galeri->user->name }}
                                        </span>
                                        <span>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $galeri->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-images text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            @if(request('search'))
                                Tidak ada galeri yang ditemukan
                            @else
                                Belum ada galeri
                            @endif
                        </h3>
                        <p class="text-gray-500">
                            @if(request('search'))
                                Coba ubah kata kunci pencarian Anda.
                            @else
                                Galeri akan ditampilkan setelah admin menambahkan foto.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 