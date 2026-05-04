@extends('layouts.app')
@section('title', 'Data Absensi')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Absensi Sholat Siswa</h3>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Jam Sholat</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($absensis as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            {{-- Nama dari users lewat accessor --}}
                            <td>{{ $item->siswa->nama ?? '-' }}</td>

                            <td>{{ $item->siswa->kelas ?? '-' }}</td>

                            {{-- karena sudah di-cast, gak perlu Carbon parse --}}
                            <td>{{ $item->tanggal ? $item->tanggal->format('d-m-Y') : '-' }}</td>

                            <td>{{ $item->jam_masuk ?? '-' }}</td>

                            <td>
                                @if ($item->status == 'Sholat')
                                    <span class="badge bg-success">Sudah Sholat</span>
                                @else
                                    <span class="badge bg-danger">Tidak Sholat</span>
                                @endif
                            </td>

                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Jam Sholat</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
