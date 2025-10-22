<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kuesioner Polibatam</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 85vh;
            background: url('{{ asset('assets/images/background.jpg') }}') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .btn-select {
            background-color: #0043ce;
            color: white;
            font-weight: 500;
        }
        .btn-select:hover {
            background-color: #0032a0;
            color: white;
        }

        /* Info Section */
        .feature-icon {
            font-size: 40px;
            color: #007bff;
        }

        footer {
            background-color: #f8f9fa;
            color: #6c757d;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/images/logo_polibatam.png') }}" alt="Polibatam" width="45" class="me-2">
                <h5 class="mb-0 fw-bold text-primary">E-Kuesioner</h5>
            </div>

            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item mx-2"><a href="#" class="nav-link fw-semibold">Beranda</a></li>
                <li class="nav-item mx-2"><a href="#" class="nav-link fw-semibold">Tentang</a></li>
                <li class="nav-item mx-2"><a href="#" class="nav-link fw-semibold">Panduan</a></li>

                {{-- Dropdown Select --}}
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="selectDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Select
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="selectDropdown">
                        <li><a class="dropdown-item" href="#">Admin</a></li>
                        <li><a class="dropdown-item" href="#">Responden</a></li>
                    </ul>
                </li>

                {{-- Login Dropdown --}}
                <li class="nav-item dropdown mx-2">
                    <a class="btn btn-primary dropdown-toggle px-3 py-1 fw-semibold" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Login
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
                        <li><a class="dropdown-item" href="{{ route('login') }}">Masuk</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero">
        <div class="hero-overlay text-center">
            <div class="container">
                <h1 class="fw-bold mb-3">E-Kuesioner Polibatam</h1>
                <p class="fs-5 mb-4">Evaluasi layanan kampus untuk meningkatkan kualitas</p>

                {{-- Select Jenis Pengguna --}}
                <div class="dropdown mt-2">
                    <button class="btn btn-select dropdown-toggle px-4 py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Select Jenis Pengguna
                    </button>
                    <ul class="dropdown-menu mx-auto text-center" style="max-width:250px;">
                        <li><a class="dropdown-item" href="#">Admin</a></li>
                        <li><a class="dropdown-item" href="#">Responden</a></li>
                    </ul>
                </div>

                <p class="mt-3 text-white-50">Gunakan akun Polibatam (SSO) untuk Login</p>
            </div>
        </div>
    </section>

    {{-- Info Section --}}
    <section class="py-5 bg-white">
        <div class="container text-center">
            <h4 class="fw-bold mb-3">Apa Itu E-Kuesioner Polibatam?</h4>
            <p class="text-muted mb-5 mx-auto" style="max-width:750px;">
                Layanan E-Kuesioner Polibatam adalah platform online untuk mahasiswa, dosen, alumni, dan masyarakat dalam memberikan umpan balik terhadap layanan Polibatam.
            </p>

            <div class="row justify-content-center">
                <div class="col-md-3">
                    <i class="bi bi-bar-chart feature-icon"></i>
                    <h5 class="fw-bold mt-2">Evaluasi</h5>
                    <p class="text-muted">Platform bagi mahasiswa, dosen, alumni</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-person-badge feature-icon"></i>
                    <h5 class="fw-bold mt-2">Dosen</h5>
                    <p class="text-muted">Pilih layanan dan unit yang hendak dievaluasi</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-mortarboard feature-icon"></i>
                    <h5 class="fw-bold mt-2">Mahasiswa</h5>
                    <p class="text-muted">Pilih layanan yang dievaluasi</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-gear feature-icon"></i>
                    <h5 class="fw-bold mt-2">Peningkatan</h5>
                    <p class="text-muted">Aspek layanan perlu perbaikan</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-3 text-center">
        © 2025 Polibatam - Sistem E-Kuesioner
    </footer>

    {{-- Bootstrap Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


