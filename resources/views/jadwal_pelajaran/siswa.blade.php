@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Jadwal Pelajaran</h1>
                @if($siswa)
                    <p class="text-gray-600 mt-1">Jadwal kelas {{ $siswa->kelas }} - {{ $siswa->nama }}</p>
                @else
                    <p class="text-gray-600 mt-1 text-red-500">Akun Anda belum terhubung ke data siswa. Silakan hubungi admin.</p>
                @endif
            </div>
            <div class="text-right flex flex-col items-end gap-2">
                <a href="{{ route('jadwal-pelajaran.export-pdf') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a>
                <p class="text-sm text-gray-500">Hari ini</p>
                <p class="text-lg font-semibold text-gray-900">{{ now()->format('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Today's Schedule Highlight -->
    @php
        $today = strtolower(now()->format('l'));
        $todaySchedule = $jadwalPerHari->get($today, collect());
    @endphp
    
    @if($todaySchedule->count() > 0)
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
        <h3 class="text-lg font-semibold mb-4 flex items-center">
            <i class="fas fa-calendar-day mr-2"></i>
            Jadwal Hari Ini ({{ ucfirst($today) }})
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($todaySchedule as $jadwal)
            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</span>
                    <div class="bg-white bg-opacity-30 p-1 rounded">
                        <i class="fas fa-clock text-xs"></i>
                    </div>
                </div>
                <h4 class="font-semibold text-lg">{{ $jadwal->mataPelajaran->nama }}</h4>
                <p class="text-blue-100 text-sm">{{ $jadwal->guru->name ?? 'Guru belum ditentukan' }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Weekly Schedule -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-calendar-week text-indigo-500 mr-2"></i>
            Jadwal Mingguan
        </h3>
        
        @if($jadwals->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($hariList as $hari)
                    @php
                        $jadwalHari = $jadwalPerHari->get($hari, collect());
                        $isToday = $hari === $today;
                    @endphp
                    
                    <div class="border border-gray-200 rounded-lg overflow-hidden {{ $isToday ? 'ring-2 ring-blue-500' : '' }}">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-900 flex items-center">
                                @if($isToday)
                                    <i class="fas fa-star text-yellow-500 mr-2"></i>
                                @endif
                                {{ ucfirst($hari) }}
                                @if($isToday)
                                    <span class="ml-2 text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Hari Ini</span>
                                @endif
                            </h4>
                        </div>
                        
                        @if($jadwalHari->count() > 0)
                            <div class="p-4 space-y-3">
                                @foreach($jadwalHari as $jadwal)
                                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="bg-blue-500 p-2 rounded-lg">
                                            <i class="fas fa-book text-white text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                <h5 class="font-medium text-gray-900 truncate">{{ $jadwal->mataPelajaran->nama }}</h5>
                                                <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600">{{ $jadwal->guru->name ?? 'Guru belum ditentukan' }}</p>
                                            <p class="text-xs text-gray-500">{{ $jadwal->mataPelajaran->kode }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-8 text-center text-gray-500">
                                <i class="fas fa-calendar-times text-2xl mb-2"></i>
                                <p class="text-sm">Tidak ada jadwal</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif($siswa)
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada jadwal</h3>
                <p class="text-gray-500">Belum ada jadwal untuk kelas {{ $siswa->kelas }}.</p>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada jadwal</h3>
                <p class="text-gray-500 text-red-500">Akun Anda belum terhubung ke data siswa. Silakan hubungi admin.</p>
            </div>
        @endif
    </div>

    <!-- Schedule Summary -->
    @if($jadwals->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-chart-pie text-green-500 mr-2"></i>
            Ringkasan Jadwal
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <p class="text-2xl font-bold text-blue-600">{{ $jadwals->count() }}</p>
                <p class="text-sm text-gray-600">Total Mata Pelajaran</p>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <p class="text-2xl font-bold text-green-600">{{ $jadwals->unique('mata_pelajaran_id')->count() }}</p>
                <p class="text-sm text-gray-600">Jenis Mata Pelajaran</p>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <p class="text-2xl font-bold text-purple-600">{{ $jadwals->unique('guru_id')->count() }}</p>
                <p class="text-sm text-gray-600">Guru Pengajar</p>
            </div>
            <div class="text-center p-4 bg-orange-50 rounded-lg">
                <p class="text-2xl font-bold text-orange-600">{{ $jadwals->unique('hari')->count() }}</p>
                <p class="text-sm text-gray-600">Hari Aktif</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 