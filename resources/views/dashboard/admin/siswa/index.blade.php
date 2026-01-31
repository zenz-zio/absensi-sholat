@extends('layouts.main')
@section('title', 'Data Siswa')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
                <i class="nav-icon fas fa-plus"></i> Tambah Siswa
            </a>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NISN</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                @php $no = 1; @endphp
                <tbody>
                    @foreach ($siswas as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td>{{ $item->jurusan }}</td>
                            <td>
                                <a href="{{ route('admin.siswa.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin mau hapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>NISN</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
