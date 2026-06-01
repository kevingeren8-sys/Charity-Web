<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Charity App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-white text-stone-900">
    <div class="min-h-screen flex">
        
        <!-- Sisi Kiri: Banner & Branding (Sembunyi di HP, Muncul di Laptop) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-emerald-700 items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 to-stone-600 opacity-90"></div>
            <!-- Boleh diganti tag img kalau lu punya ilustrasi/foto -->
            <div class="relative z-10 p-12 max-w-xl text-center">
                <h1 class="text-5xl font-extrabold text-white mb-6 leading-tight">Mari Lanjutkan Langkah Baikmu.</h1>
                <p class="text-lg text-emerald-100 mb-8">Ribuan orang terbantu setiap harinya berkat donasi kecil yang disalurkan bersama-sama. Masuk untuk melihat perkembangan campaign atau mulai berdonasi.</p>
            </div>
            <!-- Dekorasi Lingkaran -->
            <div class="absolute -bottom-32 -left-40 w-96 h-96 rounded-full border-4 border-white border-opacity-10"></div>
            <div class="absolute -top-32 -right-40 w-96 h-96 rounded-full bg-white bg-opacity-10"></div>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-stone-50">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg border border-stone-100">
                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-stone-900 mb-2">Selamat Datang! 👋</h2>
                    <p class="text-stone-600">Silakan masukkan email dan kata sandi kamu.</p>
                </div>

                <!-- Pesan Error Global (misal salah password) -->
                @if ($errors->any())
                    <div class="mb-4 bg-rose-50 p-4 rounded-lg border border-rose-200">
                        <p class="text-sm text-rose-600 font-medium">Email atau kata sandi yang kamu masukkan salah.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-stone-900 mb-1">Alamat Email</label>
                        <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com" class="w-full px-4 py-3 rounded-lg border border-stone-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none">
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-stone-900 mb-1">Kata Sandi</label>
                        <input id="password" type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 rounded-lg border border-stone-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-stone-50 focus:bg-white text-stone-900 outline-none">
                    </div>

                    <!-- Remember Me & Lupa Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-stone-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="ml-2 text-sm text-stone-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-semibold text-emerald-600 hover:text-emerald-700" href="{{ route('password.request') }}">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Masuk Sekarang
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-stone-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>

    </div>
</body>
</html>