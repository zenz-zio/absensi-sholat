@extends('layouts.main')
@section('title', 'Data Siswa')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Data Siswa</h3>
                <div>
                    <!-- Tombol Aksi Massal yang Sederhana -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success" onclick="updateAllStatus('sudah')">
                            <i class="fas fa-check-circle"></i> Sudah Sholat Semua
                        </button>
                        <button type="button" class="btn btn-danger" onclick="updateAllStatus('belum')">
                            <i class="fas fa-times-circle"></i> Belum Sholat Semua
                        </button>
                    </div>

                    <!-- Tombol Tambah Siswa -->
                    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary ml-2">
                        <i class="nav-icon fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Status Sholat Hari Ini</th>
                    </tr>
                </thead>

                @php
                    $no = 1;
                @endphp

                <tbody>
                    @foreach ($siswas as $item)
                        @php
                            // Untuk contoh, kita buat random status
                            $hasSholatToday = $item->status_sholat ?? false;
                        @endphp

                        <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nisn }}</td>
        <td>{{ $item->user->name ?? 'Tidak ada user' }}</td>
        <td>{{ $item->kelas }}</td>
        <td>{{ $item->jurusan }}</td>
        <td>
            @if ($item->status_sholat)
                <span class="badge bg-success">Sudah Sholat</span>
            @else
                <span class="badge bg-danger">Belum Sholat</span>
            @endif
        </td>
    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Status Sholat Hari Ini</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Card Footer dengan Statistik Sederhana -->
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-md-12">
                    <h5>Total Siswa: <span class="badge badge-info">{{ count($siswas) }}</span></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Form tersembunyi untuk update massal -->
    <form id="massUpdateForm" method="POST" action="{{ route('admin.siswa.update-massal') }}" style="display: none;">
        @csrf
        <input type="hidden" name="status" id="massStatus" value="">
    </form>
@endsection
