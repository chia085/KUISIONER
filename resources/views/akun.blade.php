<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kuesioner - Kelola Akun Kepala Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

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
        }

        .sidebar h4 {
            margin: 0;
            color: #fff;
            font-weight: bold;
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
        }

        .dropdown-container a:hover {
            color: #fff;
            transform: translateX(5px);
        }

        .dropdown-btn i.bi-caret-down-fill {
            float: right;
            transition: transform 0.3s ease;
        }

        .dropdown-btn.active i.bi-caret-down-fill {
            transform: rotate(180deg);
        }

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

        .profile-icon {
            font-size: 1.8rem;
            color: #0046BF;
            cursor: pointer;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
        }

        table {
            width: 100%;
        }

        th {
            background-color: #0046BF;
            color: white;
        }

        td, th {
            text-align: center;
            vertical-align: middle;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
        }

        .pagination button {
            border: none;
            background-color: #0046BF;
            color: white;
            padding: 5px 12px;
            border-radius: 6px;
        }

        .pagination button:disabled {
            background-color: #ccc;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <img src="{{ asset('assets/images/logo_polibatam.png') }}" alt="Logo">
            <h4>E-Kuesioner</h4>
        </div>

        <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>

        <!-- Manajemen -->
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

        <!-- Analisis -->
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

        <!-- Akun -->
        <a href="{{ route('akun') }}" style="color: #fff;"><i class="bi bi-person-gear me-2"></i> Kelola Akun Kepala Unit</a>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <h3>Kelola Akun Kepala Unit</h3>
        <i class="bi bi-person-circle profile-icon"></i>
    </div>

    <!-- Konten -->
    <div class="content">
        <div class="container mt-3">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kepala Unit</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="akunTable">
                        <!-- data dummy diisi lewat script -->
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <button id="prevBtn">Prev</button>
                <span id="pageNum">1</span>
                <button id="nextBtn">Next</button>
            </div>
        </div>
    </div>

    <script>
        // Dropdown interaktif
        document.querySelectorAll('.dropdown-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.toggle('active');
                this.nextElementSibling.classList.toggle('show');
            });
        });

        // Data dummy akun kepala unit
        const akunData = [
            { nama: "Budi Santoso", username: "budi_s", email: "budi@polibatam.ac.id", status: "Aktif" },
            { nama: "Siti Rahma", username: "siti_r", email: "siti@polibatam.ac.id", status: "Aktif" },
            { nama: "Andi Pratama", username: "andi_p", email: "andi@polibatam.ac.id", status: "Tidak Aktif" },
            { nama: "Dewi Lestari", username: "dewi_l", email: "dewi@polibatam.ac.id", status: "Aktif" },
            { nama: "Rudi Hartono", username: "rudi_h", email: "rudi@polibatam.ac.id", status: "Aktif" },
            { nama: "Eka Saputra", username: "eka_s", email: "eka@polibatam.ac.id", status: "Tidak Aktif" },
            { nama: "Rina Kurnia", username: "rina_k", email: "rina@polibatam.ac.id", status: "Aktif" },
            { nama: "Joko Mulyono", username: "joko_m", email: "joko@polibatam.ac.id", status: "Aktif" },
            { nama: "Lina Susanti", username: "lina_s", email: "lina@polibatam.ac.id", status: "Aktif" },
            { nama: "Fajar Nugroho", username: "fajar_n", email: "fajar@polibatam.ac.id", status: "Aktif" },
        ];

        let currentPage = 1;
        const perPage = 5;

        function renderTable() {
            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const paginatedData = akunData.slice(start, end);

            const table = document.getElementById('akunTable');
            table.innerHTML = '';

            paginatedData.forEach((akun, index) => {
                const row = `<tr>
                    <td>${start + index + 1}</td>
                    <td>${akun.nama}</td>
                    <td>${akun.username}</td>
                    <td>${akun.email}</td>
                    <td>${akun.status}</td>
                </tr>`;
                table.innerHTML += row;
            });

            document.getElementById('pageNum').innerText = currentPage;
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = end >= akunData.length;
        }

        document.getElementById('prevBtn').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        document.getElementById('nextBtn').addEventListener('click', () => {
            if (currentPage * perPage < akunData.length) {
                currentPage++;
                renderTable();
            }
        });

        renderTable();
    </script>
</body>
</html>
