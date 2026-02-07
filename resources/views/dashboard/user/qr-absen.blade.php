@extends('layouts.app')

@section('title','QR Absensi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">

        <div class="card text-center">
            <div class="card-body">

                <h5 class="mb-3">QR Absensi</h5>

                {!! QrCode::size(250)->generate($data) !!}

                <p class="mt-3 text-muted">
                    {{ now()->format('d M Y H:i') }}
                </p>

            </div>
        </div>

    </div>
</div>
@endsection
