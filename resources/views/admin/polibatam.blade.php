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

    <!-- Bootstrap CSS -->
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
                            <option value="{{ route('kuisioner.show', $k->id) }}">
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

    <!-- FOOTER -->
    <footer class="bg-teal-600 text-white text-center py-3 mt-8">
        <p>&copy; 2025 E-Kuisioner Politeknik Negeri Batam - All Rights Reserved</p>
    </footer>

    <!-- SCRIPT -->
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

            // awal: disable tombol kalau belum ada pilihan
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
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
