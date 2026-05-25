@extends('layouts.main')

@section('title', 'Data Siswa')

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
    
    .btn-action {
        border-radius: 12px;
        padding: 8px 16px;
        transition: all 0.3s ease;
        margin: 0 2px;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-create {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
    
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102,126,234,0.4);
    }
    
    .stat-card-footer {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-top: none;
        padding: 1rem;
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
    
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-hadir {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .badge-belum {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #fa709a 0%, #f5576c 100%);
        border: none;
        color: white;
    }
    
    .btn-detail {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
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
    
    /* No data row style */
    .no-data-row td {
        text-align: center;
        padding: 40px !important;
        color: #999;
        font-style: italic;
    }
    
    /* Info bar */
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
    
    /* Highlight animation */
    @keyframes highlight {
        0% {
            background-color: #fff3cd;
        }
        100% {
            background-color: transparent;
        }
    }
    
    .highlight-row {
        animation: highlight 1s ease-out;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .info-bar {
            flex-direction: column;
            text-align: center;
        }
        
        .btn-group {
            flex-wrap: wrap;
        }
        
        .btn-action {
            margin-bottom: 5px;
        }
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
                    <p class="text-white-50 mb-0 mt-2">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Update terakhir: {{ now()->format('d/m/Y H:i:s') }}
                    </p>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('admin.siswa.create') }}" class="btn btn-create text-white">
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
                            <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control search-input border-start-0 rounded-end-pill" 
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
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                            <option value="Bahasa">Bahasa</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100 btn-action" id="resetFilterBtn">
                            <i class="fas fa-undo-alt me-2"></i>
                            Reset
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
                <div id="filterBadges"></div>
            </div>

            <!-- Tabel Data Siswa -->
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th style="width: 50px">#</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Status Absensi</th>
                            <th style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="siswaTableBody">
                        @forelse ($siswas as $item)
                            <tr data-id="{{ $item->id }}" 
                                data-kelas="{{ $item->kelas }}" 
                                data-jurusan="{{ $item->jurusan }}"
                                data-nisn="{{ $item->nisn }}"
                                data-nama="{{ $item->user->name ?? 'Tidak ada user' }}">
                                <td>
                                    <input type="checkbox" class="siswaCheckbox" value="{{ $item->id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td class="nisn">{{ $item->nisn }}</td>
                                <td class="nama">{{ $item->user->name ?? 'Tidak ada user' }}</td>
                                <td class="kelas">{{ $item->kelas }}</td>
                                <td class="jurusan">{{ $item->jurusan }}</td>
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
                                           class="btn btn-sm btn-edit btn-action"
                                           data-bs-toggle="tooltip" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-delete btn-action"
                                                onclick="confirmDelete({{ $item->id }})"
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
                                    <h5>Belum ada data siswa</h5>
                                    <p class="text-muted">Silakan tambah siswa baru dengan mengklik tombol "Tambah Siswa Baru"</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="text-end">
                                <button class="btn btn-success btn-action" onclick="bulkAbsen()" id="bulkAbsenBtn" style="display: none;">
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
                        <i class="fas fa-users fa-2x text-primary mb-2"></i>
                        <h5 class="mb-0" id="totalSiswa">{{ $siswas->count() }}</h5>
                        <small class="text-muted">Total Siswa</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('hadir')">
                        <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                        <h5 class="mb-0" id="hadirCount">0</h5>
                        <small class="text-muted">Sudah Absen</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="stat-item" onclick="filterByStatus('belum')">
                        <i class="fas fa-user-clock fa-2x text-warning mb-2"></i>
                        <h5 class="mb-0" id="belumCount">0</h5>
                        <small class="text-muted">Belum Absen</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                        <h5 class="mb-0" id="persentaseHadir">0%</h5>
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
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-user-graduate me-2"></i>
                    Detail Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <!-- Content akan diisi via JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <a href="#" id="editLink" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Data
                </a>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
        const id = row.getAttribute('data-id');
        const nisn = row.getAttribute('data-nisn');
        const nama = row.getAttribute('data-nama');
        const kelas = row.getAttribute('data-kelas');
        const jurusan = row.getAttribute('data-jurusan');
        const statusBadge = row.querySelector('.badge-status');
        const statusText = statusBadge ? statusBadge.innerText.trim() : 'Tidak diketahui';
        const statusClass = statusBadge ? (statusBadge.classList.contains('badge-hadir') ? 'hadir' : 'belum') : '';
        
        const modalBody = document.getElementById('detailModalBody');
        modalBody.innerHTML = `
            <div class="text-center mb-3">
                <div class="rounded-circle bg-light d-inline-flex p-3 mb-3">
                    <i class="fas fa-user-graduate fa-3x" style="color: #667eea;"></i>
                </div>
            </div>
            <table class="table table-borderless">
                <tr>
                    <td width="35%"><strong><i class="fas fa-id-card me-2"></i>NISN</strong></td>
                    <td>: <span class="text-primary fw-bold">${nisn}</span></td>
                </tr>
                <tr>
                    <td><strong><i class="fas fa-user me-2"></i>Nama Lengkap</strong></td>
                    <td>: ${nama}</td>
                </tr>
                <tr>
                    <td><strong><i class="fas fa-chalkboard-user me-2"></i>Kelas</strong></td>
                    <td>: ${kelas}</td>
                </tr>
                <tr>
                    <td><strong><i class="fas fa-book me-2"></i>Jurusan</strong></td>
                    <td>: ${jurusan}</td>
                </tr>
                <tr>
                    <td><strong><i class="fas fa-clipboard-list me-2"></i>Status Absensi</strong></td>
                    <td>: <span class="badge-status ${statusClass == 'hadir' ? 'badge-hadir' : 'badge-belum'}">${statusText}</span></td>
                </tr>
            </table>
        `;
        
        // Update edit link
        const editLink = document.getElementById('editLink');
        editLink.href = `{{ url('admin/siswa') }}/${id}/edit`;
        
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    }
    
    // Confirm Delete
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data siswa akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin/siswa') }}/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
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
            const badge = document.createElement('span');
            badge.className = 'badge bg-primary me-2 p-2';
            badge.innerHTML = `<i class="fas fa-search me-1"></i> "${searchTerm}" <i class="fas fa-times-circle ms-1" style="cursor:pointer" onclick="clearSearch()"></i>`;
            filterBadges.appendChild(badge);
        }
        
        if (kelasFilter) {
            const badge = document.createElement('span');
            badge.className = 'badge bg-info me-2 p-2';
            badge.innerHTML = `<i class="fas fa-chalkboard-user me-1"></i> Kelas ${kelasFilter} <i class="fas fa-times-circle ms-1" style="cursor:pointer" onclick="clearKelas()"></i>`;
            filterBadges.appendChild(badge);
        }
        
        if (jurusanFilter) {
            const badge = document.createElement('span');
            badge.className = 'badge bg-warning me-2 p-2';
            badge.innerHTML = `<i class="fas fa-book me-1"></i> ${jurusanFilter} <i class="fas fa-times-circle ms-1" style="cursor:pointer" onclick="clearJurusan()"></i>`;
            filterBadges.appendChild(badge);
        }
        
        if (statusFilter) {
            const badge = document.createElement('span');
            badge.className = 'badge bg-success me-2 p-2';
            badge.innerHTML = `<i class="fas fa-filter me-1"></i> ${statusFilter == 'hadir' ? 'Sudah Absen' : 'Belum Absen'} <i class="fas fa-times-circle ms-1" style="cursor:pointer" onclick="clearStatus()"></i>`;
            filterBadges.appendChild(badge);
        }
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
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
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
                form.innerHTML = `
                    @csrf
                    <input type="hidden" name="ids" value='${JSON.stringify(selectedIds)}'>
                    <input type="hidden" name="status" value="hadir">
                `;
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