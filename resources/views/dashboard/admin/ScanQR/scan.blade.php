<!-- resources/views/scan.blade.php -->
@extends('layouts.main')
@section('title', 'Scan Absensi')

@push('styles')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --danger-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes scanLine {
            0% {
                top: 0;
            }
            100% {
                top: 100%;
            }
        }

        /* Card Styles */
        .scan-card {
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            animation: fadeInUp 0.6s ease-out;
        }

        .card-header-gradient {
            background: var(--primary-gradient);
            padding: 1.5rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .card-header-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        /* Toast Container */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            min-width: 320px;
            padding: 15px 20px;
            border-radius: 12px;
            color: #fff;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast.success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .toast.error {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .toast.warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: #333;
        }

        .toast.info {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }

        /* Scanner Section */
        .scanner-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            background: #000;
        }

        #reader {
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }

        .scanner-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #fff;
            z-index: 10;
            border-radius: 20px;
        }

        .scanner-overlay .spinner-border {
            width: 50px;
            height: 50px;
            margin-bottom: 15px;
        }

        /* Scanner Frame */
        .scanner-frame {
            position: relative;
            display: inline-block;
        }

        .scanner-frame::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ff00, transparent);
            animation: scanLine 2s linear infinite;
            box-shadow: 0 0 10px #00ff00;
        }

        /* Prayer Info Card */
        .prayer-info {
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .prayer-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .prayer-info.active {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid #28a745;
        }

        .prayer-info.active::before {
            background: linear-gradient(90deg, #28a745, #20c997);
        }

        .prayer-info.inactive {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-left: 4px solid #ffc107;
        }

        .prayer-info.inactive::before {
            background: linear-gradient(90deg, #ffc107, #fd7e14);
        }

        .prayer-info.waiting {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-left: 4px solid #2196f3;
        }

        /* Form Styles */
        .form-group-modern {
            margin-bottom: 20px;
        }

        .form-group-modern label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-group-modern input {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group-modern input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
        }

        .form-group-modern input:disabled {
            background: #f8f9fa;
            cursor: not-allowed;
        }

        /* Button Styles */
        .btn-gradient {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102,126,234,0.4);
        }

        .btn-gradient:disabled {
            opacity: 0.6;
            transform: none;
        }

        .btn-success-gradient {
            background: var(--success-gradient);
        }

        .btn-warning-gradient {
            background: var(--warning-gradient);
            color: #333;
        }

        /* History Section */
        .history-container {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .history-item {
            border-left: 3px solid #28a745;
            margin-bottom: 12px;
            padding: 12px 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            transition: all 0.3s ease;
            animation: fadeInUp 0.3s ease-out;
        }

        .history-item:hover {
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .history-item.success {
            border-left-color: #28a745;
        }

        .history-item.error {
            border-left-color: #dc3545;
        }

        /* Timer */
        .prayer-timer {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
            margin-top: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-header-gradient {
                padding: 1rem;
            }
            
            .btn-gradient {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
            
            .prayer-timer {
                font-size: 1.5rem;
            }
        }

        /* Custom Scrollbar */
        .history-container::-webkit-scrollbar {
            width: 6px;
        }

        .history-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .history-container::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }

        /* Loading Spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="scan-card card border-0">
        <div class="card-header-gradient">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h3 class="mb-0 text-white">
                        <i class="fas fa-qrcode me-2"></i>
                        Scan QR Code Absensi
                    </h3>
                    <p class="text-white-50 mb-0 mt-2">
                        <i class="fas fa-mosque me-1"></i>
                        Scan QR Code siswa untuk melakukan absensi sholat
                    </p>
                </div>
                <div class="mt-2 mt-md-0">
                    <span class="badge bg-light text-dark p-2">
                        <i class="fas fa-user-check me-1"></i>
                        {{ auth()->user()->name ?? 'Recorder' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row">
                <!-- Left Panel -->
                <div class="col-lg-5">
                    <!-- Info Waktu Sholat -->
                    <div class="prayer-info waiting" id="prayerInfo">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border text-primary me-3" style="width: 30px; height: 30px;"></div>
                            <div>
                                <strong>Memuat jadwal sholat...</strong><br>
                                <small class="text-muted">Mengambil data jadwal sholat</small>
                            </div>
                        </div>
                    </div>

                    <!-- ID Recorder -->
                    <div class="form-group-modern">
                        <label>
                            <i class="fas fa-microphone-alt text-primary me-2"></i>
                            ID Recorder
                        </label>
                        <input type="text" id="id_recorder" class="form-control" 
                               value="{{ auth()->user()->id }}" disabled readonly>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            ID perangkat perekam (otomatis dari akun login)
                        </small>
                    </div>

                    <!-- Hasil Scan QR -->
                    <div class="form-group-modern">
                        <label>
                            <i class="fas fa-qrcode text-success me-2"></i>
                            Hasil Scan QR
                        </label>
                        <input type="text" id="randomString" class="form-control" 
                               placeholder="QR Code akan muncul di sini" readonly>
                    </div>

                    <!-- Kode Darurat -->
                    <div class="form-group-modern">
                        <label>
                            <i class="fas fa-shield-alt text-warning me-2"></i>
                            Kode Darurat
                        </label>
                        <div class="d-flex gap-2">
                            <input type="text" id="emergency_code" class="form-control flex-grow-1"
                                   placeholder="Masukkan kode 6 digit" maxlength="6">
                            <button class="btn btn-warning-gradient" id="submitEmergencyBtn">
                                <i class="fas fa-paper-plane me-1"></i> Submit
                            </button>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Gunakan jika QR Code tidak terbaca
                        </small>
                    </div>

                    <!-- Keterangan Sholat -->
                    <div class="form-group-modern">
                        <label>
                            <i class="fas fa-clock text-info me-2"></i>
                            Keterangan Sholat
                        </label>
                        <input type="text" id="keterangan" class="form-control" 
                               placeholder="Otomatis terisi" readonly>
                        <small class="form-text text-muted" id="keteranganHelp">
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
                        <button class="btn btn-secondary flex-grow-1" id="switchCameraBtn" style="display:none">
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
                                <h6 class="mb-2">Memproses Absensi...</h6>
                                <small>Mohon tunggu sebentar</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-camera me-1"></i>
                            Arahkan kamera ke QR Code siswa
                        </small>
                    </div>
                </div>
            </div>

            <hr class="my-4" style="border-top: 2px dashed #e0e0e0;">

            <!-- History Section -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-primary me-2"></i>
                            Riwayat Scan
                        </h5>
                        <button class="btn btn-sm btn-outline-secondary" onclick="clearHistory()">
                            <i class="fas fa-trash-alt me-1"></i>
                            Hapus Riwayat
                        </button>
                    </div>
                    <div class="history-container" id="scanHistory">
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-2 d-block"></i>
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
    const keteranganInput = document.getElementById('keterangan');
    const startBtn = document.getElementById('startScanBtn');
    const switchBtn = document.getElementById('switchCameraBtn');
    const submitEmergencyBtn = document.getElementById('submitEmergencyBtn');
    const overlay = document.getElementById('scannerOverlay');
    const historyContainer = document.getElementById('scanHistory');
    const prayerInfo = document.getElementById('prayerInfo');

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
        // Remove empty state if exists
        if (historyContainer.querySelector('.text-center')) {
            historyContainer.innerHTML = '';
        }
        
        const historyItem = document.createElement('div');
        historyItem.className = `history-item ${status === 'Berhasil' ? 'success' : 'error'}`;
        const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        historyItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong class="text-primary">${time}</strong>
                    ${namaSiswa ? `<span class="mx-2">•</span> <strong>${namaSiswa}</strong>` : ''}
                </div>
                <span class="badge ${status === 'Berhasil' ? 'bg-success' : 'bg-danger'}">${status}</span>
            </div>
            <div class="mt-1 small">${message}</div>
        `;
        historyContainer.prepend(historyItem);
        
        // Limit history to 20 items
        while (historyContainer.children.length > 20) {
            historyContainer.removeChild(historyContainer.lastChild);
        }
    }

    function clearHistory() {
        historyContainer.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fas fa-inbox fa-3x mb-2 d-block"></i>
                <small>Belum ada riwayat scan</small>
            </div>
        `;
        showToast('Riwayat berhasil dihapus', 'info');
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
                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2 d-block"></i>
                    <strong>Gagal memuat jadwal sholat</strong>
                    <button class="btn btn-sm btn-primary mt-2" onclick="location.reload()">
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

        if (activePrayer) {
            isScanAllowed = true;
            currentActivePrayer = activePrayer.name;
            
            prayerInfo.className = 'prayer-info active';
            prayerInfo.innerHTML = `
                <div class="d-flex align-items-start">
                    <i class="fas fa-check-circle fa-2x text-success me-3"></i>
                    <div class="flex-grow-1">
                        <strong class="d-block mb-1">✅ Absensi Aktif</strong>
                        <h5 class="mb-1">Sholat ${activePrayer.name}</h5>
                        <small class="text-success">
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
                
                if (now < prayerTime) {
                    nextPrayer = prayers[i];
                    break;
                }
            }
            
            if (!nextPrayer) nextPrayer = prayers[0];
            
            prayerInfo.className = 'prayer-info waiting';
            prayerInfo.innerHTML = `
                <div class="d-flex align-items-start">
                    <i class="fas fa-clock fa-2x text-warning me-3"></i>
                    <div class="flex-grow-1">
                        <strong class="d-block mb-1">⏰ Menunggu Waktu Sholat</strong>
                        <h5 class="mb-1">Sholat ${nextPrayer.name}</h5>
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
            
            if (html5QrCode && html5QrCode.isScanning) {
                stopScanner();
            }
        }
    }

    // Submit Attendance
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

    // QR Scanner Functions
    function onScanSuccess(decodedText) {
        if (!isScanAllowed) {
            showToast("Absensi belum dibuka untuk sesi ini", "warning");
            return;
        }
        
        if (isSubmitting) {
            return;
        }
        
        randomStringInput.value = decodedText;
        submitAttendance(decodedText, 'qr');
    }

    function onScanFailure(error) {
        // Silent fail
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

    // Event Listeners
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
        if (emergencyCode.length !== 6) {
            showToast("Kode darurat harus 6 digit", "warning");
            return;
        }
        await submitAttendance(emergencyCode, 'emergency');
    });

    // Auto-refresh waktu setiap menit
    setInterval(() => {
        if (isScanAllowed) {
            // Refresh status untuk update timer jika perlu
        }
    }, 60000);

    // Initialize
    fetchPrayerTimes();
    window.clearHistory = clearHistory;

    // Cleanup
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