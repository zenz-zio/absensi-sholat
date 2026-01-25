@extends('layouts.main')
@section('title', 'Resi')
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.resi.create') }}" class="btn btn-primary">
                <i class="nav-icon fas fa-plus"></i> Buat Resi
            </a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No Resi</th>
                        <th>Pengirim</th>
                        <th>Penerima</th>
                        <th>Jenis Pengiriman</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @php
                    $no = 1;
                @endphp
                <tbody>
                    @foreach ($resi as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->no_resi }}</td>
                            <td>
                                Nama : {{ $item->nama_pengirim }} <br>
                                Kontak : {{ $item->kontak_pengirim }} <br>
                                Alamat : {{ $item->alamat_pengirim }}
                            </td>
                            <td>
                                Nama : {{ $item->nama_penerima }} <br>
                                Kontak : {{ $item->kontak_penerima }} <br>
                                Alamat : {{ $item->alamat_penerima }}
                            </td>
                            <td>{{ $item->jenis_pengiriman }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>
                                <a href="{{ route('admin.resi.qr', $item->id) }}" class="btn btn-warning"
                                    onclick="openQrPopup(this.href); return false;">
                                    <i class="fas fa-qrcode mr-1"></i> Show QR
                                </a>
                                <a href="{{ route('admin.resi.edit', $item->id) }}" class="btn btn-primary mt-2 mb-2"><i
                                        class="fas fa-edit mr-1"></i>Edit</a>
                                <br>
                                <form action="{{ route('admin.resi.delete', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin mau hapus resi ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger"><i
                                            class="fas fa-trash mr-1"></i>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>No Resi</th>
                        <th>Pengirim</th>
                        <th>Penerima</th>
                        <th>Jenis Pengiriman</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>

        </div>
        <!-- /.card-body -->
    </div>
    <script>
        function openQrPopup(url) {
            const width = 375; // lebar HP
            const height = 667; // tinggi HP

            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;

            window.open(
                url,
                'QRResiWindow',
                `width=${width},height=${height},top=${top},left=${left},resizable=no,scrollbars=yes`
            );
        }
    </script>

@endsection
