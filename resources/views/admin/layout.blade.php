<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - E-Kuisioner')</title>

    {{-- Gunakan Tailwind CDN karena dashboard pakai CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" type="image/png" href="{{ asset('images/polibatam.png') }}">
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- HEADER -->
    <header class="bg-teal-600 text-white px-6 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/polibatam.png') }}" alt="Logo Polibatam" class="w-8 h-8">
            <h1 class="text-xl font-bold tracking-wide">Dashboard Admin</h1>
        </div>

        <a href="{{ route('admin.logout') }}" 
           class="bg-white text-teal-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
            Logout
        </a>
    </header>

    <!-- MAIN CONTENT -->
    <main class="p-8">
        <div class="max-w-6xl mx-auto">
            @yield('content')
        </div>
    </main>

</body>
</html>
