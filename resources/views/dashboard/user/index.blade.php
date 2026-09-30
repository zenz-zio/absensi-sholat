@extends('layouts.app')

@section('title', 'Dashboard User')

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
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .container-fluid { font-family: var(--font-body); color: var(--ink); }

    /* ============ EQUAL HEIGHT ROW ============ */
    .equal-height-row { display: flex; flex-wrap: wrap; }
    .equal-height-row > [class*="col-"] { display: flex; flex-direction: column; }

    /* ============ WELCOME ============ */
    .welcome-card {
        background: var(--teal);
        border: none;
        border-radius: 14px;
        margin-bottom: 22px;
        animation: fadeInUp 0.4s ease-out;
    }
    .welcome-card h2 { font-weight: 600; font-size: 1.3rem; }
    .welcome-card p { font-size: 0.86rem; color: rgba(255,255,255,0.75) !important; }

    /* ============ DASHBOARD STAT CARDS ============ */
    .dashboard-card-wrapper { display: flex; height: 100%; width: 100%; }

    .dashboard-card {
        border-radius: 14px;
        overflow: hidden;
        width: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        border: 1px solid var(--line);
        background: #fff;
        animation: fadeInUp 0.5s ease-out;
    }

    .card-gradient-primary { background: var(--teal-soft); }
    .card-gradient-secondary { background: var(--gold-soft); }

    .card-inner {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 120px;
    }

    .card-inner h3 { font-size: 2rem; font-weight: 700; margin-bottom: 6px; color: var(--ink); }
    .card-inner h4 { font-size: 1.35rem; font-weight: 700; margin-bottom: 6px; color: var(--ink); }
    .card-inner p { margin-bottom: 0; font-size: 0.85rem; color: var(--muted); }

    .card-icon {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 3.6rem;
        opacity: 0.12;
        color: var(--teal);
    }
    .card-gradient-secondary .card-icon { color: var(--gold); }

    /* ============ PRAYER CARD ============ */
    .prayer-card-wrapper { display: flex; height: 100%; width: 100%; }

    .prayer-card {
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid var(--line);
        background: #fff;
    }

    .prayer-header { padding: 16px 20px; border-bottom: 1px solid var(--line); background: #fff; }
    .prayer-header h3 { color: var(--ink); margin: 0; font-weight: 600; font-size: 1.1rem; }
    .prayer-header h3 i { color: var(--teal); margin-right: 8px; }
    .prayer-header .prayer-subtitle { color: var(--muted); font-size: 0.78rem; margin-top: 4px; }
    .prayer-header .badge {
        background: var(--teal-soft) !important;
        border: none;
        color: var(--teal) !important;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .prayer-card .card-body { flex: 1; padding: 0; }

    /* ============ PRAYER TABLE ============ */
    .prayer-table { margin-bottom: 0; }
    .prayer-table tbody tr { border-bottom: 1px solid var(--line); }
    .prayer-table tbody tr:last-child { border-bottom: none; }

    .prayer-table th {
        width: 130px;
        background: var(--bg);
        font-weight: 600;
        color: var(--ink);
        padding: 12px 18px;
        font-size: 0.88rem;
        border: none;
    }
    .prayer-table th i { color: var(--muted); width: 22px; margin-right: 6px; }

    .prayer-table td {
        font-weight: 500;
        padding: 12px 18px;
        color: var(--ink);
        vertical-align: middle;
        border: none;
    }

    .prayer-table .prayer-time {
        font-size: 1rem;
        font-weight: 600;
        color: var(--teal);
        background: var(--teal-soft);
        padding: 3px 12px;
        border-radius: 20px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }

    .prayer-table .prayer-label { display: flex; align-items: center; gap: 8px; }
    .prayer-table .prayer-label span { font-size: 0.8rem; color: var(--muted); font-weight: 400; }

    /* ============ ACTIVE PRAYER ============ */
    .prayer-table tbody tr.active-prayer { background: var(--gold-soft); border-left: 3px solid var(--gold); }
    .prayer-table tbody tr.active-prayer .prayer-time { background: var(--gold); color: #fff; }

    .prayer-table .next-prayer-indicator {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.62rem;
        font-weight: 700;
        text-transform: uppercase;
        background: var(--line);
        color: var(--ink);
    }

    /* ============ LOCATION BADGE ============ */
    .location-badge {
        background: var(--bg);
        border-top: 1px solid var(--line);
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .location-badge i { color: var(--gold); }
    .location-badge .location-text { font-size: 0.85rem; color: var(--ink); }

    .btn-refresh {
        color: var(--teal);
        background: #fff;
        border-radius: 50px;
        padding: 4px 14px;
        border: 1px solid var(--line);
        font-size: 0.78rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-refresh:hover { border-color: var(--teal); }

    /* ============ SIDE INFO ============ */
    .side-info-wrapper { display: flex; flex-direction: column; gap: 16px; height: 100%; }

    .today-card {
        border: 1px solid var(--line);
        border-radius: 14px;
        background: #fff;
        padding: 12px;
        animation: fadeInUp 0.5s ease-out;
    }
    .today-card-inner { background: var(--bg); border-radius: 10px; padding: 16px; }
    .today-title { color: var(--gold); font-size: 0.8rem; font-weight: 700; margin-bottom: 8px; }
    .today-day { color: var(--ink); font-size: 1.5rem; font-weight: 700; line-height: 1.1; margin-bottom: 4px; }
    .today-date { color: var(--muted); font-size: 0.68rem; }

    .quote-card {
        flex: 1;
        border: 1px solid var(--line);
        border-radius: 14px;
        background: #fff;
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out;
    }
    .quote-inner { padding: 20px 18px; background: var(--bg); height: 100%; }
    .quote-icon { color: var(--gold); font-size: 0.9rem; margin-bottom: 16px; }
    .quote-text { color: var(--ink); font-size: 0.78rem; line-height: 1.6; margin: 0; max-width: 190px; }
    .quote-line { width: 22px; height: 2px; background: var(--gold); margin-top: 12px; }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 991px) {
        .side-info-wrapper { margin-top: 18px; }
    }

    @media (max-width: 768px) {
        .card-inner { min-height: 100px; padding: 16px; }
        .card-inner h3 { font-size: 1.6rem; }
        .card-inner h4 { font-size: 1.2rem; }
        .card-icon { font-size: 2.8rem; }
        .prayer-table th { padding: 10px 14px; font-size: 0.82rem; width: 100px; }
        .prayer-table td { padding: 10px 14px; font-size: 0.9rem; }
        .prayer-table .prayer-time { font-size: 0.9rem; min-width: 60px; }
        .prayer-header h3 { font-size: 1rem; }
    }

    @media (max-width: 576px) {
        .card-inner { min-height: 80px; padding: 14px; }
        .card-inner h3 { font-size: 1.3rem; }
        .card-inner h4 { font-size: 1.05rem; }
        .card-icon { font-size: 2.2rem; right: 10px; }
        .today-day { font-size: 1.3rem; }
    }

</style>


<div class="container-fluid">

    {{-- =========================
         WELCOME SECTION
    ========================= --}}
    <div class="row">

        <div class="col-12">

            <div class="welcome-card shadow-sm">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div>

                            <h2 class="mb-2 fw-bold text-white">

                                <i class="fas fa-user-graduate me-2" style="color: var(--gold-soft);"></i>

                                Selamat Datang, {{ Auth::user()->name ?? 'User' }}!

                            </h2>

                            <p class="mb-0">

                                <i class="fas fa-calendar-alt me-2"></i>

                                {{ now()->translatedFormat('l, d F Y') }}

                            </p>

                        </div>


                        <div class="text-center mt-3 mt-md-0">

                            <div class="bg-white rounded-circle p-3 d-inline-flex" style="width: 64px; height: 64px;">

                                <i class="fas fa-mosque fa-lg m-auto" style="color: var(--teal);"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
         3 CARD DASHBOARD
    ========================= --}}
    <div class="row equal-height-row mb-4">


        {{-- SHOLAT TERDEKAT --}}
        <div class="col-lg-4 col-md-6 col-12 mb-3">

            <div class="dashboard-card-wrapper">

                <div class="dashboard-card card-gradient-primary">

                    <div class="card-inner">

                        <h4 id="nextPrayer" class="next-prayer-text">
                            Loading...
                        </h4>

                        <p>
                            <i class="fas fa-clock me-2"></i>
                            Waktu Sholat Terdekat
                        </p>

                    </div>

                    <div class="card-icon">
                        <i class="fas fa-mosque"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- STATUS ABSENSI --}}
        <div class="col-lg-4 col-md-6 col-12 mb-3">

            <div class="dashboard-card-wrapper">

                <div class="dashboard-card card-gradient-secondary">

                    <div class="card-inner">

                        <h4 id="statusAbsensi">
                            <i class="fas fa-spinner fa-spin"></i>
                        </h4>

                        <p>
                            <i class="fas fa-user-clock me-2"></i>
                            Status Absensi Hari Ini
                        </p>

                    </div>

                    <div class="card-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- TOTAL KEHADIRAN --}}
        <div class="col-lg-4 col-md-12 col-12 mb-3">

            <div class="dashboard-card-wrapper">

                <div class="dashboard-card card-gradient-primary">

                    <div class="card-inner">

                        <h3 id="totalHadir">0</h3>

                        <p>
                            <i class="fas fa-chart-line me-2"></i>
                            Total Kehadiran
                        </p>

                    </div>

                    <div class="card-icon">
                        <i class="fas fa-trophy"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         JADWAL SHOLAT + CARD SAMPING
    ========================================================= --}}
    <div class="row">


        {{-- =========================
             JADWAL SHOLAT
        ========================= --}}
        <div class="col-lg-8 col-md-12 col-12">

            <div class="prayer-card-wrapper">

                <div class="prayer-card card border-0 w-100">


                    {{-- HEADER --}}
                    <div class="prayer-header">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h3 class="mb-0">
                                    <i class="fas fa-mosque"></i>
                                    Jadwal Sholat Hari Ini
                                </h3>

                                <div class="prayer-subtitle">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ now()->translatedFormat('l, d F Y') }}
                                </div>

                            </div>


                            <div class="text-end">

                                <span class="badge px-3 py-2 rounded-pill">
                                    <i class="fas fa-map-pin me-1"></i>
                                    <span id="locationShort">Memuat...</span>
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- TABLE --}}
                    <div class="card-body p-0">

                        <table class="table prayer-table mb-0">

                            <tbody>


                                {{-- SUBUH --}}
                                <tr id="row-subuh">

                                    <th>
                                        <div class="prayer-label">
                                            <i class="fas fa-cloud-moon"></i>
                                            Subuh
                                            <span>Fajr</span>
                                        </div>
                                    </th>

                                    <td id="subuh" class="text-center">-</td>

                                    <td class="text-end text-muted" style="width: 100px;">
                                        <small id="subuh-badge"></small>
                                    </td>

                                </tr>


                                {{-- DZUHUR --}}
                                <tr id="row-dzuhur">

                                    <th>
                                        <div class="prayer-label">
                                            <i class="fas fa-sun"></i>
                                            Dzuhur
                                            <span>Dhuhr</span>
                                        </div>
                                    </th>

                                    <td id="dzuhur" class="text-center">-</td>

                                    <td class="text-end text-muted" style="width: 100px;">
                                        <small id="dzuhur-badge"></small>
                                    </td>

                                </tr>


                                {{-- ASHAR --}}
                                <tr id="row-ashar">

                                    <th>
                                        <div class="prayer-label">
                                            <i class="fas fa-sun-haze"></i>
                                            Ashar
                                            <span>Asr</span>
                                        </div>
                                    </th>

                                    <td id="ashar" class="text-center">-</td>

                                    <td class="text-end text-muted" style="width: 100px;">
                                        <small id="ashar-badge"></small>
                                    </td>

                                </tr>


                                {{-- MAGHRIB --}}
                                <tr id="row-maghrib">

                                    <th>
                                        <div class="prayer-label">
                                            <i class="fas fa-sunset"></i>
                                            Maghrib
                                            <span>Maghrib</span>
                                        </div>
                                    </th>

                                    <td id="maghrib" class="text-center">-</td>

                                    <td class="text-end text-muted" style="width: 100px;">
                                        <small id="maghrib-badge"></small>
                                    </td>

                                </tr>


                                {{-- ISYA --}}
                                <tr id="row-isya">

                                    <th>
                                        <div class="prayer-label">
                                            <i class="fas fa-moon-stars"></i>
                                            Isya
                                            <span>Isha</span>
                                        </div>
                                    </th>

                                    <td id="isya" class="text-center">-</td>

                                    <td class="text-end text-muted" style="width: 100px;">
                                        <small id="isya-badge"></small>
                                    </td>

                                </tr>


                            </tbody>

                        </table>

                    </div>


                    {{-- LOCATION --}}
                    <div class="location-badge" id="locationInfo">

                        <i class="fas fa-map-marker-alt"></i>

                        <span class="location-text" id="locationText">
                            <i class="fas fa-spinner fa-spin me-2"></i>
                            Mendapatkan lokasi Anda...
                        </span>

                        <button class="btn-refresh" onclick="refreshLocation()">
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>

                    </div>


                </div>

            </div>

        </div>


        {{-- =====================================================
             CARD SAMPING
        ====================================================== --}}
        <div class="col-lg-4 col-md-12 col-12">

            <div class="side-info-wrapper">


                {{-- =========================
                     JADWAL HARI INI
                ========================= --}}
                <div class="today-card">

                    <div class="today-card-inner">

                        <div class="today-title">
                            <i class="fas fa-calendar-day"></i>
                            Jadwal Hari Ini
                        </div>

                        <div class="today-day">
                            {{ now()->translatedFormat('l') }}
                        </div>

                        <div class="today-date">
                            {{ now()->translatedFormat('d F Y') }}
                        </div>

                    </div>

                </div>


                {{-- =========================
                     QUOTE
                ========================= --}}
                <div class="quote-card">

                    <div class="quote-inner">

                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>

                        <p class="quote-text">
                            “Jadikan sholat sebagai kebiasaan,
                            bukan sekadar kewajiban.”
                        </p>

                        <div class="quote-line"></div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>


