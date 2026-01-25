@extends('layouts.main')
@section('title', 'Show QR')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <strong>QR Resi Generate</strong>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title mb-3">
                            Nomor Resi:
                            <span class="badge bg-secondary">
                                {{ $resi->no_resi }}
                            </span>
                        </h5>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($resi->no_resi) }}"
                            alt="QR Resi" class="img-fluid mb-3">

                        <p class="text-muted mb-0">
                            Scan QR untuk melihat detail resi
                        </p>
                    </div>
                    <div class="card-footer text-center">
                        <button type="button" onclick="window.close()" class="btn btn-outline-primary btn-sm">
                            Kembali
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
