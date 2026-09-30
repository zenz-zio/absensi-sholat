@extends('layouts.app')

@section('title', 'Profil User')

@section('content')
<style>
    :root {
        --bg: #f7f6f2;
        --line: #e8e5dc;
        --ink: #1f2a28;
        --muted: #7a8582;
        --teal: #145c4f;
        --teal-dark: #0f4a41;
        --teal-soft: #e6f0ed;
        --gold: #b08d2a;
        --gold-soft: #f6efd9;
        --rose: #a8452f;
        --rose-soft: #f6e6e1;

        --font-body: system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* ============ CONTAINER ============ */
    .profile-container {
        background: var(--bg);
        min-height: calc(100vh - 100px);
        padding: 28px 0;
        font-family: var(--font-body);
        color: var(--ink);
    }

    /* ============ PROFILE / PHOTO CARD ============ */
    .profile-card {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--line);
        animation: fadeInUp 0.4s ease-out;
    }

    .photo-card { background: var(--teal); border-bottom: none; }

    .profile-user-img {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid rgba(255,255,255,0.8);
    }

    .profile-username { font-weight: 600; }

    .role-badge {
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
        color: #fff;
    }

    /* ============ DETAIL CARD ============ */
    .detail-card { border: 1px solid var(--line); border-radius: 16px; overflow: hidden; }

    .detail-header { padding: 15px 20px; border-bottom: 1px solid var(--line); background: #fff; }
    .detail-header h3 { color: var(--ink); margin: 0; font-weight: 600; font-size: 1.1rem; }
    .detail-header h3 i { margin-right: 10px; color: var(--teal); }

    /* ============ TABLE ============ */
    .profile-table { margin-bottom: 0; }
    .profile-table tr:hover { background-color: var(--bg); }

    .profile-table th {
        width: 30%;
        background-color: var(--bg);
        color: var(--ink);
        font-weight: 600;
        border-bottom: 1px solid var(--line);
        padding: 14px;
    }

    .profile-table td {
        padding: 14px;
        color: var(--ink);
        font-weight: 500;
        border-bottom: 1px solid var(--line);
        font-size: 0.9rem;
    }

    /* ============ BUTTON ============ */
    .btn-edit {
        background: var(--teal);
        border: none;
        border-radius: 10px;
        padding: 10px 22px;
        font-weight: 600;
        transition: background 0.2s ease;
        color: #fff;
    }
    .btn-edit:hover { background: var(--teal-dark); color: #fff; }
    .btn-edit i { margin-right: 8px; }

    /* ============ INFO CARDS ============ */
    .info-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 14px;
        text-align: center;
        transition: all 0.2s ease;
        margin-bottom: 14px;
    }
    .info-card:hover { background: var(--teal-soft); }
    .info-card i { font-size: 1.7rem; color: var(--gold); margin-bottom: 8px; }
    .info-card .info-label { font-size: 0.78rem; color: var(--muted); margin-bottom: 5px; }
    .info-card .info-value { font-size: 1.05rem; font-weight: 700; color: var(--ink); }

    .stats-section { margin-top: 18px; }

    /* ============ WELCOME ============ */
    .welcome-text {
        background: var(--teal);
        color: #fff;
        padding: 15px 20px;
        border-radius: 14px;
        margin-bottom: 20px;
        animation: slideInLeft 0.4s ease-out;
    }
    .welcome-text h5 { margin: 0; font-weight: 600; }
    .welcome-text p { margin: 5px 0 0; opacity: 0.85; font-size: 0.82rem; }

    /* ============ MODAL ============ */
    .modal-content-custom { border-radius: 14px; overflow: hidden; }
    .modal-header-custom { background: var(--teal); color: #fff; border-bottom: none; padding: 15px 20px; }

    .badge.bg-success.bg-opacity-10 { background: var(--teal-soft) !important; color: var(--teal) !important; }
    .badge.bg-light.text-dark { background: var(--bg) !important; color: var(--ink) !important; }
    #qrStatus.bg-success { background: var(--teal) !important; }
    #qrStatus.bg-warning { background: var(--gold) !important; }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 768px) {
        .profile-user-img { width: 100px; height: 100px; }
        .profile-table th, .profile-table td { padding: 10px; font-size: 0.85rem; }
        .info-card { margin-bottom: 10px; }
        .info-card i { font-size: 1.3rem; }
        .info-card .info-value { font-size: 0.9rem; }
    }
</style>

<div class="profile-container">
    <div class="container">
        <div class="row">
            <!-- Welcome Section -->
            <div class="col-12 mb-4">
                <div class="welcome-text">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h5>
                                <i class="fas fa-user-graduate me-2"></i>
                                Selamat Datang, {{ auth()->user()->name ?? 'User' }}!
                            </h5>
                            <p>
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ now()->translatedFormat('l, d F Y') }}
                            </p>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <span class="role-badge">
                                <i class="fas fa-graduation-cap me-1"></i>
                                Siswa
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- FOTO & INFO -->
            <div class="col-lg-4 col-md-5 mb-4">
                <div class="card profile-card photo-card border-0">
                    <div class="card-body text-center p-4">
                        @php
                            $profilePhotoPath = auth()->user()->profile_photo ?? null;
                            $profilePhotoUrl = $profilePhotoPath
                                ? asset('storage/' . $profilePhotoPath)
                                : asset('assets/AdminLTE/dist/img/avatar.png');
                        @endphp
                        <img class="profile-user-img img-fluid"
                             src="{{ $profilePhotoUrl }}"
                             alt="Profile picture"
                             onerror="this.src='{{ asset('assets/AdminLTE/dist/img/avatar.png') }}'">
                        
                        <h3 class="profile-username mt-3 text-white">
                            {{ auth()->user()->name ?? 'User' }}
                        </h3>
                        <p class="text-white-50 mb-0">
                            <i class="fas fa-envelope me-1"></i>
                            {{ auth()->user()->email ?? 'user@example.com' }}
                        </p>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="stats-section">
                    <div class="row">
                        <div class="col-6">
                            <div class="info-card">
                                <i class="fas fa-clock"></i>
                                <div class="info-label">Total Absensi</div>
                                <div class="info-value" id="totalAbsensi">-</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-card">
                                <i class="fas fa-check-circle"></i>
                                <div class="info-label">Kehadiran</div>
                                <div class="info-value" id="persentase">-</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAIL PROFIL -->
            <div class="col-lg-8 col-md-7">
                <div class="card detail-card">
                    <div class="detail-header">
                        <h3>
                            <i class="fas fa-id-card"></i>
                            Data Profil
                        </h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table profile-table mb-0">
                            <tbody>
                                <tr>
                                    <th>
                                        <i class="fas fa-user me-2" style="color: var(--gold);"></i>
                                        Nama Lengkap
                                    </th>
                                    <td>{{ auth()->user()->name ?? 'User' }}</td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-envelope me-2" style="color: var(--gold);"></i>
                                        Email
                                    </th>
                                    <td>{{ auth()->user()->email ?? 'user@example.com' }}</td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-id-card me-2" style="color: var(--gold);"></i>
                                        NISN
                                    </th>
                                    <td>
                                        <span class="badge bg-light text-dark p-2">
                                            <i class="fas fa-hashtag me-1"></i>
                                            {{ auth()->user()->siswa->nisn ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-chalkboard-user me-2" style="color: var(--gold);"></i>
                                        Kelas & Jurusan
                                    </th>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success p-2">
                                            <i class="fas fa-graduation-cap me-1"></i>
                                            {{ auth()->user()->siswa->kelas ?? '-' }} 
                                            {{ auth()->user()->siswa->jurusan ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-calendar-alt me-2" style="color: var(--gold);"></i>
                                        Tanggal Bergabung
                                    </th>
                                    <td>
                                        {{ auth()->user()->created_at ? auth()->user()->created_at->translatedFormat('d F Y') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-qrcode me-2" style="color: var(--gold);"></i>
                                        Status QR
                                    </th>
                                    <td>
                                        <span id="qrStatus" class="badge bg-warning">
                                            <i class="fas fa-spinner fa-spin me-1"></i>
                                            Memuat...
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-end bg-transparent border-0">
                        <a href="{{ route('user.profil.edit') }}" class="btn-edit">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch user statistics
        fetchUserStatistics();
        
        // Fetch QR status
        fetchQRStatus();
    });
    
    async function fetchUserStatistics() {
        try {
            const response = await fetch('/api/user/statistics', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            });
            
            if (response.ok) {
                const data = await response.json();
                if (data.success) {
                    document.getElementById('totalAbsensi').innerHTML = data.total_absensi || 0;
                    document.getElementById('persentase').innerHTML = (data.persentase || 0) + '%';
                }
            }
        } catch (error) {
            console.error('Error fetching statistics:', error);
            document.getElementById('totalAbsensi').innerHTML = '0';
            document.getElementById('persentase').innerHTML = '0%';
        }
    }
    
    async function fetchQRStatus() {
        try {
            const response = await fetch('/api/user/qr-status', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            });
            
            if (response.ok) {
                const data = await response.json();
                const qrStatus = document.getElementById('qrStatus');
                if (data.has_qr) {
                    qrStatus.innerHTML = '<i class="fas fa-check-circle me-1"></i> QR Aktif';
                    qrStatus.className = 'badge bg-success';
                } else {
                    qrStatus.innerHTML = '<i class="fas fa-clock me-1"></i> Belum Ada QR';
                    qrStatus.className = 'badge bg-warning';
                }
            }
        } catch (error) {
            console.error('Error fetching QR status:', error);
            document.getElementById('qrStatus').innerHTML = '<i class="fas fa-question-circle me-1"></i> Tidak Diketahui';
        }
    }
    
    // Show success message if exists
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif
    
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: true
        });
    @endif
</script>

@endsection