@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-dumbbell text-blue-600 mr-2"></i>
                        Ekstrakurikuler
                    </h2>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($ekstrakurikulers as $ekstrakurikuler)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ $ekstrakurikuler->nama }}
                                    </h3>
                                    @if(isset($ekstraDiikuti) && is_array($ekstraDiikuti) && in_array($ekstrakurikuler->id, $ekstraDiikuti))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>
                                            Terdaftar
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ $ekstrakurikuler->deskripsi ?: 'Tidak ada deskripsi' }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $ekstrakurikuler->siswa->count() }} peserta
                                    </div>
                                    
                                    @if(isset($ekstraDiikuti) && is_array($ekstraDiikuti) && !in_array($ekstrakurikuler->id, $ekstraDiikuti))
                                        <form action="{{ route('ekstrakurikuler.siswa.daftar', $ekstrakurikuler->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <i class="fas fa-plus mr-1"></i>
                                                Daftar
                                            </button>
                                        </form>
                                    @elseif(isset($ekstraDiikuti) && is_array($ekstraDiikuti) && in_array($ekstrakurikuler->id, $ekstraDiikuti))
                                        <span class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-50">
                                            <i class="fas fa-check mr-1"></i>
                                            Sudah Terdaftar
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-12">
                                <i class="fas fa-dumbbell text-gray-400 text-4xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada ekstrakurikuler</h3>
                                <p class="text-gray-500">Belum ada ekstrakurikuler yang tersedia saat ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 