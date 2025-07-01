@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-eye"></i>
                Detail Jadwal Pelajaran
            </h1>
            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Informasi Jadwal</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mata Pelajaran:</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($jadwalPelajaran->mataPelajaran)
                                    <span class="font-medium">{{ $jadwalPelajaran->mataPelajaran->nama }}</span>
                                    <br><span class="text-gray-500">{{ $jadwalPelajaran->mataPelajaran->kode }}</span>
                                @else
                                    <span class="text-gray-400">Mata pelajaran tidak ditemukan</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kelas:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jadwalPelajaran->kelas }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hari:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jadwalPelajaran->hari }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Waktu:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jadwalPelajaran->jam_mulai }} - {{ $jadwalPelajaran->jam_selesai }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Informasi Guru</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Guru:</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($jadwalPelajaran->guru)
                                    <span class="font-medium">{{ $jadwalPelajaran->guru->name }}</span>
                                    <br><span class="text-gray-500">{{ $jadwalPelajaran->guru->email }}</span>
                                @else
                                    <span class="text-gray-400">Guru belum ditugaskan</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dibuat pada:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jadwalPelajaran->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Terakhir diperbarui:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jadwalPelajaran->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 mt-6">
                <a href="{{ route('jadwal-pelajaran.edit', $jadwalPelajaran) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-edit"></i>
                    Edit Jadwal
                </a>
                <a href="{{ route('jadwal-pelajaran.index') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
                <form action="{{ route('jadwal-pelajaran.destroy', $jadwalPelajaran) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        <i class="fas fa-trash"></i>
                        Hapus Jadwal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 