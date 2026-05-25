@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')

{{-- ===== 3 CARD USER ===== --}}
<div class="row">

    <!-- Sholat Terdekat -->
    <div class="col-lg-4 col-12">
        <div class="small-box bg-info">
            <div class="inner">
                <h4 id="nextPrayer">Loading...</h4>
                <p>Sholat Terdekat</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- Status Absensi -->
    <div class="col-lg-4 col-12">
        <div class="small-box bg-warning">
            <div class="inner">
                <h4 id="statusAbsensi">Belum Absen</h4>
                <p>Status Absensi Hari Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-clock"></i>
            </div>
        </div>
    </div>

    <!-- Total Kehadiran -->
    <div class="col-lg-4 col-12">
        <div class="small-box bg-success">
            <div class="inner">
                <h3 id="totalHadir">0</h3>
                <p>Total Kehadiran</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>

</div>

{{-- ===== JADWAL SHOLAT ===== --}}
<div class="row">
    <div class="col-lg-6 col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-mosque"></i> Jadwal Sholat Hari Ini
                </h3>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <tbody>
                        <tr><th>Subuh</th><td id="subuh">-</td></tr>
                        <tr><th>Dzuhur</th><td id="dzuhur">-</td></tr>
                        <tr><th>Ashar</th><td id="ashar">-</td></tr>
                        <tr><th>Maghrib</th><td id="maghrib">-</td></tr>
                        <tr><th>Isya</th><td id="isya">-</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer text-muted text-center" id="locationInfo">
                <i class="fas fa-spinner fa-spin"></i> Mendapatkan lokasi Anda...
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Variabel global
    let userLat = null;
    let userLong = null;
    let userCity = '';

    // ============ FUNGSI AMBIL NAMA KOTA (MULTI API) ============
    async function getCityFromCoordinates(lat, lon) {
        // Pilihan 1: AlAdhan API
        try {
            const response = await fetch(`https://api.aladhan.com/v1/addressInfo?address=${lat},${lon}`);
            const data = await response.json();
            
            if (data.code === 200 && data.data && data.data.city) {
                console.log('AlAdhan API:', data.data.city);
                return { city: data.data.city, country: data.data.country || 'Indonesia' };
            }
        } catch (e) {
            console.log('AlAdhan error:', e);
        }

        // Pilihan 2: Nominatim (OpenStreetMap)
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=id`);
            const data = await response.json();
            
            if (data && data.address) {
                const city = data.address.city || 
                            data.address.town || 
                            data.address.village || 
                            data.address.county ||
                            'Lokasi Anda';
                const country = data.address.country || 'Indonesia';
                console.log('Nominatim API:', city);
                return { city, country };
            }
        } catch (e) {
            console.log('Nominatim error:', e);
        }

        // Pilihan 3: BigDataCloud
        try {
            const response = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=id`);
            const data = await response.json();
            
            if (data && data.city) {
                console.log('BigDataCloud API:', data.city);
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
                    <i class="fas fa-exclamation-triangle"></i> 
                    Browser tidak support geolocation. Lokasi default: Harau
                `;
                reject('Browser tidak support');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    userLat = position.coords.latitude;
                    userLong = position.coords.longitude;
                    
                    console.log('Koordinat user:', userLat, userLong);
                    
                    // Tampilkan loading ambil nama kota
                    document.getElementById('locationInfo').innerHTML = `
                        <i class="fas fa-spinner fa-spin"></i> Mendapatkan nama kota...
                    `;
                    
                    const locationInfo = await getCityFromCoordinates(userLat, userLong);
                    
                    if (locationInfo && locationInfo.city) {
                        userCity = locationInfo.city;
                        document.getElementById('locationInfo').innerHTML = `
                            <i class="fas fa-map-marker-alt"></i> 
                            📍 ${userCity}, ${locationInfo.country}
                            <button class="btn btn-sm btn-link" onclick="refreshLocation()">🔄 Refresh</button>
                        `;
                    } else {
                        userCity = `${userLat.toFixed(3)}°, ${userLong.toFixed(3)}°`;
                        document.getElementById('locationInfo').innerHTML = `
                            <i class="fas fa-map-marker-alt"></i> 
                            📍 Koordinat: ${userCity}
                            <button class="btn btn-sm btn-link" onclick="refreshLocation()">🔄 Refresh</button>
                            <br><small class="text-muted">Nama kota tidak tersedia</small>
                        `;
                    }
                    
                    resolve({ lat: userLat, long: userLong });
                },
                (error) => {
                    console.log('Geolocation error:', error);
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
                    
                    // Fallback ke Harau
                    userLat = -0.227819;
                    userLong = 100.626617;
                    userCity = 'Harau';
                    
                    document.getElementById('locationInfo').innerHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        ${errorMsg} Menggunakan lokasi default: 📍 ${userCity}, Sumatera Barat
                        <button class="btn btn-sm btn-link" onclick="refreshLocation()">🔄 Coba lagi</button>
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
    async function fetchPrayerSchedule(lat, long) {
        const today = new Date().toISOString().split('T')[0];
        const apiUrl = `https://api.aladhan.com/v1/timings/${today}?latitude=${lat}&longitude=${long}&method=20`;
        
        try {
            const response = await fetch(apiUrl);
            const data = await response.json();
            
            if (data.code === 200 && data.data) {
                return data.data.timings;
            } else {
                throw new Error('Gagal mengambil jadwal sholat');
            }
        } catch (error) {
            console.error('Fetch error:', error);
            throw error;
        }
    }

    // ============ UPDATE UI JADWAL ============
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

        document.getElementById('nextPrayer').innerText = next;
    }

    // ============ FETCH DATA USER DARI BACKEND ============
    async function fetchUserData() {
        try {
            const response = await fetch('/api/user/dashboard-data', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            });
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('statusAbsensi').innerText = data.status_absensi || 'Belum Absen';
                document.getElementById('totalHadir').innerText = data.total_kehadiran || 0;
            } else {
                console.error('Gagal ambil data user:', data.message);
                // Data dummy sebagai fallback
                document.getElementById('statusAbsensi').innerText = 'Belum Absen';
                document.getElementById('totalHadir').innerText = '0';
            }
        } catch (error) {
            console.error('Error fetch user data:', error);
            // Data dummy sebagai fallback
            document.getElementById('statusAbsensi').innerText = 'Belum Absen';
            document.getElementById('totalHadir').innerText = '0';
        }
    }

    // ============ REFRESH LOKASI ============
    window.refreshLocation = function() {
        document.getElementById('locationInfo').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendapatkan lokasi Anda...';
        document.getElementById('nextPrayer').innerText = 'Loading...';
        document.getElementById('subuh').innerText = '-';
        document.getElementById('dzuhur').innerText = '-';
        document.getElementById('ashar').innerText = '-';
        document.getElementById('maghrib').innerText = '-';
        document.getElementById('isya').innerText = '-';
        
        initDashboard();
    };

    // ============ MAIN FUNCTION ============
    async function initDashboard() {
        try {
            // 1. Dapatkan lokasi user
            const location = await getUserLocation();
            
            // 2. Fetch jadwal sholat berdasarkan lokasi user
            const timings = await fetchPrayerSchedule(location.lat, location.long);
            
            // 3. Update UI jadwal
            updatePrayerUI(timings);
            
        } catch (error) {
            console.error('Error initDashboard:', error);
            // Fallback ke lokasi default Harau
            try {
                const timings = await fetchPrayerSchedule(-0.227819, 100.626617);
                updatePrayerUI(timings);
            } catch (fallbackError) {
                console.error('Fallback error:', fallbackError);
                document.getElementById('nextPrayer').innerText = 'Error';
            }
        }
    }

    // ============ START ============
    initDashboard();
    fetchUserData();
    
    // Refresh data user setiap 30 detik
    setInterval(fetchUserData, 30000);
    
    // Refresh jadwal setiap 1 jam
    setInterval(() => {
        if (userLat && userLong) {
            fetchPrayerSchedule(userLat, userLong)
                .then(timings => updatePrayerUI(timings))
                .catch(err => console.error('Error refresh jadwal:', err));
        }
    }, 3600000);
});
</script>
@endpush