<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charity Web</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    <main class="min-h-screen flex items-center justify-center px-6">
        <section class="max-w-3xl text-center">
            <h1 class="text-4xl font-bold mb-4">
                Charity Web
            </h1>

            <p class="text-lg text-gray-600 mb-8">
                A donation platform that helps donors support verified charity campaigns.
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}"
                   class="px-5 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                    Register
                </a>

                <a href="{{ route('login') }}"
                   class="px-5 py-3 bg-white border rounded-lg font-semibold hover:bg-gray-100">
                    Login
                </a>
            </div>
        </section>
    </main>
</body>
</html>