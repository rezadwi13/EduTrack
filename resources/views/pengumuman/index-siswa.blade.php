@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-bullhorn"></i>
            Pengumuman
        </h1>
        <form method="GET" action="{{ route('pengumuman_siswa') }}" class="flex flex-wrap gap-2 mb-6 items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengumuman..." class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 flex-1" />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center gap-1">
                <i class="fas fa-search"></i> Cari
                            </button>
                            @if(request('search'))
                <a href="{{ route('pengumuman_siswa') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 flex items-center gap-1">
                    <i class="fas fa-times"></i> Reset
                                </a>
                            @endif
                        </form>
                    @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
                    @endif
                    @if($pengumumen->count() > 0)
                        <div class="grid gap-6">
                            @foreach($pengumumen as $pengumuman)
                    <div class="border border-gray-200 rounded-lg p-6 bg-white hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-bullhorn"></i>
                                            {{ $pengumuman->judul }}
                                        </h3>
                            <div class="text-sm text-gray-500">
                                            {{ $pengumuman->created_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                        <div class="text-gray-600 mb-4">
                            {!! nl2br(e(Str::limit($pengumuman->isi, 150))) !!}
                                    </div>
                        <div class="text-sm text-gray-500 mb-2">
                                        Oleh: {{ $pengumuman->user->name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                <p class="text-gray-500">Tidak ada pengumuman saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
@endsection 