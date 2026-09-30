@extends('layouts.main')
@section('title', 'Scan Wajah Absensi')

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
            min-width: 300px;
            padding: 12px 16px;
            border-radius: 10px;
            color: #fff;
            margin-bottom: 10px;
            box-shadow: 0 8px 22px rgba(20, 40, 36, 0.2);
            font-size: 0.9rem;
        }

        /* ============ PRAYER STATUS ============ */
        .prayer-info {
            padding: 16px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid var(--line);
            background: #fff;
        }
        .prayer-info.active { background: var(--gold-soft); border-color: #e8d9a6; }
        .prayer-info.waiting { background: var(--teal-soft); border-color: #cfe1dc; }

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
        .btn-gradient {
            border: none;
            border-radius: 10px;
            padding: 11px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s ease;
            color: #fff;
            background: var(--teal);
        }
        .btn-gradient:hover { background: var(--teal-dark); color: #fff; }
        .btn-gradient:disabled { opacity: 0.5; cursor: not-allowed; }

        hr.divider-custom { border-top: 1px solid var(--line); margin: 1.5rem 0; opacity: 1; }

        /* ============ CAMERA / SCANNER ============ */
        .scanner-wrapper {
            border-radius: 14px;
            overflow: hidden;
            background: #10201d;
            border: 1px solid var(--line);
            max-width: 520px;
            margin: 0 auto;
        }

        .cam-wrapper {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            background: #10201d;
            aspect-ratio: 4 / 3;
        }

        #video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transform: scaleX(-1);
        }

        #overlay {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            pointer-events: none;
            transform: scaleX(-1);
        }

        .face-guide {
            position: absolute;
            width: 48%;
            height: 66%;
            left: 26%;
            top: 17%;
            border: 2px solid rgba(255, 255, 255, 0.75);
            border-radius: 46%;
            z-index: 3;
            pointer-events: none;
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.22);
            transition: border-color 0.25s ease;
        }
        .face-guide.detected { border-color: var(--teal); }
        .face-guide.too-far { border-color: var(--gold); }
        .face-guide.too-close { border-color: var(--rose); }

        .camera-top-status {
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            z-index: 5;
            display: flex;
            justify-content: center;
            pointer-events: none;
        }

        .camera-status {
            padding: 6px 14px;
            border-radius: 20px;
            background: rgba(20, 40, 36, 0.75);
            color: #fff;
            font-size: 12.5px;
            font-weight: 600;
        }
        .camera-status.success { background: rgba(20, 92, 79, 0.9); }
        .camera-status.warning { background: rgba(176, 141, 42, 0.9); }
        .camera-status.error   { background: rgba(168, 69, 47, 0.9); }

        .camera-hint {
            position: absolute;
            bottom: 14px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 5;
            padding: 7px 14px;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.55);
            color: #fff;
            font-size: 11.5px;
            white-space: nowrap;
            pointer-events: none;
        }

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
            font-size: 0.9rem;
        }

        .scanner-status { display: inline-block; width: 9px; height: 9px; border-radius: 50%; background: var(--rose); }
        .scanner-status.active { background: var(--teal); }

        /* ============ STATUS PILL ============ */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1px solid var(--line);
            background: var(--teal-soft);
            color: var(--teal);
        }
        .status-pill.detected { background: var(--teal); border-color: var(--teal); color: #fff; }
        .status-pill.error { background: var(--rose-soft); border-color: #ecc9bf; color: var(--rose); }

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
            font-size: 0.9rem;
        }
        .history-item.error { border-left-color: var(--rose); }

        .history-container::-webkit-scrollbar { width: 6px; }
        .history-container::-webkit-scrollbar-track { background: var(--bg); border-radius: 10px; }
        .history-container::-webkit-scrollbar-thumb { background: #cfcbbd; border-radius: 10px; }

        @media (max-width: 768px) {
            .card-header-gradient { padding: 1rem 1.25rem; }
            .card-header-gradient h3 { font-size: 1.15rem; }
            .btn-gradient { padding: 10px 14px; font-size: 0.85rem; }
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
                        <i class="fas fa-user-check me-2"></i>
                        Scan Wajah Absensi
                    </h3>
                    <p class="mb-0 mt-2">
                        <i class="fas fa-mosque me-1"></i>
                        Arahkan kamera ke wajah siswa untuk mencatat kehadiran sholat
                    </p>
                </div>
                <div class="mt-2 mt-md-0">
                    <span class="badge-light-custom">
                        <i class="fas fa-id-badge me-1"></i>
                        {{ auth()->user()->name ?? 'Recorder' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">

            <div class="row">

                <div class="col-lg-5">

                    <div class="prayer-info waiting" id="prayerInfo">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border me-3" style="width: 26px; height: 26px; color: var(--teal);"></div>
                            <div>
                                <strong style="color: var(--teal);">Memuat jadwal sholat...</strong>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label>
                            <i class="fas fa-microphone-alt me-2"></i>
                            ID Recorder
                        </label>
                        <input type="text" id="id_recorder" class="form-control" value="{{ auth()->user()->id }}" disabled readonly>
                        <small class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            ID perangkat perekam (otomatis dari akun login)
                        </small>
                    </div>

                    <div id="statusPill" class="status-pill waiting">
                        <i class="fas fa-spinner fa-spin"></i>
                        <span id="statusText">Memuat model deteksi wajah...</span>
                    </div>

                    <button id="startBtn" class="btn-gradient w-100 mt-3" disabled>
                        <i class="fas fa-play me-2"></i>
                        Mulai Scan Wajah
                    </button>

                </div>

                <div class="col-lg-7 mt-4 mt-lg-0">

                    <div class="scanner-wrapper">
                        <div class="cam-wrapper">

                            <video id="video" autoplay muted playsinline style="display: none;"></video>
                            <canvas id="overlay"></canvas>
                            <div class="face-guide" id="faceGuide"></div>

                            <div class="camera-top-status">
                                <div class="camera-status" id="cameraStatus">Kamera siap</div>
                            </div>

                            <div class="camera-hint" id="cameraHint">Posisikan wajah di dalam bingkai</div>

                            <div class="scanner-overlay" id="scannerOverlay">
                                <div class="spinner-border text-light mb-3"></div>
                                <div>Memproses Absensi...</div>
                            </div>

                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <span class="scanner-status me-1"></span>
                            Arahkan kamera ke wajah siswa
                        </small>
                    </div>

                </div>

            </div>

            <hr class="divider-custom">

            <div class="d-flex justify-content-between align-items-center mb-3 history-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2" style="color: var(--muted);"></i>
                    Riwayat Scan
                </h5>
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


<div class="toast-container" id="toastContainer"></div>

<!-- face-api.js -->
<script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Model face-api.js
    |--------------------------------------------------------------------------
    */

    const MODEL_URL =
        "https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js@master/weights";


    /*
    |--------------------------------------------------------------------------
    | Element
    |--------------------------------------------------------------------------
    */

    const idRecorderInput =
        document.getElementById('id_recorder');

    const video =
        document.getElementById('video');

    const overlay =
        document.getElementById('overlay');

    const statusPill =
        document.getElementById('statusPill');

    const statusText =
        document.getElementById('statusText');

    const startBtn =
        document.getElementById('startBtn');

    const overlayEl =
        document.getElementById('scannerOverlay');

    const prayerInfo =
        document.getElementById('prayerInfo');

    const historyContainer =
        document.getElementById('scanHistory');

    const faceGuide =
        document.getElementById('faceGuide');

    const cameraStatus =
        document.getElementById('cameraStatus');

    const cameraHint =
        document.getElementById('cameraHint');


    /*
    |--------------------------------------------------------------------------
    | Variable
    |--------------------------------------------------------------------------
    */

    let isScanAllowed = false;

    let currentActivePrayer = null;

    let scanning = false;

    let isSubmitting = false;

    let detectInterval = null;

    let lastSubmitTime = 0;

    const SUBMIT_COOLDOWN_MS = 5000;

    let scannedPrayers = new Set();


    /*
    |--------------------------------------------------------------------------
    | Toast
    |--------------------------------------------------------------------------
    */

    function showToast(message, type = 'success') {

        const container =
            document.getElementById('toastContainer');

        const toast =
            document.createElement('div');

        const colors = {

            success:
                '#145c4f',

            error:
                '#a8452f',

            warning:
                '#b08d2a'

        };

        toast.className = 'toast';

        toast.style.cssText = `
            min-width: 300px;
            padding: 12px 16px;
            border-radius: 10px;
            color: #fff;
            margin-bottom: 10px;
            background: ${colors[type] || colors.success};
            box-shadow: 0 8px 22px rgba(20,40,36,0.2);
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
            font-size: 0.9rem;
        `;

        toast.textContent = message;

        container.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 4000);

    }


    /*
    |--------------------------------------------------------------------------
    | History
    |--------------------------------------------------------------------------
    */

    function addToHistory(nama, status, message) {

        if (
            historyContainer.querySelector('.text-center')
        ) {
            historyContainer.innerHTML = '';
        }

        const el =
            document.createElement('div');

        el.className =
            `history-item ${status === 'Berhasil' ? '' : 'error'}`;

        const time =
            new Date().toLocaleTimeString('id-ID');

        el.innerHTML = `
            <strong>${time}</strong>
            ${nama ? '• ' + nama : ''}
            <div class="small text-muted">
                ${message}
            </div>
        `;

        historyContainer.prepend(el);

    }


    /*
    |--------------------------------------------------------------------------
    | Jadwal Sholat
    |--------------------------------------------------------------------------
    */

    async function fetchPrayerTimes() {

        const today =
            new Date().toISOString().split('T')[0];

        try {

            const res = await fetch(
                `https://api.aladhan.com/v1/timings/${today}?latitude=-0.227819&longitude=100.626617&method=20`
            );

            const data =
                await res.json();

            const t =
                data.data.timings;

            const schedule = {
                subuh: t.Fajr,
                dzuhur: t.Dhuhr,
                ashar: t.Asr,
                maghrib: t.Maghrib,
                isya: t.Isha
            };

            updatePrayerStatus(schedule);

            setInterval(() => {
                updatePrayerStatus(schedule);
            }, 30000);

        } catch (e) {

            prayerInfo.innerHTML = `
                <strong style="color:#a8452f;">
                    Gagal memuat jadwal sholat
                </strong>
            `;

        }

    }


    function updatePrayerStatus(schedule) {

        const now =
            new Date();

        const prayers = [

            {
                name: 'Subuh',
                time: schedule.subuh
            },

            {
                name: 'Dzuhur',
                time: schedule.dzuhur
            },

            {
                name: 'Ashar',
                time: schedule.ashar
            },

            {
                name: 'Maghrib',
                time: schedule.maghrib
            },

            {
                name: 'Isya',
                time: schedule.isya
            }

        ];

        let active = null;


        for (
            let i = 0;
            i < prayers.length;
            i++
        ) {

            const [h, m] =
                prayers[i].time.split(':');

            const pt =
                new Date(now);

            pt.setHours(
                parseInt(h),
                parseInt(m),
                0,
                0
            );

            const start =
                new Date(
                    pt.getTime() - 15 * 60000
                );

            let end;


            if (
                i < prayers.length - 1
            ) {

                const [nh, nm] =
                    prayers[i + 1].time.split(':');

                end =
                    new Date(now);

                end.setHours(
                    parseInt(nh),
                    parseInt(nm),
                    0,
                    0
                );

            } else {

                end =
                    new Date(now);

                end.setDate(
                    end.getDate() + 1
                );

                end.setHours(
                    4,
                    0,
                    0,
                    0
                );

            }


            if (
                now >= start &&
                now < end
            ) {

                active =
                    prayers[i];

                break;

            }

        }


        if (active) {

            isScanAllowed = true;

            currentActivePrayer =
                active.name;

            prayerInfo.className =
                'prayer-info active';

            prayerInfo.innerHTML = `
                <strong style="color:#b08d2a;">
                    ✅ Absensi Aktif — Sholat ${active.name}
                </strong>
            `;

            startBtn.disabled = false;

        } else {

            isScanAllowed = false;

            currentActivePrayer = null;

            prayerInfo.className =
                'prayer-info waiting';

            prayerInfo.innerHTML = `
                <strong style="color:#145c4f;">
                    ⏰ Menunggu waktu sholat
                </strong>
            `;

            startBtn.disabled = true;

            scanning = false;

            cameraStatus.className =
                'camera-status warning';

            cameraStatus.textContent =
                'Menunggu waktu sholat';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Load Face API Models
    |--------------------------------------------------------------------------
    */

    async function loadModels() {

        await faceapi.nets.tinyFaceDetector.loadFromUri(
            MODEL_URL
        );

        await faceapi.nets.faceLandmark68Net.loadFromUri(
            MODEL_URL
        );

        await faceapi.nets.faceRecognitionNet.loadFromUri(
            MODEL_URL
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Submit Face
    |--------------------------------------------------------------------------
    */

    async function submitFace(descriptor) {

        isSubmitting = true;

        overlayEl.style.display = 'flex';

        cameraStatus.className =
            'camera-status';

        cameraStatus.textContent =
            'Memverifikasi wajah...';

        cameraHint.textContent =
            'Mohon tunggu...';


        try {

            const res =
                await fetch(
                    '{{ route("face.match") }}',
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                )?.content || ''
                        },

                        body: JSON.stringify({

                            descriptor:
                                Array.from(descriptor),

                            id_recorder:
                                idRecorderInput.value.trim(),

                            prayer_name:
                                currentActivePrayer,

                            keterangan:
                                `Sholat ${currentActivePrayer}`

                        })
                    }
                );


            const result =
                await res.json();


            if (
                res.ok &&
                result.success
            ) {

                showToast(
                    `✓ ${result.message}`,
                    'success'
                );

                addToHistory(
                    result.data?.siswa?.nama,
                    'Berhasil',
                    `${currentActivePrayer} — jarak: ${result.data?.jarak_kemiripan ?? '-'}`
                );

                scannedPrayers.add(
                    currentActivePrayer
                );

                cameraStatus.className =
                    'camera-status success';

                cameraStatus.textContent =
                    '✓ Absensi berhasil';

                cameraHint.textContent =
                    `Absensi Sholat ${currentActivePrayer} berhasil`;

                statusPill.className =
                    'status-pill detected';

                statusText.textContent =
                    'Absensi berhasil dicatat';


            } else {

                showToast(
                    result.message ||
                    'Wajah tidak dikenali',
                    'warning'
                );

                addToHistory(
                    null,
                    'Gagal',
                    result.message ||
                    'Wajah tidak dikenali'
                );

                cameraStatus.className =
                    'camera-status warning';

                cameraStatus.textContent =
                    'Wajah tidak dikenali';

                cameraHint.textContent =
                    'Coba posisikan wajah dengan lebih jelas';

                statusPill.className =
                    'status-pill error';

                statusText.textContent =
                    'Wajah tidak dikenali';

            }


        } catch (e) {

            console.error(e);

            showToast(
                'Gagal terhubung ke server',
                'error'
            );

            cameraStatus.className =
                'camera-status error';

            cameraStatus.textContent =
                'Koneksi bermasalah';

            cameraHint.textContent =
                'Periksa koneksi lalu coba lagi';

            statusPill.className =
                'status-pill error';

            statusText.textContent =
                'Gagal terhubung ke server';


        } finally {

            isSubmitting = false;

            overlayEl.style.display = 'none';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Deteksi Wajah
    |--------------------------------------------------------------------------
    */

    function detectLoop() {

        const displaySize = {
            width: video.videoWidth,
            height: video.videoHeight
        };

        faceapi.matchDimensions(
            overlay,
            displaySize
        );


        if (detectInterval) {
            clearInterval(detectInterval);
        }


        detectInterval =
            setInterval(
                async () => {

                    if (
                        !scanning ||
                        isSubmitting
                    ) {
                        return;
                    }


                    try {

                        const detection =
                            await faceapi
                                .detectSingleFace(
                                    video,
                                    new faceapi.TinyFaceDetectorOptions({
                                        inputSize: 416,
                                        scoreThreshold: 0.5
                                    })
                                )
                                .withFaceLandmarks()
                                .withFaceDescriptor();


                        const ctx =
                            overlay.getContext('2d');

                        ctx.clearRect(
                            0,
                            0,
                            overlay.width,
                            overlay.height
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | Tidak ada wajah
                        |--------------------------------------------------------------------------
                        */

                        if (!detection) {

                            faceGuide.classList.remove(
                                'detected',
                                'too-far',
                                'too-close'
                            );

                            cameraStatus.className =
                                'camera-status warning';

                            cameraStatus.textContent =
                                'Wajah belum terdeteksi';

                            cameraHint.textContent =
                                'Posisikan wajah di dalam bingkai';

                            statusPill.className =
                                'status-pill waiting';

                            statusText.textContent =
                                'Mencari wajah...';

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Gambar kotak wajah
                        |--------------------------------------------------------------------------
                        */

                        const resized =
                            faceapi.resizeResults(
                                detection,
                                displaySize
                            );

                        faceapi.draw.drawDetections(
                            overlay,
                            resized
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | Cek jarak wajah
                        |--------------------------------------------------------------------------
                        */

                        const box =
                            detection.detection.box;

                        const faceWidthRatio =
                            box.width /
                            video.videoWidth;


                        /*
                        |--------------------------------------------------------------------------
                        | Terlalu jauh
                        |--------------------------------------------------------------------------
                        */

                        if (
                            faceWidthRatio < 0.20
                        ) {

                            faceGuide.classList.remove(
                                'detected',
                                'too-close'
                            );

                            faceGuide.classList.add(
                                'too-far'
                            );

                            cameraStatus.className =
                                'camera-status warning';

                            cameraStatus.textContent =
                                'Wajah terlalu jauh';

                            cameraHint.textContent =
                                'Dekatkan wajah ke kamera';

                            statusPill.className =
                                'status-pill waiting';

                            statusText.textContent =
                                'Wajah terlalu jauh';

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Terlalu dekat
                        |--------------------------------------------------------------------------
                        */

                        if (
                            faceWidthRatio > 0.65
                        ) {

                            faceGuide.classList.remove(
                                'detected',
                                'too-far'
                            );

                            faceGuide.classList.add(
                                'too-close'
                            );

                            cameraStatus.className =
                                'camera-status warning';

                            cameraStatus.textContent =
                                'Wajah terlalu dekat';

                            cameraHint.textContent =
                                'Jauhkan wajah sedikit';

                            statusPill.className =
                                'status-pill waiting';

                            statusText.textContent =
                                'Wajah terlalu dekat';

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Wajah posisi bagus
                        |--------------------------------------------------------------------------
                        */

                        faceGuide.classList.remove(
                            'too-far',
                            'too-close'
                        );

                        faceGuide.classList.add(
                            'detected'
                        );

                        cameraStatus.className =
                            'camera-status success';

                        cameraStatus.textContent =
                            '✓ Wajah siap discan';

                        cameraHint.textContent =
                            'Tahan posisi wajah sebentar';


                        /*
                        |--------------------------------------------------------------------------
                        | Cek waktu sholat
                        |--------------------------------------------------------------------------
                        */

                        if (!isScanAllowed) {

                            statusText.textContent =
                                'Absensi belum dibuka';

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Cek sudah scan
                        |--------------------------------------------------------------------------
                        */

                        if (
                            scannedPrayers.has(
                                currentActivePrayer
                            )
                        ) {

                            cameraStatus.className =
                                'camera-status success';

                            cameraStatus.textContent =
                                '✓ Sudah melakukan absensi';

                            cameraHint.textContent =
                                `Sudah absen Sholat ${currentActivePrayer}`;

                            statusPill.className =
                                'status-pill detected';

                            statusText.textContent =
                                `Sudah absen untuk Sholat ${currentActivePrayer}`;

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Submit dengan cooldown
                        |--------------------------------------------------------------------------
                        */

                        const now =
                            Date.now();

                        if (
                            now - lastSubmitTime <
                            SUBMIT_COOLDOWN_MS
                        ) {
                            return;
                        }

                        lastSubmitTime =
                            now;

                        submitFace(
                            detection.descriptor
                        );


                    } catch (error) {

                        console.error(
                            'Face detection error:',
                            error
                        );

                    }

                },
                300
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Mulai Kamera
    |--------------------------------------------------------------------------
    */

    startBtn.addEventListener(
        'click',
        async () => {

            if (!isScanAllowed) {

                showToast(
                    'Absensi hanya dibuka saat waktu sholat',
                    'warning'
                );

                return;

            }


            try {

                if (detectInterval) {

                    clearInterval(
                        detectInterval
                    );

                    detectInterval = null;

                }


                const stream =
                    await navigator.mediaDevices.getUserMedia({

                        video: {
                            facingMode: 'user',
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            }
                        }

                    });


                video.srcObject =
                    stream;

                video.style.display =
                    'block';


                await new Promise(
                    resolve => {
                        video.onloadedmetadata =
                            resolve;
                    }
                );


                scanning =
                    true;


                detectLoop();


                cameraStatus.className =
                    'camera-status';

                cameraStatus.textContent =
                    'Scanner aktif';

                cameraHint.textContent =
                    'Posisikan wajah di dalam bingkai';


                showToast(
                    `Scanner aktif — Absensi Sholat ${currentActivePrayer}`,
                    'success'
                );


            } catch (e) {

                console.error(e);

                showToast(
                    'Tidak bisa mengakses kamera',
                    'error'
                );

                cameraStatus.className =
                    'camera-status error';

                cameraStatus.textContent =
                    'Kamera tidak dapat diakses';

                cameraHint.textContent =
                    'Periksa izin akses kamera';

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Init
    |--------------------------------------------------------------------------
    */

    (async function init() {

        try {

            statusText.textContent =
                'Memuat model deteksi wajah...';

            await loadModels();

            statusText.textContent =
                'Model siap. Menunggu waktu sholat...';

        } catch (e) {

            console.error(e);

            statusPill.className =
                'status-pill error';

            statusText.textContent =
                'Gagal memuat model wajah.';

        }

        fetchPrayerTimes();

    })();


    /*
    |--------------------------------------------------------------------------
    | Bersihkan kamera ketika halaman ditutup
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'beforeunload',
        () => {

            if (detectInterval) {
                clearInterval(detectInterval);
            }

            if (video.srcObject) {

                video.srcObject
                    .getTracks()
                    .forEach(track => {
                        track.stop();
                    });

            }

        }
    );

});

</script>

@endpush