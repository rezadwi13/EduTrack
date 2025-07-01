<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="'Nama Lengkap'" class="font-bold text-gray-700" />
                <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="'Alamat Email'" class="font-bold text-gray-700" />
                <x-text-input id="email" name="email" type="email" class="mt-2 block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" :value="old('email', $user->email)" required autocomplete="username" placeholder="Masukkan email aktif Anda" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div class="w-5 h-5 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-exclamation-triangle text-white text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-yellow-800">
                            Alamat email Anda belum diverifikasi.
                        </p>
                        <p class="text-sm text-yellow-700 mt-1">
                            Silakan verifikasi email Anda untuk mengakses semua fitur.
                        </p>
                        <button form="send-verification" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Ulang Email Verifikasi
                        </button>
                    </div>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="mt-3 bg-green-50 border border-green-200 rounded-lg p-3">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <p class="text-sm font-medium text-green-800">
                                Link verifikasi baru telah dikirim ke email Anda.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
            <x-primary-button class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl px-6 py-3 font-bold shadow-sm">
                <i class="fas fa-save mr-2"></i>
                Simpan Perubahan
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-200 rounded-lg"
                >
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span class="text-sm font-medium text-green-800">Profil berhasil diperbarui!</span>
                </div>
            @endif
        </div>
    </form>
</section>
