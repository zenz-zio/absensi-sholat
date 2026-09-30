@extends('layouts.main')

@section('title', 'Tambah Siswa Baru')

@section('content')

<style>
    :root {
        --bg: #f7f6f2;
        --line: #e8e5dc;
        --ink: #1f2a28;
        --muted: #7a8582;
        --teal: #145c4f;
        --teal-soft: #e6f0ed;
        --gold: #b08d2a;

        --font-body: system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
    }

    .container-fluid { font-family: var(--font-body); color: var(--ink); }

    .form-card {
        background: #fff;
        border: 1px solid var(--line) !important;
        border-radius: 14px;
        box-shadow: 0 1px 2px rgba(20, 40, 36, 0.04);
        overflow: hidden;
        max-width: 720px;
        margin: 0 auto;
    }

    .card-header-custom {
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid var(--line);
        background: #fff;
    }
    .card-header-custom h3 { margin: 0; font-size: 1.2rem; font-weight: 600; color: var(--ink); }
    .card-header-custom h3 i { color: var(--teal); }
    .card-header-custom p { margin: 4px 0 0; font-size: 0.82rem; color: var(--muted); }

    .card-body-custom { padding: 1.75rem; }

    .form-label { font-weight: 600; color: var(--ink); font-size: 0.86rem; }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid var(--line);
        padding: 9px 14px;
        font-size: 0.9rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(20, 92, 79, 0.12);
    }

    .section-title {
        font-size: 0.74rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--muted);
        font-weight: 600;
        margin: 1.75rem 0 1rem;
        padding-bottom: 6px;
        border-bottom: 1px solid var(--line);
    }
    .section-title i { color: var(--teal); }
    .section-title:first-child { margin-top: 0; }

    .btn-save {
        background: var(--teal);
        border: none;
        border-radius: 10px;
        padding: 9px 22px;
        color: #fff;
        font-size: 0.9rem;
        font-weight: 600;
        transition: background 0.2s ease;
    }
    .btn-save:hover { background: #0f4a41; color: #fff; }

    .btn-cancel {
        border-radius: 10px;
        padding: 9px 22px;
        font-size: 0.9rem;
        font-weight: 600;
        border: 1px solid var(--line);
        color: var(--muted);
        background: #fff;
    }
    .btn-cancel:hover { background: var(--bg); color: var(--ink); }

    .invalid-feedback { display: block; }
</style>

<div class="container-fluid">
    <div class="card form-card border-0">
        <div class="card-header-custom">
            <h3><i class="fas fa-user-plus me-2"></i>Tambah Siswa Baru</h3>
            <p>Membuat akun & data siswa baru</p>
        </div>

        <div class="card-body-custom">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Ada isian yang belum benar:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.siswa.store') }}">
                @csrf

                <div class="section-title"><i class="fas fa-user me-1"></i> Akun Login</div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Contoh: Ahmad Fauzan" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="contoh@email.com" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="section-title"><i class="fas fa-id-card me-1"></i> Data Siswa</div>

                <div class="mb-3">
                    <label class="form-label">NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" class="form-control" placeholder="10 digit angka" maxlength="10" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kelas</label>
                        <select name="kelas" class="form-select" required>
                            <option value="" disabled {{ old('kelas') ? '' : 'selected' }}>Pilih Kelas</option>
                            <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>Kelas 10</option>
                            <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>Kelas 11</option>
                            <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>Kelas 12</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jurusan</label>
                        <select name="jurusan" class="form-select" required>
                            <option value="" disabled {{ old('jurusan') ? '' : 'selected' }}>Pilih Jurusan</option>
                            <option value="RPL" {{ old('jurusan') == 'RPL' ? 'selected' : '' }}>RPL</option>
                            <option value="TKJ" {{ old('jurusan') == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                            <option value="DKV" {{ old('jurusan') == 'DKV' ? 'selected' : '' }}>DKV</option>
                            <option value="BC" {{ old('jurusan') == 'BC' ? 'selected' : '' }}>BC</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-cancel">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save me-2"></i>Simpan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection