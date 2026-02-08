@extends('layouts.main')
@section('title', 'Scan Absensi')

@push('styles')
<style>
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }
    .toast {
        min-width: 300px;
        padding: 15px;
        border-radius: 6px;
        color: #fff;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        opacity: 0;
        transform: translateY(-20px);
        transition: all .3s ease;
    }
    .toast.show { opacity: 1; transform: translateY(0); }
    .toast.success { background: #28a745; }
    .toast.error { background: #dc3545; }
    .toast.warning { background: #ffc107; color: #333; }

    #reader {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,.15);
    }

    .scanner-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,.7);
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #fff;
        z-index: 10;
        border-radius: 10px;
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(40,167,69,.4); }
        70% { box-shadow: 0 0 0 10px rgba(40,167,69,0); }
        100% { box-shadow: 0 0 0 0 rgba(40,167,69,0); }
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">QR Scan Absensi</h3>
    </div>

    <div class="card-body">
        <p class="text-muted">
            Scan QR Code siswa untuk melakukan absensi. Kamera akan tetap aktif.
        </p>

        <div class="row">
            <div class="col-md-5">

                <div class="form-group">
                    <label>Output Code</label>
                    <input type="text" id="randomString" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Kode Darurat</label>
                    <div class="d-flex">
                        <input type="text" id="randomStringEmergency" class="form-control mr-2">
                        <button class="btn btn-primary" id="submitEmergencyBtn">Submit</button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Keterangan <span class="text-danger">*</span></label>
                    <input type="text" id="keterangan" class="form-control" placeholder="Contoh: Hadir apel pagi">
                </div>

                <div class="mt-3">
                    <button class="btn btn-success" id="startScanBtn">
                        <i class="fas fa-qrcode"></i> Mulai Scan
                    </button>
                    <button class="btn btn-secondary" id="switchCameraBtn" style="display:none">
                        Ganti Kamera
                    </button>
                </div>
            </div>

            <div class="col-md-7 text-center">
                <div id="reader" style="max-width:400px;margin:auto;position:relative">
                    <div class="scanner-overlay" id="scannerOverlay">
                        <div class="spinner-border text-light mb-2"></div>
                        <span>Memproses...</span>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h5>Riwayat Scan</h5>
        <div id="scanHistory"></div>
    </div>
</div>

<div class="toast-container" id="toastContainer"></div>
<script src="https://unpkg.com/html5-qrcode"></script>

@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {

    let html5QrCode;
    let currentCameraId = null;
    let cameras = [];
    let cameraIndex = 0;

    const startBtn = document.getElementById("startScanBtn");
    const switchBtn = document.getElementById("switchCameraBtn");
    const overlay = document.getElementById("scannerOverlay");

    function showOverlay(show = true) {
        overlay.style.display = show ? "flex" : "none";
    }

    function showToast(message, type = "success") {
        const container = document.getElementById("toastContainer");

        const toast = document.createElement("div");
        toast.className = `toast ${type} show`;
        toast.innerHTML = `<span>${message}</span>`;

        container.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    function onScanSuccess(decodedText) {
        showOverlay(true);

        document.getElementById("randomString").value = decodedText;

        setTimeout(() => {
            showOverlay(false);
            showToast("QR berhasil discan", "success");
        }, 800);
    }

    function onScanFailure(error) {
        // boleh kosong biar ga spam console
    }

    async function startScanner(cameraId) {
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("reader");
        }

        try {
            await html5QrCode.start(
                cameraId,
                {
                    fps: 10,
                    qrbox: 250
                },
                onScanSuccess,
                onScanFailure
            );
        } catch (err) {
            console.error(err);
            showToast("Gagal membuka kamera", "error");
        }
    }

    startBtn.addEventListener("click", async () => {
        try {
            cameras = await Html5Qrcode.getCameras();

            if (cameras && cameras.length) {
                currentCameraId = cameras[cameraIndex].id;
                await startScanner(currentCameraId);

                if (cameras.length > 1) {
                    switchBtn.style.display = "inline-block";
                }

                showToast("Scanner aktif", "success");
            }
        } catch (err) {
            console.error(err);
            showToast("Tidak bisa akses kamera", "error");
        }
    });

    switchBtn.addEventListener("click", async () => {
        if (!cameras.length) return;

        cameraIndex = (cameraIndex + 1) % cameras.length;
        currentCameraId = cameras[cameraIndex].id;

        if (html5QrCode) {
            await html5QrCode.stop();
            await startScanner(currentCameraId);
        }
    });

});
</script>
