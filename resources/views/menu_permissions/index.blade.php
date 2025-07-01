@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-shield-alt text-blue-600"></i>
                    Manajemen Menu Permissions
                </h1>
                <a href="{{ route('menu-permissions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus"></i>
                    Tambah Menu
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Menu</p>
                            <p class="text-2xl font-bold text-blue-900">{{ collect($menus)->flatten()->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Aktif</p>
                            <p class="text-2xl font-bold text-green-900">{{ collect($menus)->flatten()->where('is_active', 1)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-purple-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-600">Role</p>
                            <p class="text-2xl font-bold text-purple-900">{{ count($menus) }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-key text-orange-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-orange-600">Permissions</p>
                            <p class="text-2xl font-bold text-orange-900">{{ collect($menus)->flatten()->sum(function($menu) { return ($menu->can_create ? 1 : 0) + ($menu->can_read ? 1 : 0) + ($menu->can_update ? 1 : 0) + ($menu->can_delete ? 1 : 0); }) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Permissions by Role -->
            <div class="space-y-6">
                @foreach($menus as $role => $roleMenus)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if($role === 'admin')
                                        <i class="fas fa-user-shield text-purple-600 text-xl"></i>
                                    @elseif($role === 'guru')
                                        <i class="fas fa-chalkboard-teacher text-green-600 text-xl"></i>
                                    @elseif($role === 'siswa')
                                        <i class="fas fa-user-graduate text-orange-600 text-xl"></i>
                                    @else
                                        <i class="fas fa-user text-blue-600 text-xl"></i>
                                    @endif
                                    <h2 class="text-xl font-semibold text-gray-800 capitalize">{{ ucfirst($role) }}</h2>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ count($roleMenus) }} menu
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">Aktif: {{ $roleMenus->where('is_active', 1)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($roleMenus as $menu)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                                    {{ $menu->order }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($menu->menu_icon)
                                                        <i class="{{ $menu->menu_icon }} text-gray-400 mr-3 w-5 h-5"></i>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">{{ $menu->menu_label }}</div>
                                                        <div class="text-sm text-gray-500">{{ $menu->menu_name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <code class="bg-gray-100 px-2 py-1 rounded text-xs font-mono">{{ $menu->menu_route }}</code>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($menu->menu_icon)
                                                    <i class="{{ $menu->menu_icon }} text-lg text-gray-600"></i>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex flex-wrap gap-1">
                                                    @if($menu->can_create)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="fas fa-plus mr-1"></i>Create
                                                        </span>
                                                    @endif
                                                    @if($menu->can_read)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            <i class="fas fa-eye mr-1"></i>Read
                                                        </span>
                                                    @endif
                                                    @if($menu->can_update)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-edit mr-1"></i>Update
                                                        </span>
                                                    @endif
                                                    @if($menu->can_delete)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            <i class="fas fa-trash mr-1"></i>Delete
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $menu->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                                    {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('menu-permissions.edit', $menu) }}" 
                                                       class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50" 
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('menu-permissions.toggle-status', $menu) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-yellow-600 hover:text-yellow-900 p-1 rounded hover:bg-yellow-50" 
                                                                title="{{ $menu->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                            <i class="fas fa-toggle-{{ $menu->is_active ? 'on' : 'off' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('menu-permissions.destroy', $menu) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" 
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 