<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-900 leading-tight">
            Tarik Dana: {{ $campaign->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-stone-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl p-8 border border-stone-100">
                
                <div class="bg-emerald-50 rounded-2xl p-6 mb-8 border border-emerald-100">
                    <h3 class="text-emerald-900 font-bold mb-4 border-b border-emerald-200 pb-2">Rincian Saldo Campaign</h3>
                    
                    <div class="flex justify-between items-center text-sm text-emerald-800 mb-2">
                        <span>Total Dana Terkumpul:</span>
                        <span class="font-semibold">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm text-emerald-800 mb-2">
                        <span>Potongan Fee Platform:</span>
                        <span class="font-semibold text-rose-500">- Rp {{ number_format($jatahPlatform, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center text-sm text-emerald-800 mb-4 border-b border-emerald-200 pb-4">
                        <span>Dana yang Sudah Dicairkan:</span>
                        <span class="font-semibold text-stone-600">- Rp {{ number_format($campaign->withdrawn_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center mt-2">
                        <span class="text-emerald-900 font-bold">Saldo Tersedia untuk Ditarik:</span>
                        <span class="text-3xl font-extrabold text-emerald-700">Rp {{ number_format($saldoTersedia, 0, ',', '.') }}</span>
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
                        <label for="bank_account_number" class="block text-sm font-bold text-stone-900 mb-2">Nomor Rekening</label>
                        <input type="text" name="bank_account_number" id="bank_account_number" 
                            class="w-full px-4 py-3 rounded-lg border @error('bank_account_number') border-rose-500 @else border-stone-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none text-lg font-semibold"
                            placeholder="Contoh: 1234567890" 
                            required>
                        @error('bank_account_number') 
                            <span class="text-rose-500 text-xs mt-1 block font-semibold">{{ $message }}</span> 
                        @enderror
                        <p class="text-sm text-stone-600 mt-2">Pastikan nomor rekening sesuai dengan nama pembuat campaign.</p>
                    </div>

                    <div class="flex items-center gap-4 mt-8 pt-6 border-t border-stone-200">
                        @if($saldoTersedia >= 10000)
                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-8 rounded-2xl shadow-md hover:shadow-lg transition">
                                Cairkan Dana Sekarang
                            </button>
                        @else
                            <button type="button" disabled class="bg-stone-300 text-stone-500 font-bold py-3 px-8 rounded-2xl cursor-not-allowed">
                                Saldo Tidak Cukup
                            </button>
                        @endif
                        <a href="{{ route('campaigns.show', $campaign->id) }}" class="text-stone-600 font-semibold hover:text-stone-900 hover:underline">Batal</a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-stone-100">
                <div class="bg-stone-50 px-8 py-5 border-b border-stone-100 flex items-center gap-3">
                    <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h3 class="font-extrabold text-stone-800 text-lg">Riwayat Penarikan Dana</h3>
                </div>
                
                <div class="p-0 overflow-x-auto">
                    @if(isset($withdrawals) && $withdrawals->count() > 0)
                        <table class="w-full text-left text-sm text-stone-600">
                            <thead class="bg-white text-stone-400 text-xs uppercase font-bold border-b border-stone-100">
                                <tr>
                                    <th class="px-8 py-4">Tanggal</th>
                                    <th class="px-8 py-4">Rekening Tujuan</th>
                                    <th class="px-8 py-4">Nominal</th>
                                    <th class="px-8 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100">
                                @foreach($withdrawals as $wd)
                                <tr class="hover:bg-stone-50 transition">
                                    <td class="px-8 py-5 whitespace-nowrap">{{ $wd->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-8 py-5">
                                        <span class="font-bold text-stone-800 block">{{ $wd->bank_name }}</span>
                                        <span class="text-xs text-stone-500">{{ $wd->bank_account_number }}</span>
                                    </td>
                                    <td class="px-8 py-5 font-extrabold text-emerald-600">Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                                    <td class="px-8 py-5">
                                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold">{{ strtoupper($wd->status) }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-4 text-stone-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <p class="text-stone-800 font-bold mb-1">Belum ada penarikan</p>
                            <p class="text-stone-500 text-sm">Riwayat pencairan dana akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>