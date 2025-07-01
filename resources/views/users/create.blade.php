@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-blue-600"></i>
                    Tambah User Baru
                </h1>
                <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <p class="text-sm text-blue-800">
                            Isi informasi user yang akan ditambahkan ke sistem. User akan dapat login dengan email dan password yang dibuat.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-user mr-1"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="Nama lengkap user"
                               required>
                        @error('name')
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
                               placeholder="email@example.com"
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
                            <i class="fas fa-user-tag mr-1"></i>
                            Role
                        </label>
                        <select name="role" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                required>
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

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

                <!-- Role Information -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-yellow-600"></i>
                        Informasi Role
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="bg-white rounded p-3">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-user-shield text-purple-600 mr-2"></i>
                                <span class="font-medium text-purple-800">Admin</span>
                        </div>
                            <p class="text-gray-600 text-xs">Akses penuh ke semua fitur sistem</p>
                        </div>
                        <div class="bg-white rounded p-3">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-chalkboard-teacher text-green-600 mr-2"></i>
                                <span class="font-medium text-green-800">Guru</span>
                        </div>
                            <p class="text-gray-600 text-xs">Mengelola data siswa, nilai, dan jadwal</p>
                        </div>
                        <div class="bg-white rounded p-3">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-user-graduate text-orange-600 mr-2"></i>
                                <span class="font-medium text-orange-800">Siswa</span>
                        </div>
                            <p class="text-gray-600 text-xs">Melihat data pribadi dan akademik</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan User
                    </button>
                    <a href="{{ route('users.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection 