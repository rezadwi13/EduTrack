@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            <i class="fas fa-book text-blue-600 mr-2"></i>
                            Daftar Siswa - {{ $mataPelajaran->nama }}
                        </h2>
                        <p class="text-gray-600 mt-1">
                            Mata Pelajaran: {{ $mataPelajaran->nama }} ({{ $mataPelajaran->kode }})
                        </p>
                    </div>
                    <a href="{{ route('mata-pelajaran.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>

                <!-- Info Kelas -->
                @if(!empty($kelasList))
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            <div>
                                <h4 class="font-semibold text-blue-800">Kelas yang Diajar</h4>
                                <p class="text-blue-700 text-sm">
                                    Mata pelajaran ini diajar di kelas: 
                                    <span class="font-medium">{{ implode(', ', $kelasList) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Total Siswa</h3>
                                <p class="text-3xl font-bold">{{ $siswaList->count() }}</p>
                                <p class="text-blue-100 text-sm">Di kelas yang diajar</p>
                            </div>
                            <i class="fas fa-user-graduate text-4xl opacity-75"></i>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Kelas</h3>
                                <p class="text-3xl font-bold">{{ count($kelasList) }}</p>
                                <p class="text-green-100 text-sm">Yang diajar</p>
                            </div>
                            <i class="fas fa-graduation-cap text-4xl opacity-75"></i>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-lg text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Ekstrakurikuler</h3>
                                <p class="text-3xl font-bold">{{ $siswaList->flatMap->ekstrakurikulers->unique('id')->count() }}</p>
                                <p class="text-purple-100 text-sm">Yang diikuti siswa</p>
                            </div>
                            <i class="fas fa-futbol text-4xl opacity-75"></i>
                        </div>
                    </div>
                </div>

                <!-- Tabel Siswa -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ekstrakurikuler</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($siswaList as $siswa)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $siswa->nama }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->nis }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($siswa->jenis_kelamin)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $siswa->jenis_kelamin === 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ $siswa->jenis_kelamin }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->kelas }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($siswa->ekstrakurikulers->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($siswa->ekstrakurikulers->take(2) as $ekstra)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $ekstra->nama }}
                                                </span>
                                            @endforeach
                                            @if($siswa->ekstrakurikulers->count() > 2)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    +{{ $siswa->ekstrakurikulers->count() - 2 }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('siswa.show', $siswa) }}" class="text-green-600 hover:text-green-900" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('siswa.edit', $siswa) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center py-8">
                                        <i class="fas fa-user-graduate text-gray-400 text-4xl mb-2"></i>
                                        <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada siswa</p>
                                        <p class="text-gray-500">
                                            Belum ada siswa di kelas yang diajar untuk mata pelajaran ini.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 