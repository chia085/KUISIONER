<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind / CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    {{-- HEADER --}}
    <header class="bg-teal-600 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-lg">Dashboard Admin</h1>
        <a href="{{ route('admin.logout') }}"
           class="bg-white text-teal-600 px-4 py-1 rounded text-sm font-semibold">
            Logout
        </a>
    </header>

    {{-- CONTENT --}}
    <main class="p-6">
        @yield('content')
    </main>

</body>
</html>
