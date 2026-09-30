@extends('layouts.main')

@section('title', 'Data Absensi Sholat Siswa')

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
        --gold-soft: #f6efd9;
        --rose: #a8452f;
        --rose-soft: #f6e6e1;

        --font-body: system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
    }

    .container-fluid { font-family: var(--font-body); color: var(--ink); font-variant-numeric: tabular-nums; }

    /* ===== CARD ===== */
    .data-card {
        background: #fff;
        border: 1px solid var(--line) !important;
        border-radius: 14px;
        box-shadow: 0 1px 2px rgba(20, 40, 36, 0.04);
        overflow: hidden;
    }

    .card-header-custom { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--line); background: #fff; }
    .card-header-custom h3 { margin: 0; font-size: 1.2rem; font-weight: 600; color: var(--ink); }
    .card-header-custom h3 i { color: var(--teal); }
    .card-header-custom p { margin: 4px 0 0; font-size: 0.8rem; color: var(--muted) !important; }

    .header-actions { display: flex; flex-wrap: wrap; gap: 8px; }

    .btn-header-action {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 8px 14px;
        font-weight: 500;
        font-size: 0.82rem;
        color: var(--ink);
        transition: background 0.2s ease, border-color 0.2s ease;
        white-space: nowrap;
    }
    .btn-header-action:hover { background: var(--bg); border-color: #d3cfc2; color: var(--ink); }
    .btn-header-action.export-excel i { color: #1d6f42; }
    .btn-header-action.print-action i { color: var(--muted); }

    /* ===== FILTER ===== */
    .filter-section {
        background: var(--bg);
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 1px solid var(--line);
    }

    .filter-row { display: flex; flex-wrap: wrap; align-items: stretch; gap: 10px; }
    .filter-row > .filter-field { flex: 1 1 150px; min-width: 0; }
    .filter-row > .filter-field.field-search { flex: 2 1 220px; }
    .filter-row > .filter-field.field-reset { flex: 0 0 auto; }
    .filter-row .search-input, .filter-row .input-group { height: 40px; }
    .filter-row .input-group .search-input { height: 100%; }

    .search-input {
        border-radius: 10px;
        border: 1px solid var(--line);
        padding: 8px 14px;
        background: #fff;
        font-size: 0.88rem;
        color: var(--ink);
        height: 40px;
        width: 100%;
    }
    .search-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(20, 92, 79, 0.12); }

    .input-group-text {
        background: #fff;
        border: 1px solid var(--line);
        border-right: none;
        color: var(--muted);
        border-radius: 10px 0 0 10px;
        height: 40px;
        display: flex;
        align-items: center;
    }
    .input-group .search-input { border-left: none; border-radius: 0 10px 10px 0; }

    .btn-reset-filter {
        height: 40px;
        width: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--teal);
        border: none;
        color: #fff;
        flex-shrink: 0;
        transition: background 0.2s ease;
    }
    .btn-reset-filter:hover { background: #0f4a41; color: #fff; }

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
    .info-bar i { color: var(--muted) !important; }
    .info-bar strong { color: var(--ink); font-weight: 600; }

    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 500;
        background: #fff;
        border: 1px solid var(--line);
    }
    .filter-badge i { cursor: pointer; }
    .filter-badge i:hover { opacity: 0.7; }

    /* ===== TABLE ===== */
    .table-custom { margin-bottom: 0; }

    .table-custom thead th, .table-custom tfoot th {
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
    .table-custom .jam, .table-custom .tanggal { font-size: 0.86rem; }
    .table-custom i.fa-calendar-alt, .table-custom i.fa-clock, .table-custom i.fa-comment { color: var(--muted) !important; }

    .badge.bg-success.bg-opacity-10 { background: var(--teal-soft) !important; color: var(--teal) !important; font-weight: 500; }

    .badge-sholat, .badge-tidak {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-sholat { background: var(--teal-soft); color: var(--teal); }
    .badge-tidak { background: var(--rose-soft); color: var(--rose); }

    .btn-action { border-radius: 8px; padding: 6px 10px; border: none; transition: background 0.15s ease; }
    .btn-detail { background: var(--gold-soft); color: var(--gold); padding: 6px 10px; border-radius: 8px; border: none; }
    .btn-detail:hover { background: #efe3bb; color: var(--gold); }

    .no-data-row td { text-align: center; padding: 60px !important; color: var(--muted); }
    .no-data-icon { font-size: 48px; margin-bottom: 16px; color: var(--line); }

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
    .progress-bar { background: var(--teal); border-radius: 10px; transition: width 0.6s ease; }

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

    .detail-avatar {
        width: 64px;
        height: 64px;
        background: var(--teal-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
    }
    .detail-avatar i { font-size: 28px; color: var(--teal); }

    .detail-info-row { padding: 12px 0; border-bottom: 1px solid var(--line); }
    .detail-info-row:last-child { border-bottom: none; }
    .detail-label { font-weight: 500; color: var(--muted); font-size: 0.8rem; margin-bottom: 4px; }
    .detail-label i { margin-right: 8px; color: var(--muted); }
    .detail-value { font-size: 0.96rem; color: var(--ink); }

    .btn-primary-custom {
        background: var(--teal);
        border: none;
        color: #fff;
        border-radius: 10px;
        padding: 8px 20px;
        transition: background 0.2s ease;
    }
    .btn-primary-custom:hover { background: #0f4a41; color: #fff; }

    /* ===== PAGINATION ===== */
    .pagination .page-link { color: var(--teal); border-color: var(--line); }
    .pagination .page-item.active .page-link { background: var(--teal); border-color: var(--teal); color: #fff; }
    .pagination .page-link:hover { background: var(--teal-soft); border-color: var(--teal); color: var(--teal); }

    /* Hide default DataTables Buttons toolbar and length/search UI if this
       page's table is also initialized as a DataTable elsewhere (dom:
       'Bfrtip' with Copy/CSV/Excel/PDF/Print/colvis) - keeps only our
       custom Export Excel / Print buttons above and our custom filters. */
    .dt-buttons,
    .dataTables_length,
    .dataTables_filter {
        display: none !important;
    }

    /* Excel export uses a temporary hidden <table> - never show it */
    #excelExportTable { display: none !important; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .info-bar { flex-direction: column; text-align: center; gap: 10px; }
        .table-custom thead th { font-size: 0.7rem; padding: 10px; }
        .table-custom tbody td { font-size: 0.82rem; padding: 8px; }
        .filter-section { padding: 12px; }
        .filter-row > .filter-field { flex: 1 1 100%; }
        .filter-row > .filter-field.field-reset { flex: 1 1 100%; }
        .btn-reset-filter { width: 100%; gap: 8px; }
        .btn-reset-filter::after { content: 'Reset Filter'; font-size: 0.85rem; font-weight: 600; }
        .header-actions { width: 100%; }
        .btn-header-action { flex: 1 1 auto; justify-content: center; padding: 12px 16px; min-height: 44px; }
    }

    @media (max-width: 380px) {
        .btn-header-action { padding: 12px 10px; font-size: 0.8rem; }
    }
</style>

<div class="container-fluid">
    <div class="card data-card border-0">
        <!-- Card Header -->
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-0">
                        <i class="fas fa-chalkboard-user me-2"></i>
                        Data Absensi Sholat Siswa
                    </h3>
                    <p class="mb-0">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Update terakhir: {{ now()->format('d/m/Y H:i:s') }}
                    </p>
                </div>
                <div class="header-actions">
                    <button class="btn-header-action export-excel" onclick="exportToExcel()" title="Export Excel">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button class="btn-header-action print-action" onclick="window.print()" title="Print">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-row">
                    <div class="filter-field field-search">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control search-input border-start-0"
                                   placeholder="Cari nama siswa...">
                        </div>
                    </div>
                    <div class="filter-field">
                        <select id="kelasFilter" class="form-select search-input">
                            <option value="">Semua Kelas</option>
                            <option value="10">Kelas 10</option>
                            <option value="11">Kelas 11</option>
                            <option value="12">Kelas 12</option>
                        </select>
                    </div>
                    <div class="filter-field">
                        <input type="date" id="tanggalFilter" class="form-control search-input">
                    </div>
                    <div class="filter-field">
                        <select id="statusFilter" class="form-select search-input">
                            <option value="">Semua Status</option>
                            <option value="Sholat">Sudah Sholat</option>
                            <option value="Tidak">Tidak Sholat</option>
                        </select>
                    </div>
                    <div class="filter-field">
                        <select id="bulanFilter" class="form-select search-input">
                            <option value="">Semua Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="filter-field field-reset">
                        <button class="btn-reset-filter" id="resetFilterBtn" title="Reset Filter">
                            <i class="fas fa-undo-alt"></i>
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

            <!-- Tabel Data Absensi -->
            <div class="table-responsive">
                <table id="example1" class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Jam Sholat</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="absensiTableBody">
                        @php $no = 1; @endphp
                        @forelse ($absensis as $item)
                            <tr data-id="{{ $item->id }}"
                                data-nama="{{ $item->siswa->nama ?? '-' }}"
                                data-kelas="{{ $item->siswa->kelas ?? '-' }}"
                                data-tanggal="{{ $item->tanggal }}"
                                data-jam="{{ $item->jam_masuk ?? '-' }}"
                                data-status="{{ $item->status }}"
                                data-keterangan="{{ $item->keterangan ?? '-' }}">
                                <td>{{ $no++ }}</td>
                                <td class="nama-siswa fw-semibold">{{ $item->siswa->nama ?? '-' }}</td>
                                <td class="kelas">
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        {{ $item->siswa->kelas ?? '-' }}
                                    </span>
                                </td>
                                <td class="tanggal">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                </td>
                                <td class="jam">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $item->jam_masuk ?? '-' }}
                                </td>
                                <td>
                                    @if ($item->status == 'Sholat')
                                        <span class="badge-sholat">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Sudah Sholat
                                        </span>
                                    @else
                                        <span class="badge-tidak">
                                            <i class="fas fa-times-circle me-1"></i>
                                            Tidak Sholat
                                        </span>
                                    @endif
                                </td>
                                <td class="keterangan">
                                    @if($item->keterangan && $item->keterangan != '-')
                                        <span class="text-muted">
                                            <i class="fas fa-comment me-1"></i>
                                            {{ Str::limit($item->keterangan, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-detail btn-action"
                                            onclick="showDetail({{ $item->id }})"
                                            title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-data-row">
                                <td colspan="8">
                                    <div class="no-data-icon">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                    <h5 style="color: var(--ink);">Belum ada data absensi</h5>
                                    <p class="text-muted">Belum ada data absensi sholat yang tersedia</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($absensis) && method_exists($absensis, 'links'))
                <div class="mt-4 d-flex justify-content-center">
                    {{ $absensis->links() }}
                </div>
            @endif
        </div>

        <!-- Card Footer dengan Statistik -->
        <div class="card-footer stat-card-footer">
            <div class="row text-center">
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('all')">
                        <i class="fas fa-chart-line fa-2x mb-2" style="color: var(--teal);"></i>
                        <h5 class="mb-0" id="totalAbsensi">0</h5>
                        <small>Total Absensi</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('Sholat')">
                        <i class="fas fa-check-circle fa-2x mb-2" style="color: var(--teal);"></i>
                        <h5 class="mb-0" id="sholatCount">0</h5>
                        <small>Sudah Sholat</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('Tidak')">
                        <i class="fas fa-times-circle fa-2x mb-2" style="color: var(--rose);"></i>
                        <h5 class="mb-0" id="tidakCount">0</h5>
                        <small>Tidak Sholat</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <i class="fas fa-chart-pie fa-2x mb-2" style="color: var(--gold);"></i>
                        <h5 class="mb-0" id="persentaseSholat">0%</h5>
                        <small>Persentase Kehadiran</small>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-3">
                <div class="progress">
                    <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
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
                    <i class="fas fa-clipboard-list me-2"></i>
                    Detail Absensi Sholat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody" style="padding: 1.5rem;"></div>
            <div class="modal-footer" style="border-top: 1px solid var(--line); justify-content: center; padding: 1rem 1.5rem;">
                <button type="button" class="btn btn-primary-custom px-4 py-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalCount = document.querySelectorAll('#absensiTableBody tr:not(.no-data-row)').length;
        document.getElementById('totalCount').innerText = totalCount;
        document.getElementById('visibleCount').innerText = totalCount;
        document.getElementById('totalAbsensi').innerText = totalCount;

        filterTable();
        updateStatistics();
    });

    // Show Detail Modal
    function showDetail(id) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (!row) return;

        const nama = row.getAttribute('data-nama') || '-';
        const kelas = row.getAttribute('data-kelas') || '-';
        const tanggal = row.getAttribute('data-tanggal') || '-';
        const jam = row.getAttribute('data-jam') || '-';
        const status = row.getAttribute('data-status') || '-';
        const keterangan = row.getAttribute('data-keterangan') || '-';

        const formattedDate = tanggal !== '-' ? new Date(tanggal).toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }) : '-';

        const isSholat = status === 'Sholat';

        const modalBody = document.getElementById('detailModalBody');
        modalBody.innerHTML = `
            <div class="detail-avatar">
                <i class="fas fa-mosque"></i>
            </div>
            <div class="detail-info-row">
                <div class="detail-label">
                    <i class="fas fa-user-graduate"></i>Nama Siswa
                </div>
                <div class="detail-value fw-bold">${nama}</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-label">
                    <i class="fas fa-chalkboard-user"></i>Kelas
                </div>
                <div class="detail-value">${kelas}</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-label">
                    <i class="fas fa-calendar"></i>Tanggal
                </div>
                <div class="detail-value">${formattedDate}</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-label">
                    <i class="fas fa-clock"></i>Jam Sholat
                </div>
                <div class="detail-value">${jam}</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-label">
                    <i class="fas fa-check-circle"></i>Status
                </div>
                <div class="detail-value">
                    <span class="${isSholat ? 'badge-sholat' : 'badge-tidak'}">
                        <i class="fas ${isSholat ? 'fa-check-circle' : 'fa-times-circle'} me-1"></i>
                        ${isSholat ? 'Sudah Sholat' : 'Tidak Sholat'}
                    </span>
                </div>
            </div>
            ${keterangan !== '-' ? `
            <div class="detail-info-row">
                <div class="detail-label">
                    <i class="fas fa-comment"></i>Keterangan
                </div>
                <div class="detail-value">${keterangan}</div>
            </div>
            ` : ''}
        `;

        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    }

    // Filter Table Function
    function filterTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const kelasFilter = document.getElementById('kelasFilter').value;
        const tanggalFilter = document.getElementById('tanggalFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        const bulanFilter = document.getElementById('bulanFilter').value;

        const rows = document.querySelectorAll('#absensiTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.classList.contains('no-data-row')) return;

            const nama = row.querySelector('.nama-siswa')?.textContent.toLowerCase() || '';
            const kelas = row.querySelector('.kelas')?.textContent.trim() || '';
            const tanggal = row.getAttribute('data-tanggal') || '';
            const status = row.getAttribute('data-status') || '';
            const bulan = tanggal ? tanggal.substring(5, 7) : '';

            let show = true;

            if (searchTerm && !nama.includes(searchTerm)) show = false;
            if (kelasFilter && kelas !== kelasFilter) show = false;
            if (tanggalFilter && tanggal !== tanggalFilter) show = false;
            if (statusFilter && status !== statusFilter) show = false;
            if (bulanFilter && bulan !== bulanFilter) show = false;

            if (show) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const totalCount = document.querySelectorAll('#absensiTableBody tr:not(.no-data-row)').length;
        document.getElementById('visibleCount').innerText = visibleCount;
        document.getElementById('totalCount').innerText = totalCount;

        updateFilterBadges(searchTerm, kelasFilter, tanggalFilter, statusFilter, bulanFilter);
        updateStatistics();
    }

    function updateFilterBadges(searchTerm, kelasFilter, tanggalFilter, statusFilter, bulanFilter) {
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

        if (tanggalFilter) {
            const formattedDate = new Date(tanggalFilter).toLocaleDateString('id-ID');
            const badge = createBadge('success', 'calendar', formattedDate, 'clearTanggal()');
            filterBadges.appendChild(badge);
        }

        if (statusFilter) {
            const statusText = statusFilter === 'Sholat' ? 'Sudah Sholat' : 'Tidak Sholat';
            const badge = createBadge('dark', 'filter', statusText, 'clearStatus()');
            filterBadges.appendChild(badge);
        }

        if (bulanFilter) {
            const bulanNames = {
                '01': 'Januari', '02': 'Februari', '03': 'Maret', '04': 'April',
                '05': 'Mei', '06': 'Juni', '07': 'Juli', '08': 'Agustus',
                '09': 'September', '10': 'Oktober', '11': 'November', '12': 'Desember'
            };
            const badge = createBadge('warning', 'calendar-alt', bulanNames[bulanFilter], 'clearBulan()');
            filterBadges.appendChild(badge);
        }
    }

    function createBadge(color, icon, text, onclickFn) {
        const badge = document.createElement('span');
        badge.className = `filter-badge`;
        badge.innerHTML = `
            <i class="fas fa-${icon} text-${color} me-1"></i>
            ${text}
            <i class="fas fa-times-circle text-danger ms-2" style="cursor: pointer" onclick="${onclickFn}"></i>
        `;
        return badge;
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        filterTable();
    }

    function clearKelas() {
        document.getElementById('kelasFilter').value = '';
        filterTable();
    }

    function clearTanggal() {
        document.getElementById('tanggalFilter').value = '';
        filterTable();
    }

    function clearStatus() {
        document.getElementById('statusFilter').value = '';
        filterTable();
    }

    function clearBulan() {
        document.getElementById('bulanFilter').value = '';
        filterTable();
    }

    function filterByStatus(status) {
        if (status === 'all') {
            document.getElementById('statusFilter').value = '';
        } else {
            document.getElementById('statusFilter').value = status;
        }
        filterTable();
        document.querySelector('.table-responsive').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    document.getElementById('resetFilterBtn')?.addEventListener('click', function() {
        document.getElementById('searchInput').value = '';
        document.getElementById('kelasFilter').value = '';
        document.getElementById('tanggalFilter').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('bulanFilter').value = '';
        filterTable();

        Swal.fire({
            icon: 'success',
            title: 'Filter direset',
            text: 'Menampilkan semua data absensi',
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    });

    function updateStatistics() {
        const visibleRows = document.querySelectorAll('#absensiTableBody tr:not(.no-data-row):not([style*="display: none"])');
        let sholat = 0;
        let tidak = 0;

        visibleRows.forEach(row => {
            const status = row.getAttribute('data-status');
            if (status === 'Sholat') sholat++;
            else if (status === 'Tidak') tidak++;
        });

        const total = sholat + tidak;
        const persen = total > 0 ? ((sholat / total) * 100).toFixed(1) : 0;

        document.getElementById('sholatCount').innerHTML = sholat;
        document.getElementById('tidakCount').innerHTML = tidak;
        document.getElementById('persentaseSholat').innerHTML = persen + '%';
        document.getElementById('totalAbsensi').innerHTML = total;

        const progressBar = document.getElementById('progressBar');
        progressBar.style.width = persen + '%';

        if (persen >= 70) {
            progressBar.style.background = '#145c4f';
        } else if (persen >= 40) {
            progressBar.style.background = '#b08d2a';
        } else {
            progressBar.style.background = '#a8452f';
        }
    }

    // Event listeners
    document.getElementById('searchInput')?.addEventListener('keyup', filterTable);
    document.getElementById('kelasFilter')?.addEventListener('change', filterTable);
    document.getElementById('tanggalFilter')?.addEventListener('change', filterTable);
    document.getElementById('statusFilter')?.addEventListener('change', filterTable);
    document.getElementById('bulanFilter')?.addEventListener('change', filterTable);

    // ============ EXPORT EXCEL (custom button, no plugin needed) ============
    // Membuat file .xls berisi baris-baris yang SEDANG TERLIHAT (sesuai
    // filter aktif), lewat tabel HTML sederhana yang dibungkus sebagai
    // Excel Workbook - dibuka Excel/Sheets tanpa perlu library tambahan.
    function exportToExcel() {
        const visibleRows = document.querySelectorAll('#absensiTableBody tr:not(.no-data-row):not([style*="display: none"])');

        if (visibleRows.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak ada data',
                text: 'Tidak ada data absensi untuk diekspor pada filter saat ini',
                confirmButtonColor: '#145c4f'
            });
            return;
        }

        const headers = ['No', 'Nama Siswa', 'Kelas', 'Tanggal', 'Jam Sholat', 'Status', 'Keterangan'];

        let rowsHtml = '';
        let no = 1;
        visibleRows.forEach(row => {
            const nama = row.getAttribute('data-nama') || '-';
            const kelas = row.getAttribute('data-kelas') || '-';
            const tanggal = row.getAttribute('data-tanggal') || '-';
            const jam = row.getAttribute('data-jam') || '-';
            const status = row.getAttribute('data-status') === 'Sholat' ? 'Sudah Sholat' : 'Tidak Sholat';
            const keterangan = row.getAttribute('data-keterangan') || '-';

            rowsHtml += `
                <tr>
                    <td>${no++}</td>
                    <td>${escapeHtml(nama)}</td>
                    <td>${escapeHtml(kelas)}</td>
                    <td>${escapeHtml(tanggal)}</td>
                    <td>${escapeHtml(jam)}</td>
                    <td>${escapeHtml(status)}</td>
                    <td>${escapeHtml(keterangan)}</td>
                </tr>`;
        });

        const excelHtml = `
            <table border="1">
                <thead>
                    <tr>${headers.map(h => `<th>${h}</th>`).join('')}</tr>
                </thead>
                <tbody>${rowsHtml}</tbody>
            </table>`;

        const template = `
            <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
            <head><meta charset="UTF-8"></head>
            <body>${excelHtml}</body>
            </html>`;

        const blob = new Blob(['\ufeff' + template], { type: 'application/vnd.ms-excel' });
        const url = URL.createObjectURL(blob);

        const today = new Date().toISOString().split('T')[0];
        const a = document.createElement('a');
        a.href = url;
        a.download = `absensi-sholat-${today}.xls`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data absensi berhasil diekspor',
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

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
</script>

@endsection