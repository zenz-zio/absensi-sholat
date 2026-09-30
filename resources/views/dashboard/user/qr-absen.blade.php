@extends('layouts.app')

@section('title', 'QR Code Absensi')

@section('content')

<style>

    :root {
        --bg: #f7f6f2;
        --line: #e8e5dc;
        --ink: #1f2a28;
        --muted: #7a8582;
        --teal: #145c4f;
        --teal-dark: #0f4a41;
        --teal-soft: #e6f0ed;
        --gold: #b08d2a;
        --gold-soft: #f6efd9;
        --rose: #a8452f;
        --rose-soft: #f6e6e1;

        --font-body: system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .qr-container {
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        background: transparent;
        font-family: var(--font-body);
        color: var(--ink);
    }

    .qr-container .container { padding-left: 16px; padding-right: 16px; }

    /* ============ PAGE HEADER ============ */
    .qr-page-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .qr-page-header .btn-outline-custom,
    .qr-page-header .btn-warning-custom {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        flex-shrink: 0;
    }

    /* ============ CARD ============ */
    .qr-card {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid var(--line) !important;
        box-shadow: 0 1px 2px rgba(20, 40, 36, 0.04);
        animation: fadeInUp 0.4s ease-out;
    }

    .qr-header { padding: 16px 20px; border-bottom: 1px solid var(--line); background: #fff; }

    .qr-header h4 { color: var(--ink); margin: 0; font-weight: 600; font-size: 1.1rem; }
    .qr-header h4 i { color: var(--teal); }
    .qr-header p { color: var(--muted); margin: 4px 0 0; font-size: 0.8rem; }

    .qr-card .card-body { padding: 28px 22px; }

    /* ============ QR BOX ============ */
    .qr-box {
        display: inline-block;
        padding: 14px;
        background: #fff;
        border-radius: 14px;
        border: 1px solid var(--line);
        max-width: 100%;
    }

    .qr-box svg { display: block; margin: 0 auto; max-width: 100%; height: auto; }

    /* ============ BADGE ============ */
    .badge-success-custom {
        background: var(--teal);
        padding: 7px 18px;
        border-radius: 50px;
        font-size: 0.83rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #fff;
    }

    /* ============ KODE DARURAT ============ */
    .emergency-code {
        font-size: 1.7rem;
        font-weight: 700;
        font-family: 'IBM Plex Mono', monospace;
        letter-spacing: 4px;
        background: var(--bg);
        display: inline-block;
        max-width: 100%;
        padding: 10px 20px;
        border-radius: 12px;
        color: var(--ink);
        margin: 10px 0;
        border: 1.5px dashed var(--gold);
        word-break: break-all;
    }

    /* ============ TIME INFO ============ */
    .time-info { background: var(--bg); border-radius: 12px; padding: 12px; margin-top: 15px; border: 1px solid var(--line); }
    .expiry-text { font-size: 0.85rem; color: var(--gold); font-weight: 700; }

    /* ============ PROGRESS ============ */
    .progress-custom { height: 8px; border-radius: 10px; background-color: var(--line); overflow: hidden; }
    .progress-bar-custom { background: var(--teal); border-radius: 10px; transition: width 0.8s linear; }

    /* ============ COUNTDOWN ============ */
    .countdown-timer {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--ink);
        background: #fff;
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        margin-top: 10px;
        border: 1px solid var(--line);
    }

    /* ============ BUTTONS ============ */
    .btn-create {
        background: var(--teal);
        border: none;
        border-radius: 10px;
        padding: 11px 24px;
        font-weight: 600;
        transition: background 0.2s ease;
        color: #fff;
        font-size: 0.95rem;
        width: 100%;
        max-width: 260px;
    }
    .btn-create:hover { background: var(--teal-dark); color: #fff; }

    .btn-outline-custom {
        border: 1px solid var(--line);
        border-radius: 50px;
        padding: 8px 16px;
        font-weight: 600;
        transition: background 0.2s ease;
        background: #fff;
        color: var(--teal);
    }
    .btn-outline-custom:hover { background: var(--teal-soft); color: var(--teal); }

    .btn-warning-custom {
        background: var(--gold);
        border: none;
        border-radius: 50px;
        padding: 8px 16px;
        font-weight: 600;
        transition: background 0.2s ease;
        color: #fff;
    }
    .btn-warning-custom:hover { background: #967820; color: #fff; }

    /* ============ EMPTY STATE ============ */
    .empty-state { text-align: center; padding: 10px; }
    .empty-icon { font-size: 58px; color: var(--line); margin-bottom: 14px; animation: rotate 10s linear infinite; }

    /* ============ ALERT ============ */
    .alert-custom { border-radius: 12px; border: none; padding: 14px 18px; animation: fadeInUp 0.3s ease-out; }
    .alert-custom.alert-success { background: var(--teal-soft); color: var(--teal); border-left: 3px solid var(--teal); }
    .alert-custom.alert-danger { background: var(--rose-soft); color: var(--rose); border-left: 3px solid var(--rose); }
    .alert-custom .fa-check-circle { color: var(--teal) !important; }
    .alert-custom .fa-exclamation-circle { color: var(--rose) !important; }

    .bg-light.rounded-3 { background: var(--bg) !important; border: 1px solid var(--line); }

    /* ============ FOOTER NOTE ============ */
    .qr-footer-note { font-size: 0.85rem; line-height: 1.5; padding: 0 8px; }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 768px) {
        .qr-container { min-height: auto; padding: 24px 0; }
        .qr-container .container { padding-left: 12px; padding-right: 12px; }
        .qr-container .py-5 { padding-top: 1.5rem !important; padding-bottom: 1.5rem !important; }
        .qr-card .card-body { padding: 22px 16px; }
        .emergency-code { font-size: 1.3rem; letter-spacing: 3px; padding: 8px 18px; }
        .qr-header { padding: 14px 16px; }
        .qr-header h4 { font-size: 1rem; }
        .countdown-timer { font-size: 0.9rem; }
        .empty-icon { font-size: 48px; }
        .qr-box { padding: 12px; }
        .badge-success-custom { font-size: 0.76rem; padding: 6px 14px; }
    }

    @media (max-width: 380px) {
        .emergency-code { font-size: 1.05rem; letter-spacing: 2px; }
        .qr-header h4 { font-size: 0.92rem; }
    }

</style>

<div class="qr-container">

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-5 col-md-7 col-12">

                {{-- HEADER --}}

                <div class="qr-page-header mb-4">

                    @if ($qrMasihValid)

                        <div class="d-flex gap-2">

                            <button onclick="downloadQR()"
                                class="btn btn-outline-custom"
                                title="Download QR">

                                <i class="fas fa-download"></i>

                            </button>

                            <form action="{{ route('user.force-generate') }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                <button class="btn btn-warning-custom"
                                    onclick="return confirm('QR lama akan tidak berlaku. Lanjutkan?')"
                                    title="Generate QR Baru">

                                    <i class="fas fa-sync-alt"></i>

                                </button>

                            </form>

                        </div>

                    @endif

                </div>

                {{-- ALERT --}}

                @if (session('success'))

                    <div class="alert alert-success alert-custom mb-4">

                        <div class="d-flex align-items-center">

                            <i class="fas fa-check-circle fa-2x me-3"></i>

                            <div class="flex-grow-1">

                                <strong class="d-block">Berhasil!</strong>

                                {{ session('success') }}

                            </div>

                            <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                            </button>

                        </div>

                    </div>

                @endif

                @if (session('error'))

                    <div class="alert alert-danger alert-custom mb-4">

                        <div class="d-flex align-items-center">

                            <i class="fas fa-exclamation-circle fa-2x me-3"></i>

                            <div class="flex-grow-1">

                                <strong class="d-block">Gagal!</strong>

                                {{ session('error') }}

                            </div>

                            <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                            </button>

                        </div>

                    </div>

                @endif

                {{-- MAIN CARD --}}

                <div class="card qr-card border-0">

                    <div class="qr-header">

                        <h4>
                            <i class="fas fa-qrcode me-2"></i>
                            QR Code Absensi
                        </h4>

                        <p>Scan QR Code ini saat waktu sholat</p>

                    </div>

                    <div class="card-body text-center">

                        {{-- MODE: BELUM ADA QR --}}

                        @if (!$qrMasihValid)

                            <div class="empty-state">

                                <div class="empty-icon">

                                    <i class="fas fa-qrcode"></i>

                                </div>

                                <h5 class="mb-2" style="color: var(--ink);">

                                    QR Absensi Belum Dibuat

                                </h5>

                                <p class="text-muted mb-4">

                                    Silakan buat QR untuk melakukan absensi hari ini.

                                </p>

                                <form action="{{ route('user.force-generate') }}"
                                    method="POST">

                                    @csrf

                                    <button class="btn btn-create">

                                        <i class="fas fa-plus me-2"></i>
                                        Buat QR Sekarang

                                    </button>

                                </form>

                            </div>

                        {{-- MODE: QR AKTIF --}}

                        @else

                            <div class="qr-box mb-4">

                                {!! QrCode::size(220)->margin(2)->generate($qrData) !!}

                            </div>

                            <div class="mb-3">

                                <span class="badge-success-custom">

                                    <i class="fas fa-check-circle me-1"></i>
                                    QR AKTIF

                                </span>

                            </div>

                            {{-- Kode Darurat --}}

                            <div class="mt-3 mb-2">

                                <small class="text-muted d-block mb-1">

                                    <i class="fas fa-shield-alt me-1" style="color: var(--gold);"></i>

                                    Kode Darurat

                                </small>

                                <div class="emergency-code">

                                    {{ $kode }}

                                </div>

                                <small class="text-muted">
                                    Gunakan jika QR tidak terbaca
                                </small>

                            </div>

                            {{-- Waktu Berlaku --}}

                            <div class="time-info mt-3">

                                <div class="d-flex justify-content-between align-items-center mb-2">

                                    <small class="text-muted">

                                        <i class="fas fa-hourglass-half me-1"></i>
                                        Berlaku Sampai

                                    </small>

                                    <small class="expiry-text">

                                        <i class="fas fa-clock me-1"></i>
                                        {{ $expired }}

                                    </small>

                                </div>

                                <div class="progress-custom">

                                    <div id="timeProgress"
                                        class="progress-bar-custom"
                                        style="width: 100%">
                                    </div>

                                </div>

                                <div class="countdown-timer"
                                    id="countdown">

                                    --:--:--

                                </div>

                            </div>

                            {{-- Informasi Tambahan --}}

                            <div class="mt-4 p-3 bg-light rounded-3">

                                <small class="text-muted d-block">

                                    <i class="fas fa-info-circle me-1" style="color: var(--gold);"></i>

                                    QR Code akan diperbaharui otomatis setiap hari

                                </small>

                            </div>

                        @endif

                    </div>

                </div>

                {{-- Footer Note --}}

                <div class="text-center mt-4">

                    <small class="text-muted qr-footer-note">

                        "Barangsiapa yang melaksanakan sholat tepat waktu, maka ia mendapatkan cahaya di akhirat"

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

    const expiredAt = {{ $expiredTimestamp ?? 'null' }};
    const qrMasihValidAwal = {{ $qrMasihValid ? 'true' : 'false' }};

    function updateCountdown() {

        if (!expiredAt) return;

        const now = Date.now();
        const distance = expiredAt - now;

        if (distance <= 0) {

            location.reload();
            return;

        }

        const h = Math.floor(distance / (1000 * 60 * 60));
        const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const s = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('countdown').innerHTML =
            '<i class="fas fa-hourglass-half me-1"></i>' +
            String(h).padStart(2, '0') + ':' +
            String(m).padStart(2, '0') + ':' +
            String(s).padStart(2, '0');

        const totalDuration = 60 * 60 * 1000;
        const percent = Math.max(
            0,
            Math.min(100, (distance / totalDuration) * 100)
        );

        document.getElementById('timeProgress').style.width = percent + '%';

        // Change color when time is running out

        if (percent < 30) {

            document.getElementById('timeProgress').style.background = '#a8452f';

        } else if (percent < 60) {

            document.getElementById('timeProgress').style.background = '#b08d2a';

        } else {

            document.getElementById('timeProgress').style.background = '#145c4f';

        }

    }

    if (expiredAt) {

        updateCountdown();

        setInterval(updateCountdown, 1000);

    }

    // ============ POLLING STATUS QR ============

    if (qrMasihValidAwal) {

        setInterval(function () {

            fetch('{{ route("user.qr.status") }}', {

                method: 'GET',

                headers: {

                    'Content-Type': 'application/json',

                    'X-CSRF-TOKEN':
                        document.querySelector('meta[name="csrf-token"]')?.content || '',

                }

            })

            .then(res => res.json())

            .then(data => {

                if (!data.valid) {

                    location.reload();

                }

            })

            .catch(err =>
                console.error('Gagal cek status QR:', err)
            );

        }, 5000);

    }

    function downloadQR() {

        const svg = document.querySelector('.qr-box svg');

        if (!svg) {

            Swal.fire({

                icon: 'warning',
                title: 'Peringatan',
                text: 'QR Code belum tersedia',
                confirmButtonColor: '#145c4f'

            });

            return;

        }

        Swal.fire({

            title: 'Memproses...',
            text: 'Mengunduh QR Code',
            allowOutsideClick: false,

            didOpen: () => {

                Swal.showLoading();

            }

        });

        setTimeout(() => {

            const serializer = new XMLSerializer();
            const source = serializer.serializeToString(svg);

            const img = new Image();
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            img.onload = function() {

                canvas.width = img.width;
                canvas.height = img.height;

                ctx.drawImage(img, 0, 0);

                const a = document.createElement('a');

                a.download =
                    'QR-Absensi-' +
                    new Date().toISOString().split('T')[0] +
                    '.png';

                a.href = canvas.toDataURL('image/png');

                a.click();

                Swal.close();

                Swal.fire({

                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'QR Code berhasil diunduh',
                    timer: 1500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'

                });

            };

            img.onerror = function() {

                Swal.close();

                Swal.fire({

                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal mengunduh QR Code',
                    confirmButtonColor: '#145c4f'

                });

            };

            img.src =
                'data:image/svg+xml;base64,' +
                btoa(unescape(encodeURIComponent(source)));

        }, 500);

    }

</script>

<!-- SweetAlert2 CDN -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection