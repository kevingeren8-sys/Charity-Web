<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(Auth::user()->role === 'campaigner')
                    {{ __('Dashboard Campaigner') }}
                @else
                    {{ __('Dashboard Donatur') }}
                @endif
            </h2>
            
            @if(Auth::user()->role === 'campaigner')
                <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                    + Buat Campaign Baru
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 text-gray-900 text-lg px-2">
                Halo, <span class="font-bold text-indigo-600">{{ Auth::user()->name }}</span>! 
                @if(Auth::user()->role === 'campaigner')
                    Berikut adalah perkembangan galang dana yang kamu buat:
                @else
                    Mari bantu mereka yang membutuhkan hari ini:
                @endif
            </div>

            @if(Auth::user()->role === 'campaigner')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terkumpul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($campaigns as $campaign)
                                    <tr>
                                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $campaign->title }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                        @if($campaign->status === 'pending')
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 uppercase">Pending</span>
                                        @elseif($campaign->status === 'approved')
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 uppercase">Approved</span>
                                        @elseif($campaign->status === 'completed')
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 uppercase">Completed</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800 uppercase">Rejected</span>
                                        @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">Belum ada campaign.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($campaigns as $campaign)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            <div class="p-6 flex-grow">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $campaign->title }}</h3>
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