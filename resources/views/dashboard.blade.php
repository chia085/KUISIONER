<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kuesioner - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", sans-serif;
            background-color: #fff;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #0046BF;
            height: 100vh;
            color: white;
            position: fixed;
            top: 0; left: 0;
            padding: 20px 15px;
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .sidebar .brand img {
            width: 45px;
            height: auto;
        }

        .sidebar .brand h4 {
            margin: 0;
            font-weight: bold;
            color: #fff;
        }

        .sidebar a, .dropdown-btn {
            color: #d1d1d1;
            display: block;
            text-decoration: none;
            margin: 8px 0;
            font-size: 15px;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 6px 0;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .dropdown-btn:hover {
            color: #fff;
            transform: translateX(4px);
        }

        /* Dropdown */
        .dropdown-container {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.3s ease;
            padding-left: 20px;
        }

        .dropdown-container.show {
            max-height: 300px;
            padding-top: 5px;
        }

        .dropdown-container a {
            font-size: 14px;
            color: #e0e0e0;
            display: block;
            margin: 6px 0;
            transition: 0.2s;
        }

        .dropdown-container a:hover {
            color: #fff;
            transform: translateX(5px);
        }

        .dropdown-container a.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 6px;
            padding-left: 10px;
            font-weight: 600;
            color: #ffffff;
        }

        .dropdown-btn i.bi-caret-down-fill {
            float: right;
            transition: transform 0.3s ease;
        }

        .dropdown-btn.active i.bi-caret-down-fill {
            transform: rotate(180deg);
        }

        /* Topbar */
        .topbar {
            height: 60px;
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
            margin-left: 220px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar h3 {
            margin: 0;
            font-weight: 600;
            color: #333;
        }

        .profile-icon {
            font-size: 1.8rem;
            color: #0046BF;
            cursor: pointer;
            transition: 0.2s;
        }

        .profile-icon:hover {
            color: #002f7d;
        }

        /* Content */
        .content {
            margin-left: 240px;
            padding: 20px;
        }

        .btn-category {
            min-width: 180px;
            margin: 10px;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-category:hover {
            background-color: #0046BF;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-category.active {
            background-color: #0046BF;
            color: #fff;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
            transform: scale(1.03);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <img src="{{ asset('assets/images/logo_polibatam.png') }}" alt="Logo Polibatam">
            <h4>E-Kuesioner</h4>
        </div>

        <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>

        <!-- Dropdown Manajemen -->
        <button class="dropdown-btn">
            <i class="bi bi-clipboard-check me-2"></i> Manajemen Kuesioner
            <i class="bi bi-caret-down-fill"></i>
        </button>
        <div class="dropdown-container">
            <a href="{{ route('manajemen.mahasiswa') }}">Mahasiswa</a>
            <a href="{{ route('manajemen.polibatam') }}">Pihak Polibatam</a>
            <a href="{{ route('manajemen.alumni') }}">Alumni / Lulusan</a>
            <a href="{{ route('manajemen.masyarakat') }}">Masyarakat Umum</a>
        </div>

        <!-- 🔽 Tambahan: Dropdown Analisis Data -->
        <button class="dropdown-btn">
            <i class="bi bi-bar-chart-line me-2"></i> Analisis Data
            <i class="bi bi-caret-down-fill"></i>
        </button>
        <div class="dropdown-container">
            <a href="{{ route('analisis.index') }}">Dashboard Analisis</a>
            <a href="{{ route('analisis.mahasiswa') }}">Mahasiswa</a>
            <a href="{{ route('analisis.polibatam') }}">Pihak Polibatam</a>
            <a href="{{ route('analisis.alumni') }}">Alumni / Lulusan</a>
            <a href="{{ route('analisis.masyarakat') }}">Masyarakat Umum</a>
        </div>
        <!-- 🔼 Akhir tambahan -->

        <a href="{{ route('akun') }}"><i class="bi bi-person-gear me-2"></i> Kelola Akun Kepala Unit</a>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <h3>Dashboard</h3>
        <i class="bi bi-person-circle profile-icon"></i>
    </div>

    <!-- Main Content -->
    <div class="content">
        <p><strong>Analisis data</strong></p>

        <div class="d-flex flex-wrap">
            <button class="btn btn-outline-primary btn-category">Mahasiswa</button>
            <button class="btn btn-outline-primary btn-category">Pihak Polibatam</button>
            <button class="btn btn-outline-primary btn-category">Alumni/Lulusan</button>
            <button class="btn btn-outline-primary btn-category">Masyarakat Umum</button>
        </div>
    </div>

    <script>
        // Dropdown interaktif
        document.querySelectorAll('.dropdown-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.toggle('active');
                let dropdown = this.nextElementSibling;
                dropdown.classList.toggle('show');
            });
        });

        // Efek klik di tombol kategori
        document.querySelectorAll('.btn-category').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.btn-category').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Efek aktif submenu
        document.querySelectorAll('.dropdown-container a').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-container a').forEach(a => a.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Otomatis buka dropdown sesuai halaman aktif
        document.addEventListener("DOMContentLoaded", function() {
            const path = window.location.pathname;

            if (path.includes("/analisis")) {
                const btn = [...document.querySelectorAll(".dropdown-btn")]
                    .find(b => b.textContent.includes("Analisis Data"));
                if (btn) {
                    btn.classList.add("active");
                    btn.nextElementSibling.classList.add("show");
                }
            }

            if (path.includes("/manajemen")) {
                const btn = [...document.querySelectorAll(".dropdown-btn")]
                    .find(b => b.textContent.includes("Manajemen Kuesioner"));
                if (btn) {
                    btn.classList.add("active");
                    btn.nextElementSibling.classList.add("show");
                }
            }
        });
    </script>

</body>
</html>
