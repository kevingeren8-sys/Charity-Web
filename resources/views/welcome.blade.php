<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Charity - Kebaikan Tanpa Batas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-stone-50 text-stone-900 overflow-x-hidden">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(168,162,158,0.1),_transparent_20%),radial-gradient(circle_at_bottom_right,_rgba(16,185,129,0.08),_transparent_25%)]">
        <header class="sticky top-0 z-40 border-b border-stone-200 bg-white/80 backdrop-blur-xl">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-5 lg:px-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-200"></div>
                </div>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-full border border-stone-200 bg-white px-4 py-2 text-sm font-semibold text-stone-900 transition hover:bg-stone-100">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-sm font-medium text-stone-700 transition hover:text-stone-900">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full bg-emerald-400 px-5 py-2.5 text-sm font-semibold text-stone-950 shadow-sm shadow-emerald-300/30 transition hover:bg-emerald-300">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <main class="py-20 lg:py-24">
            <div class="mx-auto max-w-5xl px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                    <div class="space-y-8">
                        <div class="space-y-6">
                            <h1 class="text-4xl font-black tracking-tight text-stone-900 sm:text-5xl">Buat kebaikan menjadi lebih mudah, hangat, dan terpercaya.</h1>
                            <p class="text-lg leading-8 text-stone-600">Kami membantu penggalang dana dan donatur berkolaborasi dalam langkah kecil yang bermakna.</p>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-400 px-8 py-4 text-lg font-semibold text-stone-950 shadow-lg shadow-emerald-300/20 transition hover:bg-emerald-300">Gabung Sekarang</a>
                            <a href="#info" class="inline-flex items-center justify-center rounded-full border border-stone-200 bg-white px-8 py-4 text-lg font-semibold text-stone-900 transition hover:bg-stone-100">Info Singkat</a>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-stone-200 bg-white p-8 shadow-lg shadow-stone-300/10">
                        <p class="text-sm uppercase tracking-[0.3em] text-stone-500">Tentang kami</p>
                        <p class="mt-4 text-stone-700">Kami mendukung gerakan kebaikan lewat donasi yang mudah, transparan, dan bersahabat.</p>
                    </div>
                </div>

                <section id="info" class="mt-16 rounded-[2rem] border border-stone-200 bg-white/95 p-8 shadow-lg shadow-stone-300/10">
                    <div class="space-y-4 text-center">
                        <h2 class="text-3xl font-bold text-stone-900">Bersama dalam aksi kebaikan</h2>
                        <p class="mx-auto max-w-2xl text-base leading-7 text-stone-600">Kami mempermudah donatur dan penggalang dana untuk ikut dalam aksi kecil yang bermakna.</p>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
