@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-basketball-ball"></i>
                Ekstrakurikuler Siswa - {{ $siswa->nama }}
            </h1>
            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Ekstrakurikuler yang Diikuti</h3>
                @if($siswa->ekstrakurikuler->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($siswa->ekstrakurikuler as $ekstrakurikuler)
                            <div class="border rounded-lg p-4 bg-gray-50 flex justify-between items-center">
                                <div>
                                    <h4 class="font-medium">{{ $ekstrakurikuler->nama }}</h4>
                                    <p class="text-sm text-gray-600">{{ $ekstrakurikuler->deskripsi }}</p>
                                </div>
                                <form action="{{ route('siswa.remove-ekstrakurikuler', $siswa) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="ekstrakurikuler_id" value="{{ $ekstrakurikuler->id }}">
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm flex items-center gap-1">
                                        <i class="fas fa-times"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Siswa belum mengikuti ekstrakurikuler apapun.</p>
                @endif
            </div>
            @if($availableEkstrakurikuler->count() > 0)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Tambah Ekstrakurikuler Baru</h3>
                    <form action="{{ route('siswa.add-ekstrakurikuler', $siswa) }}" method="POST" class="flex gap-4 flex-wrap">
                        @csrf
                        <div class="relative flex-1 min-w-[200px]">
                            <select name="ekstrakurikuler_id" class="appearance-none border border-gray-300 rounded px-3 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                                <option value="">Pilih Ekstrakurikuler</option>
                                @foreach($availableEkstrakurikuler as $ekstrakurikuler)
                                    <option value="{{ $ekstrakurikuler->id }}">{{ $ekstrakurikuler->nama }} - {{ $ekstrakurikuler->deskripsi }}</option>
                                @endforeach
                            </select>
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center gap-1">
                            <i class="fas fa-plus"></i> Tambah Ekstrakurikuler
                        </button>
                    </form>
                </div>
            @endif
            <div class="mt-6">
                <a href="{{ route('siswa.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-1">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siswa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 