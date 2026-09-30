@extends('layouts.app')

@section('title', 'Data Absensi Sholat Siswa')

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
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .container-fluid { font-family: var(--font-body); color: var(--ink); }

    /* ============ CARD ============ */
    .data-card {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid var(--line);
        animation: fadeInUp 0.4s ease-out;
    }

    /* ============ HEADER ============ */
    .card-header-gradient {
        background: #fff;
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid var(--line);
    }

    .card-header-gradient h3 { color: var(--ink); margin: 0; font-weight: 600; font-size: 1.25rem; }
    .card-header-gradient h3 i { color: var(--teal); }
    .card-header-gradient p { color: var(--muted); font-size: 0.82rem; margin: 4px 0 0; }

    /* ============ TABLE ============ */
    .table-custom { margin-bottom: 0; }

    .table-custom thead th {
        background: var(--bg);
        color: var(--ink);
        font-weight: 600;
        border: none;
        padding: 13px 15px;
        font-size: 0.84rem;
    }

    .table-custom tbody tr { border-bottom: 1px solid var(--line); }
    .table-custom tbody tr:hover { background-color: var(--bg); }

    .table-custom tbody td { padding: 12px 15px; vertical-align: middle; }
    .table-custom .tanggal { font-size: 0.86rem; }
    .table-custom td .fa-calendar-alt, .table-custom td .fa-clock, .table-custom td .fa-comment { color: var(--gold) !important; }

    /* ============ BADGES ============ */
    .badge-sholat {
        background: var(--teal-soft);
        padding: 5px 13px;
        border-radius: 20px;
        font-size: 0.74rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--teal);
    }

    .badge-tidak {
        background: var(--rose-soft);
        padding: 5px 13px;
        border-radius: 20px;
        font-size: 0.74rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--rose);
    }

    /* ============ FILTER SECTION ============ */
    .filter-section {
        background: var(--bg);
        padding: 16px 18px;
        border-radius: 12px;
        margin-bottom: 22px;
        border: 1px solid var(--line);
    }

    .filter-row { display: flex; flex-wrap: wrap; align-items: stretch; gap: 12px; }
    .filter-row > .filter-field { flex: 1 1 150px; min-width: 0; }
    .filter-row > .filter-field.field-search { flex: 2 1 220px; }
    .filter-row > .filter-field.field-reset { flex: 0 0 auto; }
    .filter-row .search-input, .filter-row .input-group { height: 42px; }
    .filter-row .input-group .search-input { height: 100%; }

    .search-input {
        border-radius: 10px;
        border: 1px solid var(--line);
        transition: all 0.2s ease;
        padding: 8px 16px;
        height: 42px;
        width: 100%;
        font-size: 0.88rem;
        background: #fff;
        color: var(--ink);
    }

    .search-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(20, 92, 79, 0.12); }

    .input-group-text {
        background: #fff;
        border: 1px solid var(--line);
        border-right: none;
        color: var(--gold);
        height: 42px;
        display: flex;
        align-items: center;
    }

    .btn-reset-filter {
        height: 42px;
        width: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--teal);
        border: none;
        color: #fff;
        transition: background 0.2s ease;
        flex-shrink: 0;
    }
    .btn-reset-filter:hover { background: var(--teal-dark); color: #fff; }

    /* ============ INFO BAR ============ */
    .info-bar {
        background: var(--bg);
        border-radius: 10px;
        padding: 10px 15px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        border-left: 3px solid var(--gold);
        font-size: 0.88rem;
    }

    .info-bar strong { color: var(--ink); }

    /* ============ FILTER BADGES ============ */
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 500;
    }

    .filter-badge i { cursor: pointer; transition: transform 0.15s ease; }
    .filter-badge i:hover { transform: scale(1.15); }

    /* ============ STAT FOOTER ============ */
    .stat-footer { background: var(--bg); border-top: 1px solid var(--line); padding: 1rem; }

    .stat-item {
        padding: 10px;
        border-radius: 10px;
        transition: all 0.2s ease;
        background: #fff;
        border: 1px solid var(--line);
        cursor: pointer;
        text-align: center;
    }
    .stat-item:hover { background: var(--teal-soft); }
    .stat-item h5 { color: var(--ink); font-weight: 700; }

    /* ============ NO DATA ============ */
    .no-data-row td { text-align: center; padding: 60px !important; }
    .no-data-icon { font-size: 56px; margin-bottom: 18px; color: var(--line); }

    /* ============ PROGRESS ============ */
    .progress-custom { height: 8px; border-radius: 10px; background-color: var(--line); }
    .progress-bar-custom { background: var(--teal); border-radius: 10px; transition: width 0.4s ease; }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 768px) {
        .info-bar { flex-direction: column; text-align: center; }
        .table-custom thead th { font-size: 0.74rem; padding: 8px; }
        .table-custom tbody td { font-size: 0.8rem; padding: 8px; }
        .filter-row > .filter-field { flex: 1 1 100%; }
        .filter-row > .filter-field.field-reset { flex: 1 1 100%; }
        .btn-reset-filter { width: 100%; border-radius: 10px; gap: 8px; }
        .btn-reset-filter::after { content: 'Reset Filter'; font-size: 0.85rem; font-weight: 600; }
    }

    /* ============ MODAL ============ */
    .modal-content-custom { border-radius: 14px; overflow: hidden; }

    .modal-header-custom {
        background: var(--teal);
        color: #fff;
        border-bottom: none;
        padding: 15px 20px;
    }
    .modal-header-custom h5 { font-weight: 600; }

    .detail-avatar {
        width: 64px;
        height: 64px;
        background: var(--teal-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    .detail-avatar i { font-size: 28px; color: var(--teal); }

    .detail-row { padding: 10px 0; border-bottom: 1px solid var(--line); }
    .detail-label { font-weight: 600; color: var(--teal); font-size: 0.84rem; margin-bottom: 5px; }
    .detail-value { font-size: 1rem; color: var(--ink); }

    /* ============ BUTTON ============ */
    .btn-export {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 8px 15px;
        transition: background 0.2s ease;
        color: var(--teal);
        font-weight: 600;
    }
    .btn-export:hover { background: var(--teal-soft); color: var(--teal); }
</style>

<div class="container-fluid">
    <div class="data-card card border-0">
        <!-- Card Header -->
        <div class="card-header-gradient">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h3 class="mb-0">
                        <i class="fas fa-chalkboard-user me-2"></i>
                        Data Absensi Sholat Siswa
                    </h3>
                    <p>
                        <i class="fas fa-calendar-alt me-1"></i>
                        Update terakhir: {{ now()->translatedFormat('d F Y H:i:s') }}
                    </p>
                </div>
                <div class="mt-2 mt-md-0">
                    <button class="btn-export" onclick="exportToExcel()">
                        <i class="fas fa-file-excel me-1" style="color: var(--teal);"></i>
                        Export Excel
                    </button>
                    <button class="btn-export ms-2" onclick="window.print()">
                        <i class="fas fa-print me-1" style="color: var(--gold);"></i>
                        Print
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
                            <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                                <i class="fas fa-search" style="color: var(--gold);"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control search-input border-start-0 rounded-end-pill" 
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
            <div class="info-bar">
                <div>
                    <i class="fas fa-chart-line me-2" style="color: var(--gold);"></i>
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
                        @forelse ($absensis as $item)
                            <tr data-id="{{ $item->id }}"
                                data-nama="{{ $item->siswa->nama ?? '-' }}"
                                data-kelas="{{ $item->siswa->kelas ?? '-' }}"
                                data-tanggal="{{ $item->tanggal }}"
                                data-jam="{{ $item->jam_masuk ?? '-' }}"
                                data-status="{{ $item->status }}"
                                data-keterangan="{{ $item->keterangan ?? '-' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td class="nama-siswa">{{ $item->siswa->nama ?? '-' }}</td>
                                <td class="kelas">{{ $item->siswa->kelas ?? '-' }}</td>
                                <td class="tanggal">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                </td>
                                <td class="tanggal">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $item->jam_masuk ?? '-' }}
                                </td>
                                <td>
                                    @if ($item->status == 'Sholat')
                                        <span class="badge-sholat">
                                            <i class="fas fa-check-circle"></i>
                                            Sudah Sholat
                                        </span>
                                    @else
                                        <span class="badge-tidak">
                                            <i class="fas fa-times-circle"></i>
                                            Tidak Sholat
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->keterangan && $item->keterangan != '-')
                                        <span class="text-muted">
                                            <i class="fas fa-comment me-1"></i>
                                            {{ Str::limit($item->keterangan, 30) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-sm" 
                                            onclick="showDetail({{ $item->id }})"
                                            style="background: var(--gold); border: none; border-radius: 8px; padding: 5px 10px; color: white;"
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
                                    <h5 style="color: var(--teal);">Belum ada data absensi</h5>
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
        <div class="card-footer stat-footer">
            <div class="row text-center">
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('all')">
                        <i class="fas fa-chart-line fa-2x mb-2" style="color: var(--teal);"></i>
                        <h5 class="mb-0" id="totalAbsensi">0</h5>
                        <small class="text-muted">Total Absensi</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('Sholat')">
                        <i class="fas fa-check-circle fa-2x mb-2" style="color: var(--teal);"></i>
                        <h5 class="mb-0" id="sholatCount">0</h5>
                        <small class="text-muted">Sudah Sholat</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('Tidak')">
                        <i class="fas fa-times-circle fa-2x mb-2" style="color: var(--rose);"></i>
                        <h5 class="mb-0" id="tidakCount">0</h5>
                        <small class="text-muted">Tidak Sholat</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <i class="fas fa-chart-pie fa-2x mb-2" style="color: var(--gold);"></i>
                        <h5 class="mb-0" id="persentaseSholat">0%</h5>
                        <small class="text-muted">Persentase Kehadiran</small>
                    </div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="mt-3">
                <div class="progress-custom">
                    <div id="progressBar" class="progress-bar-custom" style="width: 0%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header-custom">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Detail Absensi Sholat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="detailModalBody">
                <!-- Content akan diisi via JS -->
            </div>
            <div class="modal-footer" style="border-top: none; justify-content: center;">
                <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill" data-bs-dismiss="modal" style="border-radius: 25px;">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>

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
            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-user-graduate me-2"></i>Nama Siswa
                </div>
                <div class="detail-value fw-bold">${nama}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-chalkboard-user me-2"></i>Kelas
                </div>
                <div class="detail-value">${kelas}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-calendar me-2"></i>Tanggal
                </div>
                <div class="detail-value">${formattedDate}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-clock me-2"></i>Jam Sholat
                </div>
                <div class="detail-value">${jam}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-check-circle me-2"></i>Status
                </div>
                <div class="detail-value">
                    <span class="${isSholat ? 'badge-sholat' : 'badge-tidak'}">
                        <i class="fas ${isSholat ? 'fa-check-circle' : 'fa-times-circle'} me-1"></i>
                        ${isSholat ? 'Sudah Sholat' : 'Tidak Sholat'}
                    </span>
                </div>
            </div>
            ${keterangan !== '-' ? `
            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-comment me-2"></i>Keterangan
                </div>
                <div class="detail-value">${keterangan}</div>
            </div>
            ` : ''}
        `;
        
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    }
    
    // Filter Functions
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
            const kelas = row.querySelector('.kelas')?.textContent || '';
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
        badge.className = `filter-badge bg-${color} text-white me-2 p-2`;
        badge.style.borderRadius = '20px';
        badge.innerHTML = `
            <i class="fas fa-${icon} me-1"></i>
            ${text}
            <i class="fas fa-times-circle ms-2" style="cursor: pointer" onclick="${onclickFn}"></i>
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
    
    function exportToExcel() {
        const table = document.getElementById('example1');
        const ws = XLSX.utils.table_to_sheet(table, { raw: true });
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Data_Absensi');
        XLSX.writeFile(wb, `data_absensi_${new Date().toISOString().split('T')[0]}.xlsx`);
        
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data berhasil diekspor ke Excel',
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }
    
    // Event listeners
    document.getElementById('searchInput')?.addEventListener('keyup', filterTable);
    document.getElementById('kelasFilter')?.addEventListener('change', filterTable);
    document.getElementById('tanggalFilter')?.addEventListener('change', filterTable);
    document.getElementById('statusFilter')?.addEventListener('change', filterTable);
    document.getElementById('bulanFilter')?.addEventListener('change', filterTable);
    
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