@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =========================
       VARIABEL GLOBAL
    ========================= */

    let userLat = null;
    let userLong = null;
    let userCity = '';


    /* =====================================================
       FUNGSI AMBIL NAMA KOTA
    ===================================================== */

    async function getCityFromCoordinates(lat, lon) {

        try {

            const response = await fetch(
                `https://api.aladhan.com/v1/addressInfo?address=${lat},${lon}`
            );

            const data = await response.json();

            if (
                data.code === 200 &&
                data.data &&
                data.data.city
            ) {

                console.log(
                    'AlAdhan API:',
                    data.data.city
                );

                return {
                    city: data.data.city,
                    country: data.data.country || 'Indonesia'
                };

            }

        } catch (e) {

            console.log(
                'AlAdhan error:',
                e
            );

        }


        try {

            const response = await fetch(
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=id`
            );

            const data = await response.json();

            if (
                data &&
                data.address
            ) {

                const city =
                    data.address.city ||
                    data.address.town ||
                    data.address.village ||
                    data.address.county ||
                    'Lokasi Anda';

                const country =
                    data.address.country ||
                    'Indonesia';

                console.log(
                    'Nominatim API:',
                    city
                );

                return {
                    city,
                    country
                };

            }

        } catch (e) {

            console.log(
                'Nominatim error:',
                e
            );

        }


        try {

            const response = await fetch(
                `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=id`
            );

            const data = await response.json();

            if (
                data &&
                data.city
            ) {

                console.log(
                    'BigDataCloud API:',
                    data.city
                );

                return {
                    city: data.city,
                    country: data.countryName || 'Indonesia'
                };

            }

        } catch (e) {

            console.log(
                'BigDataCloud error:',
                e
            );

        }


        return null;

    }


    /* =====================================================
       GET LOKASI USER
    ===================================================== */

    async function getUserLocation() {

        return new Promise((resolve, reject) => {


            if (!navigator.geolocation) {

                document.getElementById(
                    'locationText'
                ).innerHTML = `

                    <i class="fas fa-exclamation-triangle me-2"
                       style="color:#b08d2a;">
                    </i>

                    Browser tidak support geolocation.
                    Lokasi default: Harau

                `;


                document.getElementById(
                    'locationShort'
                ).innerHTML = 'Harau';


                reject(
                    'Browser tidak support'
                );

                return;

            }


            document.getElementById(
                'locationText'
            ).innerHTML = `

                <i class="fas fa-spinner fa-spin me-2"></i>

                Meminta izin lokasi...

            `;


            navigator.geolocation.getCurrentPosition(

                async (position) => {


                    userLat =
                        position.coords.latitude;

                    userLong =
                        position.coords.longitude;


                    console.log(
                        'Koordinat user:',
                        userLat,
                        userLong
                    );


                    document.getElementById(
                        'locationText'
                    ).innerHTML = `

                        <i class="fas fa-spinner fa-spin me-2"></i>

                        Mendapatkan nama kota...

                    `;


                    const locationInfo =
                        await getCityFromCoordinates(
                            userLat,
                            userLong
                        );


                    if (
                        locationInfo &&
                        locationInfo.city
                    ) {


                        userCity =
                            locationInfo.city;


                        document.getElementById(
                            'locationText'
                        ).innerHTML = `

                            ${userCity},
                            ${locationInfo.country}

                        `;


                        document.getElementById(
                            'locationShort'
                        ).innerHTML =
                            userCity;


                    } else {


                        userCity =
                            `${userLat.toFixed(3)}°, ${userLong.toFixed(3)}°`;


                        document.getElementById(
                            'locationText'
                        ).innerHTML = `

                            <i class="fas fa-map-marker-alt me-2"
                               style="color:#b08d2a;">
                            </i>

                            📍 Koordinat:
                            ${userCity}

                            <br>

                            <small class="text-muted">
                                Nama kota tidak tersedia
                            </small>

                        `;


                        document.getElementById(
                            'locationShort'
                        ).innerHTML =
                            'Koordinat';

                    }


                    resolve({
                        lat: userLat,
                        long: userLong
                    });

                },


                (error) => {


                    console.log(
                        'Geolocation error:',
                        error
                    );


                    let errorMsg = '';


                    switch (error.code) {

                        case error.PERMISSION_DENIED:

                            errorMsg =
                                'Izin lokasi ditolak.';

                            break;


                        case error.POSITION_UNAVAILABLE:

                            errorMsg =
                                'Lokasi tidak tersedia.';

                            break;


                        case error.TIMEOUT:

                            errorMsg =
                                'Waktu habis.';

                            break;


                        default:

                            errorMsg =
                                'Error tidak dikenal.';

                    }


                    userLat =
                        -0.227819;

                    userLong =
                        100.626617;

                    userCity =
                        'Harau';


                    document.getElementById(
                        'locationText'
                    ).innerHTML = `

                        <i class="fas fa-exclamation-triangle me-2"
                           style="color:#b08d2a;">
                        </i>

                        ${errorMsg}

                        Menggunakan lokasi default:

                        📍 ${userCity},
                        Sumatera Barat

                    `;


                    document.getElementById(
                        'locationShort'
                    ).innerHTML =
                        userCity;


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


    /* =====================================================
       FETCH JADWAL SHOLAT
    ===================================================== */

    async function fetchPrayerSchedule(lat, long) {


        const today =
            new Date()
                .toISOString()
                .split('T')[0];


        const apiUrl =
            `https://api.aladhan.com/v1/timings/${today}?latitude=${lat}&longitude=${long}&method=20`;


        try {


            const response =
                await fetch(apiUrl);


            const data =
                await response.json();


            if (
                data.code === 200 &&
                data.data
            ) {

                return data.data.timings;

            } else {

                throw new Error(
                    'Gagal mengambil jadwal sholat'
                );

            }


        } catch (error) {


            console.error(
                'Fetch error:',
                error
            );


            throw error;

        }

    }


    /* =====================================================
       UPDATE UI JADWAL
    ===================================================== */

    function updatePrayerUI(timings) {


        const prayerTimes = {

            subuh: timings.Fajr,

            dzuhur: timings.Dhuhr,

            ashar: timings.Asr,

            maghrib: timings.Maghrib,

            isya: timings.Isha

        };


        /* UPDATE WAKTU */

        document.getElementById(
            'subuh'
        ).innerHTML =
            `<span class="prayer-time">${prayerTimes.subuh}</span>`;


        document.getElementById(
            'dzuhur'
        ).innerHTML =
            `<span class="prayer-time">${prayerTimes.dzuhur}</span>`;


        document.getElementById(
            'ashar'
        ).innerHTML =
            `<span class="prayer-time">${prayerTimes.ashar}</span>`;


        document.getElementById(
            'maghrib'
        ).innerHTML =
            `<span class="prayer-time">${prayerTimes.maghrib}</span>`;


        document.getElementById(
            'isya'
        ).innerHTML =
            `<span class="prayer-time">${prayerTimes.isya}</span>`;


        /* =================================================
           TENTUKAN SHOLAT AKTIF / BERIKUTNYA
        ================================================= */

        const now = new Date();


        const prayers = [

            {
                id: 'subuh',
                name: 'Subuh',
                time: prayerTimes.subuh,
                rowId: 'row-subuh',
                badgeId: 'subuh-badge'
            },

            {
                id: 'dzuhur',
                name: 'Dzuhur',
                time: prayerTimes.dzuhur,
                rowId: 'row-dzuhur',
                badgeId: 'dzuhur-badge'
            },

            {
                id: 'ashar',
                name: 'Ashar',
                time: prayerTimes.ashar,
                rowId: 'row-ashar',
                badgeId: 'ashar-badge'
            },

            {
                id: 'maghrib',
                name: 'Maghrib',
                time: prayerTimes.maghrib,
                rowId: 'row-maghrib',
                badgeId: 'maghrib-badge'
            },

            {
                id: 'isya',
                name: 'Isya',
                time: prayerTimes.isya,
                rowId: 'row-isya',
                badgeId: 'isya-badge'
            }

        ];


        /* CLEAR ACTIVE */

        prayers.forEach(p => {

            const row =
                document.getElementById(
                    p.rowId
                );

            if (row) {

                row.classList.remove(
                    'active-prayer'
                );

            }


            const badge =
                document.getElementById(
                    p.badgeId
                );

            if (badge) {

                badge.innerHTML = '';

            }

        });


        let nextPrayer = null;

        let foundActive = false;


        /* CEK SHOLAT AKTIF */

        for (
            let i = 0;
            i < prayers.length;
            i++
        ) {


            const [h, m] =
                prayers[i].time.split(':');


            const prayerTime =
                new Date();


            prayerTime.setHours(
                parseInt(h),
                parseInt(m),
                0,
                0
            );


            const nextPrayerTime =
                i < prayers.length - 1

                    ?

                    (() => {

                        const [
                            nh,
                            nm
                        ] =
                            prayers[i + 1]
                                .time
                                .split(':');


                        const d =
                            new Date();


                        d.setHours(
                            parseInt(nh),
                            parseInt(nm),
                            0,
                            0
                        );


                        return d;

                    })()

                    :

                    (() => {

                        const d =
                            new Date();


                        d.setDate(
                            d.getDate() + 1
                        );


                        d.setHours(
                            4,
                            0,
                            0,
                            0
                        );


                        return d;

                    })();


            const scanStartTime =
                new Date(
                    prayerTime.getTime() -
                    15 * 60000
                );


            if (
                now >= scanStartTime &&
                now < nextPrayerTime
            ) {


                const row =
                    document.getElementById(
                        prayers[i].rowId
                    );


                if (row) {

                    row.classList.add(
                        'active-prayer'
                    );

                }


                const badge =
                    document.getElementById(
                        prayers[i].badgeId
                    );


                if (badge) {

                    badge.innerHTML = `

                        <span class="next-prayer-indicator">

                            ● Aktif

                        </span>

                    `;

                }


                foundActive = true;


                nextPrayer =
                    prayers[i + 1] ||
                    prayers[0];


                break;

            }

        }


        /* =================================================
           JIKA TIDAK ADA YANG AKTIF
        ================================================= */

        if (!foundActive) {


            for (
                let i = 0;
                i < prayers.length;
                i++
            ) {


                const [h, m] =
                    prayers[i]
                        .time
                        .split(':');


                const prayerTime =
                    new Date();


                prayerTime.setHours(
                    parseInt(h),
                    parseInt(m),
                    0,
                    0
                );


                if (
                    now < prayerTime
                ) {


                    nextPrayer =
                        prayers[i];


                    const badge =
                        document.getElementById(
                            prayers[i].badgeId
                        );


                    if (badge) {

                        badge.innerHTML = `

                            <span class="next-prayer-indicator">

                                ⏳ Berikutnya

                            </span>

                        `;

                    }


                    break;

                }

            }


            if (!nextPrayer) {


                nextPrayer =
                    prayers[0];


                const badge =
                    document.getElementById(
                        prayers[0].badgeId
                    );


                if (badge) {

                    badge.innerHTML = `

                        <span class="next-prayer-indicator">

                            ⏳ Berikutnya

                        </span>

                    `;

                }

            }

        }


        /* UPDATE CARD SHOLAT TERDEKAT */

        let nextText =
            '✨ Selesai (Isya) ✨';


        if (nextPrayer) {

            nextText =
                `${nextPrayer.name} • ${nextPrayer.time}`;

        }


        document.getElementById(
            'nextPrayer'
        ).innerHTML = `

            <i class="fas fa-bell me-2"></i>

            ${nextText}

        `;

    }


    /* =====================================================
       FETCH DATA USER DARI BACKEND
    ===================================================== */

    async function fetchUserData() {


        try {


            const response =
                await fetch(
                    '/api/user/dashboard-data',
                    {
                        method: 'GET',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                )?.content || ''

                        }

                    }
                );


            const data =
                await response.json();


            if (data.success) {


                const status =
                    data.status_absensi ||
                    'Belum Absen';


                const isHadir =
                    status === 'Sudah Absen';


                document.getElementById(
                    'statusAbsensi'
                ).innerHTML = `

                    <i class="fas ${
                        isHadir
                            ? 'fa-check-circle'
                            : 'fa-clock'
                    } me-2"></i>

                    ${status}

                `;


                document.getElementById(
                    'totalHadir'
                ).innerHTML =
                    data.total_kehadiran || 0;


            } else {


                console.error(
                    'Gagal ambil data user:',
                    data.message
                );


                document.getElementById(
                    'statusAbsensi'
                ).innerHTML = `

                    <i class="fas fa-question-circle me-2"></i>

                    Belum Absen

                `;


                document.getElementById(
                    'totalHadir'
                ).innerHTML = '0';

            }


        } catch (error) {


            console.error(
                'Error fetch user data:',
                error
            );


            document.getElementById(
                'statusAbsensi'
            ).innerHTML = `

                <i class="fas fa-exclamation-triangle me-2"></i>

                Error

            `;


            document.getElementById(
                'totalHadir'
            ).innerHTML = '0';

        }

    }


    /* =====================================================
       REFRESH LOKASI
    ===================================================== */

    window.refreshLocation = function() {


        document.getElementById(
            'locationText'
        ).innerHTML = `

            <i class="fas fa-spinner fa-spin me-2"></i>

            Mendapatkan lokasi Anda...

        `;


        document.getElementById(
            'nextPrayer'
        ).innerHTML = `

            <i class="fas fa-spinner fa-spin me-2"></i>

            Loading...

        `;


        document.getElementById(
            'subuh'
        ).innerHTML = '-';


        document.getElementById(
            'dzuhur'
        ).innerHTML = '-';


        document.getElementById(
            'ashar'
        ).innerHTML = '-';


        document.getElementById(
            'maghrib'
        ).innerHTML = '-';


        document.getElementById(
            'isya'
        ).innerHTML = '-';


        [
            'subuh',
            'dzuhur',
            'ashar',
            'maghrib',
            'isya'
        ].forEach(id => {


            const badge =
                document.getElementById(
                    id + '-badge'
                );


            if (badge) {

                badge.innerHTML = '';

            }


            const row =
                document.getElementById(
                    'row-' + id
                );


            if (row) {

                row.classList.remove(
                    'active-prayer'
                );

            }

        });


        initDashboard();

    };


    /* =====================================================
       MAIN FUNCTION
    ===================================================== */

    async function initDashboard() {


        try {


            const location =
                await getUserLocation();


            const timings =
                await fetchPrayerSchedule(
                    location.lat,
                    location.long
                );


            updatePrayerUI(
                timings
            );


        } catch (error) {


            console.error(
                'Error initDashboard:',
                error
            );


            try {


                const timings =
                    await fetchPrayerSchedule(
                        -0.227819,
                        100.626617
                    );


                updatePrayerUI(
                    timings
                );


            } catch (fallbackError) {


                console.error(
                    'Fallback error:',
                    fallbackError
                );


                document.getElementById(
                    'nextPrayer'
                ).innerHTML = `

                    <i class="fas fa-exclamation-triangle me-2"></i>

                    Error

                `;

            }

        }

    }


    /* =====================================================
       START
    ===================================================== */

    initDashboard();


    fetchUserData();


    /* UPDATE DATA ABSENSI SETIAP 30 DETIK */

    setInterval(
        fetchUserData,
        30000
    );


    /* UPDATE JADWAL SETIAP 1 JAM */

    setInterval(
        () => {


            if (
                userLat &&
                userLong
            ) {


                fetchPrayerSchedule(
                    userLat,
                    userLong
                )

                .then(
                    timings =>
                        updatePrayerUI(
                            timings
                        )
                )

                .catch(
                    err =>
                        console.error(
                            'Error refresh jadwal:',
                            err
                        )
                );

            }

        },
        3600000
    );


});

</script>

@endpush