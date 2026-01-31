@extends('layouts.main')
@section('title', 'Data Absensi')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Absensi Siswa</h3>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                @php $no = 1; @endphp
                <tbody>
                    @foreach ($absensis as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->siswa->nama ?? '-' }}</td>
                            <td>{{ $item->siswa->kelas ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->jam_masuk ?? '-' }}</td>
                            <td>
                                @if ($item->status == 'hadir')
                                    <span class="badge badge-success">Hadir</span>
                                @elseif ($item->status == 'terlambat')
                                    <span class="badge badge-warning">Terlambat</span>
                                @elseif ($item->status == 'izin')
                                    <span class="badge badge-info">Izin</span>
                                @elseif ($item->status == 'sakit')
                                    <span class="badge badge-primary">Sakit</span>
                                @else
                                    <span class="badge badge-danger">Tidak Hadir</span>
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
                        <th>Jam Masuk</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
