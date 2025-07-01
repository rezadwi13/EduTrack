<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EduTrack</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-white via-red-50 to-gray-100 min-h-screen flex items-center justify-center font-sans">
        <div class="w-full min-h-screen flex flex-col justify-center items-center">
            <div class="max-w-6xl w-full mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center px-4 py-12">
                <!-- Kiri: Info EduTrack -->
                <div class="flex flex-col items-start md:items-start">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">EduTrack</h1>
                    <h2 class="text-lg md:text-xl font-medium text-[#FF2D20] mb-4 tracking-wide">Sistem Informasi Manajemen Sekolah</h2>
                    <p class="text-gray-600 text-base md:text-lg mb-8 max-w-md leading-relaxed">
                        Platform digital modern untuk pengelolaan data siswa, guru, jadwal, nilai, ekstrakurikuler, dan pengumuman sekolah. EduTrack membantu sekolah menjadi lebih efisien, transparan, dan terintegrasi.
                    </p>
                </div>
                <!-- Kanan: Card Login -->
                <div class="flex justify-center items-center">
                    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md flex flex-col items-center">
                        <img src="image/logo.jpg" alt="EduTrack Logo" class="h-40 w-40">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Masuk ke Akun</h3>
                        <div class="bg-red-50 border border-[#FF2D20] text-[#FF2D20] rounded-md px-4 py-2 text-sm mb-6 text-center">
                            EduTrack menggunakan sistem keamanan modern. Silakan login untuk mengakses fitur sekolah digital.
                        </div>
                        @if (Route::has('login'))
                                @auth
                                <a href="{{ url('/dashboard') }}" class="w-full rounded-lg bg-[#FF2D20] text-white px-6 py-3 font-semibold shadow hover:bg-red-600 transition text-center text-lg mb-2">Dashboard</a>
                                @else
                                <a href="{{ route('login') }}" class="w-full rounded-lg bg-[#FF2D20] text-white px-6 py-3 font-semibold shadow hover:bg-red-600 transition text-center text-lg mb-2">Login</a>
                                @endauth
                        @endif
                        </div>
                </div>
            </div>
            <footer class="w-full text-center text-sm text-gray-500 py-6 mt-8">
                EduTrack &copy;2025
            </footer>
        </div>
        <!-- FontAwesome CDN for icons -->
        <script src="https://kit.fontawesome.com/4e9c8e6e5a.js" crossorigin="anonymous"></script>
    </body>
</html>
