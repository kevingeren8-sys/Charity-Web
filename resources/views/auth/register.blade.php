<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Charity App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-white text-stone-900">
    <div class="min-h-screen flex">
        
        <!-- Sisi Kiri: Form Register -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-16 bg-stone-50 overflow-y-auto">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg border border-stone-100 my-8">
                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-stone-900 mb-2">Buat Akun Baru ✨</h2>
                    <p class="text-stone-600">Bergabunglah bersama ribuan orang baik lainnya.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-stone-900 mb-1">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe" class="w-full px-4 py-3 rounded-lg border @error('name') border-rose-500 @else border-stone-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none">
                        @error('name') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-stone-900 mb-1">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com" class="w-full px-4 py-3 rounded-lg border @error('email') border-rose-500 @else border-stone-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none">
                        @error('email') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Pilihan Role (Wajib untuk aplikasi lu) -->
                    <div>
                        <label for="role" class="block text-sm font-semibold text-stone-900 mb-1">Saya ingin bergabung sebagai</label>
                        <select id="role" name="role" required class="w-full px-4 py-3 rounded-lg border border-stone-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none cursor-pointer">
                            <option value="donatur">Donatur (Orang Baik)</option>
                            <option value="campaigner">Campaigner (Penggalang Dana)</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-stone-900 mb-1">Kata Sandi</label>
                        <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full px-4 py-3 rounded-lg border @error('password') border-rose-500 @else border-stone-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none">
                        @error('password') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-stone-900 mb-1">Ulangi Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-3 rounded-lg border border-stone-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none">
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 mt-2">
                        Daftar Sekarang
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-stone-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Sisi Kanan: Banner (Sembunyi di HP, Muncul di Laptop) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-emerald-600 items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-stone-600 opacity-90"></div>
            <div class="relative z-10 p-12 max-w-xl text-center">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h1 class="text-4xl font-extrabold text-white mb-6 leading-tight">Satu Langkah Kecil, Perubahan Besar.</h1>
                <p class="text-lg text-green-100">Jadilah bagian dari komunitas yang peduli. Buat galang dana untuk bantu sesama, atau salurkan donasimu dengan aman dan transparan.</p>
            </div>
            <!-- Dekorasi -->
            <div class="absolute -bottom-20 -right-20 w-80 h-80 rounded-full border-4 border-white border-opacity-10"></div>
            <div class="absolute top-10 left-10 w-40 h-40 rounded-full bg-white bg-opacity-5"></div>
        </div>

    </div>
</body>
</html>