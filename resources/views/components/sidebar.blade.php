<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="https://i.ibb.co.com/s9ps2xyc/download-16.jpg"
            alt="Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-bold">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="https://i.ibb.co.com/HDCXLGJj/download-17.jpg"
                    class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block text-white">Admin</a>
                <small class="text-muted">Administrator</small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <!-- Home -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>

                <!-- Siswa -->
                <li class="nav-item">
                    <a href="{{ route('admin.siswa.index') }}"
                        class="nav-link {{ request()->routeIs('admin.siswa.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Siswa</p>
                    </a>
                </li>

                <!-- Absensi -->
                <li class="nav-item">
                    <a href="{{ route('admin.absensi.index') }}"
                        class="nav-link {{ request()->routeIs('admin.absensi.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>Absensi</p>
                    </a>
                </li>

                <!-- Scan QR -->
                <li class="nav-item">
                    <a href="{{ route('admin.ScanQR.index') }}"
                        class="nav-link {{ request()->routeIs('admin.ScanQR.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-qrcode"></i>
                        <p>Scan QR</p>
                    </a>
                </li>

                <!-- Scan Wajah -->
                <li class="nav-item">
                    <a href="{{ route('face.scan') }}"
                        class="nav-link {{ request()->routeIs('face.scan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Scan Wajah</p>
                    </a>
                </li>

                <!-- Header Akun -->
                <li class="nav-header text-uppercase small">Akun</li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="#"
                        class="nav-link text-danger-custom"
                        onclick="event.preventDefault(); showLogoutConfirm();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>

                    <!-- Form Logout Laravel -->
                    <form id="logout-form"
                        action="{{ route('logout') }}"
                        method="POST"
                        class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>

    </div>
</aside>


<!-- MODAL KONFIRMASI LOGOUT -->
<div id="logoutModal" class="logout-modal">
    <div class="logout-box">

        <div class="logout-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>

        <h4>Konfirmasi Logout</h4>

        <p>Apakah Anda yakin ingin keluar dari akun?</p>

        <div class="logout-buttons">
            <button type="button" class="btn-cancel" onclick="closeLogoutConfirm()">
                Batal
            </button>
            <button type="button" class="btn-logout" onclick="confirmLogout()">
                Logout
            </button>
        </div>

    </div>
</div>


<!-- GOOGLE FONTS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">


