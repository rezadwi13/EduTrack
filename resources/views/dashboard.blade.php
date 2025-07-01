@extends('layouts.app')

@section('content')
<main>
    @php $role = $role ?? auth()->user()->role; @endphp
    @if($role === 'admin')
        <!-- Header Welcome -->
        <div class="relative mb-10">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 opacity-10 rounded-2xl"></div>
            <div class="relative z-10 text-center py-8">
                <h1 class="text-4xl md:text-5xl font-extrabold text-blue-700 mb-2 drop-shadow-lg">Selamat datang, Admin!</h1>
                <p class="text-lg text-gray-600">Kelola data sekolah dengan mudah dan modern.</p>
            </div>
        </div>
        <!-- Statistik Card -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="flex flex-col items-center p-6 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl shadow-lg hover:scale-105 transition-transform group">
                <i class="fas fa-user-graduate text-4xl text-blue-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <div class="text-3xl font-extrabold text-blue-800">{{ \App\Models\Siswa::count() }}</div>
                <div class="text-sm text-blue-700">Total Siswa</div>
            </div>
            <div class="flex flex-col items-center p-6 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl shadow-lg hover:scale-105 transition-transform group">
                <i class="fas fa-chalkboard-teacher text-4xl text-green-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <div class="text-3xl font-extrabold text-green-800">{{ \App\Models\User::where('role', 'guru')->count() }}</div>
                <div class="text-sm text-green-700">Total Guru</div>
            </div>
            <div class="flex flex-col items-center p-6 bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-2xl shadow-lg hover:scale-105 transition-transform group">
                <i class="fas fa-book text-4xl text-yellow-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <div class="text-3xl font-extrabold text-yellow-800">{{ \App\Models\MataPelajaran::count() }}</div>
                <div class="text-sm text-yellow-700">Mata Pelajaran</div>
            </div>
            <div class="flex flex-col items-center p-6 bg-gradient-to-br from-purple-100 to-purple-50 rounded-2xl shadow-lg hover:scale-105 transition-transform group">
                <i class="fas fa-futbol text-4xl text-purple-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <div class="text-3xl font-extrabold text-purple-800">{{ \App\Models\Ekstrakurikuler::count() }}</div>
                <div class="text-sm text-purple-700">Ekstrakurikuler</div>
            </div>
        </div>
        <!-- Fitur -->
        <div class="bg-white rounded-2xl shadow p-8">
            <h2 class="text-xl font-bold mb-6 text-gray-800 flex items-center gap-2">
                <i class="fas fa-cogs text-blue-500"></i> Fitur yang Tersedia
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg">
                    <i class="fas fa-users-cog text-2xl text-blue-400"></i>
                    <span class="font-medium text-gray-700">Manajemen User (Admin, Guru, Siswa)</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-green-50 rounded-lg">
                    <i class="fas fa-user-graduate text-2xl text-green-400"></i>
                    <span class="font-medium text-gray-700">Data Siswa dan Nilai</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-yellow-50 rounded-lg">
                    <i class="fas fa-calendar-alt text-2xl text-yellow-400"></i>
                    <span class="font-medium text-gray-700">Jadwal Pelajaran</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-purple-50 rounded-lg">
                    <i class="fas fa-book text-2xl text-purple-400"></i>
                    <span class="font-medium text-gray-700">Mata Pelajaran</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-pink-50 rounded-lg">
                    <i class="fas fa-futbol text-2xl text-pink-400"></i>
                    <span class="font-medium text-gray-700">Ekstrakurikuler</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-indigo-50 rounded-lg">
                    <i class="fas fa-bullhorn text-2xl text-indigo-400"></i>
                    <span class="font-medium text-gray-700">Pengumuman</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                    <i class="fas fa-images text-2xl text-gray-400"></i>
                    <span class="font-medium text-gray-700">Galeri</span>
                </div>
            </div>
        </div>
    @elseif($role === 'siswa')
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-100 to-indigo-100 rounded-2xl p-8 shadow text-center">
                <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Selamat datang, {{ auth()->user()->name }}!</h1>
                <p class="text-lg text-gray-600">Dashboard Siswa - pantau aktivitas dan perkembanganmu di sini.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Jadwal Hari Ini -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-bold text-blue-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-day"></i> Jadwal Hari Ini
                </h2>
                @php
                    $hariIni = \Illuminate\Support\Str::ucfirst(now()->locale('id')->isoFormat('dddd'));
                    $siswa = \App\Models\Siswa::where('user_id', auth()->id())->first();
                    $jadwalHariIni = collect();
                    if ($siswa) {
                        $jadwalHariIni = \App\Models\JadwalPelajaran::with('mataPelajaran', 'guru')
                            ->where('kelas', $siswa->kelas)
                            ->where('hari', $hariIni)
                            ->orderBy('jam_mulai')
                            ->get();
                    }
                @endphp
                @if($jadwalHariIni->count() > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($jadwalHariIni as $jadwal)
                            <li class="py-2 flex items-center gap-3">
                                <span class="font-semibold text-blue-600">{{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }}</span>
                                <span class="flex-1">{{ $jadwal->mataPelajaran->nama }}</span>
                                <span class="text-sm text-gray-500">{{ $jadwal->guru->name ?? '-' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-500 text-center py-6">
                        Tidak ada jadwal hari ini.
                    </div>
                @endif
            </div>
            <!-- Ringkasan Nilai -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-bold text-green-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-line"></i> Ringkasan Nilai
                </h2>
                @php
                    $nilaiList = collect();
                    $rataRata = null;
                    if ($siswa) {
                        $nilaiList = \App\Models\Nilai::where('siswa_id', $siswa->id)->get();
                        if ($nilaiList->count() > 0) {
                            $rataRata = round($nilaiList->avg('nilai'), 2);
                        }
                    }
                @endphp
                @if($nilaiList->count() > 0)
                    <div class="flex items-center gap-4 mb-2">
                        <div class="text-3xl font-bold text-green-600">{{ $rataRata }}</div>
                        <div class="text-gray-600">Rata-rata Nilai</div>
                    </div>
                    <div class="text-sm text-gray-500">Total Mata Pelajaran: {{ $nilaiList->unique('mata_pelajaran_id')->count() }}</div>
                @else
                    <div class="text-gray-500 text-center py-6">
                        Belum ada nilai yang tercatat.
                    </div>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <!-- Ekstrakurikuler Diikuti -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-bold text-purple-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-futbol"></i> Ekstrakurikuler Diikuti
                </h2>
                @php
                    $ekstraDiikuti = collect();
                    if ($siswa) {
                        $ekstraDiikuti = $siswa->ekstrakurikulers;
                    }
                @endphp
                @if($ekstraDiikuti->count() > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($ekstraDiikuti as $ekstra)
                            <li class="py-2 flex items-center gap-3">
                                <span class="font-semibold text-purple-600">{{ $ekstra->nama }}</span>
                                <span class="text-sm text-gray-500">{{ $ekstra->pembina ?? '-' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-500 text-center py-6">
                        Belum mengikuti ekstrakurikuler apapun.
                    </div>
                @endif
            </div>
            <!-- Info Pengumuman Terbaru -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-bold text-indigo-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-bullhorn"></i> Pengumuman Terbaru
                </h2>
                @php
                    $pengumumanTerbaru = \App\Models\Pengumuman::where('status', 'Aktif')->latest()->take(3)->get();
                @endphp
                @if($pengumumanTerbaru->count() > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($pengumumanTerbaru as $pengumuman)
                            <li class="py-2">
                                <div class="font-semibold text-indigo-700">{{ $pengumuman->judul }}</div>
                                <div class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($pengumuman->isi, 60) }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $pengumuman->created_at->format('d M Y') }}</div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-500 text-center py-6">
                        Tidak ada pengumuman terbaru.
                    </div>
                @endif
            </div>
        </div>
    @elseif($role === 'guru')
        <div class="mb-8">
            <div class="bg-gradient-to-r from-green-100 to-blue-100 rounded-2xl p-8 shadow text-center">
                <h1 class="text-3xl md:text-4xl font-extrabold text-green-700 mb-2">Selamat datang, {{ auth()->user()->name }}!</h1>
                <p class="text-lg text-gray-600">Dashboard Guru - pantau aktivitas mengajar dan info penting di sini.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="flex flex-col items-center p-6 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl shadow-lg">
                <i class="fas fa-user-graduate text-3xl text-blue-600 mb-2"></i>
                <div class="text-2xl font-extrabold text-blue-800">
                    {{ \App\Models\JadwalPelajaran::where('guru_id', auth()->id())->distinct('kelas')->count('kelas') }}
                </div>
                <div class="text-sm text-blue-700">Kelas Diampu</div>
            </div>
            <div class="flex flex-col items-center p-6 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl shadow-lg">
                <i class="fas fa-book text-3xl text-green-600 mb-2"></i>
                <div class="text-2xl font-extrabold text-green-800">
                    {{ \App\Models\JadwalPelajaran::where('guru_id', auth()->id())->distinct('mata_pelajaran_id')->count('mata_pelajaran_id') }}
                </div>
                <div class="text-sm text-green-700">Mapel Diampu</div>
            </div>
            <div class="flex flex-col items-center p-6 bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-2xl shadow-lg">
                <i class="fas fa-calendar-day text-3xl text-yellow-600 mb-2"></i>
                <div class="text-2xl font-extrabold text-yellow-800">
                    {{ \App\Models\JadwalPelajaran::where('guru_id', auth()->id())->where('hari', \Illuminate\Support\Str::ucfirst(now()->locale('id')->isoFormat('dddd')))->count() }}
                </div>
                <div class="text-sm text-yellow-700">Jadwal Hari Ini</div>
            </div>
            <div class="flex flex-col items-center p-6 bg-gradient-to-br from-purple-100 to-purple-50 rounded-2xl shadow-lg">
                <i class="fas fa-users text-3xl text-purple-600 mb-2"></i>
                <div class="text-2xl font-extrabold text-purple-800">
                    {{ \App\Models\Siswa::whereIn('kelas', \App\Models\JadwalPelajaran::where('guru_id', auth()->id())->pluck('kelas'))->count() }}
                </div>
                <div class="text-sm text-purple-700">Total Siswa</div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Jadwal Hari Ini -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-bold text-blue-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-day"></i> Jadwal Mengajar Hari Ini
                </h2>
                @php
                    $hariIni = \Illuminate\Support\Str::ucfirst(now()->locale('id')->isoFormat('dddd'));
                    $jadwalHariIni = \App\Models\JadwalPelajaran::with('mataPelajaran')
                        ->where('guru_id', auth()->id())
                        ->where('hari', $hariIni)
                        ->orderBy('jam_mulai')
                        ->get();
                @endphp
                @if($jadwalHariIni->count() > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($jadwalHariIni as $jadwal)
                            <li class="py-2 flex items-center gap-3">
                                <span class="font-semibold text-blue-600">{{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }}</span>
                                <span class="flex-1">{{ $jadwal->mataPelajaran->nama }}</span>
                                <span class="text-sm text-gray-500">{{ $jadwal->kelas }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-500 text-center py-6">
                        Tidak ada jadwal mengajar hari ini.
                    </div>
                @endif
            </div>
            <!-- Pengumuman Terbaru -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-bold text-indigo-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-bullhorn"></i> Pengumuman Terbaru
                </h2>
                @php
                    $pengumumanTerbaru = \App\Models\Pengumuman::where('status', 'Aktif')->latest()->take(3)->get();
                @endphp
                @if($pengumumanTerbaru->count() > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($pengumumanTerbaru as $pengumuman)
                            <li class="py-2">
                                <div class="font-semibold text-indigo-700">{{ $pengumuman->judul }}</div>
                                <div class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($pengumuman->isi, 60) }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $pengumuman->created_at->format('d M Y') }}</div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-500 text-center py-6">
                        Tidak ada pengumuman terbaru.
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="text-center py-16">
            <h1 class="text-3xl font-bold text-blue-700 mb-4">Selamat datang di EduTrack!</h1>
            <p class="text-lg text-gray-600">Silakan akses menu sesuai role Anda.</p>
        </div>
    @endif
</main>
@endsection