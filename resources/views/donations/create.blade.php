<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Donasi untuk: {{ $campaign->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-4 text-gray-600">
                    Target Dana: <strong>Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</strong><br>
                    Terkumpul: <strong>Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</strong>
                </div>

                <form method="POST" action="{{ route('donations.store', $campaign->id) }}">
                    @csrf
                    <div>
                        <x-input-label for="amount" :value="__('Nominal Donasi (Rp)')" />
                        <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" required autofocus placeholder="Contoh: 50000" />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div class="flex items-center mt-4">
                        <x-primary-button class="w-full justify-center bg-green-600 hover:bg-green-700">
                            {{ __('Kirim Donasi') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>