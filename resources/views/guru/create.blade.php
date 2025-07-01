@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-blue-600"></i>
                    Tambah Guru Baru
                </h1>
                <a href="{{ route('guru.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('guru.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <p class="text-sm text-blue-800">
                            Isi informasi guru yang akan ditambahkan ke sistem. Akun login akan dibuat otomatis.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-id-card mr-1"></i>
                            NIP
                        </label>
                        <input type="text" 
                               name="nip" 
                               value="{{ old('nip') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="Contoh: 198501012010012001"
                               required>
                        @error('nip')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-user mr-1"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               name="nama" 
                               value="{{ old('nama') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="Nama lengkap guru"
                               required>
                        @error('nama')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-envelope mr-1"></i>
                            Email
                        </label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="email@sekolah.sch.id"
                               required>
                        @error('email')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-phone mr-1"></i>
                            No. HP
                        </label>
                        <input type="text" 
                               name="no_hp" 
                               value="{{ old('no_hp') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="081234567890">
                        @error('no_hp')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-venus-mars mr-1"></i>
                            Jenis Kelamin
                        </label>
                        <select name="jenis_kelamin" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                required>
                            <option value="">Pilih Jenis Kelamin</option>
                            @foreach($jenisKelaminList as $jk)
                                <option value="{{ $jk }}" {{ old('jenis_kelamin') == $jk ? 'selected' : '' }}>
                                    {{ $jk }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_kelamin')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-book mr-1"></i>
                            Mata Pelajaran Utama
                        </label>
                        <select name="mata_pelajaran" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <option value="">Pilih Mata Pelajaran (Opsional)</option>
                            @foreach($mataPelajaranList as $mapel)
                                <option value="{{ $mapel }}" {{ old('mata_pelajaran') == $mapel ? 'selected' : '' }}>
                                    {{ $mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-lock mr-1"></i>
                            Password
                        </label>
                        <input type="password" 
                               name="password" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="Minimal 6 karakter"
                               required>
                        @error('password')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-lock mr-1"></i>
                            Konfirmasi Password
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="Ulangi password"
                               required>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Guru
                    </button>
                    <a href="{{ route('guru.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 