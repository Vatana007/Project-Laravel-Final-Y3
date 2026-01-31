<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Nexus POS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --bg-body: #f9fafb;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            outline: none;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* --- BACKGROUND DECORATION (Blurred Orbs) --- */
        .bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            z-index: 0;
            animation: float 10s infinite ease-in-out;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: #c7d2fe;
            top: -100px;
            left: -100px;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: #e0e7ff;
            bottom: -50px;
            right: -50px;
            animation-delay: 2s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(20px, 30px);
            }
        }

        /* --- LOGIN CARD --- */
        .login-card {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        /* --- BRANDING --- */
        .brand-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-mark {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 1rem;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
        }

        p.subtitle {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* --- FORM ELEMENTS --- */
        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: #ffffff;
            color: var(--text-main);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn-primary {
            width: 100%;
            padding: 0.85rem;
            background: var(--text-main);
            /* Black button for modern look */
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background: #000;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* --- UTILS --- */
        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .link:hover {
            text-decoration: underline;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>

<body>

    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>

    <div class="login-card">
        <div class="brand-header">
            <div class="logo-mark">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h1>Nexus POS</h1>
            <p class="subtitle">Enter your credentials to access the dashboard</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <div class="input-wrapper">
                    <input type="email" name="email" class="form-control" placeholder="admin@nexus.com" required
                        autofocus value="admin@example.com">
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required
                        value="password">
                </div>
            </div>

            <div class="actions">
                <label
                    style="display: flex; align-items: center; gap: 6px; cursor: pointer; color: var(--text-muted); font-weight: 500; margin:0;">
                    <input type="checkbox" style="accent-color: var(--text-main);"> Keep me logged in
                </label>
                <a href="#" class="link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-primary">
                Sign In
            </button>
        </form>

        <div style="margin-top: 2rem; text-align: center; border-top: 1px solid #f3f4f6; padding-top: 1.5rem;">
            <p style="font-size: 0.8rem; color: #9ca3af;">Protected by Nexus Security Systems</p>
        </div>
    </div>

</body>

</html>