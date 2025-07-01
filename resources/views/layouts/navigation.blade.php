<div x-data="{ sidebarOpen: true }" class="flex flex-col h-full bg-white border-r border-gray-200 shadow-sm">
    <!-- Toggle Button -->
    <button @click="sidebarOpen = !sidebarOpen" class="absolute top-4 left-4 z-20 bg-blue-600 text-white rounded-full p-2 shadow-md focus:outline-none md:hidden">
        <i :class="sidebarOpen ? 'fas fa-times' : 'fas fa-bars'"></i>
    </button>
    <div :class="sidebarOpen ? 'block' : 'hidden'" class="md:block flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <!-- Header kosong, tanpa icon, tanpa tulisan -->
        </div>

        <!-- Menu Navigasi -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 bg-gray-50">
            @php
                $userRole = Auth::user()->role ?? '';
                $menus = \App\Models\MenuPermission::where('is_active', 1)
                    ->where('role', $userRole)
                    ->orderBy('order')
                    ->get();
            @endphp
            <ul class="space-y-2">
                @forelse($menus as $menu)
                    @if($menu->menu_route && Route::has($menu->menu_route))
                        <li>
                            <a href="{{ route($menu->menu_route) }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-white hover:text-blue-600 hover:shadow-sm {{ request()->routeIs($menu->menu_route) ? 'bg-white text-blue-600 shadow-sm font-bold' : '' }}">
                                @if($menu->menu_icon)
                                    <i class="fas fa-{{ $menu->menu_icon }} text-gray-500"></i>
                                @endif
                                <span class="text-sm font-medium">{{ $menu->menu_name }}</span>
                            </a>
                        </li>
                    @endif
                @empty
                    <li>
                        <span class="text-gray-400 text-sm">Tidak ada menu untuk role ini.</span>
                    </li>
                @endforelse
            </ul>
        </nav>
    </div>
</div> 