<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pengumuman') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 text-green-600">{{ session('success') }}</div>
                    @endif
                    
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $pengumuman->judul }}</h2>
                        <div class="text-sm text-gray-500 mb-4">
                            <span>Dibuat oleh: {{ $pengumuman->user->name ?? 'Unknown' }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $pengumuman->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                    
                    <div class="prose max-w-none">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            {!! nl2br(e($pengumuman->isi)) !!}
                        </div>
                    </div>
                    
                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('pengumuman.edit', $pengumuman) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Pengumuman
                        </a>
                        <a href="{{ route('pengumuman.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali ke Daftar
                        </a>
                        <form action="{{ route('pengumuman.destroy', $pengumuman) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pengumuman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Hapus Pengumuman
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 