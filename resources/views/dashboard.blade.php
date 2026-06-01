<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-stone-900 leading-tight">
                @if(Auth::user()->role === 'campaigner')
                    {{ __('Dashboard Campaigner') }}
                @elseif(Auth::user()->role === 'admin')
                    {{ __('Control Panel Admin') }}
                @else
                    {{ __('Dashboard Donatur') }}
                @endif
            </h2>
            
            @if(Auth::user()->role === 'campaigner')
                <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">
                    + Buat Campaign Baru
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 text-stone-900 text-lg px-2">
                Halo, <span class="font-bold text-emerald-600">{{ Auth::user()->name }}</span>! 
                @if(Auth::user()->role === 'campaigner')
                    Berikut adalah perkembangan campaign kamu:
                @elseif(Auth::user()->role === 'admin')
                    Kelola dan pantau seluruh pergerakan campaign di sistem ini.
                @else
                    Mari bantu mereka yang membutuhkan hari ini:
                @endif
            </div>

            @if(Auth::user()->role === 'campaigner')
                <!-- ============================ -->
                <!-- TAMPILAN DASHBOARD CAMPAIGNER -->
                <!-- ============================ -->
                @php
                    $ditolak = $campaigns->where('status', 'rejected')->count();
                @endphp
                
                @if($ditolak > 0)
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                        <p class="font-bold">Notifikasi Penting!</p>
                        <p>Ada <strong>{{ $ditolak }}</strong> campaign kamu yang ditolak. Cek statusnya di tabel bawah. Kalau ada yang salah, kamu bisa bikin ulang galang dananya.</p>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-stone-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-stone-200 border">
                            <thead class="bg-stone-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-600 uppercase">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-600 uppercase">Target</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-600 uppercase">Terkumpul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-600 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-stone-200">
                                @forelse($campaigns as $campaign)
                                    <tr>
                                        <td class="px-6 py-4 font-semibold">
                                            <a href="{{ route('campaigns.show', $campaign->id) }}" class="text-emerald-600 hover:underline">
                                                {{ $campaign->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-stone-600">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-stone-600">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            @if($campaign->status === 'pending')
                                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-stone-100 text-stone-700 uppercase">Pending</span>
                                            @elseif($campaign->status === 'approved')
                                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 uppercase">Approved</span>
                                            @elseif($campaign->status === 'completed')
                                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 uppercase">Completed</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-700 uppercase">Rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-10 text-center text-stone-500">Belum ada campaign.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @elseif(Auth::user()->role === 'admin')
                <!-- ============================ -->
                <!-- TAMPILAN DASHBOARD ADMIN     -->
                <!-- ============================ -->
                
                @php
                    // Tarik data langsung di blade biar rapi & gak perlu ubah Controller
                    $pendingCampaigns = \App\Models\Campaign::where('status', 'pending')->latest()->get();
                    $otherCampaigns = \App\Models\Campaign::where('status', '!=', 'pending')->latest()->get();
                @endphp

                <!-- x-data ini buat nyalain fitur klik Tab tanpa loading -->
                <div x-data="{ tab: 'verifikasi' }">
                    
                    <!-- Menu Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <!-- Tombol Tab 1 -->
                            <button @click="tab = 'verifikasi'" 
                                    :class="tab === 'verifikasi' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors duration-200">
                                Antrean Verifikasi 
                                @if($pendingCampaigns->count() > 0)
                                    <span class="ml-2 bg-red-500 text-white py-0.5 px-2.5 rounded-full text-xs shadow-sm">{{ $pendingCampaigns->count() }}</span>
                                @endif
                            </button>
                            <!-- Tombol Tab 2 -->
                            <button @click="tab = 'semua'" 
                                    :class="tab === 'semua' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors duration-200">
                                Daftar Campaign Berjalan ({{ $otherCampaigns->count() }})
                            </button>
                        </nav>
                    </div>

                    <!-- TAB 1: Tabel Verifikasi (Hanya Pending) -->
                    <div x-show="tab === 'verifikasi'">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Campaign</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target Dana</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($pendingCampaigns as $campaign)
                                            <tr>
                                                <td class="px-6 py-4 font-bold">
                                                    <!-- Judul bisa diklik buat cek halaman detail/transparansi -->
                                                    <a href="{{ route('campaigns.show', $campaign->id) }}" class="text-indigo-600 hover:underline">
                                                        {{ $campaign->title }}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $campaign->description }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 flex space-x-2">
                                                    <form action="{{ route('campaigns.approve', $campaign->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded text-xs font-bold hover:bg-green-600">Approve</button>
                                                    </form>
                                                    <form action="{{ route('campaigns.reject', $campaign->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-xs font-bold hover:bg-red-600">Reject</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500 font-medium">Asik, nggak ada antrean campaign yang perlu di-review! 🎉</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: Tabel Semua Campaign (Approved/Completed/Rejected) -->
                    <!-- Sengaja dikasih style="display: none;" biar pas loading pertama nggak bocor tampilannya -->
                    <div x-show="tab === 'semua'" style="display: none;">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Campaign</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target Dana</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dana Terkumpul</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($otherCampaigns as $campaign)
                                            <tr>
                                                <td class="px-6 py-4 font-bold">
                                                    <a href="{{ route('campaigns.show', $campaign->id) }}" class="text-indigo-600 hover:underline">
                                                        {{ $campaign->title }}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 text-sm font-bold text-green-600">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4">
                                                    @if($campaign->status === 'approved')
                                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 uppercase">Approved</span>
                                                    @elseif($campaign->status === 'completed')
                                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 uppercase">Completed</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800 uppercase">Rejected</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500 font-medium">Belum ada data campaign selain yang antre verifikasi.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            @else
                <!-- ============================ -->
                <!-- TAMPILAN DASHBOARD DONATUR   -->
                <!-- ============================ -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($campaigns as $campaign)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            <div class="p-6 flex-grow">
                                <a href="{{ route('campaigns.show', $campaign->id) }}" class="hover:underline text-indigo-600">
                                    <h3 class="text-xl font-bold mb-2">{{ $campaign->title }}</h3>
                                </a>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $campaign->description }}</p>
                                
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ min(($campaign->current_amount / $campaign->target_amount) * 100, 100) }}%"></div>
                                </div>
                                <div class="flex justify-between text-sm mb-4">
                                    <span class="font-bold text-indigo-600">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                                    <span class="text-gray-500">dari Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <a href="{{ route('donations.create', $campaign->id) }}" class="block text-center w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition">
                                Donasi Sekarang
                            </a>
                        </div>
                    @empty
                        <div class="col-span-3 bg-white p-10 text-center rounded-lg shadow-md text-gray-500">
                            Belum ada galang dana yang tersedia saat ini.
                        </div>
                    @endforelse
                </div>
            @endif

        </div>
    </div>
</x-app-layout>