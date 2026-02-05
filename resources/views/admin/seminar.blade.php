@extends('layouts.admin_app')

@section('content')
@section('header_title', 'Manajemen Seminar')
@section('header_subtitle', 'Kelola data seminar dan validasi pendaftaran')
    <div class="container-fluid py-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 text-dark">
                {{-- Header Manajemen Seminar --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Manajemen Seminar</h4>
                        <p class="text-muted small mb-0">Kelola data seminar dan atur poin untuk setiap kategori</p>
                    </div>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal"
                        data-bs-target="#modalTambahSeminar" style="background-color: #6366f1; border: none;">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Seminar
                    </button>
                </div>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table align-middle table-hover-custom">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>JUDUL SEMINAR</th>
                                <th>KATEGORI</th>
                                <th>PELAKSANAAN</th>
                                <th>POIN</th>
                                <th class="text-center">KUOTA</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($seminars as $s)
                                {{-- Baris Tabel (Bisa diklik untuk lihat pendaftar) --}}
                                <tr class="clickable-row" data-id="{{ $s->kode_seminar }}" style="cursor: pointer;">
                                    <td class="ps-3 fw-bold small text-dark">{{ $s->kode_seminar }}</td>
                                    <td>
                                        <div class="fw-bold text-dark mb-0 text-truncate" style="max-width: 250px;">
                                            {{ $s->nama_seminar }}</div>
                                        <small class="text-muted small">{{ $s->penyelenggara }}</small>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2 small"
                                            style="background: #eff6ff; color: #3b82f6">
                                            {{ $s->kategori_seminar }}
                                        </span>
                                    </td>
                                    <td class="small fw-bold text-dark">
                                        {{ \Carbon\Carbon::parse($s->tgl_seminar)->format('d M Y') }}</td>
                                    <td class="fw-bold text-indigo small">{{ $s->poin_seminar }} Poin</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border shadow-sm px-3 py-2 fw-bold"
                                            style="border-radius: 8px;">
                                            {{ $s->pendaftarans_count ?? 0 }}/{{ $s->kapasitas }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $s->tgl_seminar >= now() ? 'bg-success-light text-success' : 'bg-light text-secondary' }} rounded-pill px-3">
                                            {{ $s->tgl_seminar >= now() ? 'Aktif' : 'Selesai' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Tombol Edit --}}
                                            <button class="btn btn-sm text-primary p-0 btn-action btn-edit"
                                                data-id="{{ $s->kode_seminar }}" title="Edit Seminar">
                                                <i class="bi bi-pencil fs-5"></i>
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <button class="btn btn-sm text-danger p-0 btn-action btn-delete"
                                                data-id="{{ $s->kode_seminar }}" data-nama="{{ $s->nama_seminar }}"
                                                title="Hapus Seminar">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted small">Belum ada data seminar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODAL & FORM SECTION --}}
    {{-- ============================================================ --}}

    {{-- 1. FORM HAPUS (Hidden) --}}
    <form id="formDelete" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- 2. MODAL TAMBAH SEMINAR --}}
    <div class="modal fade" id="modalTambahSeminar" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 text-dark">
                <form action="{{ route('admin.seminar.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <h5 class="fw-bold mb-4">Tambah Seminar Baru</h5>
                        <div class="row g-3">
                            {{-- Form Inputs --}}
                            <div class="col-md-6">
                                <label class="small fw-bold">Judul Seminar *</label>
                                <input type="text" name="nama_seminar" class="form-control"
                                    placeholder="Contoh: AI Tech Summit" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold">Penyelenggara *</label>
                                <input type="text" name="penyelenggara" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-success">Pendaftaran Dibuka *</label>
                                <input type="date" name="tgl_dibuka" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-danger">Pendaftaran Ditutup *</label>
                                <input type="date" name="tgl_ditutup" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Tanggal Pelaksanaan *</label>
                                <input type="date" name="tgl_seminar" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Kategori *</label>
                                <select name="kategori_seminar" id="selectKategori" class="form-select" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="Internasional">Internasional (10 Poin)</option>
                                    <option value="Nasional">Nasional (7 Poin)</option>
                                    <option value="Regional/Daerah">Regional/Daerah (5 Poin)</option>
                                    <option value="Internal">Internal (3 Poin)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-indigo">Poin Seminar (Otomatis)</label>
                                <input type="number" name="poin_seminar" id="inputPoin" class="form-control bg-light"
                                    readonly required>
                            </div>
                            <div class="col-md-8">
                                <label class="small fw-bold">Lokasi *</label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Gedung / Link Zoom"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Kuota Peserta *</label>
                                <input type="number" name="kapasitas" class="form-control" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold"
                            style="background: #6366f1;">Simpan Seminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 3. MODAL EDIT SEMINAR --}}
    <div class="modal fade" id="modalEditSeminar" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 text-dark">
                <form id="formEditSeminar" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body p-4">
                        <h5 class="fw-bold mb-4">Edit Data Seminar</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold">Judul Seminar</label>
                                <input type="text" name="nama_seminar" id="edit_nama_seminar" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold">Penyelenggara</label>
                                <input type="text" name="penyelenggara" id="edit_penyelenggara" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-success">Pendaftaran Dibuka</label>
                                <input type="date" name="tgl_dibuka" id="edit_tgl_dibuka" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-danger">Pendaftaran Ditutup</label>
                                <input type="date" name="tgl_ditutup" id="edit_tgl_ditutup" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Tanggal Pelaksanaan</label>
                                <input type="date" name="tgl_seminar" id="edit_tgl_seminar" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Kategori</label>
                                <select name="kategori_seminar" id="edit_kategori" class="form-select" required>
                                    <option value="Internasional">Internasional</option>
                                    <option value="Nasional">Nasional</option>
                                    <option value="Regional/Daerah">Regional/Daerah</option>
                                    <option value="Internal">Internal</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Poin</label>
                                <input type="number" name="poin_seminar" id="edit_poin" class="form-control bg-light"
                                    readonly>
                            </div>
                            <div class="col-md-8">
                                <label class="small fw-bold">Lokasi</label>
                                <input type="text" name="lokasi" id="edit_lokasi" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Kuota</label>
                                <input type="number" name="kapasitas" id="edit_kapasitas" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4 me-2"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 4. MODAL DAFTAR PENDAFTAR (Lihat Detail) --}}
    <div class="modal fade" id="modalPendaftar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 text-dark">
                <div class="modal-header border-0 p-4 pb-0">
                    <div>
                        <h4 class="fw-bold mb-1">Daftar Pendaftar</h4>
                        <p class="text-muted small mb-0" id="modalSeminarTitle"></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Kartu Statistik --}}
                    <div class="row g-3 mb-4 text-center">
                        <div class="col-4">
                            <div class="p-3 rounded-4 bg-light text-primary">
                                <small class="fw-bold d-block mb-1">Total Pendaftar</small>
                                <h3 id="statTotal" class="fw-bold mb-0">0</h3>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-4 bg-light text-success">
                                <small class="fw-bold d-block mb-1">Kuota Tersedia</small>
                                <h3 id="statTersedia" class="fw-bold mb-0">0</h3>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-4 bg-light text-indigo">
                                <small class="fw-bold d-block mb-1">Tingkat Pengisian</small>
                                <h3 id="statPersen" class="fw-bold mb-0">0%</h3>
                            </div>
                        </div>
                    </div>
                    {{-- Tabel Peserta --}}
                    <div class="table-responsive">
                        <table class="table align-middle small table-hover">
                            <thead class="bg-light text-muted text-uppercase" style="font-size: 0.7rem;">
                                <tr>
                                    <th>NO</th>
                                    <th>NIM</th>
                                    <th>NAMA PESERTA</th>
                                    <th>EMAIL</th>
                                    <th>TANGGAL DAFTAR</th>
                                </tr>
                            </thead>
                            <tbody id="listPendaftar"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-dark rounded-3 px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- SCRIPTS (JQUERY + SWEETALERT + CUSTOM LOGIC) --}}
    {{-- ============================================================ --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // 1. Logic untuk Auto-Point di Modal Tambah Seminar (Vanilla JS)
        document.addEventListener('DOMContentLoaded', function () {
            const selectKategori = document.getElementById('selectKategori');
            const inputPoin = document.getElementById('inputPoin');
            const poinMap = { 'Internasional': 10, 'Nasional': 7, 'Regional/Daerah': 5, 'Internal': 3 };

            if (selectKategori) {
                selectKategori.addEventListener('change', function () {
                    inputPoin.value = poinMap[this.value] || 0;
                });
            }
        });

        // 2. Logic Interaktif dengan jQuery
        $(document).ready(function () {

            // --- A. KLIK BARIS (LIHAT DAFTAR PENDAFTAR) ---
            $('.clickable-row').on('click', function (e) {
                // Cegah jika yang diklik adalah tombol Edit/Hapus
                if ($(e.target).closest('.btn-action').length) return;

                let id = $(this).data('id'); // Ambil kode_seminar
                console.log("View detail ID: " + id);

                // Reset modal content
                $('#listPendaftar').html('<tr><td colspan="5" class="text-center py-3">Memuat data...</td></tr>');

                $.get(`/admin/seminar/${id}/pendaftar`, function (data) {
                    // Isi Header
                    $('#modalSeminarTitle').text(data.seminar.nama_seminar);
                    $('#statTotal').text(data.stats.total);
                    $('#statTersedia').text(data.stats.tersedia);
                    $('#statPersen').text(data.stats.persen + '%');

                    // Isi Tabel
                    let rows = '';
                    if (data.seminar.pendaftarans && data.seminar.pendaftarans.length > 0) {
                        data.seminar.pendaftarans.forEach((p, i) => {
                            let nama = p.peserta ? p.peserta.nama_peserta : 'Data Peserta Hilang';
                            let nim = p.peserta ? p.peserta.nim_peserta : '-';
                            let email = p.peserta ? p.peserta.email : '-';
                            let tgl = new Date(p.tanggal_pendaftaran).toLocaleDateString('id-ID');

                            rows += `<tr>
                                <td>${i + 1}</td>
                                <td class="fw-bold">${nim}</td>
                                <td>${nama}</td>
                                <td class="text-muted small">${email}</td>
                                <td>${tgl}</td>
                            </tr>`;
                        });
                    } else {
                        rows = '<tr><td colspan="5" class="text-center py-4 text-muted small">Belum ada pendaftar.</td></tr>';
                    }

                    $('#listPendaftar').html(rows);
                    $('#modalPendaftar').modal('show');

                }).fail(function (xhr) {
                    alert("Gagal memuat data! Cek koneksi atau Rute.");
                });
            });

            // --- B. KLIK TOMBOL EDIT (PENSIL) ---
            $('.btn-edit').click(function (e) {
                e.stopPropagation(); // Stop agar tidak memicu klik baris

                let id = $(this).data('id');

                // Ambil Data Seminar
                $.get(`/admin/seminar/${id}/edit`, function (data) {
                    // Isi Form di Modal Edit
                    $('#edit_nama_seminar').val(data.nama_seminar);
                    $('#edit_penyelenggara').val(data.penyelenggara);
                    $('#edit_tgl_dibuka').val(data.tgl_dibuka);
                    $('#edit_tgl_ditutup').val(data.tgl_ditutup);
                    $('#edit_tgl_seminar').val(data.tgl_seminar);
                    $('#edit_kategori').val(data.kategori_seminar);
                    $('#edit_poin').val(data.poin_seminar);
                    $('#edit_lokasi').val(data.lokasi);
                    $('#edit_kapasitas').val(data.kapasitas);

                    // Update URL Action pada Form
                    $('#formEditSeminar').attr('action', `/admin/seminar/${id}`);

                    $('#modalEditSeminar').modal('show');
                }).fail(function (xhr) {
                    alert("Gagal mengambil data edit.");
                });
            });

            // Auto Update Poin di Modal Edit
            $('#edit_kategori').on('change', function () {
                const poinMap = { 'Internasional': 10, 'Nasional': 7, 'Regional/Daerah': 5, 'Internal': 3 };
                $('#edit_poin').val(poinMap[$(this).val()] || 0);
            });

            // --- C. KLIK TOMBOL HAPUS (SAMPAH) ---
            $('.btn-delete').click(function (e) {
                e.stopPropagation(); // Stop agar tidak memicu klik baris

                let id = $(this).data('id');
                let nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Seminar?',
                    text: `Anda yakin ingin menghapus "${nama}"? Data yang dihapus tidak bisa dikembalikan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = $('#formDelete');
                        // Set action form ke route destroy
                        form.attr('action', `/admin/seminar/${id}`);
                        form.submit();
                    }
                });
            });
        });
    </script>

    <style>
        .rounded-4 {
            border-radius: 1.25rem !important;
        }

        .text-indigo {
            color: #6366f1;
        }

        .bg-success-light {
            background: #f0fdf4;
            color: #22c55e;
        }

        .table-hover-custom tbody tr {
            transition: all 0.2s;
        }

        .table-hover-custom tbody tr:hover {
            background-color: rgba(99, 102, 241, 0.05) !important;
            box-shadow: inset 4px 0 0 #6366f1;
        }
    </style>
@endsection