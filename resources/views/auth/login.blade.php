<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <title>Login | Aplikasi Absensi Sholat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            /* Mosque tilework palette */
            --ivory: #faf6ec;
            --sand: #efe6d0;
            --sand-line: #ddceac;
            --teal-900: #0b3d36;
            --teal-800: #0f4a41;
            --teal-700: #145c4f;
            --teal-600: #1a7364;
            --teal-500: #218a76;
            --gold-600: #a9821d;
            --gold-500: #c9a227;
            --gold-300: #e3c565;
            --gold-100: #f5e9c4;
            --terracotta: #b5482f;
            --ink: #1c2b28;
            --muted: #6b7a76;

            /* Font disederhanakan */
            --font-display: Arial, sans-serif;
            --font-body: Arial, sans-serif;
            --font-mono: Arial, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            min-height: 100vh;
            min-height: 100dvh;

            background:
                radial-gradient(
                    circle at 15% 15%,
                    rgba(227, 197, 101, 0.12) 0%,
                    transparent 45%
                ),
                radial-gradient(
                    circle at 85% 85%,
                    rgba(227, 197, 101, 0.1) 0%,
                    transparent 45%
                ),
                linear-gradient(
                    135deg,
                    var(--teal-900) 0%,
                    var(--teal-700) 100%
                );

            font-family: var(--font-body);
            position: relative;
            overflow-x: hidden;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;
        }

        /* Geometric star motifs */
        body::before {
            content: '';

            position: absolute;
            top: 8%;
            left: 6%;

            width: 220px;
            height: 220px;

            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath fill='%23e3c565' d='M50 0 L61 39 L100 50 L61 61 L50 100 L39 61 L0 50 L39 39 Z'/%3E%3C/svg%3E")
                no-repeat center / contain;

            opacity: 0.08;

            animation:
                float 22s infinite ease-in-out,
                starSpin 90s linear infinite;

            pointer-events: none;
        }

        body::after {
            content: '';

            position: absolute;
            bottom: 8%;
            right: 6%;

            width: 160px;
            height: 160px;

            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath fill='%23e3c565' d='M50 0 L61 39 L100 50 L61 61 L50 100 L39 61 L0 50 L39 39 Z'/%3E%3C/svg%3E")
                no-repeat center / contain;

            opacity: 0.07;

            animation:
                float 17s infinite ease-in-out reverse,
                starSpin 70s linear infinite reverse;

            pointer-events: none;
        }

        @media (max-width: 576px) {
            body::before,
            body::after {
                display: none;
            }
        }

        @keyframes float {
            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-24px) scale(1.05);
            }
        }

        @keyframes starSpin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(26px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card */
        .login-card-wrapper {
            width: 100%;
            max-width: 380px;
        }

        .card {
            border-radius: 22px;
            border: none;
            border-top: 4px solid var(--gold-500);

            background: var(--ivory);

            box-shadow:
                0 30px 60px -18px rgba(11, 61, 54, 0.5);

            animation: slideUp 0.6s ease-out;
            transition: transform 0.3s ease;

            position: relative;
            z-index: 1;

            width: 100%;
            padding: 2rem !important;
        }

        @media (hover: hover) and (pointer: fine) {
            .card:hover {
                transform: translateY(-4px);
            }
        }

        .card h4 {
            color: var(--teal-900);

            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.7rem;

            margin-bottom: 0.4rem;
        }

        .card .text-muted.small {
            color: var(--muted) !important;
        }

        /* Avatar */
        .avatar-badge {
            width: 62px;
            height: 62px;

            background: linear-gradient(
                135deg,
                var(--teal-800) 0%,
                var(--teal-600) 100%
            );

            border-radius: 50%;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 15px;

            border: 3px solid var(--gold-300);

            box-shadow:
                0 8px 20px -4px rgba(11, 61, 54, 0.4);
        }

        .avatar-badge i {
            font-size: 26px;
            color: white;
        }

        /* Form */
        .form-control {
            border-radius: 12px;

            border: 1.5px solid var(--sand-line);

            padding: 12px 16px;

            font-size: 16px;

            font-family: var(--font-mono);

            transition: all 0.3s ease;

            background: white;
            color: var(--ink);

            cursor: default;
        }

        .form-control:focus {
            border-color: var(--teal-600);

            box-shadow:
                0 0 0 3px rgba(33, 138, 118, 0.18);

            background: white;
            outline: none;
        }

        .form-control::placeholder {
            color: #9aa8a4;

            font-size: 0.9rem;

            font-family: var(--font-body);
        }

        /* Error message */
        .input-error {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-top: 7px;
            margin-left: 4px;

            color: var(--terracotta);

            font-size: 0.78rem;
            font-weight: 600;
        }

        .input-error i {
            font-size: 0.75rem;
        }

        .form-control.is-invalid {
            border-color: var(--terracotta);

            background-image: none;

            box-shadow:
                0 0 0 2px rgba(181, 72, 47, 0.08);
        }

        .form-control.is-invalid:focus {
            border-color: var(--terracotta);

            box-shadow:
                0 0 0 3px rgba(181, 72, 47, 0.12);
        }

        /* Input icon */
        .input-icon-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;

            left: 16px;
            top: 50%;

            transform: translateY(-50%);

            color: var(--gold-600);

            font-size: 1rem;

            z-index: 2;

            pointer-events: none;
        }

        .input-icon-wrapper .form-control {
            padding-left: 45px;
        }

        /* Button */
        .btn-primary {
            background: linear-gradient(
                120deg,
                var(--teal-800),
                var(--teal-600)
            );

            border: none;
            border-radius: 12px;

            padding: 13px;

            font-weight: 700;
            font-size: 0.98rem;

            transition: all 0.3s ease;

            cursor: pointer;

            min-height: 48px;
        }

        @media (hover: hover) and (pointer: fine) {
            .btn-primary:hover {
                transform: translateY(-2px);

                box-shadow:
                    0 12px 24px -6px rgba(15, 74, 65, 0.45);
            }
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Alert */
        .alert {
            border-radius: 12px;

            border: none;

            background: #fbe9e4;

            color: var(--terracotta);

            font-size: 0.85rem;

            padding: 12px;

            border-left: 4px solid var(--terracotta);
        }

        /* Link */
        a {
            color: var(--teal-700);

            text-decoration: none;

            font-weight: 700;

            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--teal-900);

            text-decoration: underline;
        }

        /* Divider */
        .card-footer-text {
            margin-top: 1.5rem;

            padding-top: 1rem;

            border-top: 1px dashed var(--sand-line);

            color: var(--muted);

            font-size: 0.9rem;
        }

        /* HP */
        @media (max-width: 400px) {
            .card {
                padding: 1.5rem !important;
                border-radius: 18px;
            }

            .card h4 {
                font-size: 1.4rem;
            }

            .avatar-badge {
                width: 54px;
                height: 54px;
            }

            .avatar-badge i {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

    <div class="login-card-wrapper">

        <div class="card p-4 shadow">

            <div class="text-center mb-3">

                <div class="avatar-badge">
                    <i class="fas fa-mosque"></i>
                </div>

                <h4>Selamat Datang</h4>

                <p class="text-muted small">
                    Silakan login untuk melanjutkan
                </p>

            </div>

            {{-- Error umum --}}
            @if(session('error'))
                <div class="alert alert-danger">

                    <i class="fas fa-exclamation-circle me-2"></i>

                    {{ session('error') }}

                </div>
            @endif

            <form method="POST" action="{{ route('store.login') }}">

                @csrf

                {{-- EMAIL --}}
                <div class="mb-3">

                    <div class="input-icon-wrapper">

                        <span class="input-icon">
                            <i class="fas fa-envelope"></i>
                        </span>

                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email"
                            value="{{ old('email') }}"
                            required
                        >

                    </div>

                    @error('email')
                        <div class="input-error">

                            <i class="fas fa-circle-exclamation"></i>

                            {{ $message }}

                        </div>
                    @enderror

                </div>

                {{-- PASSWORD --}}
                <div class="mb-3">

                    <div class="input-icon-wrapper">

                        <span class="input-icon">
                            <i class="fas fa-lock"></i>
                        </span>

                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password"
                            required
                        >

                    </div>

                    @error('password')
                        <div class="input-error">

                            <i class="fas fa-circle-exclamation"></i>

                            {{ $message }}

                        </div>
                    @enderror

                </div>

                {{-- BUTTON LOGIN --}}
                <button
                    type="submit"
                    class="btn btn-primary w-100 text-white"
                >

                    <i class="fas fa-sign-in-alt me-2"></i>

                    Login

                </button>

            </form>

            <div class="card-footer-text text-center">

                <p class="mb-0">

                    <i
                        class="fas fa-user-plus me-1"
                        style="color: var(--gold-600);"
                    ></i>

                    Belum punya akun?

                    <a href="{{ route('register') }}">
                        Daftar Sekarang
                    </a>

                </p>

            </div>

        </div>

    </div>

</body>

</html>