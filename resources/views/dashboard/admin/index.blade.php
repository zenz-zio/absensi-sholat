@extends('layouts.main')

@section('title', 'Halaman Utama - Dashboard')

@section('content')

<style>
    :root {
        --bg: #f7f6f2;
        --card: #ffffff;
        --line: #e8e5dc;
        --ink: #1f2a28;
        --muted: #7a8582;
        --teal: #145c4f;
        --teal-soft: #e6f0ed;
        --gold: #b08d2a;
        --gold-soft: #f6efd9;
        --rose: #a8452f;
        --rose-soft: #f6e6e1;

        --font-body: system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
    }

    .container-fluid { font-family: var(--font-body); color: var(--ink); font-variant-numeric: tabular-nums; }

    .card-plain {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 14px;
        box-shadow: 0 1px 2px rgba(20, 40, 36, 0.04);
    }

    /* ===== WELCOME ===== */
    .welcome-card {
        background: var(--teal);
        border: none;
        border-radius: 14px;
        color: #fff;
    }
    .welcome-card h2 { font-size: 1.35rem; font-weight: 600; margin: 0 0 6px; }
    .welcome-card p { font-size: 0.88rem; margin: 0; color: rgba(255, 255, 255, 0.72); }
    .welcome-card .welcome-icon { font-size: 2rem; color: rgba(255, 255, 255, 0.25); }

    /* ===== STAT CARDS ===== */
    .equal-height-row { display: flex; flex-wrap: wrap; }
    .stat-card-wrapper { display: flex; height: 100%; }

    .stat-card {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 20px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 14px;
        box-shadow: 0 1px 2px rgba(20, 40, 36, 0.04);
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .stat-card:hover { box-shadow: 0 6px 18px -8px rgba(20, 40, 36, 0.18); border-color: #d9d5c8; }

    .stat-card .icon {
        width: 44px; height: 44px; min-width: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem;
    }
    .stat-primary .icon { background: var(--teal-soft); color: var(--teal); }
    .stat-danger  .icon { background: var(--rose-soft); color: var(--rose); }
    .stat-success .icon { background: var(--teal-soft); color: var(--teal); }
    .stat-warning .icon { background: var(--gold-soft); color: var(--gold); }

    .stat-card .inner { min-width: 0; }
    .stat-card .inner h3 {
        font-family: var(--font-body);
        font-size: 1.7rem; font-weight: 600;
        margin: 0; line-height: 1.15; color: var(--ink);
    }
    .stat-card .inner h4 {
        font-size: 1.05rem; font-weight: 600;
        margin: 0; line-height: 1.3; color: var(--ink);
    }
    .stat-card .inner p {
        margin: 2px 0 0; font-size: 0.8rem; color: var(--muted);
    }

    /* ===== PANEL (shared by prayer & attendance) ===== */
    .panel {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 14px;
        box-shadow: 0 1px 2px rgba(20, 40, 36, 0.04);
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .panel-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--line);
        flex-shrink: 0;
    }
    .header-title-row {
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 8px 14px;
    }
    .header-title-row h3 {
        margin: 0; font-size: 1.02rem; font-weight: 600; color: var(--ink);
        flex: 1 1 auto; min-width: 0;
    }
    .header-title-row h3 i { color: var(--teal); }
    .prayer-subtitle {
        margin-top: 4px; font-size: 0.78rem; color: var(--muted);
        display: flex; align-items: center; gap: 6px;
    }

    .location-badge {
        background: var(--teal-soft) !important;
        color: var(--teal) !important;
        font-size: 0.75rem; font-weight: 500;
        border: none;
        white-space: nowrap; max-width: 100%;
        overflow: hidden; text-overflow: ellipsis;
    }

    .panel-body { flex: 1; padding: 0; }

    /* ===== PRAYER TABLE ===== */
    .prayer-table { margin: 0; width: 100%; table-layout: fixed; border-collapse: collapse; }
    .prayer-table tbody tr { border-bottom: 1px solid var(--line); transition: background 0.2s ease; }
    .prayer-table tbody tr:last-child { border-bottom: none; }
    .prayer-table tbody tr:hover { background: var(--bg); }
    .prayer-table td { background: transparent; border: none; box-shadow: none; }

    .prayer-table .col-icon { width: 50px; text-align: center; padding: 14px 8px; vertical-align: middle; }
    .prayer-table .col-name { width: 100px; padding: 14px 8px; vertical-align: middle; font-weight: 600; color: var(--ink); font-size: 0.92rem; white-space: nowrap; }
    .prayer-table .col-sub { width: 70px; padding: 14px 8px; vertical-align: middle; color: var(--muted); font-family: var(--font-body); font-size: 0.7rem; white-space: nowrap; }
    .prayer-table .col-time { text-align: center; padding: 14px 8px; vertical-align: middle; }
    .prayer-table .col-badge { width: 100px; text-align: right; padding: 14px 16px 14px 8px; vertical-align: middle; }

    .prayer-table .prayer-icon { font-size: 1rem; color: var(--muted); width: 24px; text-align: center; }

    .prayer-table .prayer-time {
        font-family: var(--font-body);
        font-size: 1.05rem; font-weight: 500;
        color: var(--ink);
        display: inline-block; min-width: 70px; text-align: center;
    }

    .prayer-table .active-indicator,
    .prayer-table .next-prayer-indicator {
        display: inline-block; padding: 2px 10px; border-radius: 20px;
        font-size: 0.62rem; font-weight: 600; letter-spacing: 0.4px; text-transform: uppercase;
        white-space: nowrap;
    }
    .prayer-table .active-indicator { background: var(--teal); color: #fff; }
    .prayer-table .next-prayer-indicator { background: var(--gold-soft); color: var(--gold); }

    /* Active prayer row */
    .prayer-table tbody tr.active-prayer { background: var(--teal-soft); box-shadow: inset 3px 0 0 var(--teal); }
    .prayer-table tbody tr.active-prayer .prayer-icon { color: var(--teal); }
    .prayer-table tbody tr.active-prayer .prayer-time { color: var(--teal); font-weight: 600; }
    .prayer-table tbody tr.active-prayer .col-name { color: var(--teal); }

    /* ===== LOCATION INFO ===== */
    .location-info {
        padding: 12px 20px;
        border-top: 1px solid var(--line);
        background: var(--bg);
        display: flex; align-items: center; justify-content: center;
        gap: 10px; flex-wrap: wrap;
        flex-shrink: 0;
    }
    .location-info > i { color: var(--gold); }
    .location-info .location-text { font-size: 0.85rem; color: var(--ink); }

    .btn-refresh-location {
        color: var(--teal); background: #fff;
        border: 1px solid var(--line); border-radius: 50px;
        padding: 3px 12px; font-size: 0.75rem; cursor: pointer;
        transition: border-color 0.2s ease, background 0.2s ease;
    }
    .btn-refresh-location:hover { border-color: var(--teal); background: var(--teal-soft); }

    /* ===== ATTENDANCE ===== */
    .attendance-body { flex: 1; padding: 24px; display: flex; flex-direction: column; justify-content: center; }

    .chart-wrapper { position: relative; max-width: 210px; margin: 0 auto 12px; }
    .chart-center-label {
        position: absolute; top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        text-align: center; pointer-events: none;
    }
    .chart-center-label .pct { font-family: var(--font-body); font-size: 1.6rem; font-weight: 500; color: var(--ink); line-height: 1; display: block; }
    .chart-center-label .pct-label { font-size: 0.65rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600; display: block; margin-top: 4px; }

    .attendance-legend { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; }
    .legend-item { display: flex; align-items: center; gap: 7px; font-size: 0.8rem; color: var(--muted); }
    .legend-dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; }
    .legend-dot.hadir { background: var(--teal); }
    .legend-dot.belum { background: var(--rose); }

    .attendance-mini-stats { display: flex; gap: 12px; margin-top: 20px; }
    .attendance-mini-stat {
        flex: 1; display: flex; align-items: center; gap: 12px;
        padding: 12px 14px; border-radius: 12px;
        border: 1px solid var(--line); background: var(--bg);
    }
    .attendance-mini-stat .mini-icon {
        width: 36px; height: 36px; min-width: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; font-size: 0.95rem;
    }
    .attendance-mini-stat.is-hadir .mini-icon { background: var(--teal-soft); color: var(--teal); }
    .attendance-mini-stat.is-belum .mini-icon { background: var(--rose-soft); color: var(--rose); }
    .attendance-mini-stat .mini-value { font-family: var(--font-body); font-size: 1.25rem; font-weight: 500; line-height: 1.1; color: var(--ink); }
    .attendance-mini-stat .mini-label { font-size: 0.74rem; color: var(--muted); }

    .progress { background-color: var(--line); border-radius: 10px; height: 6px; overflow: hidden; }
    .progress-bar { border-radius: 10px; transition: width 0.6s ease; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .stat-card { padding: 14px 16px; gap: 12px; }
        .stat-card .icon { width: 38px; height: 38px; min-width: 38px; font-size: 0.95rem; }
        .stat-card .inner h3 { font-size: 1.4rem; }
        .stat-card .inner h4 { font-size: 0.95rem; }
        .stat-card .inner p { font-size: 0.74rem; }

        .panel-header { padding: 14px 18px; }
        .header-title-row h3 { font-size: 0.95rem; }

        .prayer-table .col-name { width: 70px; font-size: 0.84rem; }
        .prayer-table .col-sub { width: 50px; font-size: 0.62rem; }
        .prayer-table .col-badge { width: 80px; }
        .prayer-table .col-icon { width: 35px; }
        .prayer-table .prayer-time { font-size: 0.95rem; min-width: 55px; }

        .attendance-mini-stats { flex-direction: column; gap: 10px; }
        .chart-wrapper { max-width: 180px; }
    }

    @media (max-width: 576px) {
        .prayer-table .col-name { width: 60px; font-size: 0.78rem; padding: 10px 4px; }
        .prayer-table .col-sub { display: none; }
        .prayer-table .col-time { padding: 10px 4px; }
        .prayer-table .col-badge { width: 64px; padding: 10px 8px 10px 4px; }
        .prayer-table .col-icon { width: 30px; padding: 10px 4px; }
        .prayer-table .prayer-time { font-size: 0.88rem; min-width: 46px; }
        .prayer-table .next-prayer-indicator,
        .prayer-table .active-indicator { font-size: 0.52rem; padding: 1px 6px; }
    }
</style>

<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>Selamat Datang, {{ Auth::user()->name ?? 'User' }}!</h2>
                            <p>
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ now()->translatedFormat('l, d F Y') }}
                            </p>
                        </div>
                        <div class="welcome-icon">
                            <i class="fas fa-school"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== 4 STATISTIK CARD - SEJAJAR ===== --}}
    <div class="row equal-height-row mb-4">
        <!-- Waktu Sholat Terdekat -->
        <div class="col-lg-3 col-6 mb-3">
            <div class="stat-card-wrapper">
                <div class="stat-card stat-primary">
                    <div class="icon"><i class="fas fa-mosque"></i></div>
                    <div class="inner">
                        <h4 id="nextPrayer">Loading...</h4>
                        <p>Jadwal Sholat Terdekat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Belum Absensi -->
        <div class="col-lg-3 col-6 mb-3">
            <div class="stat-card-wrapper">
                <div class="stat-card stat-danger">
                    <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="inner">
                        <h3 id="belumAbsensi">0</h3>
                        <p>Belum Absensi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sudah Absensi -->
        <div class="col-lg-3 col-6 mb-3">
            <div class="stat-card-wrapper">
                <div class="stat-card stat-success">
                    <div class="icon"><i class="fas fa-user-check"></i></div>
                    <div class="inner">
                        <h3 id="sudahAbsensi">0</h3>
                        <p>Sudah Absensi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="col-lg-3 col-6 mb-3">
            <div class="stat-card-wrapper">
                <div class="stat-card stat-warning">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="inner">
                        <h3 id="totalSiswa">0</h3>
                        <p>Total Siswa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== JADWAL SHOLAT & GRAFIK ABSENSI - SEJAJAR ===== --}}
    <div class="row equal-height-row">
        <!-- Jadwal Sholat Card -->
        <div class="col-lg-6 col-12 mb-4">
            <div class="panel">
                <div class="panel-header">
                    <div class="header-title-row">
                        <h3><i class="fas fa-mosque me-2"></i>Jadwal Sholat Hari Ini</h3>
                        <span class="badge px-3 py-2 rounded-pill location-badge">
                            <i class="fas fa-map-pin me-1"></i>
                            <span id="locationShort">Memuat...</span>
                        </span>
                    </div>
                    <div class="prayer-subtitle">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>

                <div class="panel-body">
                    <table class="table prayer-table">
                        <tbody>
                            <tr id="row-subuh">
                                <td class="col-icon"><i class="fas fa-cloud-moon prayer-icon"></i></td>
                                <td class="col-name">Subuh</td>
                                <td class="col-sub">Fajr</td>
                                <td class="col-time" id="subuh">-</td>
                                <td class="col-badge" id="subuh-badge"></td>
                            </tr>
                            <tr id="row-dzuhur">
                                <td class="col-icon"><i class="fas fa-sun prayer-icon"></i></td>
                                <td class="col-name">Dzuhur</td>
                                <td class="col-sub">Dhuhr</td>
                                <td class="col-time" id="dzuhur">-</td>
                                <td class="col-badge" id="dzuhur-badge"></td>
                            </tr>
                            <tr id="row-ashar">
                                <td class="col-icon"><i class="fas fa-sun-haze prayer-icon"></i></td>
                                <td class="col-name">Ashar</td>
                                <td class="col-sub">Asr</td>
                                <td class="col-time" id="ashar">-</td>
                                <td class="col-badge" id="ashar-badge"></td>
                            </tr>
                            <tr id="row-maghrib">
                                <td class="col-icon"><i class="fas fa-sunset prayer-icon"></i></td>
                                <td class="col-name">Maghrib</td>
                                <td class="col-sub">Maghrib</td>
                                <td class="col-time" id="maghrib">-</td>
                                <td class="col-badge" id="maghrib-badge"></td>
                            </tr>
                            <tr id="row-isya">
                                <td class="col-icon"><i class="fas fa-moon-stars prayer-icon"></i></td>
                                <td class="col-name">Isya</td>
                                <td class="col-sub">Isha</td>
                                <td class="col-time" id="isya">-</td>
                                <td class="col-badge" id="isya-badge"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="location-info" id="locationInfo">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="location-text" id="locationText">
                        <i class="fas fa-spinner fa-spin me-2"></i> Mendapatkan lokasi Anda...
                    </span>
                    <button class="btn-refresh-location" onclick="refreshLocation()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistik Kehadiran Card -->
        <div class="col-lg-6 col-12 mb-4">
            <div class="panel">
                <div class="panel-header">
                    <div class="header-title-row">
                        <h3><i class="fas fa-chart-pie me-2"></i>Statistik Kehadiran</h3>
                    </div>
                    <div class="prayer-subtitle">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>

                <div class="attendance-body">
                    <div class="chart-wrapper">
                        <canvas id="attendanceChart"></canvas>
                        <div class="chart-center-label">
                            <span class="pct" id="attendancePercent">0%</span>
                            <span class="pct-label">Hadir</span>
                        </div>
                    </div>

                    <div class="attendance-legend">
                        <span class="legend-item"><span class="legend-dot hadir"></span> Sudah Absensi</span>
                        <span class="legend-item"><span class="legend-dot belum"></span> Belum Absensi</span>
                    </div>

                    <div class="attendance-mini-stats">
                        <div class="attendance-mini-stat is-hadir">
                            <div class="mini-icon"><i class="fas fa-check-circle"></i></div>
                            <div>
                                <div class="mini-value" id="sudahAbsensi2">0</div>
                                <div class="mini-label">Siswa hadir</div>
                            </div>
                        </div>
                        <div class="attendance-mini-stat is-belum">
                            <div class="mini-icon"><i class="fas fa-clock"></i></div>
                            <div>
                                <div class="mini-value" id="belumAbsensi2">0</div>
                                <div class="mini-label">Belum absen</div>
                            </div>
                        </div>
                    </div>

                    <div class="progress mt-3">
                        <div id="attendanceProgress" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                    </div>
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
    let lastTimings = null;
    let currentActivePrayer = null; // null = di luar jam sholat manapun (tampilkan total harian)
    let prayerUiInitialized = false; // supaya deteksi sholat aktif pertama kali TIDAK memicu fetch ganda

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
                document.getElementById('locationText').innerHTML = `
                    <i class="fas fa-exclamation-triangle me-2" style="color:#b08d2a;"></i>
                    Browser tidak support geolocation. Lokasi default: Harau
                `;
                document.getElementById('locationShort').innerHTML = 'Harau';
                reject('Browser tidak support');
                return;
            }

            document.getElementById('locationText').innerHTML = `
                <i class="fas fa-spinner fa-spin me-2" style="color:#145c4f;"></i> Meminta izin lokasi...
            `;

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    userLat = position.coords.latitude;
                    userLong = position.coords.longitude;

                    console.log('Koordinat user:', userLat, userLong);

                    document.getElementById('locationText').innerHTML = `
                        <i class="fas fa-spinner fa-spin me-2" style="color:#145c4f;"></i> Mendapatkan nama kota...
                    `;

                    const locationInfo = await getCityFromCoordinates(userLat, userLong);

                    if (locationInfo && locationInfo.city && locationInfo.city !== 'Lokasi Anda') {
                        userCity = locationInfo.city;
                        document.getElementById('locationText').innerHTML = `
                            ${userCity}, ${locationInfo.country}
                        `;
                        document.getElementById('locationShort').innerHTML = userCity;
                    } else {
                        userCity = `${userLat.toFixed(3)}°, ${userLong.toFixed(3)}°`;
                        document.getElementById('locationText').innerHTML = `
                            Koordinat: ${userCity}
                            <br><small class="text-muted">Nama kota tidak tersedia</small>
                        `;
                        document.getElementById('locationShort').innerHTML = 'Koordinat';
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

                    document.getElementById('locationText').innerHTML = `
                        <i class="fas fa-exclamation-triangle me-2" style="color:#b08d2a;"></i>
                        ${errorMsg} Menggunakan lokasi default: ${userCity}, Sumatera Barat
                    `;
                    document.getElementById('locationShort').innerHTML = userCity;

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
        const prayerTimes = {
            subuh: timings.Fajr,
            dzuhur: timings.Dhuhr,
            ashar: timings.Asr,
            maghrib: timings.Maghrib,
            isya: timings.Isha
        };

        // Update time display
        document.getElementById('subuh').innerHTML = `<span class="prayer-time">${prayerTimes.subuh}</span>`;
        document.getElementById('dzuhur').innerHTML = `<span class="prayer-time">${prayerTimes.dzuhur}</span>`;
        document.getElementById('ashar').innerHTML = `<span class="prayer-time">${prayerTimes.ashar}</span>`;
        document.getElementById('maghrib').innerHTML = `<span class="prayer-time">${prayerTimes.maghrib}</span>`;
        document.getElementById('isya').innerHTML = `<span class="prayer-time">${prayerTimes.isya}</span>`;

        // Determine current and next prayer
        const now = new Date();
        const prayers = [
            { id: 'subuh', name: 'Subuh', time: prayerTimes.subuh, rowId: 'row-subuh', badgeId: 'subuh-badge' },
            { id: 'dzuhur', name: 'Dzuhur', time: prayerTimes.dzuhur, rowId: 'row-dzuhur', badgeId: 'dzuhur-badge' },
            { id: 'ashar', name: 'Ashar', time: prayerTimes.ashar, rowId: 'row-ashar', badgeId: 'ashar-badge' },
            { id: 'maghrib', name: 'Maghrib', time: prayerTimes.maghrib, rowId: 'row-maghrib', badgeId: 'maghrib-badge' },
            { id: 'isya', name: 'Isya', time: prayerTimes.isya, rowId: 'row-isya', badgeId: 'isya-badge' }
        ];

        // Remove all active classes and clear badges
        prayers.forEach(p => {
            const row = document.getElementById(p.rowId);
            if (row) row.classList.remove('active-prayer');
            const badge = document.getElementById(p.badgeId);
            if (badge) badge.innerHTML = '';
        });

        let nextPrayer = null;
        let foundActive = false;

        for (let i = 0; i < prayers.length; i++) {
            const [h, m] = prayers[i].time.split(':');
            const prayerTime = new Date();
            prayerTime.setHours(parseInt(h), parseInt(m), 0, 0);

            const nextPrayerTime = i < prayers.length - 1 ?
                (() => { const [nh, nm] = prayers[i+1].time.split(':'); const d = new Date(); d.setHours(parseInt(nh), parseInt(nm), 0, 0); return d; })() :
                (() => { const d = new Date(); d.setDate(d.getDate() + 1); d.setHours(4, 0, 0, 0); return d; })();

            const scanStartTime = new Date(prayerTime.getTime() - 15 * 60000);

            if (now >= scanStartTime && now < nextPrayerTime) {
                const row = document.getElementById(prayers[i].rowId);
                if (row) row.classList.add('active-prayer');
                const badge = document.getElementById(prayers[i].badgeId);
                if (badge) {
                    badge.innerHTML = `<span class="active-indicator">● Aktif</span>`;
                }
                foundActive = true;
                nextPrayer = prayers[i + 1] || prayers[0];

                // Catat waktu sholat yang sedang aktif, lalu refresh statistik
                // HANYA kalau ini bukan deteksi pertama kali (initial page load
                // sudah fetch data lewat fetchAbsensiData() di awal skrip -
                // fetch ulang di sini dulu bikin angka yang baru saja tampil
                // benar langsung ketiban hasil fetch kedua yang belum tentu
                // konsisten / masih 0 untuk sesi sholat yang baru saja mulai).
                if (currentActivePrayer !== prayers[i].name) {
                    currentActivePrayer = prayers[i].name;
                    if (prayerUiInitialized) {
                        fetchAbsensiData();
                    }
                }
                break;
            }
        }

        // Kalau tidak ada sholat yang aktif saat ini, tampilkan total harian
        if (!foundActive && currentActivePrayer !== null) {
            currentActivePrayer = null;
            if (prayerUiInitialized) {
                fetchAbsensiData();
            }
        }

        prayerUiInitialized = true;

        // If no active prayer, find next prayer
        if (!foundActive) {
            for (let i = 0; i < prayers.length; i++) {
                const [h, m] = prayers[i].time.split(':');
                const prayerTime = new Date();
                prayerTime.setHours(parseInt(h), parseInt(m), 0, 0);

                if (now < prayerTime) {
                    nextPrayer = prayers[i];
                    const badge = document.getElementById(prayers[i].badgeId);
                    if (badge) {
                        badge.innerHTML = `<span class="next-prayer-indicator">Berikutnya</span>`;
                    }
                    break;
                }
            }
            if (!nextPrayer) {
                nextPrayer = prayers[0];
                const badge = document.getElementById(prayers[0].badgeId);
                if (badge) {
                    badge.innerHTML = `<span class="next-prayer-indicator">Berikutnya</span>`;
                }
            }
        }

        // Update next prayer text in card
        let nextText = 'Selesai (Isya)';
        if (nextPrayer) {
            nextText = `${nextPrayer.name} • ${nextPrayer.time}`;
        }
        document.getElementById('nextPrayer').innerHTML = nextText;
    }

    // ============ UPDATE CHART ============
    function updateChart(sudah, belum) {
        const canvas = document.getElementById('attendanceChart');
        const ctx = canvas.getContext('2d');

        if (attendanceChart) {
            attendanceChart.destroy();
        }

        const total = sudah + belum;
        const percent = total > 0 ? ((sudah / total) * 100).toFixed(1) : 0;

        attendanceChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Sudah Absensi', 'Belum Absensi'],
                datasets: [{
                    data: [sudah, belum],
                    backgroundColor: ['#145c4f', '#a8452f'],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 6,
                    borderRadius: 4,
                    spacing: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2a28',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const pct = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value} (${pct}%)`;
                            }
                        }
                    }
                },
                cutout: '76%',
                animation: { animateRotate: true, animateScale: false, duration: 700, easing: 'easeOutQuart' }
            }
        });

        document.getElementById('attendancePercent').innerText = percent + '%';
        document.getElementById('attendanceProgress').style.width = `${percent}%`;
        document.getElementById('sudahAbsensi2').innerText = sudah;
        document.getElementById('belumAbsensi2').innerText = belum;

        const progressBar = document.getElementById('attendanceProgress');
        if (percent >= 70) {
            progressBar.style.background = '#145c4f';
        } else if (percent >= 40) {
            progressBar.style.background = '#b08d2a';
        } else {
            progressBar.style.background = '#a8452f';
        }
    }

    // ============ MAIN FUNCTION ============
    async function initDashboard() {
        try {
            const location = await getUserLocation();
            const timings = await fetchPrayerSchedule(location.lat, location.long);
            lastTimings = timings;
            updatePrayerUI(timings);
        } catch (error) {
            console.error('Error:', error);
            try {
                const timings = await fetchPrayerSchedule(-0.227819, 100.626617);
                lastTimings = timings;
                updatePrayerUI(timings);
            } catch (fallbackError) {
                console.error('Fallback error:', fallbackError);
                document.getElementById('nextPrayer').innerHTML = '<i class="fas fa-exclamation-triangle me-2" style="color:#b08d2a;"></i>Error';
            }
        }
    }

    // ============ FETCH DATA ABSENSI ============
    function fetchAbsensiData() {
        const url = currentActivePrayer
            ? `/api/dashboard-absensi?prayer=${encodeURIComponent(currentActivePrayer)}`
            : '/api/dashboard-absensi';

        fetch(url, {
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
        document.getElementById('locationText').innerHTML = '<i class="fas fa-spinner fa-spin me-2" style="color:#145c4f;"></i> Mendapatkan lokasi Anda...';
        document.getElementById('nextPrayer').innerHTML = 'Loading...';
        document.getElementById('subuh').innerHTML = '-';
        document.getElementById('dzuhur').innerHTML = '-';
        document.getElementById('ashar').innerHTML = '-';
        document.getElementById('maghrib').innerHTML = '-';
        document.getElementById('isya').innerHTML = '-';

        // Clear badges
        ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'].forEach(id => {
            const badge = document.getElementById(id + '-badge');
            if (badge) badge.innerHTML = '';
            const row = document.getElementById('row-' + id);
            if (row) row.classList.remove('active-prayer');
        });

        lastTimings = null;

        initDashboard();
    };

    // ============ START ============
    initDashboard();
    fetchAbsensiData();
    setInterval(fetchAbsensiData, 30000);

    // Cek ulang waktu sholat mana yang aktif setiap 1 menit (pakai jadwal
    // yang sudah di-cache di lastTimings, tanpa perlu fetch API lagi).
    setInterval(() => {
        if (lastTimings) updatePrayerUI(lastTimings);
    }, 60000);
});
</script>
@endpush