<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Game Dimzzy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-sans">

    <nav class="bg-gray-800 px-6 py-3 flex justify-between items-center">
        <h1 class="text-lg font-bold">🎮 MiniGame Dimzzy</h1>
        <div class="space-x-4">
            <a href="/" class="hover:text-yellow-400">Home</a>
            <a href="/pingpong" class="hover:text-yellow-400">DimzzPong</a>
            <a href="/dimzzsnake" class="hover:text-yellow-400">DimzzSnake</a> {{-- 🐍 Tambahan link game ular --}}
        </div>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>

</body>
</html>
