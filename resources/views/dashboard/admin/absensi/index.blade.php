@extends('layouts.main')

@section('title', 'Data Absensi Sholat Siswa')

@section('content')
<style>
    .data-card {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .data-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.2rem 1.5rem;
    }
    
    .card-header-custom h3 {
        color: white;
        margin: 0;
        font-weight: 600;
    }
    
    .table-custom {
        margin-bottom: 0;
    }
    
    .table-custom thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        border: none;
        padding: 15px;
        font-size: 0.95rem;
    }
    
    .table-custom tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-custom tbody tr:hover {
        background-color: rgba(102,126,234,0.05);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .table-custom tbody td {
        padding: 12px 15px;
        vertical-align: middle;
    }
    
    .badge-sholat {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
        color: white;
    }
    
    .badge-tidak {
        background: linear-gradient(135deg, #fa709a 0%, #f5576c 100%);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
        color: white;
    }
    
    .filter-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 25px;
    }
    
    .search-input {
        border-radius: 25px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
        padding: 10px 20px;
    }
    
    .search-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
    }
    
    .info-bar {
        background: #e3f2fd;
        border-radius: 10px;
        padding: 8px 15px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .stat-card-footer {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-top: none;
        padding: 1rem;
    }
    
    .stat-item {
        padding: 10px;
        border-radius: 15px;
        transition: all 0.3s ease;
        background: rgba(255,255,255,0.5);
        cursor: pointer;
    }
    
    .stat-item:hover {
        transform: translateY(-5px);
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .no-data-row td {
        text-align: center;
        padding: 60px !important;
        color: #999;
    }
    
    .no-data-icon {
        font-size: 60px;
        margin-bottom: 20px;
        color: #ccc;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card {
        animation: fadeIn 0.5s ease-out;
    }
    
    .btn-action {
        border-radius: 8px;
        padding: 5px 10px;
        transition: all 0.3s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-detail {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }
    
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .filter-badge i {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .filter-badge i:hover {
        transform: scale(1.2);
    }
    
    @media (max-width: 768px) {
        .info-bar {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        
        .table-custom thead th {
            font-size: 0.8rem;
            padding: 10px;
        }
        
        .table-custom tbody td {
            font-size: 0.85rem;
            padding: 8px;
        }
    }
    
    .modal-content {
        border-radius: 20px;
        overflow: hidden;
    }
    
    .detail-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .detail-avatar i {
        font-size: 40px;
        color: white;
    }
    
    .detail-info-row {
        padding: 12px 0;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .detail-info-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #667eea;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }
    
    .detail-value {
        font-size: 1rem;
    }
</style>

<div class="container-fluid">
    <div class="card data-card border-0">
        <!-- Card Header dengan Gradient -->
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h3 class="mb-0">
                        <i class="fas fa-chalkboard-user me-2"></i>
                        Data Absensi Sholat Siswa
                    </h3>
                    <p class="text-white-50 mb-0 mt-2">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Update terakhir: {{ now()->format('d/m/Y H:i:s') }}
                    </p>
                </div>
                <div class="mt-2 mt-md-0">
                    <button class="btn btn-light btn-action" onclick="window.print()" title="Print">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control search-input border-start-0 rounded-end-pill" 
                                   placeholder="Cari nama siswa...">
                        </div>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <select id="kelasFilter" class="form-select search-input">
                            <option value="">Semua Kelas</option>
                            <option value="10">Kelas 10</option>
                            <option value="11">Kelas 11</option>
                            <option value="12">Kelas 12</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <input type="date" id="tanggalFilter" class="form-control search-input">
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <select id="statusFilter" class="form-select search-input">
                            <option value="">Semua Status</option>
                            <option value="Sholat">Sudah Sholat</option>
                            <option value="Tidak">Tidak Sholat</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
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
                    <div class="col-md-1">
                        <button class="btn btn-primary w-100 btn-action" id="resetFilterBtn" style="border-radius: 25px;">
                            <i class="fas fa-undo-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info Bar -->
            <div class="info-bar" id="infoBar">
                <div>
                    <i class="fas fa-chart-line text-primary me-2"></i>
                    Menampilkan <strong id="visibleCount">0</strong> dari <strong id="totalCount">0</strong> data
                </div>
                <div id="filterBadges" class="d-flex flex-wrap gap-2"></div>
            </div>

            <!-- Tabel Data Absensi -->
            <div class="table-responsive">
                <table id="example1" class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
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
                                <td class="nama-siswa">{{ $item->siswa->nama ?? '-' }}</td>
                                <td class="kelas">{{ $item->siswa->kelas ?? '-' }}</td>
                                <td class="tanggal">
                                    <i class="fas fa-calendar-alt text-info me-1"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                </td>
                                <td class="jam">
                                    <i class="fas fa-clock text-info me-1"></i>
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
                                        -
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
                                    <h5>Belum ada data absensi</h5>
                                    <p class="text-muted">Belum ada data absensi sholat yang tersedia</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Jam Sholat</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
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
                        <i class="fas fa-chart-line fa-2x text-primary mb-2"></i>
                        <h5 class="mb-0" id="totalAbsensi">0</h5>
                        <small class="text-muted">Total Absensi</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('Sholat')">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <h5 class="mb-0" id="sholatCount">0</h5>
                        <small class="text-muted">Sudah Sholat</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('Tidak')">
                        <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                        <h5 class="mb-0" id="tidakCount">0</h5>
                        <small class="text-muted">Tidak Sholat</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <i class="fas fa-chart-pie fa-2x text-info mb-2"></i>
                        <h5 class="mb-0" id="persentaseSholat">0%</h5>
                        <small class="text-muted">Persentase Kehadiran</small>
                    </div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="mt-3">
                <div class="progress" style="height: 8px; border-radius: 10px;">
                    <div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 0%; border-radius: 10px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-bottom: none;">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Detail Absensi Sholat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody"></div>
            <div class="modal-footer" style="border-top: none; justify-content: center;">
                <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill" data-bs-dismiss="modal">
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
                    <i class="fas fa-user-graduate me-2"></i>Nama Siswa
                </div>
                <div class="detail-value fw-bold">${nama}</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-label">
                    <i class="fas fa-chalkboard-user me-2"></i>Kelas
                </div>
                <div class="detail-value">${kelas}</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-label">
                    <i class="fas fa-calendar me-2"></i>Tanggal
                </div>
                <div class="detail-value">${formattedDate}</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-label">
                    <i class="fas fa-clock me-2"></i>Jam Sholat
                </div>
                <div class="detail-value">${jam}</div>
            </div>
            <div class="detail-info-row">
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
            <div class="detail-info-row">
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
            const badge = createBadge('primary', 'search', `"${searchTerm}"`, 'clearSearch()');
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
            progressBar.className = 'progress-bar bg-success';
        } else if (persen >= 40) {
            progressBar.className = 'progress-bar bg-warning';
        } else {
            progressBar.className = 'progress-bar bg-danger';
        }
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