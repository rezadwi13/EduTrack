@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-edit"></i>
                Edit Jadwal Pelajaran
            </h1>
            <form action="{{ route('jadwal-pelajaran.update', $jadwalPelajaran) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Mata Pelajaran</label>
                    <select name="mata_pelajaran_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($mataPelajarans as $mataPelajaran)
                        <option value="{{ $mataPelajaran->id }}" {{ old('mata_pelajaran_id', $jadwalPelajaran->mata_pelajaran_id) == $mataPelajaran->id ? 'selected' : '' }}>
                            {{ $mataPelajaran->nama }} ({{ $mataPelajaran->kode }})
                        </option>
                    @endforeach
                </select>
                    @error('mata_pelajaran_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $jadwalPelajaran->kelas) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('kelas')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Hari</label>
                    <select name="hari" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Hari</option>
                    <option value="Senin" {{ old('hari', $jadwalPelajaran->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ old('hari', $jadwalPelajaran->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ old('hari', $jadwalPelajaran->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ old('hari', $jadwalPelajaran->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ old('hari', $jadwalPelajaran->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    <option value="Sabtu" {{ old('hari', $jadwalPelajaran->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                </select>
                    @error('hari')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Jam Mulai</label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jadwalPelajaran->jam_mulai) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('jam_mulai')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Jam Selesai</label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jadwalPelajaran->jam_selesai) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('jam_selesai')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Guru</label>
                    <select name="guru_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Guru (Opsional)</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ old('guru_id', $jadwalPelajaran->guru_id) == $guru->id ? 'selected' : '' }}>
                            {{ $guru->name }} ({{ $guru->email }})
                        </option>
                    @endforeach
                </select>
                    @error('guru_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('jadwal-pelajaran.index') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-save"></i>
                        Update
                    </button>
            </div>
        </form>
        </div>
    </div>
    </div>
@endsection 