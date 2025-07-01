@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-user text-blue-600"></i>
                    Detail User
                </h1>
                <div class="flex flex-wrap gap-2">
                    @if($menuPermission && $menuPermission->can_update)
                    <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        <i class="fas fa-edit"></i>
                        Edit User
                    </a>
                    @endif
                    <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
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
                        Informasi User
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama:</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                            <p class="text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role:</label>
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-user-shield mr-1"></i>
                                    Admin
                                </span>
                            @elseif($user->role === 'guru')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-chalkboard-teacher mr-1"></i>
                                    Guru
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    <i class="fas fa-user-graduate mr-1"></i>
                                    Siswa
                                </span>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
                            @if($user->id === auth()->id())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-user mr-1"></i>
                                    Akun Anda
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Aktif
                                </span>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bergabung Sejak:</label>
                            <p class="text-sm text-gray-500">{{ $user->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-blue-600"></i>
                        Informasi Terkait
                    </h3>
                    <div class="space-y-4">
                        @if($user->role === 'guru' && $user->guru)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Data Guru:</label>
                            <div class="bg-white rounded p-3">
                                <p class="text-sm font-medium text-gray-900">{{ $user->guru->nama }}</p>
                                <p class="text-xs text-gray-500">NIP: {{ $user->guru->nip }}</p>
                                @if($user->guru->mata_pelajaran)
                                    <p class="text-xs text-gray-500">Mata Pelajaran: {{ $user->guru->mata_pelajaran }}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($user->role === 'siswa' && $user->siswa)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Data Siswa:</label>
                            <div class="bg-white rounded p-3">
                                <p class="text-sm font-medium text-gray-900">{{ $user->siswa->nama }}</p>
                                <p class="text-xs text-gray-500">NIS: {{ $user->siswa->nis }}</p>
                                <p class="text-xs text-gray-500">Kelas: {{ $user->siswa->kelas }}</p>
                            </div>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Aktivitas:</label>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="bg-white rounded p-2 text-center">
                                    <p class="font-medium text-blue-600">{{ $user->pengumuman->count() }}</p>
                                    <p class="text-xs text-gray-500">Pengumuman</p>
                                </div>
                                <div class="bg-white rounded p-2 text-center">
                                    <p class="font-medium text-green-600">{{ $user->galeri->count() }}</p>
                                    <p class="text-xs text-gray-500">Galeri</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->pengumuman->count() > 0)
            <div class="bg-white border border-gray-200 rounded-lg mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-bullhorn text-purple-600"></i>
                        Pengumuman Dibuat ({{ $user->pengumuman->count() }})
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($user->pengumuman->take(5) as $pengumuman)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pengumuman->judul }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pengumuman->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>
                                        Aktif
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if($menuPermission && $menuPermission->can_delete && $user->id !== auth()->id())
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-end">
                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                            <i class="fas fa-trash-alt"></i>
                            Hapus User
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 