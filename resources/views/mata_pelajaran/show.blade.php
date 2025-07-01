@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-eye"></i>
                Detail Mata Pelajaran
            </h1>
            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Informasi Mata Pelajaran</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Mata Pelajaran:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $mataPelajaran->nama }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kode Mata Pelajaran:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $mataPelajaran->kode }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kelompok:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $mataPelajaran->kelompok }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Statistik</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah Nilai:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $mataPelajaran->nilai->count() }} nilai</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah Jadwal:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $mataPelajaran->jadwalPelajaran->count() }} jadwal</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 mt-6">
                <a href="{{ route('mata-pelajaran.edit', $mataPelajaran) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-edit"></i>
                    Edit Mata Pelajaran
                </a>
                <a href="{{ route('mata-pelajaran.index') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
                <form action="{{ route('mata-pelajaran.destroy', $mataPelajaran) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus mata pelajaran ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        <i class="fas fa-trash"></i>
                        Hapus Mata Pelajaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 