@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit Foto Galeri
                </h1>
                <a href="{{ route('galeri.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>
            <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-heading mr-1"></i>
                            Judul Foto
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $galeri->judul) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" placeholder="Judul foto" required>
                        @error('judul')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-tags mr-1"></i>
                            Kategori
                        </label>
                        <select name="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Kegiatan" {{ old('kategori', $galeri->kategori) == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                            <option value="Acara" {{ old('kategori', $galeri->kategori) == 'Acara' ? 'selected' : '' }}>Acara</option>
                            <option value="Lomba" {{ old('kategori', $galeri->kategori) == 'Lomba' ? 'selected' : '' }}>Lomba</option>
                            <option value="Kunjungan" {{ old('kategori', $galeri->kategori) == 'Kunjungan' ? 'selected' : '' }}>Kunjungan</option>
                            <option value="Lainnya" {{ old('kategori', $galeri->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-upload text-gray-600"></i>
                        Upload Foto
                    </h3>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Pilih File Foto (kosongkan jika tidak ingin ganti)</label>
                        <input type="file" name="gambar" accept="image/*" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        @error('gambar')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                        @if($galeri->gambar)
                        <img src="{{ asset('storage/'.$galeri->gambar) }}" alt="{{ $galeri->judul }}" class="w-full h-32 object-cover rounded mt-2">
                        @endif
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Format yang didukung: JPG, PNG, GIF. Maksimal ukuran: 5MB.
                        </p>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        <i class="fas fa-align-left mr-1"></i>
                        Deskripsi (Opsional)
                    </label>
                    <textarea name="deskripsi" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" placeholder="Jelaskan tentang foto ini...">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                    @error('deskripsi')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-lightbulb mr-1"></i>
                        Deskripsi membantu pengguna memahami konteks foto.
                    </p>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Update Foto
                    </button>
                    <a href="{{ route('galeri.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection