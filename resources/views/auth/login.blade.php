<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - System</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #eef2ff;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary);
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h1 class="brand">Sale System</h1>

        @if($errors->any())
            <div style="color: red; margin-bottom: 1rem; text-align: center;">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>

            <label>Password</label>
            <input type="password" name="password" class="form-control" required>

            <button class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login</button>
        </form>
    </div>
</body>

</html>