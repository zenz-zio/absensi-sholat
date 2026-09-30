<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --ivory: #faf6ec;
            --sand: #efe6d0;
            --sand-line: #ddceac;
            --teal-900: #0b3d36;
            --teal-800: #0f4a41;
            --teal-700: #145c4f;
            --gold-600: #a9821d;
            --gold-500: #c9a227;
            --gold-300: #e3c565;
            --ink: #1c2b28;
            --muted: #6b7a76;
            --font-display: 'Amiri', 'Georgia', serif;
            --font-body: 'Plus Jakarta Sans', -apple-system, sans-serif;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: var(--font-body);
            background: var(--ivory);
            color: var(--ink);
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ================= SIDEBAR ================= */

        .app-sidebar {
            width: 240px;
            flex-shrink: 0;
            background: linear-gradient(160deg, var(--teal-900), var(--teal-700));
            color: white;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px 18px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.15rem;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-menu {
            list-style: none;
            margin: 0;
            padding: 14px 10px;
            flex: 1;
        }

        .sidebar-menu li + li {
            margin-top: 4px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.12);
            color: var(--gold-300);
        }

        /* ================= NAVBAR ================= */

        .app-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .app-navbar {
            height: 60px;
            background: white;
            border-bottom: 1px solid var(--sand-line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            flex-shrink: 0;
        }

        .navbar-toggle {
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: var(--teal-800);
            display: none;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: var(--teal-800);
            font-weight: 600;
        }

        .navbar-user .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--sand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--teal-800);
        }

        /* ================= CONTENT ================= */

        .app-content {
            flex: 1;
            padding: 24px;
        }

        .app-footer {
            padding: 14px 24px;
            font-size: 0.78rem;
            color: var(--muted);
            border-top: 1px solid var(--sand-line);
            background: white;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 900px) {
            .app-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 40;
                transform: translateX(-100%);
            }

            .app-sidebar.open {
                transform: translateX(0);
            }

            .navbar-toggle {
                display: inline-block;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="app-wrapper">

        {{-- SIDEBAR — sementara, ganti isi menu sesuai kebutuhan --}}
        <aside class="app-sidebar" id="appSidebar">

            <div class="sidebar-brand">
                🕌 Absensi Sholat
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ url('/siswa/dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                {{-- TODO: isi menu lain sesuai sidebaruser.blade.php kamu --}}
            </ul>

        </aside>

        <div class="app-main">

            {{-- NAVBAR --}}
            <header class="app-navbar">
                <button class="navbar-toggle" onclick="document.getElementById('appSidebar').classList.toggle('open')">
                    ☰
                </button>

                <div class="navbar-user">
                    <div class="avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    {{ Auth::user()->name ?? 'User' }}
                </div>
            </header>

            {{-- CONTENT --}}
            <main class="app-content">
                @yield('content')
            </main>

            <footer class="app-footer">
                &copy; 2025-2026 Absensi Sholat. All rights reserved. — v3.2.0
            </footer>

        </div>

    </div>

    @stack('scripts')

</body>

</html>