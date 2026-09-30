<!-- resources/views/scan.blade.php -->
@extends('layouts.main')
@section('title', 'Scan Absensi')

@push('styles')
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
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .container-fluid, .toast-container { font-family: var(--font-body); color: var(--ink); font-variant-numeric: tabular-nums; }

        /* ============ SHELL ============ */
        .scan-card {
            background: #fff;
            border: 1px solid var(--line) !important;
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(20, 40, 36, 0.04);
            overflow: hidden;
        }

        .card-header-gradient { padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--line); background: #fff; }
        .card-header-gradient .eyebrow {
            font-size: 0.7rem; letter-spacing: 0.08em; text-transform: uppercase;
            color: var(--muted); display: block; margin-bottom: 4px; font-weight: 600;
        }
        .card-header-gradient h3 { color: var(--ink); font-weight: 600; font-size: 1.3rem; }
        .card-header-gradient h3 i { color: var(--teal); }
        .card-header-gradient p { color: var(--muted); font-size: 0.86rem; }

        .badge-light-custom {
            background: var(--teal-soft);
            color: var(--teal);
            padding: 7px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* ============ TOASTS ============ */
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }

        .toast {
            min-width: 320px;
            padding: 12px 16px;
            border-radius: 10px;
            color: #fff;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            opacity: 0;
            transform: translateX(24px);
            transition: all 0.3s ease;
            box-shadow: 0 8px 22px rgba(20, 40, 36, 0.2);
            font-size: 0.9rem;
        }
        .toast.show { opacity: 1; transform: translateX(0); }
        .toast.success { background: var(--teal); }
        .toast.error { background: var(--rose); }
        .toast.warning { background: var(--gold); }
        .toast.info { background: #34433f; }

        /* ============ PRAYER RAIL ============ */
        .prayer-rail {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 12px 10px 6px;
            margin-bottom: 14px;
            position: relative;
        }
        .prayer-rail::before {
            content: '';
            position: absolute;
            top: 22px; left: 30px; right: 30px;
            height: 1px;
            background: var(--line);
            z-index: 0;
        }
        .rail-node { position: relative; z-index: 1; display: flex; flex-direction: column; align-items: center; flex: 1; }
        .rail-node .dot {
            width: 12px; height: 12px; border-radius: 50%;
            background: #fff; border: 2px solid var(--line);
            margin-bottom: 8px; transition: all 0.3s ease;
        }
        .rail-node .label { font-size: 0.7rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em; }
        .rail-node .time { font-size: 0.7rem; color: var(--muted); opacity: 0.8; }

        .rail-node.done .dot { background: var(--teal); border-color: var(--teal); }
        .rail-node.done .label { color: var(--teal); }
        .rail-node.active .dot { background: var(--gold); border-color: var(--gold); box-shadow: 0 0 0 4px var(--gold-soft); }
        .rail-node.active .label { color: var(--gold); font-weight: 700; }
        .rail-node.active .time { color: var(--gold); }

        /* ============ PRAYER STATUS ============ */
        .prayer-info {
            padding: 16px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid var(--line);
            background: #fff;
        }
        .prayer-info.active { background: var(--gold-soft); border-color: #e8d9a6; }
        .prayer-info.inactive { background: var(--rose-soft); border-color: #ecc9bf; }
        .prayer-info.waiting { background: var(--teal-soft); border-color: #cfe1dc; }
        .prayer-info h5 { font-weight: 600; font-size: 1.05rem; }

        /* ============ FORM ============ */
        .form-group-modern { margin-bottom: 18px; }
        .form-group-modern label { font-weight: 500; color: var(--ink); margin-bottom: 6px; display: block; font-size: 0.86rem; }
        .form-group-modern label i { color: var(--muted); width: 16px; }

        .form-group-modern input {
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px 14px;
            background: #fff;
            font-size: 0.9rem;
            color: var(--ink);
        }
        .form-group-modern input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(20, 92, 79, 0.12); }
        .form-group-modern input:disabled { background: var(--bg); color: var(--muted); cursor: not-allowed; }

        .form-text { color: var(--muted); font-size: 0.78rem; }
        .form-text i { color: var(--muted); }

        /* ============ BUTTONS ============ */
        .btn-gradient, .btn-success-gradient, .btn-warning-gradient {
            border: none;
            border-radius: 10px;
            padding: 11px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s ease;
            color: #fff;
        }
        .btn-gradient { background: var(--teal); }
        .btn-gradient:hover { background: var(--teal-dark); color: #fff; }
        .btn-success-gradient { background: var(--teal-dark); }
        .btn-success-gradient:hover { background: #0b3d36; color: #fff; }
        .btn-warning-gradient { background: var(--gold); }
        .btn-warning-gradient:hover { background: #967820; color: #fff; }
        .btn-gradient:disabled, .btn-success-gradient:disabled, .btn-warning-gradient:disabled { opacity: 0.5; cursor: not-allowed; }

        .btn-secondary-custom {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 11px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--ink);
            transition: background 0.2s ease;
        }
        .btn-secondary-custom:hover { background: var(--bg); }

        .btn-outline-secondary-custom {
            border: 1px solid var(--line);
            color: var(--muted);
            border-radius: 10px;
            padding: 6px 14px;
            font-size: 0.82rem;
            font-weight: 500;
            background: #fff;
            transition: background 0.2s ease;
        }
        .btn-outline-secondary-custom:hover { background: var(--bg); color: var(--ink); }

        .manual-divider {
            display: flex; align-items: center; margin: 4px 0 18px; gap: 10px;
            color: var(--muted); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em;
        }
        .manual-divider::before, .manual-divider::after { content: ''; flex: 1; height: 1px; background: var(--line); }

        hr.divider-custom { border-top: 1px solid var(--line); margin: 1.5rem 0; opacity: 1; }

        /* ============ SCANNER ============ */
        .scanner-wrapper {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            background: #10201d;
            border: 1px solid var(--line);
        }
        #reader { border-radius: 14px; overflow: hidden; position: relative; }

        .scanner-overlay {
            position: absolute;
            inset: 0;
            background: rgba(16, 32, 29, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #fff;
            z-index: 10;
            border-radius: 14px;
        }
        .scanner-overlay .spinner-border { width: 40px; height: 40px; margin-bottom: 14px; }

        .scanner-status { display: inline-block; width: 9px; height: 9px; border-radius: 50%; background: var(--rose); }
        .scanner-status.active { background: var(--teal); }

        /* ============ HISTORY ============ */
        .history-header { border-bottom: 1px solid var(--line); padding-bottom: 10px; }
        .history-header h5 { color: var(--ink); font-weight: 600; font-size: 1.05rem; }

        .history-container { max-height: 300px; overflow-y: auto; padding-right: 10px; }

        .history-item {
            margin-bottom: 10px;
            padding: 12px 15px;
            background: #fff;
            border: 1px solid var(--line);
            border-left: 3px solid var(--teal);
            border-radius: 10px;
            animation: fadeInUp 0.3s ease-out;
        }
        .history-item.success { border-left-color: var(--teal); }
        .history-item.error { border-left-color: var(--rose); }

        .history-item .badge-success-custom {
            background: var(--teal-soft); color: var(--teal);
            padding: 3px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 600;
        }
        .history-item .badge-danger-custom {
            background: var(--rose-soft); color: var(--rose);
            padding: 3px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 600;
        }

        .history-container::-webkit-scrollbar { width: 6px; }
        .history-container::-webkit-scrollbar-track { background: var(--bg); border-radius: 10px; }
        .history-container::-webkit-scrollbar-thumb { background: #cfcbbd; border-radius: 10px; }

        .loading-spinner {
            display: inline-block; width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.35);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.6s linear infinite;
        }

        .input-group-custom { align-items: stretch; gap: 0 !important; }
        .input-group-custom .form-control { border-radius: 10px 0 0 10px; border-right: none; }
        .input-group-custom .btn {
            border-radius: 0 10px 10px 0;
            display: flex; align-items: center; justify-content: center;
            white-space: nowrap; padding-top: 0; padding-bottom: 0;
        }

        @media (max-width: 768px) {
            .card-header-gradient { padding: 1rem 1.25rem; }
            .card-header-gradient h3 { font-size: 1.15rem; }
            .btn-gradient, .btn-success-gradient, .btn-warning-gradient { padding: 10px 14px; font-size: 0.85rem; }
            .rail-node .label { font-size: 0.6rem; }
            .rail-node .time { display: none; }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="scan-card card border-0">
        <div class="card-header-gradient">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <span class="eyebrow">Absensi Digital &middot; Masjid Sekolah</span>
                    <h3 class="mb-0">
                        <i class="fas fa-qrcode me-2"></i>
                        Scan QR Absensi Sholat
                    </h3>
                    <p class="mb-0 mt-2">
                        <i class="fas fa-mosque me-1"></i>
                        Arahkan kamera ke QR Code siswa untuk mencatat kehadiran
                    </p>
                </div>
                <div class="mt-2 mt-md-0">
                    <span class="badge-light-custom">
                        <i class="fas fa-user-check me-1"></i>
                        {{ auth()->user()->name ?? 'Recorder' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- Prayer Rail -->
            <div class="prayer-rail" id="prayerRail">
                <div class="rail-node" data-key="subuh"><span class="dot"></span><span class="label">Subuh</span><span class="time">--:--</span></div>
                <div class="rail-node" data-key="dzuhur"><span class="dot"></span><span class="label">Dzuhur</span><span class="time">--:--</span></div>
                <div class="rail-node" data-key="ashar"><span class="dot"></span><span class="label">Ashar</span><span class="time">--:--</span></div>
                <div class="rail-node" data-key="maghrib"><span class="dot"></span><span class="label">Maghrib</span><span class="time">--:--</span></div>
                <div class="rail-node" data-key="isya"><span class="dot"></span><span class="label">Isya</span><span class="time">--:--</span></div>
            </div>

            <div class="row">
                <!-- Left Panel -->
                <div class="col-lg-5">
                    <!-- Info Waktu Sholat -->
                    <div class="prayer-info waiting" id="prayerInfo">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border me-3" style="width: 26px; height: 26px; color: var(--teal);"></div>
                            <div>
                                <strong style="color: var(--teal);">Memuat jadwal sholat...</strong><br>
                                <small class="text-muted">Mengambil data jadwal sholat</small>
                            </div>
                        </div>
                    </div>

                    <!-- ID Recorder -->
                    <div class="form-group-modern">
                        <label>
                            <i class="fas fa-microphone-alt me-2"></i>
                            ID Recorder
                        </label>
                        <input type="text" id="id_recorder" class="form-control"
                               value="{{ auth()->user()->id }}" disabled readonly>
                        <small class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            ID perangkat perekam (otomatis dari akun login)
                        </small>
                    </div>

                    <!-- Hasil Scan QR -->
                    <div class="form-group-modern">
                        <label>
                            <i class="fas fa-qrcode me-2"></i>
                            Hasil Scan QR
                        </label>
                        <input type="text" id="randomString" class="form-control"
                               placeholder="QR Code akan muncul di sini" readonly>
                    </div>

                    <!-- Kode Darurat -->
                    <div class="form-group-modern">
                        <label>
                            <i class="fas fa-shield-alt me-2"></i>
                            Kode Darurat
                        </label>
                        <div class="d-flex input-group-custom">
                            <input type="text" id="emergency_code" class="form-control flex-grow-1"
                                   placeholder="Masukkan kode 6 digit" maxlength="6">
                            <button class="btn btn-warning-gradient" id="submitEmergencyBtn">
                                <i class="fas fa-paper-plane me-1"></i> Submit
                            </button>
                        </div>
                        <small class="form-text">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Gunakan jika QR Code tidak terbaca
                        </small>
                    </div>

                    <!-- Absen Manual NISN -->
                    <div class="manual-divider">atau absen manual</div>
                    <div class="form-group-modern">
                        <label>
                            <i class="fas fa-id-card me-2"></i>
                            Absen Manual via NISN
                        </label>
                        <div class="d-flex input-group-custom">
                            <input type="text" id="nisn_manual" class="form-control flex-grow-1"
                                   placeholder="Masukkan NISN siswa" maxlength="10">
                            <button class="btn btn-success-gradient" id="submitNisnBtn">
                                <i class="fas fa-check me-1"></i> Absen
                            </button>
                        </div>
                        <small class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Gunakan jika siswa tidak membawa kartu QR
                        </small>
                    </div>

                    <!-- Keterangan Sholat -->
                    <div class="form-group-modern">
                        <label>
                            <i class="fas fa-clock me-2"></i>
                            Keterangan Sholat
                        </label>
                        <input type="text" id="keterangan" class="form-control"
                               placeholder="Otomatis terisi" readonly>
                        <small class="form-text" id="keteranganHelp">
                            <i class="fas fa-sync-alt me-1"></i>
                            Otomatis sesuai jadwal sholat aktif
                        </small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-gradient flex-grow-1" id="startScanBtn" disabled>
                            <i class="fas fa-play me-2"></i>
                            Mulai Scan
                        </button>
                        <button class="btn btn-secondary-custom flex-grow-1" id="switchCameraBtn" style="display:none">
                            <i class="fas fa-sync-alt me-2"></i>
                            Ganti Kamera
                        </button>
                    </div>
                </div>

                <!-- Right Panel - Scanner -->
                <div class="col-lg-7 mt-4 mt-lg-0">
                    <div class="scanner-wrapper">
                        <div id="reader" style="width:100%; max-width:500px; margin:0 auto; position:relative">
                            <div class="scanner-overlay" id="scannerOverlay">
                                <div class="spinner-border text-light mb-3"></div>
                                <h6 class="mb-2 text-light">Memproses Absensi...</h6>
                                <small class="text-light">Mohon tunggu sebentar</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <span class="scanner-status me-1" id="scannerStatusDot"></span>
                            Arahkan kamera ke QR Code siswa
                        </small>
                    </div>
                </div>
            </div>

            <hr class="divider-custom">

            <!-- History Section -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3 history-header">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2" style="color: var(--muted);"></i>
                            Riwayat Scan
                        </h5>
                        <button class="btn btn-outline-secondary-custom" onclick="clearHistory()">
                            <i class="fas fa-trash-alt me-1"></i>
                            Hapus Riwayat
                        </button>
                    </div>
                    <div class="history-container" id="scanHistory">
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-2 d-block opacity-50" style="color: var(--muted);"></i>
                            <small>Belum ada riwayat scan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Scripts -->
<script src="https://unpkg.com/html5-qrcode"></script>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // DOM Elements
    const idRecorderInput = document.getElementById('id_recorder');
    const randomStringInput = document.getElementById('randomString');
    const emergencyCodeInput = document.getElementById('emergency_code');
    const nisnInput = document.getElementById('nisn_manual');
    const keteranganInput = document.getElementById('keterangan');
    const startBtn = document.getElementById('startScanBtn');
    const switchBtn = document.getElementById('switchCameraBtn');
    const submitEmergencyBtn = document.getElementById('submitEmergencyBtn');
    const submitNisnBtn = document.getElementById('submitNisnBtn');
    const overlay = document.getElementById('scannerOverlay');
    const historyContainer = document.getElementById('scanHistory');
    const prayerInfo = document.getElementById('prayerInfo');
    const prayerRail = document.getElementById('prayerRail');
    const scannerStatusDot = document.getElementById('scannerStatusDot');

    // State Variables
    let html5QrCode = null;
    let currentCameraId = null;
    let cameras = [];
    let cameraIndex = 0;
    let isSubmitting = false;
    let currentActivePrayer = null;
    let isScanAllowed = false;
    let prayerSchedule = {};
    let scanInterval = null;

    // Anti-spam state
    let lastScanTime = 0;
    let lastScannedCode = null;
    const SCAN_COOLDOWN_MS = 3000; // jeda sebelum QR yang sama bisa discan ulang
    const BUTTON_COOLDOWN_MS = 3000; // jeda tombol manual setelah submit

    // Toast Function
    function showToast(message, type = "success") {
        const container = document.getElementById("toastContainer");
        const toast = document.createElement("div");
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-times-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        toast.className = `toast ${type} show`;
        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas ${icons[type] || icons.success} me-3 fa-lg"></i>
                <div class="flex-grow-1">${message}</div>
                <button class="btn-close btn-close-white ms-3" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    function showOverlay(show = true) {
        overlay.style.display = show ? "flex" : "none";
    }

    function addToHistory(namaSiswa, status, message) {
        if (historyContainer.querySelector('.text-center')) {
            historyContainer.innerHTML = '';
        }
        const historyItem = document.createElement('div');
        historyItem.className = `history-item ${status === 'Berhasil' ? 'success' : 'error'}`;
        const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        historyItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong style="color: var(--teal);">${time}</strong>
                    ${namaSiswa ? `<span class="mx-2 text-muted">•</span> <strong class="text-dark">${namaSiswa}</strong>` : ''}
                </div>
                <span class="${status === 'Berhasil' ? 'badge-success-custom' : 'badge-danger-custom'}">
                    ${status === 'Berhasil' ? '<i class="fas fa-check me-1"></i>' : '<i class="fas fa-times me-1"></i>'}
                    ${status}
                </span>
            </div>
            <div class="mt-1 small text-muted">${message}</div>
        `;
        historyContainer.prepend(historyItem);
        while (historyContainer.children.length > 20) {
            historyContainer.removeChild(historyContainer.lastChild);
        }
    }

    function clearHistory() {
        historyContainer.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fas fa-inbox fa-3x mb-2 d-block opacity-50" style="color: var(--muted);"></i>
                <small>Belum ada riwayat scan</small>
            </div>
        `;
        showToast('Riwayat berhasil dihapus', 'info');
    }

    // Helper: disable tombol + spinner selama proses, lalu cooldown setelah selesai
    async function withButtonCooldown(button, fn, cooldownMs = BUTTON_COOLDOWN_MS) {
        if (button.disabled) return;
        const originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="loading-spinner"></span>';
        try {
            await fn();
        } finally {
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = originalHtml;
            }, cooldownMs);
        }
    }

    // Render prayer rail (timeline of the 5 daily prayers)
    function renderPrayerRail(prayers, activeKey) {
        if (!prayerRail) return;
        const now = new Date();
        prayers.forEach(p => {
            const node = prayerRail.querySelector(`.rail-node[data-key="${p.key}"]`);
            if (!node) return;
            node.querySelector('.time').textContent = p.time || '--:--';
            node.classList.remove('active', 'done');
            if (p.key === activeKey) {
                node.classList.add('active');
            } else if (p.time) {
                const [h, m] = p.time.split(':');
                const t = new Date(now);
                t.setHours(parseInt(h), parseInt(m), 0, 0);
                if (now > t) node.classList.add('done');
            }
        });
    }

    // Fetch Prayer Times
    async function fetchPrayerTimes() {
        const today = new Date().toISOString().split('T')[0];
        try {
            const response = await fetch(
                `https://api.aladhan.com/v1/timings/${today}?latitude=-0.227819&longitude=100.626617&method=20`
            );
            const data = await response.json();
            const timings = data.data.timings;
            prayerSchedule = {
                subuh: timings.Fajr,
                dzuhur: timings.Dhuhr,
                ashar: timings.Asr,
                maghrib: timings.Maghrib,
                isya: timings.Isha
            };
            updatePrayerStatus();
            if (scanInterval) clearInterval(scanInterval);
            scanInterval = setInterval(updatePrayerStatus, 30000);
            return true;
        } catch (error) {
            console.error('Gagal fetch jadwal sholat:', error);
            prayerInfo.innerHTML = `
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2 d-block" style="color: var(--rose);"></i>
                    <strong style="color: var(--rose);">Gagal memuat jadwal sholat</strong>
                    <button class="btn btn-sm btn-gradient mt-2" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-1"></i> Muat Ulang
                    </button>
                </div>
            `;
            return false;
        }
    }

    function updatePrayerStatus() {
        const now = new Date();
        const prayers = [
            { name: 'Subuh', key: 'subuh', time: prayerSchedule.subuh },
            { name: 'Dzuhur', key: 'dzuhur', time: prayerSchedule.dzuhur },
            { name: 'Ashar', key: 'ashar', time: prayerSchedule.ashar },
            { name: 'Maghrib', key: 'maghrib', time: prayerSchedule.maghrib },
            { name: 'Isya', key: 'isya', time: prayerSchedule.isya }
        ];

        let activePrayer = null;
        let nextPrayer = null;

        for (let i = 0; i < prayers.length; i++) {
            const [hours, minutes] = prayers[i].time.split(':');
            const prayerTime = new Date(now);
            prayerTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
            const scanStartTime = new Date(prayerTime.getTime() - 15 * 60000);
            let scanEndTime;
            if (i < prayers.length - 1) {
                const [nextHours, nextMinutes] = prayers[i + 1].time.split(':');
                scanEndTime = new Date(now);
                scanEndTime.setHours(parseInt(nextHours), parseInt(nextMinutes), 0, 0);
            } else {
                scanEndTime = new Date(now);
                scanEndTime.setDate(scanEndTime.getDate() + 1);
                scanEndTime.setHours(4, 0, 0, 0);
            }
            if (now >= scanStartTime && now < scanEndTime) {
                activePrayer = prayers[i];
                nextPrayer = prayers[i + 1] || prayers[0];
                break;
            }
        }

        renderPrayerRail(prayers, activePrayer ? activePrayer.key : null);

        if (activePrayer) {
            isScanAllowed = true;
            currentActivePrayer = activePrayer.name;
            prayerInfo.className = 'prayer-info active';
            prayerInfo.innerHTML = `
                <div class="d-flex align-items-start">
                    <i class="fas fa-check-circle fa-2x me-3" style="color: var(--gold);"></i>
                    <div class="flex-grow-1">
                        <strong class="d-block mb-1" style="color: var(--gold);">Absensi Aktif</strong>
                        <h5 class="mb-1 text-dark">Sholat ${activePrayer.name}</h5>
                        <small style="color: var(--gold);">
                            <i class="fas fa-clock me-1"></i>
                            Waktu: ${activePrayer.time} - ${nextPrayer ? nextPrayer.time : '04:00'}
                        </small>
                    </div>
                </div>
            `;
            keteranganInput.value = `Sholat ${activePrayer.name}`;
            startBtn.disabled = false;
            startBtn.innerHTML = '<i class="fas fa-qrcode me-2"></i> Mulai Scan';
        } else {
            isScanAllowed = false;
            currentActivePrayer = null;
            for (let i = 0; i < prayers.length; i++) {
                const [hours, minutes] = prayers[i].time.split(':');
                const prayerTime = new Date(now);
                prayerTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
                if (now < prayerTime) { nextPrayer = prayers[i]; break; }
            }
            if (!nextPrayer) nextPrayer = prayers[0];
            prayerInfo.className = 'prayer-info waiting';
            prayerInfo.innerHTML = `
                <div class="d-flex align-items-start">
                    <i class="fas fa-clock fa-2x me-3" style="color: var(--teal);"></i>
                    <div class="flex-grow-1">
                        <strong class="d-block mb-1" style="color: var(--teal);">Menunggu Waktu Sholat</strong>
                        <h5 class="mb-1 text-dark">Sholat ${nextPrayer.name}</h5>
                        <small class="text-muted">
                            <i class="fas fa-hourglass-half me-1"></i>
                            Akan dibuka 15 menit sebelum waktu sholat
                        </small>
                    </div>
                </div>
            `;
            keteranganInput.value = '';
            startBtn.disabled = true;
            startBtn.innerHTML = '<i class="fas fa-lock me-2"></i> Scan Terkunci';
            if (html5QrCode && html5QrCode.isScanning) { stopScanner(); }
        }
    }

    // Submit via NISN
    async function submitAttendanceNisn(nisn) {
        if (isSubmitting) {
            showToast("Proses sedang berjalan, tunggu sebentar...", "warning");
            return;
        }

        isSubmitting = true;
        showOverlay(true);

        try {
            const response = await fetch('/api/scan-sholat-nisn', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({
                    nisn: nisn,
                    id_recorder: idRecorderInput.value.trim(),
                    prayer_name: currentActivePrayer,
                    keterangan: keteranganInput.value.trim() || `Sholat ${currentActivePrayer}`,
                }),
            });

            const result = await response.json();

            if (response.ok && result.success) {
                showToast(result.message || 'Absensi berhasil!', 'success');
                const siswaName = result.data?.siswa?.nama ?? 'Siswa';
                addToHistory(siswaName, 'Berhasil', `${result.message} - ${currentActivePrayer}`);
                nisnInput.value = '';
            } else {
                const errorMsg = result.message || 'NISN tidak ditemukan';
                showToast(errorMsg, 'error');
                addToHistory(null, 'Gagal', errorMsg);
            }
        } catch (error) {
            console.error(error);
            showToast('Gagal terhubung ke server.', 'error');
        } finally {
            isSubmitting = false;
            showOverlay(false);
        }
    }

    // Submit via QR / Emergency
    async function submitAttendance(payload, source = 'qr') {
        if (!isScanAllowed) {
            showToast("Absensi hanya bisa dilakukan saat waktu sholat aktif!", "warning");
            return false;
        }
        if (isSubmitting) {
            showToast("Proses sedang berjalan, tunggu sebentar...", "warning");
            return false;
        }

        const recorderId = idRecorderInput.value.trim();
        if (!recorderId) {
            showToast("ID Recorder tidak ditemukan", "error");
            return false;
        }

        const requestData = {
            id_recorder: recorderId,
            prayer_name: currentActivePrayer,
            keterangan: keteranganInput.value.trim() || `Sholat ${currentActivePrayer}`,
        };

        if (source === 'qr') {
            requestData.qr_code = payload;
        } else if (source === 'emergency') {
            requestData.emergency_code = payload;
        } else {
            return false;
        }

        isSubmitting = true;
        showOverlay(true);

        try {
            const response = await fetch('/api/scan-sholat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify(requestData),
            });

            const result = await response.json();

            if (response.ok && result.success) {
                showToast(result.message || 'Absensi berhasil!', 'success');
                const siswaName = result.data?.siswa?.nama ?? 'Siswa';
                addToHistory(siswaName, 'Berhasil', `${result.message} - ${currentActivePrayer}`);
                if (source === 'qr') {
                    randomStringInput.value = '';
                } else {
                    emergencyCodeInput.value = '';
                }
                return true;
            } else {
                const errorMsg = result.message || 'Terjadi kesalahan';
                showToast(errorMsg, 'error');
                addToHistory(null, 'Gagal', errorMsg);
                return false;
            }
        } catch (error) {
            console.error(error);
            showToast('Gagal terhubung ke server.', 'error');
            return false;
        } finally {
            isSubmitting = false;
            showOverlay(false);
        }
    }

    // QR Scanner
    function onScanSuccess(decodedText) {
        if (!isScanAllowed) { showToast("Absensi belum dibuka untuk sesi ini", "warning"); return; }
        if (isSubmitting) { return; }

        const now = Date.now();
        // Abaikan kalau QR yang sama discan ulang dalam masa cooldown
        if (decodedText === lastScannedCode && (now - lastScanTime) < SCAN_COOLDOWN_MS) {
            return;
        }

        lastScannedCode = decodedText;
        lastScanTime = now;
        randomStringInput.value = decodedText;

        // Pause kamera sementara biar gak terus-terusan baca QR yang sama
        if (html5QrCode && html5QrCode.isScanning) {
            try { html5QrCode.pause(true); } catch (e) { console.error(e); }
        }

        submitAttendance(decodedText, 'qr').finally(() => {
            setTimeout(() => {
                if (html5QrCode && isScanAllowed) {
                    try { html5QrCode.resume(); } catch (e) { console.error(e); }
                }
            }, SCAN_COOLDOWN_MS);
        });
    }

    function onScanFailure(error) { /* silent */ }

    async function startScanner(cameraId) {
        if (!isScanAllowed) { showToast("Absensi belum dibuka", "warning"); return; }
        if (!html5QrCode) { html5QrCode = new Html5Qrcode("reader"); }
        try {
            await html5QrCode.start(
                cameraId,
                { fps: 10, qrbox: 250 },
                onScanSuccess,
                onScanFailure
            );
            if (scannerStatusDot) scannerStatusDot.classList.add('active');
            setTimeout(async () => {
                if (html5QrCode && html5QrCode.isScanning) {
                    await stopScanner();
                    showToast("Scanner otomatis berhenti (timeout 5 menit)", "info");
                }
            }, 300000);
        } catch (err) {
            console.error(err);
            showToast("Gagal membuka kamera", "error");
        }
    }

    async function stopScanner() {
        if (html5QrCode && html5QrCode.isScanning) {
            try { await html5QrCode.stop(); } catch (err) { console.error(err); }
        }
        if (scannerStatusDot) scannerStatusDot.classList.remove('active');
    }

    // Event Listeners
    startBtn.addEventListener("click", async () => {
        if (!isScanAllowed) { showToast("Absensi hanya dibuka saat waktu sholat", "warning"); return; }
        try {
            await stopScanner();
            cameras = await Html5Qrcode.getCameras();
            if (cameras && cameras.length) {
                cameraIndex = 0;
                currentCameraId = cameras[cameraIndex].id;
                await startScanner(currentCameraId);
                if (cameras.length > 1) switchBtn.style.display = "inline-block";
                showToast(`Scanner aktif - Absensi Sholat ${currentActivePrayer}`, "success");
            } else {
                showToast("Tidak ditemukan kamera", "error");
            }
        } catch (err) {
            console.error(err);
            showToast("Tidak bisa mengakses kamera", "error");
        }
    });

    switchBtn.addEventListener("click", async () => {
        if (!cameras.length) return;
        cameraIndex = (cameraIndex + 1) % cameras.length;
        currentCameraId = cameras[cameraIndex].id;
        await stopScanner();
        await startScanner(currentCameraId);
    });

    submitEmergencyBtn.addEventListener("click", () => {
        withButtonCooldown(submitEmergencyBtn, async () => {
            if (!isScanAllowed) { showToast("Absensi darurat hanya bisa saat waktu sholat aktif", "warning"); return; }
            const emergencyCode = emergencyCodeInput.value.trim();
            if (!emergencyCode) { showToast("Kode darurat tidak boleh kosong", "warning"); return; }
            if (emergencyCode.length !== 6) { showToast("Kode darurat harus 6 digit", "warning"); return; }
            await submitAttendance(emergencyCode, 'emergency');
        });
    });

    // Absen Manual NISN
    submitNisnBtn.addEventListener("click", () => {
        withButtonCooldown(submitNisnBtn, async () => {
            if (!isScanAllowed) {
                showToast("Absensi hanya bisa saat waktu sholat aktif", "warning");
                return;
            }
            const nisn = nisnInput.value.trim();
            if (!nisn) { showToast("NISN tidak boleh kosong", "warning"); return; }
            if (nisn.length < 8 || nisn.length > 10) { showToast("NISN harus 8-10 digit", "warning"); return; }
            await submitAttendanceNisn(nisn);
        });
    });

    nisnInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter" && !submitNisnBtn.disabled) submitNisnBtn.click();
    });

    // Initialize
    fetchPrayerTimes();
    window.clearHistory = clearHistory;

    window.addEventListener('beforeunload', async () => {
        if (html5QrCode && html5QrCode.isScanning) { await html5QrCode.stop(); }
        if (scanInterval) { clearInterval(scanInterval); }
    });
});
</script>
@endpush