<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'EduTrack') }}</title>
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Figtree', 'Inter', 'Nunito', sans-serif; }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-900">
        <!-- Professional Header/Navbar -->
        <header class="fixed top-0 left-0 w-full z-50 bg-white border-b border-gray-200 shadow-sm">
            <div class="flex items-center justify-between h-16 px-4 md:px-6">
                <!-- Left Section: Hamburger + Branding -->
                <div class="flex items-center gap-4">
                    <!-- Hamburger menu (mobile only) -->
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 md:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <!-- Branding -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="font-bold text-xl text-gray-900">EduTrack</h1>
                            <p class="text-xs text-gray-600 font-medium">School Management System</p>
                        </div>
                    </div>
                </div>

                <!-- Center Section: Breadcrumb (hidden on mobile) -->
                <div class="hidden lg:flex items-center">
                    <nav class="flex items-center space-x-2 text-sm text-gray-600">
                        <span class="font-bold text-gray-900">{{ ucfirst(auth()->user()->role) }}</span>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                        <span class="text-gray-600 font-medium">{{ ucfirst(request()->segment(1) ?: 'Dashboard') }}</span>
                    </nav>
                </div>

                <!-- Right Section: User Dropdown Only -->
                <div class="flex items-center gap-3">
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center shadow-sm">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                                <p class="text-xs text-gray-600 capitalize font-medium">{{ Auth::user()->role ?? 'Admin' }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-50" 
                             x-cloak>
                            <div class="p-4 border-b border-gray-100">
                                <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                                <p class="text-xs text-gray-600">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <i class="fas fa-user-edit w-4 h-4"></i>
                                    Profil Saya
                                </a>
                                <a href="{{ route('profile.edit') }}#ubah-password" 
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <i class="fas fa-key w-4 h-4"></i>
                                    Ubah Password
                                </a>
                                <div class="border-t border-gray-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt w-4 h-4"></i>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Overlay untuk mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             class="fixed inset-0 bg-black bg-opacity-30 z-20 md:hidden" 
             x-cloak></div>

        <!-- Professional Sidebar -->
        <aside :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', 'md:translate-x-0']" 
               class="fixed top-16 left-0 z-30 w-64 h-[calc(100vh-4rem)] transform transition-transform duration-200 ease-in-out shadow-lg">
            @include('layouts.navigation')
        </aside>

        <!-- Main Content -->
        <div class="min-h-screen flex flex-col transition-all duration-200 md:pl-64" style="padding-top:4rem;">
            <main class="flex-1 p-6 md:p-8 overflow-y-auto">
                @isset($header)
                    <div class="mb-8">
                        {{ $header }}
                    </div>
    @endisset

        {{ $slot }}
    </main>
</div> 

        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </body>
</html> 