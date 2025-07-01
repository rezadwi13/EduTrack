@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Detail Galeri</h1>
<div class="bg-white p-6 rounded shadow max-w-4xl mx-auto">
    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div>
            <img src="{{ asset('storage/'.$galeri->gambar) }}" alt="{{ $galeri->judul }}" class="w-full h-96 object-cover rounded-lg shadow-lg">
        </div>
        <div class="space-y-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $galeri->judul }}</h3>
                <p class="text-gray-600">{{ $galeri->deskripsi }}</p>
            </div>
            <div class="border-t pt-4">
                <h4 class="text-lg font-semibold mb-3">Informasi Upload</h4>
                <div class="space-y-2">
                    <div>
                        <span class="font-medium text-gray-700">Diunggah oleh:</span>
                        <span class="text-gray-900">
                            @if($galeri->user)
                                {{ $galeri->user->name }}
                            @else
                                <span class="text-gray-400">User tidak ditemukan</span>
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Email:</span>
                        <span class="text-gray-900">
                            @if($galeri->user)
                                {{ $galeri->user->email }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Tanggal upload:</span>
                        <span class="text-gray-900">{{ $galeri->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Terakhir diperbarui:</span>
                        <span class="text-gray-900">{{ $galeri->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
            <div class="border-t pt-4">
                <h4 class="text-lg font-semibold mb-3">Aksi</h4>
                <div class="flex space-x-2">
                    <a href="{{ route('galeri.edit', $galeri) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center gap-1">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('galeri.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-1">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <form action="{{ route('galeri.destroy', $galeri) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus galeri ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center gap-1">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 