<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Kuesioner Polibatam</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('{{ asset('assets/images/background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            padding: 40px 30px;
            width: 100%;
            max-width: 360px;
            text-align: center;
        }

        .login-card .form-control {
            border: none;
            border-bottom: 2px solid #ccc;
            border-radius: 0;
            box-shadow: none;
            font-size: 16px;
            padding: 12px 10px;
            background: transparent;
        }

        .login-card .form-control:focus {
            border-color: #0043ce;
            box-shadow: none;
        }

        .btn-login {
            background-color: #0043ce;
            color: white;
            font-weight: 500;
            border-radius: 25px;
            padding: 10px 0;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0032a0;
        }

        .icon {
            font-size: 1.3rem;
            color: #0043ce;
            margin-right: 8px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <form action="#" method="POST">
            @csrf
            <div class="mb-4 text-start">
                <label class="form-label fw-semibold">
                    <i class="bi bi-person icon"></i> Username
                </label>
                <input type="text" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-semibold">
                    <i class="bi bi-lock icon"></i> Password
                </label>
                <input type="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-login w-100">Masuk</button>
        </form>
    </div>

    {{-- Bootstrap Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
