@extends('layouts.main')

@section('title', 'Halaman Utama - Dashboard')

@section('content')

<style>
    .stat-card {
        transition: all 0.3s ease;
        border-radius: 20px;
        overflow: hidden;
        cursor: pointer;
    }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }
    
    .stat-card .inner {
        padding: 20px;
        position: relative;
        z-index: 1;
    }
    
    .stat-card .inner h3 {
        font-size: 2.2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .stat-card .inner p {
        margin-bottom: 0;
        font-size: 0.95rem;
        opacity: 0.9;
    }
    
    .stat-card .icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 4rem;
        opacity: 0.3;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover .icon {
        opacity: 0.5;
        transform: translateY(-50%) scale(1.1);
    }
    
    .prayer-card {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .prayer-table {
        margin-bottom: 0;
    }
    
    .prayer-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .prayer-table tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
    }
    
    .prayer-table th {
        width: 120px;
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .prayer-table td {
        font-weight: 500;
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
    }
    
    .next-prayer-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        display: inline-block;
        font-weight: bold;
    }
    
    .location-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    
    .location-badge:hover {
        transform: scale(1.05);
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .next-prayer-text {
        animation: pulse 2s ease-in-out infinite;
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: none;
    }
    
    .card-header-custom h3 {
        color: white;
        margin: 0;
    }
    
    .btn-refresh {
        transition: all 0.3s ease;
    }
    
    .btn-refresh:hover {
        transform: rotate(180deg);
    }
    
    .stat-bg-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stat-bg-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .stat-bg-success {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .stat-bg-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    
    .loading-shimmer {
        background: linear-gradient(120deg, #e0e0e0 30%, #f0f0f0 50%, #e0e0e0 70%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
</style>

<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-2 fw-bold">
                                <i class="fas fa-chalkboard-user me-2"></i>
                                Selamat Datang, {{ Auth::user()->name ?? 'User' }}!
                            </h2>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ now()->translatedFormat('l, d F Y') }}
                            </p>
                        </div>
                        <div class="text-center">
                            <i class="fas fa-school fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== 4 STATISTIK CARD ===== --}}
    <div class="row mb-4">
        <!-- Waktu Sholat Terdekat -->
        <div class="col-lg-3 col-6 mb-3">
            <div class="stat-card stat-bg-info position-relative shadow-lg">
                <div class="inner text-white">
                    <h4 id="nextPrayer" class="next-prayer-text">Loading...</h4>
                    <p><i class="fas fa-clock me-1"></i> Jadwal Sholat Terdekat</p>
                </div>
                <div class="icon">
                    <i class="fas fa-mosque"></i>
                </div>
            </div>
        </div>

        <!-- Belum Absensi -->
        <div class="col-lg-3 col-6 mb-3">
            <div class="stat-card stat-bg-danger position-relative shadow-lg">
                <div class="inner text-white">
                    <h3 id="belumAbsensi">0</h3>
                    <p><i class="fas fa-user-clock me-1"></i> Belum Absensi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>

        <!-- Sudah Absensi -->
        <div class="col-lg-3 col-6 mb-3">
            <div class="stat-card stat-bg-success position-relative shadow-lg">
                <div class="inner text-white">
                    <h3 id="sudahAbsensi">0</h3>
                    <p><i class="fas fa-check-circle me-1"></i> Sudah Absensi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="col-lg-3 col-6 mb-3">
            <div class="stat-card stat-bg-warning position-relative shadow-lg">
                <div class="inner text-white">
                    <h3 id="totalSiswa">0</h3>
                    <p><i class="fas fa-users me-1"></i> Total Siswa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== JADWAL SHOLAT & GRAFIK ABSENSI ===== --}}
    <div class="row">
        <div class="col-lg-6 col-12 mb-4">
            <div class="card prayer-card border-0 shadow-lg">
                <div class="card-header-custom p-3">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-mosque me-2"></i> Jadwal Sholat Hari Ini
                    </h3>
                </div>

                <div class="card-body p-0">
                    <table class="table prayer-table mb-0">
                        <tbody>
                            <tr>
                                <th><i class="fas fa-cloud-moon me-2"></i> Subuh</th>
                                <td id="subuh">-</td>
                                <td class="text-end text-muted">
                                    <small>Fajr</small>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-sun me-2"></i> Dzuhur</th>
                                <td id="dzuhur">-</td>
                                <td class="text-end text-muted">
                                    <small>Dhuhr</small>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-sun-haze me-2"></i> Ashar</th>
                                <td id="ashar">-</td>
                                <td class="text-end text-muted">
                                    <small>Asr</small>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-sunset me-2"></i> Maghrib</th>
                                <td id="maghrib">-</td>
                                <td class="text-end text-muted">
                                    <small>Maghrib</small>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-moon-stars me-2"></i> Isya</th>
                                <td id="isya">-</td>
                                <td class="text-end text-muted">
                                    <small>Isha</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-light text-center p-3" id="locationInfo">
                    <i class="fas fa-spinner fa-spin me-2"></i> Mendapatkan lokasi Anda...
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 col-12 mb-4">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h3 class="card-title fw-bold">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Statistik Kehadiran
                    </h3>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <canvas id="attendanceChart" style="max-height: 250px; width: 100%;"></canvas>
                        </div>
                    </div>
                    <div class="row text-center mt-3">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="text-success mb-2">
                                    <i class="fas fa-check-circle"></i> Kehadiran
                                </h5>
                                <h3 class="fw-bold text-success" id="sudahAbsensi2">0</h3>
                                <small class="text-muted">Siswa hadir</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <h5 class="text-danger mb-2">
                                    <i class="fas fa-clock"></i> Belum Hadir
                                </h5>
                                <h3 class="fw-bold text-danger" id="belumAbsensi2">0</h3>
                                <small class="text-muted">Siswa belum absen</small>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-4" style="height: 15px; border-radius: 10px;">
                        <div id="attendanceProgress" class="progress-bar bg-success" role="progressbar" style="width: 0%; border-radius: 10px;"></div>
                    </div>
                    <p class="text-center text-muted mt-3 mb-0">
                        <small>
                            <i class="fas fa-chart-simple"></i> 
                            Persentase Kehadiran: <span id="attendancePercent">0</span>%
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let attendanceChart = null;
    let userLat = null;
    let userLong = null;
    let userCity = '';

    // ============ FUNGSI AMBIL NAMA KOTA (MULTI API) ============
    async function getCityFromCoordinates(lat, lon) {
        try {
            const response = await fetch(`https://api.aladhan.com/v1/addressInfo?address=${lat},${lon}`);
            const data = await response.json();
            
            if (data.code === 200 && data.data && data.data.city) {
                console.log('AlAdhan API:', data.data);
                return { city: data.data.city, country: data.data.country || 'Indonesia' };
            }
        } catch (e) {
            console.log('AlAdhan API error:', e);
        }

        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=id`);
            const data = await response.json();
            
            if (data && data.address) {
                const city = data.address.city || 
                            data.address.town || 
                            data.address.village || 
                            data.address.county ||
                            data.address.state ||
                            'Lokasi Anda';
                
                const country = data.address.country || 'Indonesia';
                
                console.log('Nominatim API:', { city, country });
                return { city, country };
            }
        } catch (e) {
            console.log('Nominatim API error:', e);
        }

        try {
            const response = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=id`);
            const data = await response.json();
            
            if (data && data.city) {
                console.log('BigDataCloud API:', data);
                return { city: data.city, country: data.countryName || 'Indonesia' };
            }
        } catch (e) {
            console.log('BigDataCloud error:', e);
        }

        return null;
    }

    // ============ GET LOKASI USER ============
    async function getUserLocation() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                document.getElementById('locationInfo').innerHTML = `
                    <i class="fas fa-exclamation-triangle me-2"></i> 
                    Browser tidak support geolocation. Gunakan lokasi default: Harau
                    <button class="btn btn-sm btn-link btn-refresh" onclick="refreshLocation()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                `;
                reject('Browser tidak support');
                return;
            }

            document.getElementById('locationInfo').innerHTML = `
                <i class="fas fa-spinner fa-spin me-2"></i> Meminta izin lokasi...
            `;

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    userLat = position.coords.latitude;
                    userLong = position.coords.longitude;
                    
                    console.log('Koordinat user:', userLat, userLong);
                    
                    document.getElementById('locationInfo').innerHTML = `
                        <i class="fas fa-spinner fa-spin me-2"></i> Mendapatkan nama kota...
                    `;
                    
                    const locationInfo = await getCityFromCoordinates(userLat, userLong);
                    
                    if (locationInfo && locationInfo.city && locationInfo.city !== 'Lokasi Anda') {
                        userCity = locationInfo.city;
                        document.getElementById('locationInfo').innerHTML = `
                            <i class="fas fa-map-marker-alt me-2"></i> 
                            📍 ${userCity}, ${locationInfo.country}
                            <button class="btn btn-sm btn-link btn-refresh text-white" onclick="refreshLocation()">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        `;
                    } else {
                        userCity = `${userLat.toFixed(3)}°, ${userLong.toFixed(3)}°`;
                        document.getElementById('locationInfo').innerHTML = `
                            <i class="fas fa-map-marker-alt me-2"></i> 
                            📍 Koordinat: ${userCity}
                            <button class="btn btn-sm btn-link btn-refresh text-white" onclick="refreshLocation()">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                            <br><small>Nama kota tidak tersedia</small>
                        `;
                    }
                    
                    resolve({ lat: userLat, long: userLong });
                },
                (error) => {
                    let errorMsg = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMsg = 'Izin lokasi ditolak.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMsg = 'Lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            errorMsg = 'Waktu habis.';
                            break;
                        default:
                            errorMsg = 'Error tidak dikenal.';
                    }
                    
                    userLat = -0.227819;
                    userLong = 100.626617;
                    userCity = 'Harau';
                    
                    document.getElementById('locationInfo').innerHTML = `
                        <i class="fas fa-exclamation-triangle me-2"></i> 
                        ${errorMsg} Menggunakan lokasi default: 📍 ${userCity}, Sumatera Barat
                        <button class="btn btn-sm btn-link btn-refresh text-white" onclick="refreshLocation()">
                            <i class="fas fa-sync-alt"></i> Coba lagi
                        </button>
                    `;
                    
                    reject(errorMsg);
                },
                { 
                    enableHighAccuracy: true, 
                    timeout: 15000, 
                    maximumAge: 0 
                }
            );
        });
    }

    // ============ FETCH JADWAL SHOLAT ============
    function fetchPrayerSchedule(lat, long) {
        const today = new Date().toISOString().split('T')[0];
        const apiUrl = `https://api.aladhan.com/v1/timings/${today}?latitude=${lat}&longitude=${long}&method=20`;
        
        return fetch(apiUrl)
            .then(res => res.json())
            .then(data => {
                if (data.code === 200 && data.data) {
                    return data.data.timings;
                } else {
                    throw new Error('Gagal mengambil data jadwal sholat');
                }
            });
    }

    // ============ UPDATE UI JADWAL SHOLAT ============
    function updatePrayerUI(timings) {
        document.getElementById('subuh').innerText = timings.Fajr;
        document.getElementById('dzuhur').innerText = timings.Dhuhr;
        document.getElementById('ashar').innerText = timings.Asr;
        document.getElementById('maghrib').innerText = timings.Maghrib;
        document.getElementById('isya').innerText = timings.Isha;

        const now = new Date();
        const prayers = [
            { name: 'Subuh', time: timings.Fajr },
            { name: 'Dzuhur', time: timings.Dhuhr },
            { name: 'Ashar', time: timings.Asr },
            { name: 'Maghrib', time: timings.Maghrib },
            { name: 'Isya', time: timings.Isha }
        ];

        let next = 'Selesai (Isya)';
        for (let p of prayers) {
            const [h, m] = p.time.split(':');
            const pt = new Date();
            pt.setHours(parseInt(h), parseInt(m), 0);

            if (pt > now) {
                next = `${p.name} • ${p.time}`;
                break;
            }
        }

        document.getElementById('nextPrayer').innerHTML = `<i class="fas fa-bell me-2"></i>${next}`;
    }

    // ============ UPDATE CHART ============
    function updateChart(sudah, belum) {
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        
        if (attendanceChart) {
            attendanceChart.destroy();
        }
        
        attendanceChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Sudah Absensi', 'Belum Absensi'],
                datasets: [{
                    data: [sudah, belum],
                    backgroundColor: ['#4facfe', '#f5576c'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = sudah + belum;
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
        
        const total = sudah + belum;
        const percent = total > 0 ? ((sudah / total) * 100).toFixed(1) : 0;
        document.getElementById('attendancePercent').innerText = percent;
        document.getElementById('attendanceProgress').style.width = `${percent}%`;
        document.getElementById('sudahAbsensi2').innerText = sudah;
        document.getElementById('belumAbsensi2').innerText = belum;
        
        if (percent >= 70) {
            document.getElementById('attendanceProgress').className = 'progress-bar bg-success';
        } else if (percent >= 40) {
            document.getElementById('attendanceProgress').className = 'progress-bar bg-warning';
        } else {
            document.getElementById('attendanceProgress').className = 'progress-bar bg-danger';
        }
    }

    // ============ MAIN FUNCTION ============
    async function initDashboard() {
        try {
            const location = await getUserLocation();
            const timings = await fetchPrayerSchedule(location.lat, location.long);
            updatePrayerUI(timings);
        } catch (error) {
            console.error('Error:', error);
            try {
                const timings = await fetchPrayerSchedule(-0.227819, 100.626617);
                updatePrayerUI(timings);
            } catch (fallbackError) {
                console.error('Fallback error:', fallbackError);
                document.getElementById('nextPrayer').innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Error';
            }
        }
    }

    // ============ FETCH DATA ABSENSI ============
    function fetchAbsensiData() {
        fetch('/api/dashboard-absensi', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const total = data.data.total_siswa || 0;
                const sudah = data.data.sudah_absensi || 0;
                const belum = data.data.belum_absensi || 0;
                
                document.getElementById('totalSiswa').innerText = total;
                document.getElementById('sudahAbsensi').innerText = sudah;
                document.getElementById('belumAbsensi').innerText = belum;
                
                updateChart(sudah, belum);
            }
        })
        .catch(err => console.error('Error fetch absensi:', err));
    }

    // ============ REFRESH LOCATION ============
    window.refreshLocation = function() {
        document.getElementById('locationInfo').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mendapatkan lokasi Anda...';
        document.getElementById('nextPrayer').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
        document.getElementById('subuh').innerText = '-';
        document.getElementById('dzuhur').innerText = '-';
        document.getElementById('ashar').innerText = '-';
        document.getElementById('maghrib').innerText = '-';
        document.getElementById('isya').innerText = '-';
        
        initDashboard();
    };

    // ============ START ============
    initDashboard();
    fetchAbsensiData();
    setInterval(fetchAbsensiData, 30000);
});
</script>
@endpush