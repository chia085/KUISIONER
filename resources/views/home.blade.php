<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kuesioner Polibatam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        nav {
            background-color: #0b2c52;
        }
        .nav-link {
            color: #fff !important;
        }
        .nav-link.active {
            color: #f9a825 !important;
        }
        .nav-link:hover {
            color: #f9a825 !important;
            text-decoration: underline;
        }
        .hero {
            background: url('{{ asset('images/Gedung.jpg') }}') no-repeat center center/cover;
            height: 100vh;
            position: relative;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .hero-overlay {
            background-color: rgba(0, 0, 0, 0.45);
            position: absolute;
            top: 0; left: 0;
            right: 0; bottom: 0;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            animation: fadeInUp 1s ease-out;
        }
        .hero h1 span.orange {
            color: #f9a825;
        }
        .hero h1 span.blue {
            color: #0097e6;
        }
        .hero h1, .hero p {
            text-shadow: 2px 2px 6px rgba(0,0,0,0.6);
        }
        .select-user {
            margin-top: 20px;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-white" href="#">
                <img src="{{ asset('images/polii.png') }}" alt="Logo Polibatam" width="40">
                <span class="ms-2">E-Kuesioner</span>
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Panduan</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1><span class="blue">E-Kuesioner</span> <span class="orange">Polibatam</span></h1>
            <p class="lead">Evaluasi layanan kampus untuk meningkatkan kualitas</p>

            <div class="select-user">
                <select class="form-select w-auto mx-auto" id="userSelect">
                    <option selected>Pilih Jenis Pengguna</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                    <option value="alumni">Alumni</option>
                
                </select>
            </div>
            <p class="mt-3">Gunakan akun Polibatam (SSO) untuk Login ke sistem E-Kuesioner</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Aksi ketika user memilih jenis pengguna
        document.getElementById('userSelect').addEventListener('change', function() {
            const val = this.value;
            if (val === 'mahasiswa') window.location.href = '/login/mahasiswa';
            else if (val === 'dosen') window.location.href = '/login/dosen';
            else if (val === 'alumni') window.location.href = '/login/alumni';
        });
    </script>
</body>
</html>
