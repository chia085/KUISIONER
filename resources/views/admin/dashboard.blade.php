<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-Kuisioner</title>
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
        <a href="{{ route('admin.logout') }}" class="bg-white text-teal-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
            Logout
        </a>
    </header>

    <!-- MAIN CONTENT -->
    <main class="p-8">
        <div class="max-w-6xl mx-auto">
            <!-- Greeting -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-teal-600 mb-2">Selamat Datang, Admin!</h2>
                <p class="text-gray-700">
                    Kelola dan analisis data hasil kuisioner Polibatam dengan mudah melalui fitur-fitur berikut:
                </p>
            </div>

            <!-- CARD MENU -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- CARD 2 - Grafik Kuisioner -->
                <a href="{{ route('admin.grafik') }}" 
                   class="bg-white rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-6 flex items-center space-x-4 cursor-pointer">
                    <div class="bg-teal-100 text-teal-600 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 0120.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 15A9 9 0 119 3.512V13h11.488z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-teal-700">Grafik Kuisioner</h3>
                        <p class="text-gray-600 text-sm">Visualisasikan hasil kuisioner dalam bentuk grafik interaktif.</p>
                    </div>
                </a>

                <!-- CARD 3 - CRUD KUESIONER -->
                <a href="{{ route('admin.kuisioner.index') }}"
                   class="bg-white rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-6 flex items-center space-x-4 cursor-pointer">
                    <div class="bg-teal-100 text-teal-600 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-teal-700">Kelola Kuisioner</h3>
                        <p class="text-gray-600 text-sm">Tambah, edit, dan hapus daftar kuisioner.</p>
                    </div>
                </a>

                <!-- CARD 4 - CRUD PERTANYAAN -->
                <a href="{{ route('admin.pertanyaan.index') }}"
                   class="bg-white rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-6 flex items-center space-x-4 cursor-pointer">
                    <div class="bg-teal-100 text-teal-600 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-teal-700">Kelola Pertanyaan</h3>
                        <p class="text-gray-600 text-sm">Kelola pertanyaan untuk setiap kuisioner.</p>
                    </div>
                </a>

                <!-- CARD 5 - JAWABAN RESPONDEN -->
                <a href="{{ route('admin.jawaban.index') }}"
                   class="bg-white rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-6 flex items-center space-x-4 cursor-pointer">
                    <div class="bg-teal-100 text-teal-600 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h10M4 18h7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-teal-700">Jawaban Responden</h3>
                        <p class="text-gray-600 text-sm">Lihat jawaban yang telah dikirim oleh responden.</p>
                    </div>
                </a>

            </div>

            <!-- Kembali ke halaman utama -->
            <div class="text-center mt-10">
                <a href="{{ route('polibatam') }}" 
                   class="inline-block text-teal-600 font-semibold transition duration-200 transform hover:scale-105 hover:text-teal-700">
                    &larr; Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </main>

</body>
</html>
