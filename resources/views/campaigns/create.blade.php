<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Campaign Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('campaigns.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="title" :value="__('Judul Campaign')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus placeholder="Contoh: Bantu Kucing Sakit" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category" :value="__('Kategori Campaign')" />
                        <select id="category" name="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Bencana Alam">Bencana Alam</option>
                            <option value="Sosial">Sosial</option>
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="target_amount" :value="__('Target Dana (Rp)')" />
                        <x-text-input id="target_amount" class="block mt-1 w-full" type="number" name="target_amount" required placeholder="Contoh: 1000000" />
                        <x-input-error :messages="$errors->get('target_amount')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="campaigner_fee_percentage" :value="__('Fee Operasional Campaigner (%)')" />
                        <x-text-input id="campaigner_fee_percentage" class="block mt-1 w-full" type="number" name="campaigner_fee_percentage" min="0" max="30" required placeholder="Contoh: 5 (untuk 5%)" />
                        <x-input-error :messages="$errors->get('campaigner_fee_percentage')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="description" :value="__('Deskripsi Detail')" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="5" required></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Ajukan Campaign') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>