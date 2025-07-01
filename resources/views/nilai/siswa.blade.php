@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Nilai Saya</h1>
                <p class="text-gray-600 mt-1">Informasi nilai akademik {{ $siswa->nama }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">NIS</p>
                <p class="text-lg font-semibold text-gray-900">{{ $siswa->nis }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Nilai Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Nilai</p>
                    <p class="text-3xl font-bold">{{ $nilais->count() }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 p-3 rounded-full">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Rata-rata Keseluruhan Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Rata-rata</p>
                    <p class="text-3xl font-bold">{{ number_format($rataRataKeseluruhan, 1) }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 p-3 rounded-full">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Semester Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Semester</p>
                    <p class="text-3xl font-bold">{{ $nilais->unique('semester')->count() }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 p-3 rounded-full">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Rata-rata per Semester -->
    @if($rataRataPerSemester->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-chart-bar text-indigo-500 mr-2"></i>
            Rata-rata Nilai per Semester
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($rataRataPerSemester as $semester => $rata)
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm font-medium text-gray-600">Semester {{ $semester }}</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($rata, 1) }}</p>
                <div class="mt-2">
                    @if($rata >= 85)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-star mr-1"></i> Sangat Baik
                        </span>
                    @elseif($rata >= 75)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-thumbs-up mr-1"></i> Baik
                        </span>
                    @elseif($rata >= 65)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-check mr-1"></i> Cukup
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Perlu Perbaikan
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Detail Nilai -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-list text-gray-500 mr-2"></i>
            Detail Nilai
        </h3>
        
        @if($nilais->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($nilais as $nilai)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-book text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $nilai->mataPelajaran->nama }}</div>
                                        <div class="text-sm text-gray-500">{{ $nilai->mataPelajaran->kode }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Semester {{ $nilai->semester }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-2xl font-bold 
                                    @if($nilai->nilai >= 85) text-green-600
                                    @elseif($nilai->nilai >= 75) text-blue-600
                                    @elseif($nilai->nilai >= 65) text-yellow-600
                                    @else text-red-600
                                    @endif">
                                    {{ $nilai->nilai }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($nilai->nilai >= 85)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-star mr-1"></i> Sangat Baik
                                    </span>
                                @elseif($nilai->nilai >= 75)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-thumbs-up mr-1"></i> Baik
                                    </span>
                                @elseif($nilai->nilai >= 65)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-check mr-1"></i> Cukup
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Perlu Perbaikan
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-clipboard-list text-gray-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada nilai</h3>
                <p class="text-gray-500">Nilai akan ditampilkan setelah guru menginput nilai Anda.</p>
            </div>
        @endif
    </div>
</div>
@endsection 
 