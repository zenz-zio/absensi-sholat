@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 text-primary font-weight-bold">
                        <i class="fas fa-qrcode mr-2"></i>QR Absensi
                    </h4>

                    @if ($qrMasihValid)
                        <div>
                            <button onclick="downloadQR()" class="btn btn-sm btn-outline-primary mr-1">
                                <i class="fas fa-download"></i>
                            </button>

                            <form action="{{ route('user.force-generate') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-warning"
                                    onclick="return confirm('QR lama akan tidak berlaku. Lanjutkan?')">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                {{-- ALERT --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle mr-1"></i>{{ session('success') }}
                    </div>
                @endif

                {{-- CARD --}}
                <div class="card shadow border-0">
                    <div class="card-body text-center p-5">

                        {{-- ======================
                        MODE: BELUM ADA QR
                    ======================= --}}
                        @if (!$qrMasihValid)
                            <i class="fas fa-qrcode fa-5x text-muted mb-4"></i>

                            <h5 class="mb-2">QR Absensi Belum Dibuat</h5>
                            <p class="text-muted mb-4">
                                Silakan buat QR untuk melakukan absensi hari ini.
                            </p>

                            <form action="{{ route('user.force-generate') }}" method="POST">
                                @csrf
                                <button class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-plus mr-2"></i>Buat QR Sekarang
                                </button>
                            </form>

                            {{-- ======================
                        MODE: QR AKTIF
                    ======================= --}}
                        @else
                            <div class="qr-box mb-4">
                                {!! QrCode::size(220)->margin(2)->generate($qrData) !!}
                            </div>

                            <span class="badge badge-success px-3 py-2 mb-3">
                                <i class="fas fa-check-circle mr-1"></i>QR AKTIF
                            </span>

                            <h3 class="text-danger mt-3 mb-1">{{ $kode }}</h3>
                            <small class="text-muted d-block mb-3">Kode Darurat</small>

                            <p class="mb-1 font-weight-bold">Berlaku Sampai</p>
                            <p class="text-warning mb-3">{{ $expired }}</p>

                            <div class="progress" style="height: 8px;">
                                <div id="timeProgress" class="progress-bar bg-primary"></div>
                            </div>

                            <small id="countdown" class="text-muted d-block mt-2">
                                --:--:--
                            </small>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ======================
    JAVASCRIPT
====================== --}}
    <script>
        const expiredAt = {{ $expiredTimestamp ?? 'null' }};

        function updateCountdown() {
            if (!expiredAt) return;

            const now = Date.now();
            const distance = expiredAt - now;

            if (distance <= 0) {
                location.reload();
                return;
            }

            const h = Math.floor(distance / (1000 * 60 * 60));
            const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('countdown').innerHTML =
                String(h).padStart(2, '0') + ':' +
                String(m).padStart(2, '0') + ':' +
                String(s).padStart(2, '0');

            const percent = Math.max(0, Math.min(100, (distance / (60 * 60 * 1000)) * 100));
            document.getElementById('timeProgress').style.width = percent + '%';
        }

        if (expiredAt) {
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        function downloadQR() {
            const svg = document.querySelector('.qr-box svg');
            if (!svg) {
                alert('QR belum tersedia');
                return;
            }

            const serializer = new XMLSerializer();
            const source = serializer.serializeToString(svg);

            const img = new Image();
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);

                const a = document.createElement('a');
                a.download = 'QR-Absensi.png';
                a.href = canvas.toDataURL('image/png');
                a.click();
            };

            img.src = 'data:image/svg+xml;base64,' + btoa(source);
        }
    </script>

    {{-- ======================
    STYLE
====================== --}}
    <style>
        .card {
            border-radius: 18px;
        }

        .qr-box {
            display: inline-block;
            padding: 16px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
        }

        .btn-lg {
            border-radius: 50px;
        }

        .progress {
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            transition: width .8s linear;
        }
    </style>
@endsection
