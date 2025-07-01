@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-user"></i>
                Detail Siswa
            </h1>
            <div class="space-y-4 mb-6">
                        <div>
                    <span class="block text-gray-600 text-sm">Nama</span>
                    <span class="font-semibold text-lg text-gray-900">{{ $siswa->nama }}</span>
                                </div>
                                <div>
                    <span class="block text-gray-600 text-sm">NIS</span>
                    <span class="font-semibold text-lg text-gray-900">{{ $siswa->nis }}</span>
                                </div>
                                <div>
                    <span class="block text-gray-600 text-sm">Jenis Kelamin</span>
                    <span class="font-semibold text-lg text-gray-900">{{ $siswa->jenis_kelamin ?? '-' }}</span>
                                </div>
                                    <div>
                    <span class="block text-gray-600 text-sm">Kelas</span>
                    <span class="font-semibold text-lg text-gray-900">{{ $siswa->kelas }}</span>
                        </div>
                        <div>
                    <span class="block text-gray-600 text-sm">Email</span>
                    <span class="font-semibold text-lg text-gray-900">{{ $siswa->email ?? '-' }}</span>
                            </div>
                        </div>
            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('siswa.edit', $siswa) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition" title="Edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('siswa.index') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition" title="Kembali">
                    <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                <form action="{{ route('siswa.destroy', $siswa) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus siswa?')">
                            @csrf
                            @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition" title="Hapus">
                        <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection 