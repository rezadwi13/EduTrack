<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-5xl min-h-[500px] bg-white rounded-xl shadow-2xl py-14 px-8 flex flex-col items-center justify-center">
            <!-- Logo dan Nama Aplikasi di dalam form -->
            <div class="flex items-center gap-3 mb-6">
                <h1 class="text-2xl font-extrabold text-[#FF2D20] tracking-tight flex items-center">EduTrack</h1>
            </div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="w-full">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Captcha -->
                <div class="mt-4 w-full">
                    <div class="flex flex-col items-center w-full">
                        <div class="flex items-center gap-2 mb-2">
                            <img src="{{ route('captcha') }}" alt="captcha" class="rounded w-32 h-10" id="captcha-img">
                        </div>
                        <div class="relative w-full">
                            <x-text-input id="captcha" class="block mt-2 w-full pr-10" type="text" name="captcha" required autocomplete="off" placeholder="Masukkan kode di atas" />
                            <button type="button" id="refresh-captcha" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 text-gray-500 hover:text-[#FF2D20]" title="Refresh Captcha">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12a7.5 7.5 0 0112.9-5.3l.6.6M19.5 12a7.5 7.5 0 01-12.9 5.3l-.6-.6M16.5 7.5V3h-4.5" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('captcha')" class="mt-2" />
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#FF2D20] shadow-sm focus:ring-[#FF2D20]" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="mt-6 w-full">
                    <button type="submit" class="w-full px-6 py-2 rounded-lg bg-[#FF2D20] text-white font-bold shadow hover:bg-red-600 transition text-base flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" /></svg>
                        Log In
                    </button>
                </div>
            </form>
            <a href="/" class="mt-4 w-full block text-center px-6 py-2 rounded-lg bg-white border border-[#FF2D20] text-[#FF2D20] font-bold shadow hover:bg-gray-100 transition text-base flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Kembali ke Web
            </a>
        </div>
    </div>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var refreshBtn = document.getElementById('refresh-captcha');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function() {
                var captchaImg = document.getElementById('captcha-img');
                captchaImg.src = "{{ route('captcha') }}?" + Date.now();
            });
        }
    });
</script>