<style>

    /* ============ WARNA & FONT ============ */

    :root {
        --ivory: #faf6ec;
        --teal-900: #0b3d36;
        --gold-300: #e3c565;
        --terracotta: #b5482f;
        --terracotta-light: #e2836a;

        --font-display: 'Amiri', Georgia, serif;
        --font-body: 'Plus Jakarta Sans', -apple-system, sans-serif;
    }


    /* ============ SIDEBAR ============ */

    .main-sidebar {
        background: var(--teal-900) !important;
        font-family: var(--font-body);
        border-right: none;
    }


    /* ============ BRAND ============ */

    .main-sidebar .brand-link {
        background: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .main-sidebar .brand-link .brand-text {
        font-family: var(--font-display);
        font-weight: 700 !important;
        color: var(--ivory) !important;
    }

    .main-sidebar .brand-image {
        border: 1px solid rgba(227, 197, 101, 0.6);
    }


    /* ============ USER PANEL ============ */

    .main-sidebar .user-panel {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .main-sidebar .user-panel .image img {
        width: 38px;
        height: 38px;
        object-fit: cover;
        border: 1px solid rgba(227, 197, 101, 0.6);
    }

    .main-sidebar .user-panel .info a {
        font-weight: 600;
        color: var(--ivory) !important;
    }

    .main-sidebar .user-panel .info small {
        font-size: 0.75rem;
        color: rgba(250, 246, 236, 0.55) !important;
    }


    /* ============ MENU ============ */

    .main-sidebar .nav-sidebar > .nav-item > .nav-link {
        margin: 2px 10px;
        border-radius: 8px;
        color: rgba(250, 246, 236, 0.7);
        font-weight: 500;
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .main-sidebar .nav-sidebar > .nav-item > .nav-link p {
        margin-bottom: 0;
    }

    .main-sidebar .nav-sidebar > .nav-item > .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.06);
        color: var(--ivory);
    }

    .main-sidebar .nav-sidebar > .nav-item > .nav-link:focus-visible {
        outline: 2px solid var(--gold-300);
        outline-offset: 1px;
    }


    /* Menu aktif */

    .main-sidebar .nav-sidebar > .nav-item > .nav-link.active {
        background-color: rgba(227, 197, 101, 0.14) !important;
        color: var(--gold-300) !important;
        font-weight: 600;
        box-shadow: none;
    }

    .main-sidebar .nav-sidebar > .nav-item > .nav-link.active .nav-icon {
        color: var(--gold-300) !important;
    }


    /* Ikon */

    .main-sidebar .nav-icon {
        width: 20px;
        margin-right: 10px;
        text-align: center;
        color: rgba(250, 246, 236, 0.5);
    }

    .main-sidebar .nav-link:hover .nav-icon {
        color: var(--gold-300);
    }


    /* Judul grup menu */

    .main-sidebar .nav-header {
        padding: 18px 20px 6px;
        font-size: 0.75rem;
        font-weight: 500;
        letter-spacing: 0.02em;
        text-transform: none !important;
        color: rgba(250, 246, 236, 0.4) !important;
    }


    /* Logout */

    .main-sidebar .nav-sidebar > .nav-item > .nav-link.text-danger-custom {
        color: var(--terracotta-light) !important;
    }

    .main-sidebar .nav-sidebar > .nav-item > .nav-link.text-danger-custom .nav-icon {
        color: var(--terracotta-light) !important;
    }

    .main-sidebar .nav-sidebar > .nav-item > .nav-link.text-danger-custom:hover {
        background-color: rgba(226, 131, 106, 0.1);
    }


    /* ============ MODAL LOGOUT ============ */

    .logout-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(11, 61, 54, 0.5);
    }

    .logout-modal.show {
        display: flex;
    }

    .logout-box {
        width: 340px;
        max-width: 100%;
        padding: 28px 24px 24px;
        text-align: center;
        background: var(--ivory);
        border-radius: 14px;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
        animation: logoutPopup 0.18s ease-out;
    }

    .logout-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(181, 72, 47, 0.1);
        color: var(--terracotta);
        font-size: 20px;
    }

    .logout-box h4 {
        margin: 0 0 6px;
        color: var(--teal-900);
        font-family: var(--font-body);
        font-size: 1.1rem;
        font-weight: 700;
    }

    .logout-box p {
        margin: 0 0 22px;
        color: #6b7280;
        font-family: var(--font-body);
        font-size: 0.875rem;
    }

    .logout-buttons {
        display: flex;
        gap: 10px;
    }

    .logout-buttons button {
        flex: 1;
        padding: 10px 14px;
        border-radius: 8px;
        font-family: var(--font-body);
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }

    .logout-buttons button:focus-visible {
        outline: 2px solid var(--gold-300);
        outline-offset: 2px;
    }

    .btn-cancel {
        background: transparent;
        border: 1px solid #d9d2bf;
        color: #4b5563;
    }

    .btn-cancel:hover {
        background: rgba(0, 0, 0, 0.04);
    }

    .btn-logout {
        background: var(--terracotta);
        border: 1px solid var(--terracotta);
        color: #ffffff;
    }

    .btn-logout:hover {
        background: #963c27;
        border-color: #963c27;
    }

    @keyframes logoutPopup {
        from { opacity: 0; transform: scale(0.96); }
        to   { opacity: 1; transform: scale(1); }
    }

    @media (prefers-reduced-motion: reduce) {
        .logout-box { animation: none; }
        .main-sidebar .nav-link { transition: none; }
    }

</style>


<script>

    /* Buka modal logout */
    function showLogoutConfirm() {
        const modal = document.getElementById('logoutModal');
        modal.classList.add('show');
    }

    /* Tutup modal logout */
    function closeLogoutConfirm() {
        const modal = document.getElementById('logoutModal');
        modal.classList.remove('show');
    }

    /* Konfirmasi logout */
    function confirmLogout() {
        const form = document.getElementById('logout-form');
        form.submit();
    }

    /* Klik di luar modal */
    document
        .getElementById('logoutModal')
        .addEventListener('click', function (event) {
            if (event.target === this) {
                closeLogoutConfirm();
            }
        });

    /* Tombol Escape */
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeLogoutConfirm();
        }
    });

</script>