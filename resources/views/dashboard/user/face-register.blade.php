@extends('layouts.app')

@section('title', 'Daftar Wajah')

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

    .face-container {
        background: var(--bg);
        min-height: calc(100vh - 100px);
        padding: 28px 0;
        font-family: var(--font-body);
        color: var(--ink);
    }

    .face-card { border-radius: 16px; overflow: hidden; border: 1px solid var(--line); }

    .face-header { background: #fff; padding: 1.3rem 1.6rem; border-bottom: 1px solid var(--line); }
    .face-header h3 { font-weight: 600; margin: 0; color: var(--ink); }
    .face-header h3 i { color: var(--teal); }
    .face-header p { color: var(--muted); font-size: 0.82rem; margin: 6px 0 0; }

    /* ============ CAMERA ============ */
    .cam-wrapper {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        background: #10201d;
        max-width: 520px;
        margin: 0 auto;
        aspect-ratio: 4 / 3;
        border: 1px solid var(--line);
    }

    #video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transform: scaleX(-1);
    }

    #overlay {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
        transform: scaleX(-1);
        pointer-events: none;
    }

    /* Bingkai wajah */
    .face-guide {
        position: absolute;
        z-index: 3;
        left: 50%;
        top: 50%;
        width: 42%;
        height: 68%;
        transform: translate(-50%, -50%);
        border: 2px solid rgba(255, 255, 255, 0.7);
        border-radius: 50% / 45%;
        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.22);
        pointer-events: none;
        transition: border-color 0.2s ease;
    }

    .face-guide.detected { border-color: var(--teal); }
    .face-guide.warning { border-color: var(--gold); }
    .face-guide.error { border-color: var(--rose); }

    /* Status bagian atas kamera */
    .camera-top-status {
        position: absolute;
        top: 12px;
        left: 0;
        right: 0;
        z-index: 5;
        display: flex;
        justify-content: center;
        pointer-events: none;
    }

    .camera-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
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

    /* Petunjuk bawah kamera */
    .camera-hint {
        position: absolute;
        z-index: 5;
        left: 50%;
        bottom: 14px;
        transform: translateX(-50%);
        width: calc(100% - 30px);
        text-align: center;
        color: #fff;
        font-size: 11.5px;
        font-weight: 600;
        padding: 7px 14px;
        border-radius: 20px;
        background: rgba(0, 0, 0, 0.55);
        pointer-events: none;
    }

    /* Status pill di bawah kamera */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        margin-top: 16px;
        border: 1px solid var(--line);
        background: var(--teal-soft);
        color: var(--teal);
    }

    .status-pill.detected { background: var(--teal); border-color: var(--teal); color: #fff; }
    .status-pill.warning { background: var(--gold-soft); border-color: #e8d9a6; color: var(--gold); }
    .status-pill.error { background: var(--rose-soft); border-color: #ecc9bf; color: var(--rose); }

    /* Tombol */
    .btn-face {
        background: var(--teal);
        border: none;
        color: #fff;
        border-radius: 10px;
        padding: 11px 26px;
        font-weight: 600;
        transition: background 0.2s ease;
    }
    .btn-face:hover { background: var(--teal-dark); color: #fff; }
    .btn-face:disabled { opacity: 0.5; cursor: not-allowed; }

    .already-badge {
        background: var(--teal-soft);
        border: 1px solid #cfe1dc;
        border-radius: 12px;
        padding: 14px 18px;
        color: var(--teal);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        text-align: left;
    }

    .camera-info { max-width: 520px; margin: 12px auto 0; }

    @media (max-width: 576px) {
        .face-container { padding: 15px 0; }
        .face-header { padding: 1.1rem; }
        .face-card .card-body { padding: 1.1rem !important; }
        .face-guide { width: 50%; height: 68%; }
        .camera-hint { font-size: 0.70rem; }
    }
</style>

<div class="face-container">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-7 col-md-9 col-12">

                <div class="card face-card border-0">

                    {{-- HEADER --}}
                    <div class="face-header">

                        <h3>
                            <i class="fas fa-user-circle me-2"></i>
                            Daftarkan Wajah
                        </h3>

                        <p>
                            Dipakai untuk absensi sholat lewat pengenalan wajah
                        </p>

                    </div>

                    <div class="card-body p-4 text-center">

                        {{-- JIKA SUDAH TERDAFTAR --}}
                        @if($siswa && $siswa->hasFaceRegistered())

                            <div class="already-badge mb-4">

                                <i class="fas fa-check-circle fa-lg"></i>

                                <span>
                                    Wajah kamu sudah terdaftar.
                                    Daftar ulang di bawah kalau mau memperbarui.
                                </span>

                            </div>

                        @endif

                        {{-- CAMERA --}}
                        <div class="cam-wrapper mb-2">

                            <video
                                id="video"
                                autoplay
                                muted
                                playsinline
                            ></video>

                            <canvas id="overlay"></canvas>

                            {{-- Bingkai wajah --}}
                            <div
                                class="face-guide"
                                id="faceGuide"
                            ></div>

                            {{-- Status kamera --}}
                            <div class="camera-top-status">

                                <div
                                    class="camera-status"
                                    id="cameraStatus"
                                >
                                    Kamera sedang disiapkan
                                </div>

                            </div>

                            {{-- Hint --}}
                            <div
                                class="camera-hint"
                                id="cameraHint"
                            >
                                Posisikan wajah di dalam bingkai
                            </div>

                        </div>

                        {{-- STATUS UTAMA --}}
                        <div
                            id="statusPill"
                            class="status-pill waiting"
                        >

                            <i
                                id="statusIcon"
                                class="fas fa-spinner fa-spin"
                            ></i>

                            <span id="statusText">
                                Memuat model deteksi wajah...
                            </span>

                        </div>

                        {{-- BUTTON --}}
                        <div class="mt-4">

                            <button
                                id="captureBtn"
                                class="btn-face"
                                disabled
                            >

                                <i class="fas fa-camera me-2"></i>

                                Ambil & Simpan Wajah

                            </button>

                        </div>

                        {{-- INFO --}}
                        <div class="camera-info">

                            <p class="text-muted small mt-3 mb-0">

                                <i class="fas fa-info-circle me-1"></i>

                                Pastikan wajah terlihat jelas, pencahayaan cukup,
                                dan hanya satu wajah dalam frame.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- face-api.js --}}
<script
    src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"
></script>

{{-- SweetAlert --}}
<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11"
></script>

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', async function () {

    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const MODEL_URL =
        "https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js@master/weights";

    const video = document.getElementById('video');
    const overlay = document.getElementById('overlay');

    const statusPill = document.getElementById('statusPill');
    const statusText = document.getElementById('statusText');
    const statusIcon = document.getElementById('statusIcon');

    const captureBtn = document.getElementById('captureBtn');

    const faceGuide = document.getElementById('faceGuide');
    const cameraStatus = document.getElementById('cameraStatus');
    const cameraHint = document.getElementById('cameraHint');

    let latestDetection = null;
    let detecting = false;
    let detectionInterval = null;
    let saving = false;


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    function setStatus(type, text, icon = null) {

        statusPill.className = `status-pill ${type}`;

        statusText.textContent = text;

        if (icon) {
            statusIcon.className = `fas ${icon}`;
        }
    }


    function setCameraStatus(type, text) {

        cameraStatus.className = `camera-status ${type}`;

        cameraStatus.textContent = text;

    }


    function setFaceGuide(type) {

        faceGuide.className = 'face-guide';

        if (type) {
            faceGuide.classList.add(type);
        }

    }


    /*
    |--------------------------------------------------------------------------
    | LOAD MODEL
    |--------------------------------------------------------------------------
    */

    async function loadModels() {

        await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);

        await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);

        await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);

    }


    /*
    |--------------------------------------------------------------------------
    | CAMERA
    |--------------------------------------------------------------------------
    */

    async function startCamera() {

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {

            throw new Error('Browser tidak mendukung kamera.');

        }

        const stream = await navigator.mediaDevices.getUserMedia({

            video: {

                facingMode: 'user',

                width: {
                    ideal: 1280
                },

                height: {
                    ideal: 720
                }

            },

            audio: false

        });

        video.srcObject = stream;

        return new Promise((resolve) => {

            video.onloadedmetadata = () => {

                video.play();

                resolve();

            };

        });

    }


    /*
    |--------------------------------------------------------------------------
    | DETECTION LOOP
    |--------------------------------------------------------------------------
    */

    function detectLoop() {

        if (detecting) {
            return;
        }

        detecting = true;

        const displaySize = {

            width: video.videoWidth,

            height: video.videoHeight

        };

        faceapi.matchDimensions(overlay, displaySize);

        detectionInterval = setInterval(async () => {

            if (saving) {
                return;
            }

            try {

                /*
                |--------------------------------------------------------------------------
                | DETECT SEMUA WAJAH
                |--------------------------------------------------------------------------
                */

                const detections = await faceapi
                    .detectAllFaces(
                        video,
                        new faceapi.TinyFaceDetectorOptions({
                            inputSize: 416,
                            scoreThreshold: 0.5
                        })
                    )
                    .withFaceLandmarks()
                    .withFaceDescriptors();


                /*
                |--------------------------------------------------------------------------
                | CLEAR OVERLAY
                |--------------------------------------------------------------------------
                */

                const ctx = overlay.getContext('2d');

                ctx.clearRect(
                    0,
                    0,
                    overlay.width,
                    overlay.height
                );


                /*
                |--------------------------------------------------------------------------
                | TIDAK ADA WAJAH
                |--------------------------------------------------------------------------
                */

                if (detections.length === 0) {

                    latestDetection = null;

                    captureBtn.disabled = true;

                    setFaceGuide('warning');

                    setCameraStatus(
                        'warning',
                        'Wajah belum terdeteksi'
                    );

                    cameraHint.textContent =
                        'Arahkan wajah ke dalam bingkai';

                    setStatus(
                        'waiting',
                        'Mencari wajah...',
                        'fa-search'
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | LEBIH DARI SATU WAJAH
                |--------------------------------------------------------------------------
                */

                if (detections.length > 1) {

                    latestDetection = null;

                    captureBtn.disabled = true;

                    setFaceGuide('error');

                    setCameraStatus(
                        'error',
                        'Terlalu banyak wajah'
                    );

                    cameraHint.textContent =
                        'Pastikan hanya satu wajah di dalam kamera';

                    setStatus(
                        'error',
                        'Hanya boleh ada satu wajah',
                        'fa-exclamation-triangle'
                    );

                    const resized = faceapi.resizeResults(
                        detections,
                        displaySize
                    );

                    faceapi.draw.drawDetections(
                        overlay,
                        resized
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | SATU WAJAH
                |--------------------------------------------------------------------------
                */

                const detection = detections[0];

                const resized = faceapi.resizeResults(
                    detection,
                    displaySize
                );

                faceapi.draw.drawDetections(
                    overlay,
                    resized
                );

                const box = detection.detection.box;

                /*
                |--------------------------------------------------------------------------
                | CEK JARAK WAJAH
                |--------------------------------------------------------------------------
                */

                const faceWidthRatio =
                    box.width / video.videoWidth;


                /*
                |--------------------------------------------------------------------------
                | TERLALU JAUH
                |--------------------------------------------------------------------------
                */

                if (faceWidthRatio < 0.20) {

                    latestDetection = null;

                    captureBtn.disabled = true;

                    setFaceGuide('warning');

                    setCameraStatus(
                        'warning',
                        'Wajah terlalu jauh'
                    );

                    cameraHint.textContent =
                        'Dekatkan wajah ke kamera';

                    setStatus(
                        'warning',
                        'Wajah terlalu jauh',
                        'fa-arrows-alt'
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | TERLALU DEKAT
                |--------------------------------------------------------------------------
                */

                if (faceWidthRatio > 0.65) {

                    latestDetection = null;

                    captureBtn.disabled = true;

                    setFaceGuide('warning');

                    setCameraStatus(
                        'warning',
                        'Wajah terlalu dekat'
                    );

                    cameraHint.textContent =
                        'Jauhkan sedikit wajah dari kamera';

                    setStatus(
                        'warning',
                        'Wajah terlalu dekat',
                        'fa-expand'
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | WAJAH SIAP
                |--------------------------------------------------------------------------
                */

                latestDetection = detection;

                captureBtn.disabled = false;

                setFaceGuide('detected');

                setCameraStatus(
                    'success',
                    'Wajah terdeteksi'
                );

                cameraHint.textContent =
                    '✓ Posisi wajah sudah pas';

                setStatus(
                    'detected',
                    'Wajah siap disimpan',
                    'fa-check-circle'
                );


            } catch (error) {

                console.error(
                    'Face detection error:',
                    error
                );

            }

        }, 300);

    }


    /*
    |--------------------------------------------------------------------------
    | CAPTURE & SAVE
    |--------------------------------------------------------------------------
    */

    captureBtn.addEventListener('click', async () => {

        if (!latestDetection || saving) {
            return;
        }

        saving = true;

        captureBtn.disabled = true;

        captureBtn.innerHTML =
            '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';


        setCameraStatus(
            'warning',
            'Menyimpan wajah...'
        );

        cameraHint.textContent =
            'Jangan pindahkan posisi wajah dulu';


        setStatus(
            'waiting',
            'Menyimpan data wajah...',
            'fa-spinner fa-spin'
        );


        try {

            /*
            |--------------------------------------------------------------------------
            | DESCRIPTOR
            |--------------------------------------------------------------------------
            */

            const descriptorArray =
                Array.from(latestDetection.descriptor);


            /*
            |--------------------------------------------------------------------------
            | REQUEST
            |--------------------------------------------------------------------------
            */

            const response = await fetch(
                '{{ route("user.face.store") }}',
                {

                    method: 'POST',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            )?.content || '',

                        'Accept':
                            'application/json'

                    },

                    body: JSON.stringify({

                        descriptor: descriptorArray

                    })

                }
            );


            const result = await response.json();


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            if (response.ok && result.success) {

                setFaceGuide('detected');

                setCameraStatus(
                    'success',
                    '✓ Wajah berhasil disimpan'
                );

                cameraHint.textContent =
                    'Pendaftaran wajah berhasil';


                setStatus(
                    'detected',
                    'Wajah berhasil didaftarkan',
                    'fa-check-circle'
                );


                await Swal.fire({

                    icon: 'success',

                    title: 'Berhasil!',

                    text:
                        result.message ||
                        'Wajah berhasil didaftarkan.',

                    confirmButtonColor:
                        '#145c4f',

                    confirmButtonText:
                        'OK'

                });


            } else {

                setFaceGuide('error');

                setCameraStatus(
                    'error',
                    'Gagal menyimpan'
                );

                cameraHint.textContent =
                    'Silakan coba ambil wajah lagi';


                setStatus(
                    'error',
                    'Gagal menyimpan wajah',
                    'fa-times-circle'
                );


                Swal.fire({

                    icon: 'error',

                    title: 'Gagal',

                    text:
                        result.message ||
                        'Terjadi kesalahan saat menyimpan wajah.',

                    confirmButtonColor:
                        '#145c4f'

                });

            }


        } catch (err) {

            console.error(err);


            setFaceGuide('error');

            setCameraStatus(
                'error',
                'Koneksi bermasalah'
            );

            cameraHint.textContent =
                'Periksa koneksi lalu coba lagi';


            setStatus(
                'error',
                'Tidak bisa terhubung ke server',
                'fa-wifi'
            );


            Swal.fire({

                icon: 'error',

                title: 'Gagal',

                text:
                    'Tidak bisa terhubung ke server.',

                confirmButtonColor:
                    '#145c4f'

            });


        } finally {

            saving = false;

            captureBtn.disabled =
                !latestDetection;

            captureBtn.innerHTML =
                '<i class="fas fa-camera me-2"></i>Ambil & Simpan Wajah';

        }

    });


    /*
    |--------------------------------------------------------------------------
    | START
    |--------------------------------------------------------------------------
    */

    try {

        setStatus(
            'waiting',
            'Memuat model deteksi wajah...',
            'fa-spinner fa-spin'
        );

        setCameraStatus(
            'warning',
            'Memuat sistem...'
        );


        await loadModels();


        setStatus(
            'waiting',
            'Mengaktifkan kamera...',
            'fa-camera'
        );

        setCameraStatus(
            'warning',
            'Mengaktifkan kamera...'
        );


        await startCamera();


        setStatus(
            'waiting',
            'Mencari wajah...',
            'fa-search'
        );

        setCameraStatus(
            'success',
            'Kamera siap'
        );

        cameraHint.textContent =
            'Posisikan wajah di dalam bingkai';


        detectLoop();


    } catch (err) {

        console.error(err);


        setStatus(
            'error',
            'Gagal memuat kamera atau model',
            'fa-exclamation-triangle'
        );

        setCameraStatus(
            'error',
            'Kamera gagal'
        );

        cameraHint.textContent =
            'Izinkan akses kamera lalu muat ulang halaman';


        Swal.fire({

            icon: 'error',

            title: 'Kamera tidak tersedia',

            text:
                'Pastikan izin kamera sudah diberikan dan koneksi internet tersedia untuk memuat model wajah.',

            confirmButtonColor:
                '#145c4f'

        });

    }

});

</script>

@endpush

@endsection