@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-users text-purple-600"></i>
                    Kelola Siswa - {{ $ekstrakurikuler->nama }}
                </h1>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('ekstrakurikuler.show', $ekstrakurikuler) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Detail
                    </a>
                    <a href="{{ route('ekstrakurikuler.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition">
                        <i class="fas fa-list"></i>
                        Daftar Ekstrakurikuler
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Siswa</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $siswaList->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-plus text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Siswa Tersedia</p>
                            <p class="text-2xl font-bold text-green-900">{{ $availableSiswa->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-basketball-ball text-purple-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-600">Ekstrakurikuler</p>
                            <p class="text-2xl font-bold text-purple-900">{{ $ekstrakurikuler->nama }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Daftar Siswa yang Sudah Terdaftar -->
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            Siswa Terdaftar ({{ $siswaList->count() }})
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($siswaList->count() > 0)
                            <div class="space-y-3">
                                @foreach($siswaList as $siswa)
                                    <div class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-user text-green-600 text-sm"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $siswa->nama }}</p>
                                                <p class="text-xs text-gray-500">{{ $siswa->nis }} • {{ $siswa->kelas }}</p>
                                            </div>
                                        </div>
                                        @if($menuPermission && $menuPermission->can_update)
                                            <form action="{{ route('ekstrakurikuler.remove-siswa', $ekstrakurikuler) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Yakin hapus siswa ini dari ekstrakurikuler?')">
                                                <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-users text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">Belum ada siswa yang terdaftar</p>
                            </div>
                        @endif
                    </div>
                    </div>

                <!-- Form Tambah Siswa -->
                @if($menuPermission && $menuPermission->can_update && $availableSiswa->count() > 0)
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-user-plus text-blue-600"></i>
                            Tambah Siswa Baru
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('ekstrakurikuler.add-siswa', $ekstrakurikuler) }}" method="POST" class="space-y-4">
                                @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Siswa:</label>
                                <select name="siswa_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($availableSiswa as $siswa)
                                        <option value="{{ $siswa->id }}">{{ $siswa->nama }} ({{ $siswa->nis }}) - {{ $siswa->kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <i class="fas fa-plus"></i>
                                    Tambah Siswa
                                </button>
                            </form>
                    </div>
                </div>
                @elseif($availableSiswa->count() == 0)
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-info-circle text-gray-600"></i>
                            Status Siswa
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-green-400 text-3xl mb-3"></i>
                            <p class="text-gray-600 font-medium">Semua siswa sudah terdaftar!</p>
                            <p class="text-sm text-gray-500 mt-1">Tidak ada siswa yang tersedia untuk ditambahkan</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 