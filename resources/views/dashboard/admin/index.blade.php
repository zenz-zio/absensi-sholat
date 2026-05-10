@extends('layouts.main')

@section('title', 'Halaman Utama')

@section('content')

{{-- ===== 4 CARD RINGKASAN ===== --}}
<div class="row">

    <!-- Waktu Sholat Terdekat -->
    <div class="col-lg-3 col-6">
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

    <!-- Belum Absensi -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3 id="belumAbsensi">0</h3>
                <p>Belum Absensi</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-times"></i>
            </div>
        </div>
    </div>

    <!-- Sudah Absensi -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3 id="sudahAbsensi">0</h3>
                <p>Sudah Absensi</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>

    <!-- Total Siswa -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 id="totalSiswa">0</h3>
                <p>Total Siswa</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
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
                        <tr>
                            <th>Subuh</th>
                            <td id="subuh">-</td>
                        </tr>
                        <tr>
                            <th>Dzuhur</th>
                            <td id="dzuhur">-</td>
                        </tr>
                        <tr>
                            <th>Ashar</th>
                            <td id="ashar">-</td>
                        </tr>
                        <tr>
                            <th>Maghrib</th>
                            <td id="maghrib">-</td>
                        </tr>
                        <tr>
                            <th>Isya</th>
                            <td id="isya">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer text-muted text-center">
                Lokasi: Harau, Sumatera Barat
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const today = new Date().toISOString().split('T')[0];

    // ============ FETCH JADWAL SHOLAT ============
    fetch(`https://api.aladhan.com/v1/timings/${today}?latitude=-0.227819&longitude=100.626617&method=20`)
        .then(res => res.json())
        .then(data => {
            const t = data.data.timings;
            const now = new Date();

            // isi tabel jadwal
            document.getElementById('subuh').innerText = t.Fajr;
            document.getElementById('dzuhur').innerText = t.Dhuhr;
            document.getElementById('ashar').innerText = t.Asr;
            document.getElementById('maghrib').innerText = t.Maghrib;
            document.getElementById('isya').innerText = t.Isha;

            // cari sholat terdekat
            const prayers = [
                { name: 'Subuh', time: t.Fajr },
                { name: 'Dzuhur', time: t.Dhuhr },
                { name: 'Ashar', time: t.Asr },
                { name: 'Maghrib', time: t.Maghrib },
                { name: 'Isya', time: t.Isha }
            ];

            let next = 'Selesai Isya';
            for (let p of prayers) {
                const [h, m] = p.time.split(':');
                const pt = new Date();
                pt.setHours(h, m, 0);

                if (pt > now) {
                    next = `${p.name} • ${p.time}`;
                    break;
                }
            }

            document.getElementById('nextPrayer').innerText = next;
        })
        .catch(err => {
            console.error('Gagal fetch jadwal sholat:', err);
            document.getElementById('nextPrayer').innerText = 'Error';
        });

    // ============ FETCH DATA ABSENSI REAL ============
    fetchAbsensiData();

    // Refresh data absensi setiap 30 detik
    setInterval(fetchAbsensiData, 30000);
    
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
                document.getElementById('totalSiswa').innerText = data.data.total_siswa || 0;
                document.getElementById('sudahAbsensi').innerText = data.data.sudah_absensi || 0;
                document.getElementById('belumAbsensi').innerText = data.data.belum_absensi || 0;
            } else {
                console.error('Gagal ambil data absensi:', data.message);
            }
        })
        .catch(err => {
            console.error('Error fetch absensi:', err);
            // Fallback ke 0 jika error
            document.getElementById('totalSiswa').innerText = '0';
            document.getElementById('sudahAbsensi').innerText = '0';
            document.getElementById('belumAbsensi').innerText = '0';
        });
    }
});
</script>
@endpush