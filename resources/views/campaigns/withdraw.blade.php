<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-900 leading-tight">
            Tarik Dana: {{ $campaign->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-stone-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl p-8 border border-stone-100">
                
                <div class="bg-emerald-50 rounded-2xl p-6 mb-8 border border-emerald-100 flex justify-between items-center">
                    <div>
                        <p class="text-emerald-900 font-semibold mb-1">Saldo Tersedia untuk Ditarik</p>
                        <p class="text-sm text-emerald-700">Dana yang sudah dicairkan: Rp {{ number_format($campaign->withdrawn_amount, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <h3 class="text-3xl font-extrabold text-emerald-700">Rp {{ number_format($saldoTersedia, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <form action="{{ route('campaigns.withdraw', $campaign->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="amount" class="block text-sm font-bold text-stone-900 mb-2">Nominal Penarikan (Rp)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-stone-500 sm:text-sm font-bold">Rp</span>
                            </div>
                            <input type="number" name="amount" id="amount" 
                                class="w-full pl-12 pr-4 py-3 rounded-lg border @error('amount') border-rose-500 @else border-stone-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none text-lg font-semibold"
                                placeholder="0" 
                                min="10000" 
                                max="{{ $saldoTersedia }}"
                                required>
                        </div>
                        @error('amount') 
                            <span class="text-rose-500 text-xs mt-1 block font-semibold">{{ $message }}</span> 
                        @enderror
                        <p class="text-sm text-stone-600 mt-2">Minimal penarikan adalah Rp 10.000.</p>
                    </div>

                    <div class="mb-6">
                        <label for="bank_name" class="block text-sm font-bold text-stone-900 mb-2">Pilih Bank Tujuan</label>
                        <select name="bank_name" id="bank_name" required 
                            class="w-full px-4 py-3 rounded-lg border @error('bank_name') border-rose-500 @else border-stone-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none text-lg font-semibold cursor-pointer">
                            <option value="" disabled selected>-- Pilih Bank --</option>
                            <option value="BCA">BCA (Bank Central Asia)</option>
                            <option value="Mandiri">Bank Mandiri</option>
                            <option value="BRI">BRI (Bank Rakyat Indonesia)</option>
                            <option value="BNI">BNI (Bank Negara Indonesia)</option>
                            <option value="CIMB">CIMB Niaga</option>
                        </select>
                        @error('bank_name') 
                            <span class="text-rose-500 text-xs mt-1 block font-semibold">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="account_number" class="block text-sm font-bold text-stone-900 mb-2">Nomor Rekening</label>
                        <input type="text" name="account_number" id="account_number" 
                            class="w-full px-4 py-3 rounded-lg border @error('account_number') border-rose-500 @else border-stone-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none text-lg font-semibold"
                            placeholder="Contoh: 1234567890" 
                            required>
                        @error('account_number') 
                            <span class="text-rose-500 text-xs mt-1 block font-semibold">{{ $message }}</span> 
                        @enderror
                        <p class="text-sm text-stone-600 mt-2">Pastikan nomor rekening sesuai dengan nama pembuat campaign.</p>
                    </div>

                    <div class="flex items-center gap-4 mt-8 pt-6 border-t border-stone-200">
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-8 rounded-2xl shadow-md hover:shadow-lg transition">
                            Cairkan Dana Sekarang
                        </button>
                        <a href="{{ route('campaigns.show', $campaign->id) }}" class="text-stone-600 font-semibold hover:text-stone-900 hover:underline">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>