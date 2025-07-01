<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="update_password_current_password" :value="'Password Lama'" class="font-bold text-gray-700" />
                <div class="relative mt-2">
                    <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 pr-10" autocomplete="current-password" placeholder="Masukkan password lama Anda" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="fas fa-eye text-gray-400"></i>
                    </div>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="'Password Baru'" class="font-bold text-gray-700" />
                <div class="relative mt-2">
                    <x-text-input id="update_password_password" name="password" type="password" class="block w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 pr-10" autocomplete="new-password" placeholder="Masukkan password baru" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="fas fa-eye text-gray-400"></i>
                    </div>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="'Konfirmasi Password Baru'" class="font-bold text-gray-700" />
            <div class="relative mt-2">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 pr-10" autocomplete="new-password" placeholder="Ulangi password baru Anda" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <i class="fas fa-eye text-gray-400"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Password Strength Indicator -->
        <div class="bg-gray-50 rounded-xl p-4">
            <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                <i class="fas fa-shield-alt text-gray-600"></i>
                Syarat Password
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-600">Minimal 8 karakter</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-600">Gabungan huruf dan angka</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-600">Mengandung karakter khusus</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-600">Berbeda dengan password lama</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
            <x-primary-button class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 rounded-xl px-6 py-3 font-bold shadow-sm">
                <i class="fas fa-key mr-2"></i>
                Ubah Password
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-200 rounded-lg"
                >
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span class="text-sm font-medium text-green-800">Password berhasil diubah!</span>
                </div>
            @endif
        </div>
    </form>
</section>
