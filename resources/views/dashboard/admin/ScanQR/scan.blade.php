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

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast.success {
            background: #28a745;
        }

        .toast.error {
            background: #dc3545;
        }

        .toast.warning {
            background: #ffc107;
            color: #333;
        }

        #reader {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .15);
            position: relative;
        }

        .scanner-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .7);
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #fff;
            z-index: 10;
            border-radius: 10px;
        }

        .history-item {
            border-left: 3px solid #28a745;
            margin-bottom: 8px;
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 6px;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">QR Scan Absensi</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <!-- ID Recorder -->
                    <div class="form-group">
                        <label>ID Recorder <span class="text-danger">*</span></label>
                        <input type="text" id="id_recorder" class="form-control" placeholder="Contoh: RECORDER_001">
                        <small class="form-text text-muted">ID perangkat perekam (tersimpan otomatis).</small>
                    </div>

                    <!-- Output QR Code (hasil scan) -->
                    <div class="form-group">
                        <label>Hasil Scan QR</label>
                        <input type="text" id="randomString" class="form-control" readonly>
                    </div>

                    <!-- Kode Darurat -->
                    <div class="form-group">
                        <label>Kode Darurat</label>
                        <div class="d-flex">
                            <input type="text" id="emergency_code" class="form-control mr-2"
                                placeholder="Masukkan kode 6 digit">
                            <button class="btn btn-primary" id="submitEmergencyBtn">Submit Darurat</button>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" id="keterangan" class="form-control" placeholder="Contoh: Hadir apel pagi">
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-success" id="startScanBtn">
                            <i class="fas fa-qrcode"></i> Mulai Scan
                        </button>
                        <button class="btn btn-secondary" id="switchCameraBtn" style="display:none">
                            <i class="fas fa-sync-alt"></i> Ganti Kamera
                        </button>
                    </div>
                </div>

                <div class="col-md-7 text-center">
                    <div id="reader" style="max-width:400px;margin:auto;position:relative">
                        <div class="scanner-overlay" id="scannerOverlay">
                            <div class="spinner-border text-light mb-2"></div>
                            <span>Memproses absensi...</span>
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

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ----------------------------- DOM Elements -----------------------------
            const idRecorderInput = document.getElementById('id_recorder');
            const randomStringInput = document.getElementById('randomString');
            const emergencyCodeInput = document.getElementById('emergency_code');
            const keteranganInput = document.getElementById('keterangan');
            const startBtn = document.getElementById('startScanBtn');
            const switchBtn = document.getElementById('switchCameraBtn');
            const submitEmergencyBtn = document.getElementById('submitEmergencyBtn');
            const overlay = document.getElementById('scannerOverlay');
            const historyContainer = document.getElementById('scanHistory');

            // ----------------------------- State & Variables -------------------------
            let html5QrCode = null;
            let currentCameraId = null;
            let cameras = [];
            let cameraIndex = 0;
            let isSubmitting = false; // prevent multiple requests

            // ----------------------------- Helper Functions --------------------------
            // Load/save recorder ID from localStorage
            function loadRecorderId() {
                let saved = localStorage.getItem('scan_recorder_id');
                if (saved) {
                    idRecorderInput.value = saved;
                } else {
                    idRecorderInput.value = 'RECORDER_DEFAULT';
                }
            }

            function saveRecorderId() {
                localStorage.setItem('scan_recorder_id', idRecorderInput.value.trim());
            }
            idRecorderInput.addEventListener('change', saveRecorderId);
            loadRecorderId();

            // Show toast notification
            function showToast(message, type = "success") {
                const container = document.getElementById("toastContainer");
                const toast = document.createElement("div");
                toast.className = `toast ${type} show`;
                toast.innerHTML = `<span>${message}</span>`;
                container.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }

            // Show/hide processing overlay (scanner)
            function showOverlay(show = true) {
                overlay.style.display = show ? "flex" : "none";
            }

            // Tambahkan riwayat ke dalam div
            function addToHistory(namaSiswa, status, message) {
                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                historyItem.innerHTML = `
            <strong>${new Date().toLocaleTimeString()}</strong> -
            ${namaSiswa ? `<strong>${namaSiswa}</strong> - ` : ''}
            ${status} - ${message}
        `;
                historyContainer.prepend(historyItem);
                if (historyContainer.children.length > 10) {
                    historyContainer.removeChild(historyContainer.lastChild);
                }
            }

            // Fungsi utama mengirim absensi ke API
            async function submitAttendance(payload, source = 'qr') {
                if (isSubmitting) {
                    showToast("Proses sedang berjalan, tunggu sebentar...", "warning");
                    return false;
                }

                const recorderId = idRecorderInput.value.trim();
                if (!recorderId) {
                    showToast("ID Recorder harus diisi!", "error");
                    return false;
                }

                // Siapkan data untuk dikirim ke API
                const requestData = {
                    id_recorder: recorderId,
                    keterangan: keteranganInput.value.trim() || null,
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
                    const response = await fetch('/scan-sholat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.content || '',
                        },
                        body: JSON.stringify(requestData),
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        showToast(result.message || 'Absensi berhasil!', 'success');
                        // Tambahkan riwayat jika ada data siswa
                        const siswaName = result.data?.siswa?.nama ?? 'Siswa';
                        addToHistory(siswaName, 'Berhasil', result.message);
                        // Kosongkan field QR / emergency setelah sukses
                        if (source === 'qr') {
                            randomStringInput.value = '';
                        } else {
                            emergencyCodeInput.value = '';
                        }
                        // Opsional: reset keterangan? (biarkan saja)
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

            // ----------------------------- QR Scanner Logic ---------------------------
            function onScanSuccess(decodedText) {
                if (isSubmitting) {
                    showToast("Masih memproses absensi sebelumnya", "warning");
                    return;
                }
                // Tampilkan hasil scan di input
                randomStringInput.value = decodedText;
                // Langsung kirim ke API
                submitAttendance(decodedText, 'qr');
            }

            function onScanFailure(error) {
                // tidak perlu log
            }

            async function startScanner(cameraId) {
                if (!html5QrCode) {
                    html5QrCode = new Html5Qrcode("reader");
                }
                try {
                    await html5QrCode.start(
                        cameraId, {
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

            async function stopScanner() {
                if (html5QrCode && html5QrCode.isScanning) {
                    await html5QrCode.stop();
                }
            }

            startBtn.addEventListener("click", async () => {
                try {
                    await stopScanner();
                    cameras = await Html5Qrcode.getCameras();
                    if (cameras && cameras.length) {
                        cameraIndex = 0;
                        currentCameraId = cameras[cameraIndex].id;
                        await startScanner(currentCameraId);
                        if (cameras.length > 1) switchBtn.style.display = "inline-block";
                        showToast("Scanner aktif, arahkan QR code siswa", "success");
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

            // ----------------------------- Emergency Submit --------------------------
            submitEmergencyBtn.addEventListener("click", async () => {
                const emergencyCode = emergencyCodeInput.value.trim();
                if (!emergencyCode) {
                    showToast("Kode darurat tidak boleh kosong", "warning");
                    return;
                }
                await submitAttendance(emergencyCode, 'emergency');
            });

            // Bersihkan ketika halaman ditutup (optional)
            window.addEventListener('beforeunload', async () => {
                if (html5QrCode && html5QrCode.isScanning) {
                    await html5QrCode.stop();
                }
            });
        });
    </script>
@endpush
