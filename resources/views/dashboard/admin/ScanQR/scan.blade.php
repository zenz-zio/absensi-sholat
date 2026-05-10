<!-- resources/views/scan.blade.php -->
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

        .toast.info {
            background: #17a2b8;
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

        .prayer-info {
            padding: 15px;
            background: #f0f9ff;
            border-left: 4px solid #007bff;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .prayer-info.active {
            background: #d4edda;
            border-left-color: #28a745;
        }

        .prayer-info.inactive {
            background: #fff3cd;
            border-left-color: #ffc107;
        }

        .scanner-disabled {
            filter: grayscale(100%);
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">QR Scan Absensi Sholat</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <!-- Info Waktu Sholat -->
                <div class="prayer-info" id="prayerInfo">
                    <i class="fas fa-spinner fa-spin"></i> Memuat jadwal sholat...
                </div>

                <!-- ID Recorder (otomatis dari login) -->
                <div class="form-group">
                    <label>ID Recorder <span class="text-danger">*</span></label>
                    <input type="text" id="id_recorder" class="form-control" 
                           value="{{ auth()->user()->id }}" disabled readonly>
                    <small class="form-text text-muted">
                        ID perangkat perekam (otomatis dari akun login).
                    </small>
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

                <!-- Keterangan (otomatis terisi nama sholat) -->
                <div class="form-group">
                    <label>Keterangan Sholat</label>
                    <input type="text" id="keterangan" class="form-control" 
                           placeholder="Otomatis terisi sholat terdekat" readonly>
                    <small class="form-text text-muted" id="keteranganHelp">
                        Keterangan otomatis sesuai jadwal sholat aktif
                    </small>
                </div>

                <div class="mt-3">
                    <button class="btn btn-success" id="startScanBtn" disabled>
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
document.addEventListener("DOMContentLoaded", function () {
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
    const prayerInfo = document.getElementById('prayerInfo');
    const reader = document.getElementById('reader');
    const keteranganHelp = document.getElementById('keteranganHelp');

    // ----------------------------- State & Variables -------------------------
    let html5QrCode = null;
    let currentCameraId = null;
    let cameras = [];
    let cameraIndex = 0;
    let isSubmitting = false;
    let currentActivePrayer = null; // Nama sholat yang sedang aktif
    let isScanAllowed = false; // Status apakah scan diizinkan
    let prayerSchedule = {}; // Menyimpan jadwal sholat
    let scanInterval = null; // Interval untuk pengecekan waktu

    // ----------------------------- Prayer Time Management --------------------
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
            
            // Update setiap 30 detik
            if (scanInterval) clearInterval(scanInterval);
            scanInterval = setInterval(updatePrayerStatus, 30000);
            
            return true;
        } catch (error) {
            console.error('Gagal fetch jadwal sholat:', error);
            prayerInfo.innerHTML = `
                <i class="fas fa-exclamation-triangle"></i> 
                Gagal memuat jadwal sholat. <button class="btn btn-sm btn-link" onclick="location.reload()">Muat ulang</button>
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
        let statusMessage = '';

        // Cari sholat yang sedang dalam masa aktif (dari waktu sholat sampai sholat berikutnya - 15 menit)
        for (let i = 0; i < prayers.length; i++) {
            const [hours, minutes] = prayers[i].time.split(':');
            const prayerTime = new Date(now);
            prayerTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
            
            // Waktu mulai scan: 15 menit sebelum sholat
            const scanStartTime = new Date(prayerTime.getTime() - 15 * 60000);
            
            // Waktu akhir scan: waktu sholat berikutnya (atau 2 jam setelah sholat terakhir)
            let scanEndTime;
            if (i < prayers.length - 1) {
                const [nextHours, nextMinutes] = prayers[i + 1].time.split(':');
                scanEndTime = new Date(now);
                scanEndTime.setHours(parseInt(nextHours), parseInt(nextMinutes), 0, 0);
            } else {
                // Untuk Isya (sholat terakhir), scan aktif sampai jam 4 pagi
                scanEndTime = new Date(now);
                scanEndTime.setDate(scanEndTime.getDate() + 1);
                scanEndTime.setHours(4, 0, 0, 0);
            }

            if (now >= scanStartTime && now < scanEndTime) {
                activePrayer = prayers[i];
                nextPrayer = prayers[i + 1] || prayers[0]; // Next prayer or first prayer tomorrow
                break;
            }
        }

        // Update UI berdasarkan status
        if (activePrayer) {
            isScanAllowed = true;
            currentActivePrayer = activePrayer.name;
            
            prayerInfo.className = 'prayer-info active';
            prayerInfo.innerHTML = `
                <h5><i class="fas fa-check-circle"></i> Absensi Aktif</h5>
                <strong>Sholat ${activePrayer.name}</strong> (${activePrayer.time})<br>
                <small class="text-success">
                    <i class="fas fa-clock"></i> Scan dibuka sampai pukul ${nextPrayer ? nextPrayer.time + ' (' + nextPrayer.name + ')' : '04:00'}
                </small>
            `;
            
            keteranganInput.value = `Sholat ${activePrayer.name}`;
            keteranganHelp.innerHTML = `<span class="text-success">✓ Absensi untuk sholat ${activePrayer.name} dibuka</span>`;
            startBtn.disabled = false;
            startBtn.innerHTML = '<i class="fas fa-qrcode"></i> Mulai Scan';
            reader.classList.remove('scanner-disabled');
            
        } else {
            isScanAllowed = false;
            currentActivePrayer = null;
            
            prayerInfo.className = 'prayer-info inactive';
            
            // Cari sholat berikutnya
            let foundNext = false;
            for (let i = 0; i < prayers.length; i++) {
                const [hours, minutes] = prayers[i].time.split(':');
                const prayerTime = new Date(now);
                prayerTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
                
                if (now < prayerTime) {
                    nextPrayer = prayers[i];
                    foundNext = true;
                    break;
                }
            }
            
            if (!foundNext) {
                // Jika sudah lewat Isya, tampilkan Subuh besok
                nextPrayer = prayers[0];
                prayerInfo.innerHTML = `
                    <h5><i class="fas fa-clock"></i> Di Luar Jam Absensi</h5>
                    <strong>Tidak ada sholat aktif saat ini</strong><br>
                    <small class="text-muted">
                        Absensi berikutnya: Sholat ${nextPrayer.name} besok pukul ${nextPrayer.time}
                    </small>
                `;
            } else {
                prayerInfo.innerHTML = `
                    <h5><i class="fas fa-clock"></i> Menunggu Waktu Sholat</h5>
                    <strong>Absensi berikutnya: Sholat ${nextPrayer.name}</strong> (${nextPrayer.time})<br>
                    <small class="text-warning">
                        <i class="fas fa-hourglass-half"></i> Scan akan dibuka 15 menit sebelum waktu sholat
                    </small>
                `;
            }
            
            keteranganInput.value = '';
            keteranganHelp.innerHTML = '<span class="text-danger">✗ Absensi belum dibuka</span>';
            startBtn.disabled = true;
            startBtn.innerHTML = '<i class="fas fa-lock"></i> Scan Terkunci';
            
            // Stop scanner jika sedang berjalan
            if (html5QrCode && html5QrCode.isScanning) {
                stopScanner();
                showToast("Waktu absensi telah berakhir", "warning");
            }
        }
    }

    // ----------------------------- Helper Functions --------------------------
    function showToast(message, type = "success") {
        const container = document.getElementById("toastContainer");
        const toast = document.createElement("div");
        toast.className = `toast ${type} show`;
        toast.innerHTML = `<span>${message}</span>`;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    function showOverlay(show = true) {
        overlay.style.display = show ? "flex" : "none";
    }

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

    // ----------------------------- Fungsi utama mengirim absensi -------------
    async function submitAttendance(payload, source = 'qr') {
        // Cek apakah scan diizinkan
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
            showToast("ID Recorder tidak ditemukan, pastikan Anda sudah login.", "error");
            return false;
        }

        // Siapkan data
        const requestData = {
            id_recorder: recorderId,
            prayer_name: currentActivePrayer, // Kirim nama sholat
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

    // ----------------------------- QR Scanner Logic ---------------------------
    function onScanSuccess(decodedText) {
        if (!isScanAllowed) {
            showToast("Absensi belum dibuka untuk sesi ini", "warning");
            return;
        }
        
        if (isSubmitting) {
            showToast("Masih memproses absensi sebelumnya", "warning");
            return;
        }
        
        randomStringInput.value = decodedText;
        submitAttendance(decodedText, 'qr');
    }

    function onScanFailure(error) {
        // Silent fail untuk scan yang tidak terdeteksi
    }

    async function startScanner(cameraId) {
        if (!isScanAllowed) {
            showToast("Absensi belum dibuka", "warning");
            return;
        }

        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("reader");
        }
        
        try {
            await html5QrCode.start(
                cameraId,
                { fps: 10, qrbox: 250 },
                onScanSuccess,
                onScanFailure
            );
            
            // Matikan scanner otomatis setelah 5 menit untuk hemat baterai
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
            try {
                await html5QrCode.stop();
            } catch (err) {
                console.error('Error stopping scanner:', err);
            }
        }
    }

    startBtn.addEventListener("click", async () => {
        if (!isScanAllowed) {
            showToast("Absensi hanya dibuka saat waktu sholat", "warning");
            return;
        }

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

    // ----------------------------- Emergency Submit --------------------------
    submitEmergencyBtn.addEventListener("click", async () => {
        if (!isScanAllowed) {
            showToast("Absensi darurat hanya bisa saat waktu sholat aktif", "warning");
            return;
        }
        
        const emergencyCode = emergencyCodeInput.value.trim();
        if (!emergencyCode) {
            showToast("Kode darurat tidak boleh kosong", "warning");
            return;
        }
        await submitAttendance(emergencyCode, 'emergency');
    });

    // ----------------------------- Initialization ----------------------------
    fetchPrayerTimes();

    // Bersihkan scanner saat halaman ditutup
    window.addEventListener('beforeunload', async () => {
        if (html5QrCode && html5QrCode.isScanning) {
            await html5QrCode.stop();
        }
        if (scanInterval) {
            clearInterval(scanInterval);
        }
    });
});
</script>
@endpush