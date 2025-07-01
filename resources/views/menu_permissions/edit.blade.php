@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('menu-permissions.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Menu Permission</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('menu-permissions.update', $menuPermission) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="menu_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Menu</label>
                        <input type="text" name="menu_name" id="menu_name" value="{{ old('menu_name', $menuPermission->menu_name) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('menu_name') border-red-500 @enderror" 
                               placeholder="Contoh: dashboard">
                        @error('menu_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="menu_label" class="block text-sm font-medium text-gray-700 mb-2">Label Menu</label>
                        <input type="text" name="menu_label" id="menu_label" value="{{ old('menu_label', $menuPermission->menu_label) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('menu_label') border-red-500 @enderror" 
                               placeholder="Contoh: Dashboard">
                        @error('menu_label')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="menu_route" class="block text-sm font-medium text-gray-700 mb-2">Route</label>
                        <input type="text" name="menu_route" id="menu_route" value="{{ old('menu_route', $menuPermission->menu_route) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('menu_route') border-red-500 @enderror" 
                               placeholder="Contoh: dashboard">
                        @error('menu_route')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="menu_icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (FontAwesome)</label>
                        <input type="text" name="menu_icon" id="menu_icon" value="{{ old('menu_icon', $menuPermission->menu_icon) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('menu_icon') border-red-500 @enderror" 
                               placeholder="Contoh: fas fa-tachometer-alt">
                        @error('menu_icon')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select name="role" id="role" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('role', $menuPermission->role) == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $menuPermission->order) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('order') border-red-500 @enderror">
                        @error('order')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $menuPermission->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Menu Aktif</span>
                    </label>
                </div>

                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="can_create" value="1" {{ old('can_create', $menuPermission->can_create) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Create</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="can_read" value="1" {{ old('can_read', $menuPermission->can_read) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Read</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="can_update" value="1" {{ old('can_update', $menuPermission->can_update) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Update</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="can_delete" value="1" {{ old('can_delete', $menuPermission->can_delete) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Delete</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('menu-permissions.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 