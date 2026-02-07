@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">
        <div class="card-body text-center">

            <h3 class="mb-4">QR Absensi Generator</h3>

            <div class="mb-2">
                <strong>Kode Darurat:</strong>
                <span class="badge bg-danger">{{ $kode }}</span>
            </div>

            <div class="mb-2">
                <strong>Berlaku Sampai:</strong>
                <span class="badge bg-warning text-dark">{{ $expired }}</span>
            </div>

            <div class="mb-3">
                Tunggu: <span id="countdown">60</span> detik
            </div>

            <div class="mb-3">
                {!! QrCode::size(250)->generate($qrData) !!}
            </div>

            <a href="#" class="btn btn-primary">
                Download QR Code
            </a>

        </div>
    </div>

</div>

<script>
let time = 60;

setInterval(() => {
    if(time > 0){
        time--;
        document.getElementById("countdown").innerText = time;
    }
}, 1000);
</script>

@endsection
