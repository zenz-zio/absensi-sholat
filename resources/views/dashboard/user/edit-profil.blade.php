@extends('layouts.app')

@section('title', 'Edit Profil')

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

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* ============ CONTAINER ============ */
    .edit-profile-container {
        background: transparent;
        min-height: calc(100vh - 100px);
        padding: 28px 0;
        font-family: var(--font-body);
        color: var(--ink);
    }

    /* ============ CARD ============ */
    .profile-card {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--line);
        animation: fadeInUp 0.4s ease-out;
    }

    /* ============ HEADER ============ */
    .card-header-custom { padding: 1.1rem 1.4rem; border-bottom: 1px solid var(--line); background: #fff; }
    .card-header-custom h3 { color: var(--ink); margin: 0; font-weight: 600; font-size: 1.15rem; }
    .card-header-custom h3 i { margin-right: 10px; color: var(--teal); }
    .card-header-custom p { color: var(--muted); margin: 8px 0 0; font-size: 0.82rem; }

    /* ============ FORM ============ */
    .form-group-custom { margin-bottom: 1.4rem; }

    .form-label { font-weight: 600; color: var(--ink); margin-bottom: 8px; display: block; }
    .form-label i { margin-right: 8px; color: var(--gold); }

    .form-control-custom {
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 11px 14px;
        transition: all 0.2s ease;
        width: 100%;
        font-size: 0.92rem;
        background: #fff;
        color: var(--ink);
    }

    .form-control-custom:focus {
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(20, 92, 79, 0.12);
        outline: none;
    }

    .form-control-custom:disabled { background: var(--bg); cursor: not-allowed; }

    /* ============ PHOTO PREVIEW ============ */
    .photo-preview { text-align: center; margin-bottom: 20px; }

    .current-photo {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--teal-soft);
    }

    .photo-placeholder {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: var(--teal);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .photo-placeholder i { font-size: 46px; color: #fff; }

    /* ============ FILE INPUT ============ */
    .file-input-label {
        background: var(--bg);
        border: 1.5px dashed var(--line);
        border-radius: 10px;
        padding: 11px 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        display: block;
        color: var(--ink);
        font-weight: 600;
    }
    .file-input-label:hover { background: var(--teal-soft); border-color: var(--teal); }
    .file-input-label i { margin-right: 8px; color: var(--gold); }

    .file-input-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    .file-selected-name {
        display: block;
        margin-top: 8px;
        font-size: 0.8rem;
        color: var(--teal);
    }

    /* ============ INFO ALERT ============ */
    .info-alert {
        background: var(--bg);
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 12px 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .info-alert i { font-size: 1.1rem; color: var(--gold); }
    .info-alert small { color: var(--muted); flex: 1; }

    /* ============ BUTTON ============ */
    .btn-save {
        background: var(--teal);
        border: none;
        border-radius: 10px;
        padding: 10px 24px;
        font-weight: 600;
        transition: background 0.2s ease;
        color: #fff;
    }
    .btn-save:hover { background: var(--teal-dark); color: #fff; }
    .btn-save:disabled { opacity: 0.6; cursor: not-allowed; }

    .btn-cancel {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 10px 24px;
        font-weight: 600;
        transition: background 0.2s ease;
        color: var(--teal);
    }
    .btn-cancel:hover { background: var(--bg); color: var(--teal-dark); }

    /* ============ FOOTER ============ */
    .card-footer-custom {
        background: var(--bg);
        border-top: 1px solid var(--line);
        padding: 1rem 1.4rem;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 768px) {
        .card-header-custom { padding: 1rem; }
        .card-header-custom h3 { font-size: 1.05rem; }
        .form-control-custom { padding: 10px 12px; }
        .btn-save, .btn-cancel { padding: 8px 18px; font-size: 0.88rem; }
        .current-photo, .photo-placeholder { width: 92px; height: 92px; }
    }

    /* ============ VALIDATION ============ */
    .is-invalid { border-color: var(--rose) !important; }
    .invalid-feedback { color: var(--rose); font-size: 0.8rem; margin-top: 5px; }

    /* ============ LOADING OVERLAY ============ */
    .loading-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(20, 40, 36, 0.55);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 46px;
        height: 46px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-top: 4px solid var(--gold);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

</style>


<div class="edit-profile-container">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-8 col-md-10 col-12">

                <div class="profile-card card border-0">

                    <div class="card-header-custom">

                        <h3>
                            <i class="fas fa-user-edit"></i>
                            Edit Profil
                        </h3>

                        <p>
                            <i class="fas fa-info-circle me-1"></i>
                            Perbarui informasi profil Anda di sini
                        </p>

                    </div>


                    {{-- FORM EDIT PROFIL --}}

                    <form
                        action="{{ route('user.profil.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        id="editProfileForm">

                        @csrf
                        @method('PUT')

                        <div class="card-body p-4">

                            {{-- PHOTO PREVIEW --}}

                            <div class="photo-preview mb-4">

                                <div id="photoPreviewContainer">

                                    @php

                                        $user = auth()->user();
                                        $currentPhoto = $user->profile_photo ?? null;

                                    @endphp

                                    @if($currentPhoto && Storage::disk('public')->exists($currentPhoto))

                                        <img
                                            id="photoPreview"
                                            src="{{ asset('storage/' . $currentPhoto) }}"
                                            class="current-photo"
                                            alt="Profile Photo"
                                            onerror="this.src='{{ asset('assets/AdminLTE/dist/img/avatar.png') }}'">

                                    @else

                                        <div
                                            id="photoPreview"
                                            class="photo-placeholder">

                                            <i class="fas fa-user-circle"></i>

                                        </div>

                                    @endif

                                </div>

                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-camera me-1"></i>
                                    Foto profil Anda saat ini
                                </small>

                            </div>


                            {{-- INFO ALERT --}}

                            <div class="info-alert">

                                <i class="fas fa-lightbulb"></i>

                                <small>
                                    <strong>Tips:</strong>
                                    Gunakan foto yang jelas untuk memudahkan identifikasi.
                                    Format yang didukung: JPG, JPEG, PNG (Max 2MB)
                                </small>

                            </div>


                            {{-- NAMA --}}

                            <div class="form-group-custom">

                                <label class="form-label" for="name">
                                    <i class="fas fa-user"></i>
                                    Nama Lengkap
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control form-control-custom @error('name') is-invalid @enderror"
                                    value="{{ old('name', auth()->user()->name) }}"
                                    placeholder="Masukkan nama lengkap"
                                    required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>


                            {{-- EMAIL --}}

                            <div class="form-group-custom">

                                <label class="form-label" for="email">
                                    <i class="fas fa-envelope"></i>
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control form-control-custom @error('email') is-invalid @enderror"
                                    value="{{ old('email', auth()->user()->email) }}"
                                    placeholder="Masukkan email aktif"
                                    required>

                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Email akan digunakan untuk login
                                </small>

                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>


                            {{-- FOTO PROFIL --}}

                            <div class="form-group-custom">

                                <label class="form-label" for="foto">
                                    <i class="fas fa-camera"></i>
                                    Foto Profil
                                </label>

                                <label for="foto" class="file-input-label mb-0">
                                    <i class="fas fa-upload"></i>
                                    Pilih Foto Baru
                                </label>

                                <input
                                    type="file"
                                    name="foto"
                                    id="foto"
                                    class="file-input-hidden @error('foto') is-invalid @enderror"
                                    accept="image/jpeg,image/jpg,image/png"
                                    onchange="previewImage(this)">

                                <span class="file-selected-name" id="fileSelectedName"></span>

                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-image me-1"></i>
                                    Format: JPG, JPEG, PNG (Max 2MB)
                                </small>

                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>


                        {{-- FOOTER BUTTON --}}

                        <div class="card-footer-custom">

                            <a href="{{ route('user.profil') }}" class="btn-cancel">
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>

                            <button type="submit" class="btn-save" id="submitBtn">
                                <i class="fas fa-save me-2"></i>
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- LOADING OVERLAY --}}

<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>


{{-- SWEETALERT2 --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    // Preview image sebelum upload

    function previewImage(input) {

        const previewContainer =
            document.getElementById('photoPreviewContainer');

        const fileNameLabel =
            document.getElementById('fileSelectedName');


        if (input.files && input.files[0]) {

            const file = input.files[0];


            // Validasi ukuran file

            if (file.size > 2 * 1024 * 1024) {

                Swal.fire({

                    icon: 'error',

                    title: 'Ukuran File Terlalu Besar',

                    text: 'Ukuran foto maksimal 2MB',

                    confirmButtonColor: '#145c4f'

                });

                input.value = '';

                fileNameLabel.innerHTML = '';

                return;
            }


            // Validasi tipe file

            if (
                ![
                    'image/jpeg',
                    'image/jpg',
                    'image/png'
                ].includes(file.type)
            ) {

                Swal.fire({

                    icon: 'error',

                    title: 'Format File Tidak Didukung',

                    text: 'Format foto harus JPG, JPEG, atau PNG',

                    confirmButtonColor: '#145c4f'

                });

                input.value = '';

                fileNameLabel.innerHTML = '';

                return;
            }


            fileNameLabel.innerHTML =
                `<i class="fas fa-check-circle me-1"></i>${file.name}`;


            const reader = new FileReader();


            reader.onload = function(e) {

                previewContainer.innerHTML =
                    `<img
                        id="photoPreview"
                        src="${e.target.result}"
                        class="current-photo"
                        alt="Profile Photo Preview">`;

            };


            reader.readAsDataURL(file);

        } else {

            fileNameLabel.innerHTML = '';

        }

    }


    // Form validation

    document
        .getElementById('editProfileForm')
        ?.addEventListener('submit', function(e) {

            const name =
                document.getElementById('name')?.value.trim();

            const email =
                document.getElementById('email')?.value.trim();

            const foto =
                document.getElementById('foto')?.files[0];


            let errors = [];


            if (!name) {

                errors.push('Nama lengkap tidak boleh kosong');

                highlightError('name');

            }


            if (!email) {

                errors.push('Email tidak boleh kosong');

                highlightError('email');

            } else if (!isValidEmail(email)) {

                errors.push('Email tidak valid');

                highlightError('email');

            }


            if (foto && foto.size > 2 * 1024 * 1024) {

                errors.push('Ukuran foto maksimal 2MB');

                highlightError('foto');

            }


            if (
                foto &&
                ![
                    'image/jpeg',
                    'image/jpg',
                    'image/png'
                ].includes(foto.type)
            ) {

                errors.push('Format foto harus JPG, JPEG, atau PNG');

                highlightError('foto');

            }


            if (errors.length > 0) {

                e.preventDefault();

                Swal.fire({

                    icon: 'error',

                    title: 'Validasi Gagal',

                    html: errors.join('<br>'),

                    confirmButtonColor: '#145c4f'

                });

            } else {

                // Show loading

                document
                    .getElementById('loadingOverlay')
                    .style.display = 'flex';

                document
                    .getElementById('submitBtn')
                    .setAttribute('disabled', 'disabled');

            }

        });


    function isValidEmail(email) {

        const emailRegex =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        return emailRegex.test(email);

    }


    function highlightError(fieldId) {

        const field =
            document.getElementById(fieldId);

        if (field) {

            field.classList.add('is-invalid');

            setTimeout(() => {

                field.classList.remove('is-invalid');

            }, 3000);

        }

    }


    // Hapus error highlight saat input

    document
        .getElementById('name')
        ?.addEventListener('input', function() {

            this.classList.remove('is-invalid');

        });


    document
        .getElementById('email')
        ?.addEventListener('input', function() {

            this.classList.remove('is-invalid');

        });


    document
        .getElementById('foto')
        ?.addEventListener('change', function() {

            this.classList.remove('is-invalid');

        });


    // Success message

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


    // Error message

    @if(session('error'))

        Swal.fire({

            icon: 'error',

            title: 'Gagal!',

            text: '{{ session('error') }}',

            timer: 3000,

            showConfirmButton: true,

            confirmButtonColor: '#145c4f'

        });

    @endif


    // Validation errors

    @if($errors->any())

        Swal.fire({

            icon: 'error',

            title: 'Validasi Gagal',

            html: `{!! implode('<br>', $errors->all()) !!}`,

            confirmButtonColor: '#145c4f'

        });

    @endif


    // Auto hide loading after page load

    window.addEventListener('load', function() {

        setTimeout(() => {

            document
                .getElementById('loadingOverlay')
                .style.display = 'none';

            document
                .getElementById('submitBtn')
                ?.removeAttribute('disabled');

        }, 500);

    });

</script>

@endsection