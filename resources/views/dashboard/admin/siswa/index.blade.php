@extends('layouts.main')

@section('title', 'Data Siswa')

@section('content')

<style>
    :root {
        --bg: #f7f6f2;
        --card: #ffffff;
        --line: #e8e5dc;
        --ink: #1f2a28;
        --muted: #7a8582;
        --teal: #145c4f;
        --teal-soft: #e6f0ed;
        --gold: #b08d2a;
        --gold-soft: #f6efd9;
        --rose: #a8452f;
        --rose-soft: #f6e6e1;
        --violet: #5b2e91;
        --violet-soft: #eee8f6;

        --font-body: system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
    }

    .container-fluid { font-family: var(--font-body); color: var(--ink); font-variant-numeric: tabular-nums; }

    /* ===== CARD ===== */
    .data-card {
        background: var(--card);
        border: 1px solid var(--line) !important;
        border-radius: 14px;
        box-shadow: 0 1px 2px rgba(20, 40, 36, 0.04);
        overflow: hidden;
    }

    .card-header-custom {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--line);
        background: var(--card);
    }
    .card-header-custom h3 { margin: 0; font-size: 1.2rem; font-weight: 600; color: var(--ink); }
    .card-header-custom h3 i { color: var(--teal); }
    .card-header-custom p { margin: 4px 0 0; font-size: 0.8rem; color: var(--muted); }

    .btn-create {
        background: var(--teal);
        border: none;
        border-radius: 10px;
        padding: 9px 18px;
        color: #fff;
        font-size: 0.88rem;
        font-weight: 600;
        transition: background 0.2s ease;
    }
    .btn-create:hover { background: #0f4a41; color: #fff; }

    .btn-success-custom {
        background: var(--teal);
        border: none;
        color: #fff;
        border-radius: 10px;
        padding: 8px 16px;
        font-size: 0.88rem;
        transition: background 0.2s ease;
    }
    .btn-success-custom:hover { background: #0f4a41; color: #fff; }

    /* ===== FILTER ===== */
    .filter-section {
        background: var(--bg);
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 1px solid var(--line);
    }

    .search-input {
        border-radius: 10px;
        border: 1px solid var(--line);
        padding: 9px 14px;
        background: #fff;
        font-size: 0.88rem;
        color: var(--ink);
    }
    .search-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(20, 92, 79, 0.12); }

    .input-group-text {
        background: #fff;
        border: 1px solid var(--line);
        border-right: none;
        color: var(--muted);
        border-radius: 10px 0 0 10px;
    }
    .input-group .search-input { border-left: none; border-radius: 0 10px 10px 0; }

    /* ===== INFO BAR ===== */
    .info-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: 4px 2px 12px;
        font-size: 0.86rem;
        color: var(--muted);
    }
    .info-bar i { color: var(--muted); }
    .info-bar strong { color: var(--ink); font-weight: 600; }

    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px !important;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 500;
    }
    .filter-badge.bg-success { background: var(--teal-soft) !important; color: var(--teal) !important; }
    .filter-badge.bg-info    { background: var(--gold-soft) !important; color: var(--gold) !important; }
    .filter-badge.bg-warning { background: var(--violet-soft) !important; color: var(--violet) !important; }
    .filter-badge.text-white { color: inherit !important; }
    .filter-badge .btn-close-sm { font-size: 0.7rem; cursor: pointer; opacity: 0.6; }
    .filter-badge .btn-close-sm:hover { opacity: 1; }

    /* ===== TABLE ===== */
    .table-custom { margin-bottom: 0; }

    .table-custom thead th {
        background: var(--bg);
        color: var(--muted);
        font-weight: 600;
        font-size: 0.74rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border: none;
        border-bottom: 1px solid var(--line);
        padding: 12px 14px;
        white-space: nowrap;
    }

    .table-custom tbody tr { border-bottom: 1px solid var(--line); transition: background 0.15s ease; }
    .table-custom tbody tr:hover { background-color: var(--bg); }
    .table-custom tbody tr:last-child { border-bottom: none; }
    .table-custom tbody td { padding: 12px 14px; vertical-align: middle; font-size: 0.9rem; border: none; background: transparent; }
    .table-custom .nisn { color: var(--teal); }

    .table-custom tfoot td { border: none; border-top: 1px solid var(--line); background: transparent; }

    /* Kelas & jurusan badges */
    .badge.bg-success.bg-opacity-10 { background: var(--teal-soft) !important; color: var(--teal) !important; font-weight: 500; }
    .badge.bg-info.bg-opacity-10 { background: var(--gold-soft) !important; color: var(--gold) !important; font-weight: 500; }

    /* Status badge */
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-hadir { background: var(--teal-soft); color: var(--teal); }
    .badge-belum { background: var(--rose-soft); color: var(--rose); }

    /* Action buttons: soft, icon-only */
    .btn-action {
        border-radius: 8px !important;
        padding: 6px 10px;
        margin: 0 2px;
        border: none;
        font-size: 0.82rem;
        transition: background 0.15s ease;
    }
    .btn-action.disabled, .btn-action:disabled { opacity: 0.35; cursor: not-allowed; pointer-events: none; }

    .btn-detail { background: var(--gold-soft); color: var(--gold); }
    .btn-detail:hover { background: #efe3bb; color: var(--gold); }
    .btn-edit-data { background: var(--teal-soft); color: var(--teal); }
    .btn-edit-data:hover { background: #d3e5e0; color: var(--teal); }
    .btn-edit { background: var(--teal-soft); color: var(--teal); }
    .btn-edit:hover { background: #d3e5e0; color: var(--teal); }
    .btn-face { background: var(--violet-soft); color: var(--violet); }
    .btn-face:hover { background: #e0d5ef; color: var(--violet); }
    .btn-delete { background: var(--rose-soft); color: var(--rose); }
    .btn-delete:hover { background: #efd3cb; color: var(--rose); }

    .no-data-row td { text-align: center; padding: 40px !important; color: var(--muted); }
    .no-data-row i { color: var(--line); }

    .highlight-row { animation: highlight 1.6s ease-out; }
    @keyframes highlight {
        0% { background-color: var(--gold-soft); }
        100% { background-color: transparent; }
    }

    /* ===== FOOTER STATS ===== */
    .stat-card-footer { background: var(--bg); border-top: 1px solid var(--line); padding: 1.1rem; }

    .stat-item {
        padding: 12px 10px;
        border-radius: 12px;
        background: #fff;
        border: 1px solid var(--line);
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-item:hover { border-color: #d3cfc2; box-shadow: 0 4px 12px -6px rgba(20, 40, 36, 0.18); }
    .stat-item i { font-size: 1.3rem !important; margin-bottom: 6px !important; }
    .stat-item h5 { color: var(--ink); font-weight: 600; font-size: 1.3rem; }
    .stat-item small { color: var(--muted); font-size: 0.76rem; }

    .progress { background-color: var(--line); border-radius: 10px; height: 6px; }
    .progress-bar { border-radius: 10px; transition: width 0.6s ease; }
    .progress-bar.bg-success { background: var(--teal) !important; }
    .progress-bar.bg-warning { background: var(--gold) !important; }
    .progress-bar.bg-danger  { background: var(--rose) !important; }

    /* ===== MODAL ===== */
    .modal-content { border-radius: 14px; overflow: hidden; border: none; }
    .modal-header-custom {
        background: var(--teal);
        color: #fff;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header-custom h5 { color: #fff; font-weight: 600; font-size: 1.05rem; margin: 0; }
    .modal-header-custom .btn-close { filter: brightness(0) invert(1); }
    .modal-footer-custom { border-top: 1px solid var(--line); padding: 1rem 1.5rem; display: flex; justify-content: center; gap: 8px; }

    /* ===== PAGINATION & CHECKBOX ===== */
    .pagination .page-link { color: var(--teal); border-color: var(--line); }
    .pagination .page-item.active .page-link { background: var(--teal); border-color: var(--teal); color: #fff; }
    .pagination .page-link:hover { background: var(--teal-soft); border-color: var(--teal); color: var(--teal); }

    .form-check-input:checked { background-color: var(--teal); border-color: var(--teal); }
    .form-check-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(20, 92, 79, 0.12); }

    @media (max-width: 768px) {
        .info-bar { flex-direction: column; text-align: center; gap: 8px; }
        .btn-group { flex-wrap: wrap; }
        .btn-action { margin-bottom: 5px; }
        .filter-section { padding: 12px; }
    }
</style>

<div class="container-fluid">
    <div class="card data-card border-0">
        <!-- Card Header -->
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h3 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        Data Siswa
                    </h3>
                    <p class="mb-0">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Update terakhir: {{ now()->format('d/m/Y H:i:s') }}
                    </p>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('admin.siswa.create') }}" class="btn btn-create">
                        <i class="fas fa-plus-circle me-2"></i>
                        Tambah Siswa Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control search-input border-start-0"
                                   placeholder="Cari nama atau NISN...">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <select id="kelasFilter" class="form-select search-input">
                            <option value="">Semua Kelas</option>
                            <option value="10">Kelas 10</option>
                            <option value="11">Kelas 11</option>
                            <option value="12">Kelas 12</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <select id="jurusanFilter" class="form-select search-input">
                            <option value="">Semua Jurusan</option>
                            <option value="RPL">RPL</option>
                            <option value="TKJ">TKJ</option>
                            <option value="DKV">DKV</option>
                            <option value="BC">BC</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success-custom w-100" id="resetFilterBtn">
                            <i class="fas fa-undo-alt me-2"></i>
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info Bar -->
            <div class="info-bar" id="infoBar">
                <div>
                    <i class="fas fa-chart-line me-2"></i>
                    Menampilkan <strong id="visibleCount">0</strong> dari <strong id="totalCount">0</strong> data
                </div>
                <div id="filterBadges" class="d-flex flex-wrap gap-2"></div>
            </div>

            <!-- Tabel Data Siswa -->
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Status Absensi</th>
                            <th style="width: 150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="siswaTableBody">
                        @forelse ($siswas as $item)
                            @php
                                $faceRegistered = method_exists($item, 'hasFaceRegistered') ? $item->hasFaceRegistered() : false;
                            @endphp
                            <tr data-id="{{ $item->id }}"
                                data-kelas="{{ $item->kelas }}"
                                data-jurusan="{{ $item->jurusan }}"
                                data-nisn="{{ $item->nisn }}"
                                data-status="{{ ($item->status_sholat ?? false) ? 'Sholat' : 'Tidak Sholat' }}"
                                data-nama="{{ $item->user->name ?? 'Tidak ada user' }}"
                                data-email="{{ $item->user->email ?? '-' }}">
                                <td>
                                    <input type="checkbox" class="form-check-input siswaCheckbox" value="{{ $item->id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td class="nisn fw-semibold">{{ $item->nisn }}</td>
                                <td class="nama">{{ $item->user->name ?? 'Tidak ada user' }}</td>
                                <td class="kelas">
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        {{ $item->kelas }}
                                    </span>
                                </td>
                                <td class="jurusan">
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        {{ $item->jurusan }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $hasSholatToday = $item->status_sholat ?? false;
                                    @endphp
                                    <span class="badge-status {{ $hasSholatToday ? 'badge-hadir' : 'badge-belum' }}">
                                        <i class="fas {{ $hasSholatToday ? 'fa-check-circle' : 'fa-clock' }} me-1"></i>
                                        {{ $hasSholatToday ? 'Sudah Absen' : 'Belum Absen' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button"
                                                class="btn btn-sm btn-detail btn-action"
                                                onclick="showDetail(this)"
                                                data-bs-toggle="tooltip"
                                                title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.siswa.edit', $item->id) }}"
                                           class="btn btn-sm btn-edit-data btn-action"
                                           data-bs-toggle="tooltip"
                                           title="Edit Data Siswa (termasuk reset password)">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-edit btn-action"
                                                onclick="showEditStatus(this)"
                                                data-bs-toggle="tooltip"
                                                title="Edit Status Absensi">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-face btn-action {{ $faceRegistered ? '' : 'disabled' }}"
                                                onclick="confirmResetFace(this)"
                                                data-url="{{ route('admin.siswa.reset-face', $item->id) }}"
                                                data-bs-toggle="tooltip"
                                                title="{{ $faceRegistered ? 'Reset Wajah Terdaftar' : 'Wajah belum didaftarkan' }}"
                                                {{ $faceRegistered ? '' : 'disabled' }}>
                                            <i class="fas fa-camera-retro"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-delete btn-action"
                                                onclick="confirmDelete(this)"
                                                data-url="{{ route('admin.siswa.destroy', $item->id) }}"
                                                data-bs-toggle="tooltip"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-data-row">
                                <td colspan="8">
                                    <i class="fas fa-database fa-3x mb-3 d-block"></i>
                                    <h5 style="color: var(--ink);">Belum ada data siswa</h5>
                                    <p class="text-muted">Silakan tambah siswa baru dengan mengklik tombol "Tambah Siswa Baru"</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="text-end">
                                <button class="btn btn-success-custom" onclick="bulkAbsen()" id="bulkAbsenBtn" style="display: none;">
                                    <i class="fas fa-check-double me-2"></i>
                                    Absen Massal ( <span id="selectedCount">0</span> )
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($siswas) && method_exists($siswas, 'links'))
                <div class="mt-4 d-flex justify-content-center">
                    {{ $siswas->links() }}
                </div>
            @endif
        </div>

        <!-- Card Footer dengan Statistik -->
        <div class="card-footer stat-card-footer">
            <div class="row text-center">
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('all')">
                        <i class="fas fa-users fa-2x mb-2" style="color: var(--teal);"></i>
                        <h5 class="mb-0" id="totalSiswa">{{ $siswas->count() }}</h5>
                        <small>Total Siswa</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('hadir')">
                        <i class="fas fa-user-check fa-2x mb-2" style="color: var(--teal);"></i>
                        <h5 class="mb-0" id="hadirCount">0</h5>
                        <small>Sudah Absen</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('belum')">
                        <i class="fas fa-user-clock fa-2x mb-2" style="color: var(--rose);"></i>
                        <h5 class="mb-0" id="belumCount">0</h5>
                        <small>Belum Absen</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <i class="fas fa-chart-line fa-2x mb-2" style="color: var(--gold);"></i>
                        <h5 class="mb-0" id="persentaseHadir">0%</h5>
                        <small>Persentase Kehadiran</small>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-3">
                <div class="progress">
                    <div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 0%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header-custom">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-user-graduate me-2"></i>
                    Detail Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" onclick="closeModal('detailModal')" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody" style="padding: 1.5rem;">
                <!-- Content akan diisi via JS -->
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill" onclick="closeModal('detailModal')">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Status Absensi -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header-custom">
                <h5 class="modal-title" id="editStatusModalLabel">
                    <i class="fas fa-clipboard-check me-2"></i>
                    Edit Status Absensi
                </h5>
                <button type="button" class="btn-close btn-close-white" onclick="closeModal('editStatusModal')" aria-label="Close"></button>
            </div>
            <form id="editStatusForm">
                <div class="modal-body" style="padding: 1.5rem;">
                    <p class="mb-3">
                        Siswa: <strong id="editStatusNama" style="color: var(--teal);"></strong>
                    </p>
                    <input type="hidden" id="editStatusSiswaId" name="id_siswa">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Absensi Hari Ini</label>
                        <select id="editStatusSelect" name="status" class="form-select" required>
                            <option value="Sholat">Sudah Absen (Sholat)</option>
                            <option value="Tidak Sholat">Belum Absen</option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-semibold">Keterangan (opsional)</label>
                        <textarea id="editStatusKeterangan" name="keterangan" class="form-control" rows="2" placeholder="Misal: absen manual dikonfirmasi guru piket"></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill" onclick="closeModal('editStatusModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success-custom px-4 py-2" id="editStatusSubmitBtn">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi close modal universal - jalan baik di Bootstrap 4 maupun Bootstrap 5.
    // Diprioritaskan lewat jQuery dulu karena layout AdminLTE ini pakai Bootstrap 4
    // (bootstrap.Modal ada tapi TIDAK punya method getInstance seperti di Bootstrap 5).
    function closeModal(modalId) {
        const el = document.getElementById(modalId);
        if (!el) return;

        if (window.jQuery) {
            try {
                jQuery('#' + modalId).modal('hide');
                return;
            } catch (e) { /* lanjut ke cara berikutnya */ }
        }

        if (window.bootstrap && bootstrap.Modal) {
            try {
                new bootstrap.Modal(el).hide();
                return;
            } catch (e) { /* lanjut ke fallback manual */ }
        }

        // Fallback manual kalau semua cara di atas gagal
        el.classList.remove('show');
        el.style.display = 'none';
        el.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
        document.querySelectorAll('.modal-backdrop').forEach(bd => bd.remove());
    }

    // Inisialisasi tooltip
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltip initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Set total count
        const totalCount = document.querySelectorAll('#siswaTableBody tr:not(.no-data-row)').length;
        document.getElementById('totalCount').innerText = totalCount;
        document.getElementById('visibleCount').innerText = totalCount;

        // Initial filter
        filterTable();

        // Highlight row if from session
        @if(session('highlight_id'))
            const highlightedRow = document.querySelector(`tr[data-id="{{ session('highlight_id') }}"]`);
            if (highlightedRow) {
                highlightedRow.classList.add('highlight-row');
                setTimeout(() => {
                    highlightedRow.classList.remove('highlight-row');
                }, 2000);
            }
        @endif
    });

    // Show Detail Modal
    function showDetail(button) {
        const row = button.closest('tr');
        const nisn = row.getAttribute('data-nisn');
        const nama = row.getAttribute('data-nama');
        const email = row.getAttribute('data-email');
        const kelas = row.getAttribute('data-kelas');
        const jurusan = row.getAttribute('data-jurusan');
        const statusBadge = row.querySelector('.badge-status');
        const statusText = statusBadge ? statusBadge.innerText.trim() : 'Tidak diketahui';
        const statusClass = statusBadge ? (statusBadge.classList.contains('badge-hadir') ? 'hadir' : 'belum') : '';

        const modalBody = document.getElementById('detailModalBody');
        modalBody.innerHTML = `
            <div class="text-center mb-3">
                <div class="rounded-circle d-inline-flex p-3 mb-3" style="background: #e6f0ed;">
                    <i class="fas fa-user-graduate fa-3x" style="color: #145c4f;"></i>
                </div>
            </div>
            <table class="table table-borderless">
                <tr>
                    <td width="35%"><strong style="color: #145c4f;"><i class="fas fa-id-card me-2"></i>NISN</strong></td>
                    <td>: <span class="fw-bold" style="color: #145c4f;">${nisn}</span></td>
                </tr>
                <tr>
                    <td><strong style="color: #145c4f;"><i class="fas fa-user me-2"></i>Nama Lengkap</strong></td>
                    <td>: ${nama}</td>
                </tr>
                <tr>
                    <td><strong style="color: #145c4f;"><i class="fas fa-envelope me-2"></i>Email</strong></td>
                    <td>: ${email}</td>
                </tr>
                <tr>
                    <td><strong style="color: #145c4f;"><i class="fas fa-chalkboard-user me-2"></i>Kelas</strong></td>
                    <td>: ${kelas}</td>
                </tr>
                <tr>
                    <td><strong style="color: #145c4f;"><i class="fas fa-book me-2"></i>Jurusan</strong></td>
                    <td>: ${jurusan}</td>
                </tr>
                <tr>
                    <td><strong style="color: #145c4f;"><i class="fas fa-clipboard-list me-2"></i>Status Absensi</strong></td>
                    <td>: <span class="badge-status ${statusClass == 'hadir' ? 'badge-hadir' : 'badge-belum'}">${statusText}</span></td>
                </tr>
            </table>
        `;

        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    }

    // Show Edit Status Modal
    function showEditStatus(button) {
        const row = button.closest('tr');
        document.getElementById('editStatusSiswaId').value = row.getAttribute('data-id');
        document.getElementById('editStatusNama').textContent = row.getAttribute('data-nama');
        document.getElementById('editStatusSelect').value = row.getAttribute('data-status') || 'Tidak Sholat';
        document.getElementById('editStatusKeterangan').value = '';

        const modal = new bootstrap.Modal(document.getElementById('editStatusModal'));
        modal.show();
    }

    document.getElementById('editStatusForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const submitBtn = document.getElementById('editStatusSubmitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

        fetch('{{ route("admin.absensi.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify({
                id_siswa: document.getElementById('editStatusSiswaId').value,
                status: document.getElementById('editStatusSelect').value,
                keterangan: document.getElementById('editStatusKeterangan').value,
            }),
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message,
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => location.reload());
            } else {
                Swal.fire('Gagal', result.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(() => {
            Swal.fire('Gagal', 'Tidak bisa terhubung ke server', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan';
        });
    });

    // Confirm Delete
    function confirmDelete(button) {
        const url = button.getAttribute('data-url');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data siswa akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#145c4f',
            cancelButtonColor: '#a8452f',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Confirm Reset Wajah
    function confirmResetFace(button) {
        if (button.hasAttribute('disabled')) return;

        const url = button.getAttribute('data-url');
        const row = button.closest('tr');
        const nama = row ? row.getAttribute('data-nama') : 'siswa ini';

        Swal.fire({
            title: 'Reset Wajah?',
            html: `Data wajah terdaftar milik <strong>${nama}</strong> akan dihapus. Siswa perlu mendaftar ulang wajahnya. Lanjutkan?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5b2e91',
            cancelButtonColor: '#a8452f',
            confirmButtonText: 'Ya, reset wajah!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `@csrf`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Filter Table Function
    function filterTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const kelasFilter = document.getElementById('kelasFilter').value;
        const jurusanFilter = document.getElementById('jurusanFilter').value;
        const statusFilter = document.getElementById('statusFilter')?.value || '';

        const rows = document.querySelectorAll('#siswaTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            // Skip jika row adalah no-data row
            if (row.classList.contains('no-data-row')) return;

            const nisn = row.querySelector('.nisn')?.textContent.toLowerCase() || '';
            const nama = row.querySelector('.nama')?.textContent.toLowerCase() || '';
            const kelas = row.getAttribute('data-kelas') || '';
            const jurusan = row.getAttribute('data-jurusan') || '';
            const badge = row.querySelector('.badge-status');
            const isHadir = badge && badge.classList.contains('badge-hadir');

            let show = true;

            // Filter by search term
            if (searchTerm && !nisn.includes(searchTerm) && !nama.includes(searchTerm)) {
                show = false;
            }

            // Filter by kelas
            if (kelasFilter && kelas !== kelasFilter) {
                show = false;
            }

            // Filter by jurusan
            if (jurusanFilter && jurusan !== jurusanFilter) {
                show = false;
            }

            // Filter by status
            if (statusFilter === 'hadir' && !isHadir) {
                show = false;
            }
            if (statusFilter === 'belum' && isHadir) {
                show = false;
            }

            if (show) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update info bar
        const totalCount = document.querySelectorAll('#siswaTableBody tr:not(.no-data-row)').length;
        document.getElementById('visibleCount').innerText = visibleCount;
        document.getElementById('totalCount').innerText = totalCount;

        // Update filter badges
        updateFilterBadges(searchTerm, kelasFilter, jurusanFilter, statusFilter);

        // Update statistics berdasarkan data yang terlihat
        updateStatistics();

        // Update bulk buttons
        updateBulkButton();
    }

    // Update filter badges
    function updateFilterBadges(searchTerm, kelasFilter, jurusanFilter, statusFilter) {
        const filterBadges = document.getElementById('filterBadges');
        filterBadges.innerHTML = '';

        if (searchTerm) {
            const badge = createBadge('success', 'search', `"${searchTerm}"`, 'clearSearch()');
            filterBadges.appendChild(badge);
        }

        if (kelasFilter) {
            const badge = createBadge('info', 'chalkboard-user', `Kelas ${kelasFilter}`, 'clearKelas()');
            filterBadges.appendChild(badge);
        }

        if (jurusanFilter) {
            const badge = createBadge('warning', 'book', jurusanFilter, 'clearJurusan()');
            filterBadges.appendChild(badge);
        }

        if (statusFilter) {
            const statusText = statusFilter == 'hadir' ? 'Sudah Absen' : 'Belum Absen';
            const badge = createBadge('success', 'filter', statusText, 'clearStatus()');
            filterBadges.appendChild(badge);
        }
    }

    function createBadge(color, icon, text, onclickFn) {
        const badge = document.createElement('span');
        badge.className = `filter-badge bg-${color} text-white p-2`;
        badge.style.borderRadius = '20px';
        badge.innerHTML = `
            <i class="fas fa-${icon} me-1"></i>
            ${text}
            <i class="fas fa-times-circle ms-2 btn-close-sm" onclick="${onclickFn}"></i>
        `;
        return badge;
    }

    // Clear functions
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        filterTable();
    }

    function clearKelas() {
        document.getElementById('kelasFilter').value = '';
        filterTable();
    }

    function clearJurusan() {
        document.getElementById('jurusanFilter').value = '';
        filterTable();
    }

    function clearStatus() {
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) statusFilter.value = '';
        filterTable();
    }

    // Filter by status from stat card
    function filterByStatus(status) {
        let statusFilter = document.getElementById('statusFilter');
        if (!statusFilter) {
            // Create hidden status filter if not exists
            const filterSection = document.querySelector('.filter-section .row');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.id = 'statusFilter';
            hiddenInput.value = '';
            filterSection.appendChild(hiddenInput);
            statusFilter = hiddenInput;
        }

        if (status === 'all') {
            statusFilter.value = '';
        } else if (status === 'hadir') {
            statusFilter.value = 'hadir';
        } else if (status === 'belum') {
            statusFilter.value = 'belum';
        }

        filterTable();

        // Scroll to table
        document.querySelector('.table-responsive').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Reset filters
    document.getElementById('resetFilterBtn')?.addEventListener('click', function() {
        document.getElementById('searchInput').value = '';
        document.getElementById('kelasFilter').value = '';
        document.getElementById('jurusanFilter').value = '';
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) statusFilter.value = '';
        filterTable();

        Swal.fire({
            icon: 'success',
            title: 'Filter direset',
            text: 'Menampilkan semua data siswa',
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    });

    // Update statistics berdasarkan data yang terlihat
    function updateStatistics() {
        const visibleRows = document.querySelectorAll('#siswaTableBody tr:not(.no-data-row):not([style*="display: none"])');
        let hadir = 0;
        let belum = 0;

        visibleRows.forEach(row => {
            const badge = row.querySelector('.badge-status');
            if (badge && badge.classList.contains('badge-hadir')) {
                hadir++;
            } else if (badge && badge.classList.contains('badge-belum')) {
                belum++;
            }
        });

        const total = hadir + belum;
        const persen = total > 0 ? ((hadir / total) * 100).toFixed(1) : 0;

        document.getElementById('hadirCount').innerHTML = hadir;
        document.getElementById('belumCount').innerHTML = belum;
        document.getElementById('persentaseHadir').innerHTML = persen + '%';
        document.getElementById('totalSiswa').innerHTML = total;

        const progressBar = document.getElementById('progressBar');
        progressBar.style.width = persen + '%';

        // Change progress bar color based on percentage
        if (persen >= 70) {
            progressBar.className = 'progress-bar bg-success';
        } else if (persen >= 40) {
            progressBar.className = 'progress-bar bg-warning';
        } else {
            progressBar.className = 'progress-bar bg-danger';
        }
    }

    // Select All functionality
    document.getElementById('selectAll')?.addEventListener('change', function(e) {
        const visibleRows = document.querySelectorAll('#siswaTableBody tr:not(.no-data-row):not([style*="display: none"])');
        visibleRows.forEach(row => {
            const checkbox = row.querySelector('.siswaCheckbox');
            if (checkbox) {
                checkbox.checked = e.target.checked;
            }
        });
        updateBulkButton();
    });

    function updateBulkButton() {
        const checkboxes = document.querySelectorAll('.siswaCheckbox:checked');
        const count = checkboxes.length;
        const bulkAbsenBtn = document.getElementById('bulkAbsenBtn');

        if (count > 0) {
            if (bulkAbsenBtn) {
                bulkAbsenBtn.style.display = 'inline-flex';
                document.getElementById('selectedCount').innerText = count;
            }
        } else {
            if (bulkAbsenBtn) bulkAbsenBtn.style.display = 'none';
        }
    }

    // Event listener untuk checkbox
    document.querySelectorAll('.siswaCheckbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkButton);
    });

    // Bulk Absen
    function bulkAbsen() {
        const selectedIds = [];
        document.querySelectorAll('.siswaCheckbox:checked').forEach(checkbox => {
            selectedIds.push(checkbox.value);
        });

        if (selectedIds.length === 0) {
            Swal.fire('Peringatan', 'Pilih minimal 1 siswa untuk absen massal', 'warning');
            return;
        }

        Swal.fire({
            title: 'Absen Massal',
            html: `Anda akan mengabsen <strong>${selectedIds.length}</strong> siswa. Lanjutkan?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#145c4f',
            cancelButtonColor: '#a8452f',
            confirmButtonText: 'Ya, absen sekarang!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang mengabsen siswa',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('admin.siswa.update-massal') }}";

                let inputsHtml = `@csrf`;
                selectedIds.forEach(id => {
                    inputsHtml += `<input type="hidden" name="ids[]" value="${id}">`;
                });
                form.innerHTML = inputsHtml;

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Event listeners untuk filter
    document.getElementById('searchInput')?.addEventListener('keyup', filterTable);
    document.getElementById('kelasFilter')?.addEventListener('change', filterTable);
    document.getElementById('jurusanFilter')?.addEventListener('change', filterTable);

    // Show success message
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