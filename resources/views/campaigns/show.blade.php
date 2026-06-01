<x-app-layout>
    <!-- Background utama pakai stone-50 biar hangat dan elegan -->
    <div class="min-h-screen bg-stone-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Tombol Kembali (Minimalist) -->
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-stone-500 hover:text-stone-800 transition mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>

            <!-- Grid Layout: Kiri Konten (2/3), Kanan Sticky Card (1/3) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                <!-- BAGIAN KIRI: Foto & Cerita -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Foto Banner Campaign (UDAH DI-UPDATE BISA NAMPILIN FOTO) -->
                    <div class="w-full aspect-[16/9] bg-stone-200 rounded-3xl overflow-hidden shadow-sm relative group">
                        @if($campaign->image)
                            <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-stone-400 font-medium bg-stone-100">
                                <svg class="w-12 h-12 mb-2 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p>Belum ada foto</p>
                            </div>
                        @endif
                    </div>

                    <!-- Judul & Info Campaigner -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-stone-100">
                        <span class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wide text-emerald-700 bg-emerald-50 rounded-full">
                            {{ $campaign->category ?? 'Kategori Bantuan' }}
                        </span>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-stone-900 tracking-tight mb-6 leading-tight">
                            {{ $campaign->title }}
                        </h1>
                        
                        <div class="flex items-center gap-4 py-6 border-y border-stone-100 mb-6">
                            <div class="w-12 h-12 rounded-full bg-stone-200 flex items-center justify-center text-stone-500 font-bold text-lg">
                                <!-- Inisial nama -->
                                {{ substr($campaign->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm text-stone-500 mb-0.5">Dibuat oleh</p>
                                <p class="text-base font-bold text-stone-900">{{ $campaign->user->name ?? 'Orang Baik' }}</p>
                            </div>
                            <div class="ml-auto flex items-center text-sm text-stone-500">
                                <svg class="w-5 h-5 mr-1 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $campaign->created_at->format('d M Y') }}
                            </div>
                        </div>

                        <!-- Deskripsi Campaign -->
                        <div class="prose prose-stone max-w-none">
                            <h3 class="text-xl font-bold text-stone-900 mb-4">Cerita Campaign</h3>
                            <p class="text-stone-600 leading-relaxed whitespace-pre-line">
                                {{ $campaign->description }}
                            </p>
                        </div>

                        <!-- SEGMEN TRANSPARANSI & DAFTAR ORANG BAIK -->
                        <div class="mt-12 pt-8 border-t border-stone-100">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-stone-900">Kabar Transparansi & Donatur</h3>
                                <span class="bg-emerald-50 text-emerald-700 py-1 px-3 rounded-full text-xs font-bold">
                                    {{ $campaign->donations ? $campaign->donations->where('status', 'paid')->count() : 0 }} Donasi
                                </span>
                            </div>

                            <!-- Info Singkat Potongan -->
                            <div class="bg-stone-50 rounded-2xl p-4 mb-8 flex items-start gap-3 border border-stone-200">
                                <svg class="w-5 h-5 text-stone-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-xs text-stone-600 leading-relaxed">
                                    <span class="font-bold text-stone-800">Komitmen Transparansi:</span> Sesuai ketentuan, nominal yang tercatat pada setiap donatur di bawah adalah total dana yang dibayarkan. Platform kami hanya memotong fee operasional (2.5%) dari total tersebut agar donasi tepat sasaran.
                                </p>
                            </div>

                            <!-- List Donatur -->
                            <div class="space-y-4">
                                @if($campaign->donations && $campaign->donations->where('status', 'paid')->count() > 0)
                                    @foreach($campaign->donations->where('status', 'paid')->sortByDesc('created_at') as $donation)
                                        <div class="flex items-center gap-4 p-4 rounded-2xl border border-stone-100 hover:border-emerald-200 hover:shadow-sm transition-all bg-white">
                                            <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-extrabold shrink-0 text-lg">
                                                {{ substr($donation->user->name ?? 'H', 0, 1) }}
                                            </div>
                                            
                                            <div class="flex-1">
                                                <p class="font-bold text-stone-900 text-base">{{ $donation->user->name ?? 'Orang Baik' }}</p>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="text-emerald-600 font-bold text-sm">Berdonasi Rp {{ number_format($donation->total_paid, 0, ',', '.') }}</span>
                                                    <span class="w-1 h-1 bg-stone-300 rounded-full"></span>
                                                    <span class="text-xs text-stone-500">{{ $donation->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="text-rose-400 opacity-50 shrink-0">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- State kalau belum ada yang donasi -->
                                    <div class="text-center py-10 px-4 rounded-2xl bg-stone-50 border border-dashed border-stone-200">
                                        <div class="w-12 h-12 bg-stone-200 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318z"></path></svg>
                                        </div>
                                        <p class="text-stone-800 font-bold mb-1">Belum ada donatur</p>
                                        <p class="text-stone-500 text-sm">Jadilah orang baik pertama yang mendukung campaign ini!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN KANAN: Sticky Donation Card -->
                <div class="lg:col-span-1">
                    <!-- Sticky nyala pas di-scroll di desktop -->
                    <div class="sticky top-8 bg-white p-8 rounded-3xl shadow-sm border border-stone-100">
                        
                        <!-- Info Dana -->
                        <div class="mb-2">
                            <p class="text-4xl font-extrabold text-stone-900">
                                Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}
                            </p>
                        </div>
                        <p class="text-sm font-medium text-stone-500 mb-6">
                            Terkumpul dari target <span class="font-bold text-stone-800">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
                        </p>

                        <!-- Progress Bar (Elegan & Mewah) -->
                        @php
                            $persen = ($campaign->target_amount > 0) ? min(100, ($campaign->current_amount / $campaign->target_amount) * 100) : 0;
                        @endphp
                        <div class="w-full h-3 bg-stone-100 rounded-full mb-8 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000 ease-out relative" style="width: {{ $persen }}%">
                                <div class="absolute top-0 right-0 bottom-0 w-8 bg-gradient-to-r from-transparent to-white opacity-30"></div>
                            </div>
                        </div>

                        <!-- CTA TOMBOL RAKSASA (Nembak ke halaman form Quick Select) -->
                        <a href="/campaigns/{{ $campaign->id }}/donate" class="w-full flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-lg py-4 px-8 rounded-xl shadow-[0_8px_20px_-6px_rgba(5,150,105,0.4)] hover:-translate-y-1 transition-all duration-300">
                            Donasi Sekarang
                        </a>

                        <div class="text-center mt-4 text-sm text-stone-500 font-medium">
                            <p>Lebih dari 1.000 orang telah berdonasi hari ini.</p>
                        </div>

                        <!-- Tombol Tarik Dana khusus Campaigner -->
                        @if(Auth::check() && Auth::id() === $campaign->user_id)
                            <div class="mt-8 pt-6 border-t border-stone-100 text-center">
                                <p class="text-xs text-stone-500 mb-3">Anda adalah pembuat campaign ini.</p>
                                <a href="/campaigns/{{ $campaign->id }}/withdraw" class="inline-flex justify-center items-center w-full py-3 px-4 border-2 border-stone-200 text-stone-700 font-bold rounded-xl hover:border-stone-800 hover:text-stone-900 hover:bg-stone-50 transition-all">
                                    ⚙️ Kelola & Tarik Dana
                                </a>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>