@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-eye"></i>
                Detail Nilai
            </h1>
            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Informasi Siswa</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Siswa:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $nilai->siswa->nama ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NIS:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $nilai->siswa->nis ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kelas:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $nilai->siswa->kelas ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Informasi Nilai</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mata Pelajaran:</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($nilai->mataPelajaran)
                                    <span class="font-medium">{{ $nilai->mataPelajaran->nama }}</span>
                                    <br><span class="text-gray-500">{{ $nilai->mataPelajaran->kode }} - {{ $nilai->mataPelajaran->kelompok }}</span>
                                @else
                                    <span class="text-gray-400">Mata pelajaran tidak ditemukan</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nilai:</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <span class="text-2xl font-bold {{ $nilai->nilai >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $nilai->nilai }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Semester:</label>
                            <p class="mt-1 text-sm text-gray-900">Semester {{ $nilai->semester }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 mt-6">
                <a href="{{ route('nilai.edit', $nilai) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-edit"></i>
                    Edit Nilai
                </a>
                <a href="{{ route('nilai.index') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
                <form action="{{ route('nilai.destroy', $nilai) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus nilai ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        <i class="fas fa-trash"></i>
                        Hapus Nilai
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 