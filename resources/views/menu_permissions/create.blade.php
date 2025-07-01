@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-plus text-blue-600"></i>
                    Tambah Menu Permission Baru
                </h1>
                <a href="{{ route('menu-permissions.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('menu-permissions.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <p class="text-sm text-blue-800">
                            Buat menu permission baru untuk mengatur akses pengguna berdasarkan role. Menu ini akan muncul di sidebar sesuai dengan role yang dipilih.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-tag mr-1"></i>
                            Nama Menu
                        </label>
                        <input type="text" 
                               name="menu_name" 
                               value="{{ old('menu_name') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="Contoh: dashboard"
                               required>
                        @error('menu_name')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-heading mr-1"></i>
                            Label Menu
                        </label>
                        <input type="text" 
                               name="menu_label" 
                               value="{{ old('menu_label') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="Contoh: Dashboard"
                               required>
                        @error('menu_label')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-route mr-1"></i>
                            Route
                        </label>
                        <input type="text" 
                               name="menu_route" 
                               value="{{ old('menu_route') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="Contoh: dashboard"
                               required>
                        @error('menu_route')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-icons mr-1"></i>
                            Icon (FontAwesome)
                        </label>
                        <input type="text" 
                               name="menu_icon" 
                               value="{{ old('menu_icon') }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                               placeholder="Contoh: fas fa-tachometer-alt">
                        @error('menu_icon')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-user-tag mr-1"></i>
                            Role
                        </label>
                        <select name="role" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                required>
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-sort-numeric-up mr-1"></i>
                            Urutan
                        </label>
                        <input type="number" 
                               name="order" 
                               value="{{ old('order', 0) }}" 
                               min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        @error('order')
                            <div class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Status Section -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-toggle-on text-gray-600"></i>
                        Status Menu
                    </h3>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Menu Aktif</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Menu yang tidak aktif tidak akan ditampilkan di sidebar.
                    </p>
                </div>

                <!-- Permissions Section -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-key text-yellow-600"></i>
                        Permissions (CRUD)
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="can_create" 
                                   value="1" 
                                   {{ old('can_create', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Create</span>
                                <p class="text-xs text-gray-500">Tambah data baru</p>
                            </div>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="can_read" 
                                   value="1" 
                                   {{ old('can_read', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Read</span>
                                <p class="text-xs text-gray-500">Lihat data</p>
                            </div>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="can_update" 
                                   value="1" 
                                   {{ old('can_update', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Update</span>
                                <p class="text-xs text-gray-500">Edit data</p>
                            </div>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="can_delete" 
                                   value="1" 
                                   {{ old('can_delete', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Delete</span>
                                <p class="text-xs text-gray-500">Hapus data</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Menu
                    </button>
                    <a href="{{ route('menu-permissions.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 