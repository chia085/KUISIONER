<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kuisioner Polibatam</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/polibatam.png') }}">

    <!-- Bootstrap CSS (kalau masih dipakai di tempat lain) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- HEADER -->
    <header class="bg-teal-600 text-white px-6 py-3 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/polibatam.png') }}" alt="Logo Polibatam" class="w-10 h-10">
            <h1 class="text-xl font-bold tracking-wide">E-Kuisioner Polibatam</h1>
        </div>
        <nav>
            <ul class="flex space-x-8">
                <li>
                    <a href="{{ route('admin.login') }}"
                       class="text-white font-semibold hover:underline hover:text-gray-200 transition">
                        Admin
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container mx-auto px-4 py-8">

        <!-- SLIDER -->
        <div class="relative mb-8 overflow-hidden rounded-lg" id="slider-container">
            <div id="slides" class="flex transition-transform duration-700 ease-in-out">
                <div class="slide w-full shrink-0">
                    <img src="{{ asset('images/kampuss.jpg') }}" alt="Slide 1" class="w-full h-80 object-cover">
                </div>
                <div class="slide w-full shrink-0">
                    <img src="{{ asset('images/oh.png') }}" alt="Slide 2" class="w-full h-80 object-cover">
                </div>
                <div class="slide w-full shrink-0">
                    <img src="{{ asset('images/poltek.png') }}" alt="Slide 3" class="w-full h-80 object-cover">
                </div>
            </div>

            <!-- Tombol Navigasi -->
            <button onclick="moveSlide(-1)"
                    class="absolute top-1/2 left-3 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full">
                &#10094;
            </button>
            <button onclick="moveSlide(1)"
                    class="absolute top-1/2 right-3 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full">
                &#10095;
            </button>

            <!-- Dots -->
            <div id="dots" class="flex justify-center mt-3 space-x-2"></div>
        </div>

        <!-- INFO -->
        <div class="text-center bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-3xl text-teal-600 font-bold mb-4">E-Kuisioner Layanan Polibatam</h2>
            <p class="text-gray-600">
                E-Kuisioner Polibatam adalah sistem evaluasi berbasis web yang dikembangkan untuk mendukung proses
                peningkatan mutu layanan kampus. Sistem ini memungkinkan pengguna dari berbagai kategori untuk
                mengisi kuisioner secara online dengan mudah, cepat, dan terintegrasi.
            </p>
        </div>

        {{-- ===================== MULAI ISI KUISIONER (DROPDOWN) ===================== --}}
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl text-teal-600 font-bold mb-3">
                Mulai Isi Kuisioner
            </h2>

            @if($kuisioners->isEmpty())
                <p class="text-gray-500">
                    Saat ini belum ada kuisioner yang aktif.
                </p>
            @else
                <p class="text-gray-600 mb-6">
                    Silakan pilih kuisioner yang ingin Anda isi, lalu klik tombol <strong>Mulai</strong>.
                </p>

                <div class="flex flex-col md:flex-row items-center justify-center gap-3 max-w-xl mx-auto">

                    {{-- Dropdown daftar kuisioner --}}
                    <select id="kuisionerSelect"
                            class="w-full md:w-auto border rounded-lg px-3 py-2 text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">-- Pilih Kuisioner --</option>

                        @foreach($kuisioners as $k)
                            @php
                                // selected jika:
                                // - datang dari QR (ada $selectedId sama dengan id ini), atau
                                // - hanya ada satu kuisioner aktif
                                $isSelected = (isset($selectedId) && $selectedId == $k->id)
                                              || ($kuisioners->count() === 1);
                            @endphp
                            <option value="{{ route('kuisioner.show', $k->id) }}" {{ $isSelected ? 'selected' : '' }}>
                                {{ $k->judul }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Tombol mulai --}}
                    <button type="button"
                            id="btnMulaiKuisioner"
                            class="w-full md:w-auto bg-teal-600 text-white px-6 py-2 rounded-lg text-sm md:text-base font-semibold shadow-md hover:bg-teal-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition">
                        Mulai
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- ===================== GRAFIK PUBLIK DI BAWAH MULAI ISI KUISIONER ===================== --}}
    <div class="max-w-5xl mx-auto mt-2 px-4 mb-10">
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-teal-700">
                        Hasil Kepuasan Layanan Unit Kerja Polibatam
                    </h2>
                    <p class="text-sm text-gray-500">
                        Rekap total responden dan persentase kepuasan (Sangat Baik + Baik) untuk setiap layanan.
                    </p>
                </div>
            </div>

            @if(empty($grafikData) || count($grafikData) === 0)
                <p class="text-gray-500 text-center py-6">Belum ada data grafik.</p>
            @else
                <div class="w-full overflow-x-auto">
                    <canvas id="grafikPublik" height="120"></canvas>
                </div>
            @endif
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-teal-600 text-white text-center py-3 mt-8">
        <p>&copy; 2025 E-Kuisioner Politeknik Negeri Batam - All Rights Reserved</p>
    </footer>

    <!-- SCRIPT LIBRARY -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SCRIPT SLIDER & DROPDOWN -->
    <script>
        // === SLIDER ===
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dotsContainer = document.getElementById('dots');

        slides.forEach((_, i) => {
            const dot = document.createElement('div');
            dot.className = "w-3 h-3 rounded-full bg-gray-300 cursor-pointer transition-all";
            dot.addEventListener('click', () => goToSlide(i));
            dotsContainer.appendChild(dot);
        });

        const dots = document.querySelectorAll('#dots div');
        if (dots.length > 0) {
            dots[0].classList.replace('bg-gray-300', 'bg-teal-500');
        }

        function updateDots() {
            dots.forEach(dot => dot.classList.replace('bg-teal-500', 'bg-gray-300'));
            dots[currentSlide].classList.replace('bg-gray-300', 'bg-teal-500');
        }

        function moveSlide(step) {
            currentSlide = (currentSlide + step + slides.length) % slides.length;
            document.getElementById('slides').style.transform = `translateX(-${currentSlide * 100}%)`;
            updateDots();
        }

        function goToSlide(index) {
            currentSlide = index;
            document.getElementById('slides').style.transform = `translateX(-${currentSlide * 100}%)`;
            updateDots();
        }

        function startAutoSlide() {
            setInterval(() => moveSlide(1), 4000);
        }
        startAutoSlide();

        // === DROPDOWN MULAI ISI KUISIONER ===
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('kuisionerSelect');
            const btn    = document.getElementById('btnMulaiKuisioner');

            if (!select || !btn) return;

            // Kalau dari QR / cuma 1 kuisioner dan sudah auto-selected,
            // tombol langsung aktif. Kalau tidak ada pilihan → disable.
            btn.disabled = !select.value;

            select.addEventListener('change', () => {
                btn.disabled = !select.value;
            });

            btn.addEventListener('click', () => {
                if (select.value) {
                    window.location.href = select.value; // redirect ke form kuisioner yang dipilih
                }
            });
        });

        // === GRAFIK PUBLIK ===
        (function () {
            const el = document.getElementById('grafikPublik');
            if (!el) return;

            const data = @json($grafikData ?? []);

            const labels = data.map(d => d.judul);
            const totals = data.map(d => Number(d.total || 0));
            const persens = data.map(d => Number(d.persen || 0));

            new Chart(el, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Jumlah Responden',
                            data: totals,
                            backgroundColor: '#ff7f0e'
                        },
                        {
                            label: 'Persentase Kepuasan (%)',
                            data: persens,
                            backgroundColor: '#1f77b4'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    scales: {
                        x: { beginAtZero: true }
                    }
                }
            });
        })();
    </script>

</body>
</html>
