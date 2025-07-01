@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-user-tie text-blue-600"></i>
                    Detail Guru
                </h1>
                <div class="flex flex-wrap gap-2">
                    @if($menuPermission && $menuPermission->can_update)
                    <a href="{{ route('guru.edit', $guru) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        <i class="fas fa-edit"></i>
                        Edit Guru
                    </a>
                    @endif
                    <a href="{{ route('guru.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i>
                        Informasi Pribadi
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP:</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $guru->nip }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap:</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $guru->nama }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                            <p class="text-sm text-gray-900">{{ $guru->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP:</label>
                            <p class="text-sm text-gray-900">{{ $guru->no_hp ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin:</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $guru->jenis_kelamin === 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                <i class="fas {{ $guru->jenis_kelamin === 'Laki-laki' ? 'fa-male' : 'fa-female' }} mr-1"></i>
                                {{ $guru->jenis_kelamin }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-blue-600"></i>
                        Informasi Akademik
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran Utama:</label>
                            @if($guru->mata_pelajaran)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $guru->mata_pelajaran }}
                                </span>
                            @else
                                <p class="text-sm text-gray-500">-</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Jadwal:</label>
                            <p class="text-2xl font-bold text-blue-600">{{ $guru->jadwalPelajaran->count() }} jadwal</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Akun:</label>
                            @if($guru->user)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>
                                    Tidak Aktif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($guru->alamat)
            <div class="bg-white border border-gray-200 rounded-lg mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-green-600"></i>
                        Alamat
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-900">{{ $guru->alamat }}</p>
                </div>
            </div>
            @endif

            @if($guru->jadwalPelajaran->count() > 0)
            <div class="bg-white border border-gray-200 rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-purple-600"></i>
                        Jadwal Mengajar ({{ $guru->jadwalPelajaran->count() }})
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($guru->jadwalPelajaran as $jadwal)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $jadwal->mataPelajaran->nama }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $jadwal->kelas }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->hari }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada jadwal</h3>
                <p class="text-gray-500">Guru ini belum memiliki jadwal mengajar.</p>
            </div>
            @endif

            @if($menuPermission && $menuPermission->can_delete)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-end">
                    <form action="{{ route('guru.destroy', $guru) }}" method="POST" onsubmit="return confirm('Yakin hapus guru ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                            <i class="fas fa-trash-alt"></i>
                            Hapus Guru
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 