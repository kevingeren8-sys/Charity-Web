<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 border">
                
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-stone-900 mb-2">Selesaikan Pembayaran Donasi</h3>
                    <p class="text-stone-600">Terima kasih orang baik! Sedikit lagi donasimu akan tersalurkan.</p>
                </div>
                
                <div class="bg-emerald-50 rounded-2xl p-6 mb-8 border border-emerald-100 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-stone-600">Total Tagihan</p>
                        <p class="text-3xl font-extrabold text-emerald-700">Rp {{ number_format($donation->total_paid, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-stone-600">ID Transaksi</p>
                        <p class="font-mono font-bold text-stone-900">#DON-{{ $donation->id }}-{{ time() }}</p>
                    </div>
                </div>

                <h4 class="font-bold text-stone-900 mb-4">Pilih Metode Pembayaran:</h4>
                <div class="space-y-4 mb-8">
                    
                    <label class="block border border-stone-200 rounded-2xl p-4 cursor-pointer hover:bg-stone-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" class="text-emerald-600" checked>
                                <span class="font-bold text-stone-900">BCA Virtual Account</span>
                            </div>
                            <span class="text-sm text-stone-500 font-mono">1234 5678 9012</span>
                        </div>
                    </label>

                    <label class="block border border-stone-200 rounded-2xl p-4 cursor-pointer hover:bg-stone-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" class="text-emerald-600">
                                <span class="font-bold text-stone-900">GoPay / ShopeePay</span>
                            </div>
                            <span class="text-sm text-stone-500">Scan QR via Aplikasi</span>
                        </div>
                    </label>

                    <label class="block border border-stone-200 rounded-2xl p-4 cursor-pointer hover:bg-stone-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" class="text-emerald-600">
                                <span class="font-bold text-stone-900">Transfer Bank Mandiri</span>
                            </div>
                            <span class="text-sm text-stone-500 font-mono">1370 000 111 222</span>
                        </div>
                    </label>
                </div>

                <form action="{{ route('donations.confirm', $donation->id) }}" method="POST" class="text-center border-t border-stone-100 pt-6 mt-6">
                    @csrf
                    <p class="text-sm text-stone-600 mb-4">Silakan lakukan pembayaran sesuai instruksi di atas.</p>
                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 px-8 rounded-2xl shadow-lg transition text-lg">
                        ✅ Saya Sudah Bayar
                    </button>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>