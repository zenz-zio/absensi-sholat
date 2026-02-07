@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-qrcode mr-2"></i>QR Absensi Generator
                    </h4>
                    <button onclick="downloadQR()" class="btn btn-primary">
                        <i class="fas fa-download mr-1"></i>Download QR
                    </button>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h5 class="mb-0 text-center">
                            <i class="fas fa-shield-alt mr-2"></i>Kode Absensi Sekolah
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="qr-container mx-auto mb-3 p-3 bg-light rounded-lg" style="max-width: 280px;">
                                <div class="qr-inner p-2 bg-white rounded">
                                    {!! QrCode::size(250)->margin(2)->color(21, 87, 36)->generate($qrData) !!}
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="badge badge-pill badge-light px-3 py-2 shadow-sm">
                                    <i class="far fa-clock mr-2"></i>
                                    <span id="countdown" class="font-weight-bold">--:--:--</span>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card border-danger shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-danger">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>Kode Darurat
                                        </h6>
                                        <div class="display-4 font-weight-bold text-danger mb-2">
                                            {{ $kode }}
                                        </div>
                                        <small class="text-muted">Gunakan jika QR tidak terbaca</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="card border-warning shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-warning">
                                            <i class="fas fa-hourglass-end mr-2"></i>Berlaku Sampai
                                        </h6>
                                        <div class="font-weight-bold text-warning mb-2" style="font-size: 1.1rem;">
                                            {{ $expired }}
                                        </div>
                                        <small class="text-muted">QR akan expired setelah waktu habis</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <small>Waktu Tersisa</small>
                                <small><span id="percentage">100%</span></small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div id="timeProgress" class="progress-bar bg-gradient-primary" role="progressbar"
                                    style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 shadow-sm">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle mr-2"></i>Petunjuk Penggunaan
                            </h6>
                            <ul class="mb-0 pl-3">
                                <li>QR Code ini hanya valid selama 1 jam</li>
                                <li>Scan QR code untuk absensi masuk/pulang</li>
                                <li>Kode darurat digunakan jika QR tidak terbaca</li>
                                <li>Setelah expired, QR tidak dapat digunakan lagi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const expiredAt = {{ $expiredTimestamp }};

        function updateCountdown() {
            const now = Date.now();
            const distance = expiredAt - now;

            if (distance < 0) {
                document.getElementById("countdown").innerHTML = "EXPIRED";
                document.getElementById("timeProgress").style.width = "0%";
                document.getElementById("percentage").innerHTML = "0%";
                document.getElementById("timeProgress").className = "progress-bar bg-secondary";
                return;
            }

            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const timeString =
                hours.toString().padStart(2, '0') + ":" +
                minutes.toString().padStart(2, '0') + ":" +
                seconds.toString().padStart(2, '0');

            document.getElementById("countdown").innerHTML = timeString;

            const totalTime = 60 * 60 * 1000;
            const percentage = Math.max(0, Math.min(100, (distance / totalTime) * 100));
            document.getElementById("timeProgress").style.width = percentage + "%";
            document.getElementById("percentage").innerHTML = Math.round(percentage) + "%";

            if (percentage < 20) {
                document.getElementById("timeProgress").className = "progress-bar bg-gradient-danger";
            } else if (percentage < 50) {
                document.getElementById("timeProgress").className = "progress-bar bg-gradient-warning";
            } else {
                document.getElementById("timeProgress").className = "progress-bar bg-gradient-primary";
            }
        }

        function downloadQR() {
            const qrElement = document.querySelector('.qr-inner svg');
            const svgData = new XMLSerializer().serializeToString(qrElement);
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();

            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);

                const pngFile = canvas.toDataURL('image/png');
                const downloadLink = document.createElement('a');
                downloadLink.download = `QR-Absensi-{{ $kode }}.png`;
                downloadLink.href = pngFile;
                downloadLink.click();
            };

            img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>

    <style>
        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }

        .qr-container {
            border: 2px dashed #dee2e6;
            transition: all 0.3s;
        }

        .qr-container:hover {
            transform: scale(1.02);
            border-color: #4e73df;
        }

        .progress-bar {
            border-radius: 4px;
            transition: width 1s linear, background-color 1s linear;
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }

        .bg-gradient-warning {
            background: linear-gradient(45deg, #f6c23e, #dda20a);
        }

        .bg-gradient-danger {
            background: linear-gradient(45deg, #e74a3b, #be2617);
        }
    </style>
@endsection
