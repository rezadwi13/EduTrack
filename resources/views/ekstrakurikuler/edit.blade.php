@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-edit text-blue-600"></i>
                    Edit Ekstrakurikuler
                </h1>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('ekstrakurikuler.show', $ekstrakurikuler) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                        <i class="fas fa-eye"></i>
                        Lihat Detail
                    </a>
                    <a href="{{ route('ekstrakurikuler.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
            <form action="{{ route('ekstrakurikuler.update', $ekstrakurikuler->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-edit text-yellow-600 mr-2"></i>
                        <p class="text-sm text-yellow-800">
                            Edit informasi ekstrakurikuler "{{ $ekstrakurikuler->nama }}". Perubahan akan langsung tersimpan.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-tag mr-1"></i>
                            Nama Ekstrakurikuler
                        </label>
                        <input type="text" name="nama" value="{{ old('nama', $ekstrakurikuler->nama) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" placeholder="Contoh: Basket, Futsal, Pramuka" required>
                        @error('nama')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-tags mr-1"></i>
                            Jenis
                        </label>
                        <select name="jenis" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                            <option value="">Pilih Jenis</option>
                            <option value="Olahraga" {{ old('jenis', $ekstrakurikuler->jenis) == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                            <option value="Seni" {{ old('jenis', $ekstrakurikuler->jenis) == 'Seni' ? 'selected' : '' }}>Seni</option>
                            <option value="Akademik" {{ old('jenis', $ekstrakurikuler->jenis) == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="Keagamaan" {{ old('jenis', $ekstrakurikuler->jenis) == 'Keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                            <option value="Lainnya" {{ old('jenis', $ekstrakurikuler->jenis) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-user-tie mr-1"></i>
                            Pembina
                        </label>
                        <input type="text" name="pembina" value="{{ old('pembina', $ekstrakurikuler->pembina) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" placeholder="Nama pembina ekstrakurikuler" required>
                        @error('pembina')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-toggle-on mr-1"></i>
                            Status
                        </label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                            <option value="">Pilih Status</option>
                            <option value="Aktif" {{ old('status', $ekstrakurikuler->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status', $ekstrakurikuler->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-calendar-day mr-1"></i>
                            Hari
                        </label>
                        <select name="hari" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                            <option value="">Pilih Hari</option>
                            <option value="Senin" {{ old('hari', $ekstrakurikuler->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                            <option value="Selasa" {{ old('hari', $ekstrakurikuler->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                            <option value="Rabu" {{ old('hari', $ekstrakurikuler->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                            <option value="Kamis" {{ old('hari', $ekstrakurikuler->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                            <option value="Jumat" {{ old('hari', $ekstrakurikuler->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                            <option value="Sabtu" {{ old('hari', $ekstrakurikuler->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        </select>
                        @error('hari')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-clock mr-1"></i>
                            Jam
                        </label>
                        <input type="text" name="jam" value="{{ old('jam', $ekstrakurikuler->jam) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" placeholder="Contoh: 15:00-17:00" required>
                        @error('jam')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            Tempat
                        </label>
                        <input type="text" name="tempat" value="{{ old('tempat', $ekstrakurikuler->tempat) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" placeholder="Contoh: Lapangan Basket, Lab Komputer" required>
                        @error('tempat')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-users mr-1"></i>
                            Kuota (Opsional)
                        </label>
                        <input type="number" name="kuota" value="{{ old('kuota', $ekstrakurikuler->kuota) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" placeholder="Jumlah maksimal peserta">
                        @error('kuota')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        <i class="fas fa-align-left mr-1"></i>
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" rows="4" placeholder="Jelaskan deskripsi ekstrakurikuler ini...">{{ old('deskripsi', $ekstrakurikuler->deskripsi) }}</textarea>
                    @error('deskripsi')<div class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>@enderror
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-lightbulb mr-1"></i>
                        Deskripsi membantu siswa memahami kegiatan ekstrakurikuler ini.
                    </p>
                </div>
                <!-- Info Siswa Terdaftar -->
                @if($ekstrakurikuler->siswa->count() > 0)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <p class="text-sm font-medium text-blue-800">Info Siswa Terdaftar</p>
                    </div>
                    <p class="text-xs text-blue-700">
                        Ekstrakurikuler ini memiliki {{ $ekstrakurikuler->siswa->count() }} siswa terdaftar. 
                        Perubahan nama/deskripsi tidak akan mempengaruhi keanggotaan siswa.
                    </p>
                </div>
                @endif
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Update Ekstrakurikuler
                    </button>
                    <a href="{{ route('ekstrakurikuler.show', $ekstrakurikuler) }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection