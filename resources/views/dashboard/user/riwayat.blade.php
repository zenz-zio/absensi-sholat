@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i> Riwayat Absensi Sholat
                </h3>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Sholat</th>
                            <th>Waktu Absen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- Dummy data (nanti ganti dari DB) --}}
                        <tr>
                            <td>1</td>
                            <td>31-01-2026</td>
                            <td>Subuh</td>
                            <td>05:10</td>
                            <td>
                                <span class="badge badge-success">Tepat Waktu</span>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>31-01-2026</td>
                            <td>Dzuhur</td>
                            <td>12:45</td>
                            <td>
                                <span class="badge badge-warning">Telat</span>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>30-01-2026</td>
                            <td>Maghrib</td>
                            <td>18:32</td>
                            <td>
                                <span class="badge badge-success">Tepat Waktu</span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="card-footer text-muted">
                Menampilkan riwayat absensi sholat Anda
            </div>
        </div>
    </div>
</div>

@endsection
