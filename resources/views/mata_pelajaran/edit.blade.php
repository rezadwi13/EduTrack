@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-edit"></i>
                Edit Mata Pelajaran
            </h1>
            <form action="{{ route('mata-pelajaran.update', $mataPelajaran) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $mataPelajaran->nama) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('nama')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Kode</label>
                    <input type="text" name="kode" value="{{ old('kode', $mataPelajaran->kode) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('kode')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Kelompok</label>
                    <select name="kelompok" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kelompok</option>
                    <option value="Wajib" {{ old('kelompok', $mataPelajaran->kelompok) == 'Wajib' ? 'selected' : '' }}>Wajib</option>
                    <option value="Peminatan" {{ old('kelompok', $mataPelajaran->kelompok) == 'Peminatan' ? 'selected' : '' }}>Peminatan</option>
                    <option value="Lintas Minat" {{ old('kelompok', $mataPelajaran->kelompok) == 'Lintas Minat' ? 'selected' : '' }}>Lintas Minat</option>
                </select>
                    @error('kelompok')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('mata-pelajaran.index') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
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