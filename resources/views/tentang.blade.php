<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang E-Kuesioner Polibatam</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="m-0 p-0 w-full h-screen overflow-hidden bg-[#0A2F63] text-white relative">

    <!-- Segitiga ungu di kanan atas -->
    <div class="absolute top-0 right-0 w-[55%] h-full bg-[#8D8CE6] clip-triangle"></div>

    <!-- Konten teks -->
    <div class="relative z-10 h-full flex items-center">
        <div class="px-12 md:px-24 max-w-3xl">
            <h1 class="text-3xl md:text-4xl font-bold mb-6">
                Tentang E-Kuesioner 
                <span class="text-[#1C5CAE]">P</span><span class="text-[#F97C00]">o<span class="text-[#1C5CAE]">li</span><span class="text-[#00B6E9]">batam</span>
            </h1>

            <p class="text-lg leading-relaxed text-gray-200 mb-4">
                E-Kuesioner Polibatam adalah sistem evaluasi berbasis web3
                yang dikembangkan untuk mendukung proses peningkatan mutu layanan kampus.
            </p>

            <p class="text-gray-200 leading-relaxed pl-8">
                Sistem ini memungkinkan pengguna dari berbagai kategori 
                <span class="italic text-gray-300">(mahasiswa, dosen, alumni)</span> 
                untuk mengisi kuesioner secara online dengan 
                <span class="text- font-semibold">mudah</span>, 
                <span class="text- font-semibold">cepat</span>, dan 
                <span class="text- font-semibold">terintegrasi</span>.
            </p>
        </div>
    </div>

    <style>
        /* Bentuk segitiga di kanan atas */
        .clip-triangle {
            clip-path: polygon(40% 0, 100% 0, 100% 100%);
        }

        /* Hilangkan jarak antar span */
        h1 span {
            margin-right: 0;
            padding-right: 0;
            letter-spacing: -0.5px;
        }
    </style>

</body>
</html>
