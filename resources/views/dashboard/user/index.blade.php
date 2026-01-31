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

{{-- ===== JADWAL SHOLAT (TETAP ADA) ===== --}}
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

    fetch(`https://api.aladhan.com/v1/timings/${today}?latitude=-0.227819&longitude=100.626617&method=20`)
        .then(res => res.json())
        .then(data => {
            const t = data.data.timings;
            const now = new Date();

            // isi jadwal
            subuh.innerText   = t.Fajr;
            dzuhur.innerText  = t.Dhuhr;
            ashar.innerText   = t.Asr;
            maghrib.innerText = t.Maghrib;
            isya.innerText    = t.Isha;

            // sholat terdekat
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

            nextPrayer.innerText = next;
        });

    // 🔸 Dummy USER (nanti dari database)
    statusAbsensi.innerText = 'Belum Absen';
    totalHadir.innerText   = 12;
});
</script>
@endpush
