<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Dana: {{ $campaign->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded shadow-sm border">
                    <span class="text-gray-500 text-sm">Dana Bersih Terkumpul</span>
                    <h3 class="text-xl font-bold text-green-600">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white p-4 rounded shadow-sm border">
                    <span class="text-gray-500 text-sm">Target Dana</span>
                    <h3 class="text-xl font-bold text-gray-800">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white p-4 rounded shadow-sm border">
                    <span class="text-gray-500 text-sm">Potongan Aplikasi (2.5%)</span>
                    <h3 class="text-xl font-bold text-yellow-600">Rp {{ number_format($campaign->donations()->sum('app_fee'), 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white p-4 rounded shadow-sm border">
                    <span class="text-gray-500 text-sm">Fee Operasional Kamu ({{ $campaign->campaigner_fee_percentage }}%)</span>
                    <h3 class="text-xl font-bold text-blue-600">Rp {{ number_format($campaign->donations()->sum('campaigner_fee'), 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">
                <h4 class="font-bold text-gray-900 mb-4 text-lg">Daftar Orang Baik</h4>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Donatur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donasi Bersih</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Aplikasi (1%)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Campaigner</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Dibayar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @forelse($donations as $donation)
                            <tr>
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $donation->user->name }}</td>
                                <td class="px-6 py-4 text-green-600 font-semibold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-gray-500">Rp {{ number_format($donation->app_fee, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-gray-500">Rp {{ number_format($donation->campaigner_fee, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">Rp {{ number_format($donation->total_paid, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $donation->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-10 text-center text-gray-500">Belum ada transaksi donasi masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>