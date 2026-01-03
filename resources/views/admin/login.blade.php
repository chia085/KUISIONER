<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Kuisioner</title>
    <link rel="icon" type="image/png" href="{{ asset('images/polibatam.png') }}">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #e6f7f2; /* Background color */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for the form */
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Ensures the form is centered */
        }

        /* Logo and Title */
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            width: 80px;
            height: 80px;
        }

        .logo-container h1 {
            color: #2d9c88;
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Form Inputs */
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #2d9c88;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #248c73;
        }

        /* Title */
        .login-title {
            font-size: 28px;
            color: #2d9c88;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Logo and Title -->
        <div class="logo-container">
            <img src="{{ asset('images/polibatam.png') }}" alt="Polibatam Logo">
        </div>

        <!-- Login Form -->
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>

            <input type="submit" value="LOGIN">
        </form>
    </div>

</body>
</html>
