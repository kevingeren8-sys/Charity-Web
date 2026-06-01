<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-800 leading-tight">
            Buat Campaign Baru
        </h2>
    </x-slot>

    <div class="py-12 bg-stone-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-stone-500 hover:text-stone-800 transition mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl p-8 lg:p-10 border border-stone-100">
                
                <div class="mb-8 border-b border-stone-100 pb-6">
                    <h3 class="text-2xl font-extrabold text-stone-900">Mulai Kebaikanmu Hari Ini</h3>
                    <p class="text-stone-500 mt-2">Isi detail di bawah untuk menggalang dana. Pastikan informasi yang diberikan jelas dan jujur.</p>
                </div>

                <!-- Wajib ada enctype="multipart/form-data" biar gambar bisa ke-upload -->
                <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Judul Campaign -->
                    <div>
                        <label for="title" class="block text-sm font-bold text-stone-700 mb-2">Judul Campaign</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-3 rounded-xl border-stone-200 bg-stone-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all font-medium text-stone-900"
                            placeholder="Contoh: Bantu Pembangunan Panti Asuhan Harapan">
                        @error('title') <span class="text-red-500 text-xs mt-1 font-bold block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kategori -->
                        <div>
                            <label for="category" class="block text-sm font-bold text-stone-700 mb-2">Kategori</label>
                            <select name="category" id="category" required
                                class="w-full px-4 py-3 rounded-xl border-stone-200 bg-stone-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all font-medium text-stone-900 cursor-pointer">
                                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih Kategori</option>
                                <option value="Kesehatan" {{ old('category') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="Pendidikan" {{ old('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="Bencana Alam" {{ old('category') == 'Bencana Alam' ? 'selected' : '' }}>Bencana Alam</option>
                                <option value="Sosial" {{ old('category') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                            </select>
                            @error('category') <span class="text-red-500 text-xs mt-1 font-bold block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Target Dana -->
                        <div>
                            <label for="target_amount" class="block text-sm font-bold text-stone-700 mb-2">Target Dana (Rp)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-stone-500 font-bold">Rp</span>
                                </div>
                                <input type="number" name="target_amount" id="target_amount" value="{{ old('target_amount') }}" required min="1000"
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border-stone-200 bg-stone-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all font-medium text-stone-900"
                                    placeholder="0">
                            </div>
                            @error('target_amount') <span class="text-red-500 text-xs mt-1 font-bold block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Persentase Fee Campaigner -->
                    <div>
                        <label for="campaigner_fee_percentage" class="block text-sm font-bold text-stone-700 mb-2">Persentase Fee Campaigner (%)</label>
                        <div class="relative w-1/2">
                            <input type="number" name="campaigner_fee_percentage" id="campaigner_fee_percentage" value="{{ old('campaigner_fee_percentage', 0) }}" required min="0" max="15" step="0.1"
                                class="w-full pr-10 pl-4 py-3 rounded-xl border-stone-200 bg-stone-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all font-medium text-stone-900"
                                placeholder="0 - 15">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-stone-500 font-bold">%</span>
                            </div>
                        </div>
                        <p class="text-xs text-stone-500 mt-2">Maksimal 15%. Isi 0 jika tidak ingin mengambil fee.</p>
                        @error('campaigner_fee_percentage') <span class="text-red-500 text-xs mt-1 font-bold block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Upload Foto / Banner -->
                    <div class="bg-stone-50 p-6 rounded-2xl border border-stone-200 border-dashed">
                        <label for="image" class="block text-sm font-bold text-stone-700 mb-2">Foto / Banner Campaign</label>
                        <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/jpg, image/webp"
                            class="block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 transition-all cursor-pointer">
                        <p class="text-xs text-stone-500 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Format JPG, PNG, WEBP. Maksimal ukuran 2MB. Disarankan rasio 16:9.
                        </p>
                        @error('image') <span class="text-red-500 text-xs mt-1 font-bold block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Deskripsi Cerita -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-stone-700 mb-2">Cerita / Deskripsi Lengkap</label>
                        <textarea name="description" id="description" rows="6" required
                            class="w-full px-4 py-3 rounded-xl border-stone-200 bg-stone-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all font-medium text-stone-900"
                            placeholder="Ceritakan mengapa Anda menggalang dana, untuk siapa, dan bagaimana dana tersebut akan digunakan...">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1 font-bold block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-4 border-t border-stone-100">
                        <button type="submit" class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-lg py-4 px-10 rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                            Terbitkan Campaign
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>