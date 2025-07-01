@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-bullhorn text-blue-600"></i>
                    Tambah Pengumuman Baru
                </h1>
                <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('pengumuman.store') }}" method="POST" class="space-y-6">
                        @csrf
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <p class="text-sm text-blue-800">
                            Isi informasi pengumuman yang akan ditampilkan kepada siswa dan guru. Pengumuman akan langsung terlihat di dashboard.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-heading mr-1"></i>
                            Judul Pengumuman
                        </label>
                        <input type="text" 
                               name="judul" 
                               value="{{ old('judul') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="Judul pengumuman"
                               required>
                        @error('judul')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-tags mr-1"></i>
                            Kategori
                        </label>
                        <select name="kategori" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                required>
                            <option value="">Pilih Kategori</option>
                            <option value="Umum" {{ old('kategori') == 'Umum' ? 'selected' : '' }}>Umum</option>
                            <option value="Akademik" {{ old('kategori') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="Kegiatan" {{ old('kategori') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                            <option value="Beasiswa" {{ old('kategori') == 'Beasiswa' ? 'selected' : '' }}>Beasiswa</option>
                            <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-toggle-on mr-1"></i>
                            Status
                        </label>
                        <select name="status" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                required>
                            <option value="">Pilih Status</option>
                            <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-calendar mr-1"></i>
                            Tanggal Mulai (Opsional)
                        </label>
                        <input type="date" 
                               name="tanggal_mulai" 
                               value="{{ old('tanggal_mulai') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        @error('tanggal_mulai')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-calendar mr-1"></i>
                            Tanggal Selesai (Opsional)
                        </label>
                        <input type="date" 
                               name="tanggal_selesai" 
                               value="{{ old('tanggal_selesai') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        @error('tanggal_selesai')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Isi Pengumuman Section -->
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        <i class="fas fa-align-left mr-1"></i>
                        Isi Pengumuman
                    </label>
                    <textarea name="isi" 
                              rows="8" 
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                              placeholder="Tulis isi pengumuman di sini..."
                              required>{{ old('isi') }}</textarea>
                    @error('isi')
                        <div class="text-red-600 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-lightbulb mr-1"></i>
                        Gunakan format yang jelas dan mudah dibaca. Baris baru akan otomatis ditampilkan.
                    </p>
                        </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Pengumuman
                    </button>
                    <a href="{{ route('pengumuman.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection