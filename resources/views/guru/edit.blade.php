@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-edit text-blue-600"></i>
                    Edit Guru
                </h1>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('guru.show', $guru) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                        <i class="fas fa-eye"></i>
                        Lihat Detail
                    </a>
                    <a href="{{ route('guru.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>

            <form action="{{ route('guru.update', $guru->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-edit text-yellow-600 mr-2"></i>
                        <p class="text-sm text-yellow-800">
                            Edit informasi guru "{{ $guru->nama }}". Perubahan akan langsung tersimpan.
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
                               value="{{ old('nip', $guru->nip) }}" 
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
                               value="{{ old('nama', $guru->nama) }}" 
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
                               value="{{ old('email', $guru->email) }}" 
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
                               value="{{ old('no_hp', $guru->no_hp) }}" 
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
                                <option value="{{ $jk }}" {{ old('jenis_kelamin', $guru->jenis_kelamin) == $jk ? 'selected' : '' }}>
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
                                <option value="{{ $mapel }}" {{ old('mata_pelajaran', $guru->mata_pelajaran) == $mapel ? 'selected' : '' }}>
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

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Alamat
                    </label>
                    <textarea name="alamat" 
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                              rows="3"
                              placeholder="Alamat lengkap guru">{{ old('alamat', $guru->alamat) }}</textarea>
                    @error('alamat')
                        <div class="text-red-600 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Update Section -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-lock text-gray-600"></i>
                        Update Password (Opsional)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Password Baru</label>
                            <input type="password" 
                                   name="password" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                   placeholder="Kosongkan jika tidak ingin mengubah">
                            @error('password')
                                <div class="text-red-600 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Konfirmasi Password</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Password hanya akan diubah jika kedua field diisi. Minimal 6 karakter.
                    </p>
                </div>

                <!-- Info Jadwal -->
                @if($guru->jadwalPelajaran->count() > 0)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <p class="text-sm font-medium text-blue-800">Info Jadwal Mengajar</p>
                    </div>
                    <p class="text-xs text-blue-700">
                        Guru ini memiliki {{ $guru->jadwalPelajaran->count() }} jadwal mengajar. 
                        Perubahan data guru tidak akan mempengaruhi jadwal yang sudah ada.
                    </p>
                </div>
                @endif

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Update Guru
                    </button>
                    <a href="{{ route('guru.show', $guru) }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 