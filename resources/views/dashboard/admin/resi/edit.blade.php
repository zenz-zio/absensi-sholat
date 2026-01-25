@extends('layouts.main')
@section('title', 'Edit Resi')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Resi</h3>
        </div>
        <!-- form start -->
        <form id="quickForm" method="POST" action="{{ route('admin.resi.update', $resi->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- Pengirim --}}
                <h5>Data Pengirim</h5>

                <div class="form-group">
                    <label>Nama Pengirim</label>
                    <input type="text" name="nama_pengirim" class="form-control" placeholder="Nama Pengirim"
                        value="{{ $resi->nama_pengirim }}" required>
                </div>

                <div class="form-group">
                    <label>Kontak Pengirim</label>
                    <input type="text" name="kontak_pengirim" class="form-control" placeholder="No HP / WhatsApp"
                        required pattern="[0-9]+" value="{{ $resi->kontak_pengirim }}">
                </div>

                <div class="form-group">
                    <label>Alamat Pengirim</label>
                    <textarea name="alamat_pengirim" class="form-control" rows="2" placeholder="Alamat Lengkap"
                         required>{{ $resi->alamat_pengirim }}</textarea>
                </div>

                <hr>

                {{-- Penerima --}}
                <h5>Data Penerima</h5>

                <div class="form-group">
                    <label>Nama Penerima</label>
                    <input type="text" name="nama_penerima" class="form-control" placeholder="Nama Penerima"
                        value="{{ $resi->nama_penerima }}" required>
                </div>

                <div class="form-group">
                    <label>Kontak Penerima</label>
                    <input type="text" name="kontak_penerima" class="form-control" placeholder="No HP / WhatsApp"
                        required pattern="[0-9]+" value="{{ $resi->kontak_penerima }}">
                </div>

                <div class="form-group">
                    <label>Alamat Penerima</label>
                    <textarea name="alamat_penerima" class="form-control" rows="2" placeholder="Alamat Lengkap"
                         required>{{ $resi->alamat_penerima }}</textarea>
                </div>

                <hr>

                {{-- Jenis Pengiriman --}}
                <div class="form-group">
                    <label>Jenis Pengiriman</label>
                    <select name="jenis_pengiriman" class="form-control" required>
                        <option value="">-- Pilih Jenis Pengiriman --</option>
                        <option value="Regular" {{ $resi->jenis_pengiriman == 'Regular' ? 'selected' : '' }}>
                            Regular (2–3 Hari)
                        </option>
                        <option value="Same Day" {{ $resi->jenis_pengiriman == 'Same Day' ? 'selected' : '' }}>
                            Same Day
                        </option>
                        <option value="Express" {{ $resi->jenis_pengiriman == 'Express' ? 'selected' : '' }}>
                            Express (1 Hari)
                        </option>
                        <option value="Cargo" {{ $resi->jenis_pengiriman == 'Cargo' ? 'selected' : '' }}>
                            Cargo
                        </option>
                        <option value="Instant" {{ $resi->jenis_pengiriman == 'Instant' ? 'selected' : '' }}>
                            Instant Courier
                        </option>
                    </select>
                </div>


                {{-- Harga --}}
                <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga" id="harga" class="form-control"
                        value="{{ $resi->harga ? 'Rp ' . number_format($resi->harga, 0, ',', '.') : '' }}">
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    Update Resi
                </button>
                <a href="#" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>

    <script>
        const hargaInput = document.getElementById('harga');

        hargaInput.addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value, 'Rp ');
        });

        function formatRupiah(angka, prefix) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }
    </script>

@endsection
