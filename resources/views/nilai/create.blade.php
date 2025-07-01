@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Tambah Nilai
            </h1>
            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif
            <form action="{{ route('nilai.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Filter Kelas</label>
                    <select id="filter-kelas" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k }}">{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Siswa</label>
                    <select name="siswa_id" id="siswa-select" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}" data-kelas="{{ $siswa->kelas }}" @if(old('siswa_id')==$siswa->id) selected @endif>{{ $siswa->nama }} ({{ $siswa->nis }}) - {{ $siswa->kelas }}</option>
                        @endforeach
                    </select>
                    @error('siswa_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Mata Pelajaran</label>
                    <select name="mata_pelajaran_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach($mataPelajarans as $mataPelajaran)
                            <option value="{{ $mataPelajaran->id }}" @if(old('mata_pelajaran_id')==$mataPelajaran->id) selected @endif>{{ $mataPelajaran->nama }} ({{ $mataPelajaran->kode }}) - {{ $mataPelajaran->kelompok }}</option>
                        @endforeach
                    </select>
                    @error('mata_pelajaran_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Nilai</label>
                    <input type="number" name="nilai" value="{{ old('nilai') }}" min="0" max="100" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('nilai')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Semester</label>
                    <select name="semester" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih Semester --</option>
                        <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                        <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                        <option value="3" {{ old('semester') == '3' ? 'selected' : '' }}>Semester 3</option>
                        <option value="4" {{ old('semester') == '4' ? 'selected' : '' }}>Semester 4</option>
                        <option value="5" {{ old('semester') == '5' ? 'selected' : '' }}>Semester 5</option>
                        <option value="6" {{ old('semester') == '6' ? 'selected' : '' }}>Semester 6</option>
                    </select>
                    @error('semester')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('nilai.index') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterKelas = document.getElementById('filter-kelas');
        const siswaSelect = document.getElementById('siswa-select');
        const siswaOptions = siswaSelect.querySelectorAll('option[data-kelas]');
        filterKelas.addEventListener('change', function() {
            const selectedKelas = this.value;
            siswaSelect.value = '';
            siswaOptions.forEach(option => {
                if (selectedKelas === '' || option.getAttribute('data-kelas') === selectedKelas) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection 