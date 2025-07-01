<section class="space-y-6">
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <div class="w-5 h-5 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fas fa-exclamation-triangle text-white text-xs"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-red-800">
                    Zona Bahaya
                </p>
                <p class="text-sm text-red-700 mt-1">
                    Jika Anda menghapus akun, semua data dan sumber daya akan dihapus secara permanen. Pastikan Anda telah mengunduh data penting sebelum melanjutkan.
                </p>
            </div>
        </div>
    </div>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 rounded-xl px-6 py-3 font-bold shadow-sm"
    >
        <i class="fas fa-trash-alt mr-2"></i>
        Hapus Akun
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">
                        Konfirmasi Hapus Akun
                    </h2>
                    <p class="text-sm text-gray-600">
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <p class="text-sm text-red-800">
                    Jika Anda menghapus akun, semua data dan sumber daya akan dihapus secara permanen. Masukkan password Anda untuk konfirmasi penghapusan akun.
                </p>
            </div>

            <div class="space-y-4">
                <div>
                    <x-input-label for="password" value="Password" class="font-bold text-gray-700" />
                    <div class="relative mt-2">
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="block w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 pr-10"
                            placeholder="Masukkan password Anda untuk konfirmasi"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-gray-400"></i>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-yellow-600 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-bold text-yellow-800">Sebelum menghapus akun:</p>
                            <ul class="text-sm text-yellow-700 mt-2 space-y-1">
                                <li>• Unduh data penting Anda</li>
                                <li>• Batalkan langganan aktif (jika ada)</li>
                                <li>• Tindakan ini tidak dapat dibatalkan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-6 py-3 font-bold">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </x-secondary-button>

                <x-danger-button class="bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 rounded-xl px-6 py-3 font-bold shadow-sm">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Hapus Akun
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
