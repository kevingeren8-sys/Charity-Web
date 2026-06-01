<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-800 leading-tight">
            Mulai Berdonasi
        </h2>
    </x-slot>

    <div class="py-12 bg-stone-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <!-- Tombol Kembali -->
            <a href="{{ route('campaigns.show', $campaign->id) }}" class="inline-flex items-center text-sm font-medium text-stone-500 hover:text-stone-800 transition mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Detail Campaign
            </a>

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl p-8 lg:p-10 border border-stone-100 relative">
                
                <!-- Efek Background Hiasan -->
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-emerald-50 rounded-full blur-2xl opacity-70"></div>

                <!-- Info Singkat Campaign -->
                <div class="flex items-center gap-4 pb-6 border-b border-stone-100 mb-8 relative z-10">
                    @if($campaign->image)
                        <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-16 h-16 rounded-2xl object-cover shrink-0 shadow-sm">
                    @else
                        <div class="w-16 h-16 rounded-2xl bg-stone-100 flex items-center justify-center text-stone-400 shrink-0 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm font-bold text-emerald-600 mb-1">Anda akan berdonasi untuk:</p>
                        <h3 class="text-lg font-extrabold text-stone-900 leading-tight line-clamp-2">{{ $campaign->title }}</h3>
                    </div>
                </div>

                <!-- Form Donasi -->
                <form method="POST" action="{{ route('donations.store', $campaign->id) }}" id="donation-form" class="relative z-10">
                    @csrf

                    <!-- Pilihan Nominal Cepat -->
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-stone-700 mb-3">Pilih Nominal Donasi</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <button type="button" onclick="setAmount(10000)" class="py-3 px-4 border border-stone-200 rounded-xl text-stone-700 font-bold hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 active:scale-95">Rp 10.000</button>
                            <button type="button" onclick="setAmount(20000)" class="py-3 px-4 border border-stone-200 rounded-xl text-stone-700 font-bold hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 active:scale-95">Rp 20.000</button>
                            <button type="button" onclick="setAmount(50000)" class="py-3 px-4 border border-stone-200 rounded-xl text-stone-700 font-bold hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 active:scale-95">Rp 50.000</button>
                            <button type="button" onclick="setAmount(100000)" class="py-3 px-4 border border-stone-200 rounded-xl text-stone-700 font-bold hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 active:scale-95">Rp 100.000</button>
                            <button type="button" onclick="setAmount(200000)" class="py-3 px-4 border border-stone-200 rounded-xl text-stone-700 font-bold hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 active:scale-95">Rp 200.000</button>
                            <button type="button" onclick="setAmount(500000)" class="py-3 px-4 border border-stone-200 rounded-xl text-stone-700 font-bold hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 active:scale-95">Rp 500.000</button>
                        </div>
                    </div>

                    <!-- Input Nominal Manual -->
                    <div class="mb-10">
                        <label for="amount" class="block text-sm font-bold text-stone-700 mb-2">Atau Masukkan Nominal Lainnya</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <span class="text-stone-500 font-bold text-xl">Rp</span>
                            </div>
                            <!-- Input dibuat raksasa biar mantap -->
                            <input type="number" id="amount" name="amount" required min="10000" step="1000"
                                class="w-full pl-14 pr-4 py-5 rounded-2xl border-stone-200 bg-stone-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all text-3xl font-black text-stone-900 placeholder-stone-300"
                                placeholder="0">
                        </div>
                        <p class="text-sm text-stone-500 mt-3 font-medium">Minimal donasi Rp 10.000</p>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2 text-red-500 font-bold" />
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-lg py-5 px-8 rounded-2xl shadow-[0_8px_20px_-6px_rgba(5,150,105,0.4)] hover:shadow-[0_12px_25px_-6px_rgba(5,150,105,0.5)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                        Lanjutkan Pembayaran
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                    <!-- Trust Badge -->
                    <div class="text-center mt-6 flex items-center justify-center gap-2 text-stone-500">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-sm font-semibold">Transaksi Anda 100% aman dan terenkripsi.</span>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script Javascript kecil buat fungsi tombol Quick Select -->
    <script>
        function setAmount(value) {
            const inputField = document.getElementById('amount');
            inputField.value = value;
            
            // Bikin efek kedip/highlight bentar pas diklik biar user sadar angkanya masuk
            inputField.classList.add('ring-4', 'ring-emerald-200', 'border-emerald-500', 'bg-white');
            setTimeout(() => {
                inputField.classList.remove('ring-4', 'ring-emerald-200', 'border-emerald-500', 'bg-white');
            }, 300);
        }
    </script>
</x-app-layout>