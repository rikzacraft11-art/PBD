@extends('layouts.admin_app')

@section('header_title', 'Manajemen Seminar')
@section('header_subtitle', 'Kelola data seminar dan validasi pendaftaran')

@section('content')
    <div class="card border-0 shadow-sm p-4 animate-fadeInUp">
        {{-- Header Actions --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Daftar Seminar</h5>
                <p class="text-muted small mb-0">Total {{ $seminars->count() }} seminar terdaftar</p>
            </div>
            <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm btn-hover-effect"
                data-bs-toggle="modal" data-bs-target="#modalTambahSeminar">
                <i class="bi bi-plus-lg me-2"></i>Tambah Seminar
            </button>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Data --}}
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th class="ps-3">ID/JUDUL</th>
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
                        <tr class="clickable-row" data-id="{{ $s->kode_seminar }}">
                            <td class="ps-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="seminar-icon-sm">
                                        <span class="fw-bold text-white small">{{ substr($s->kode_seminar, -2) }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block text-truncate" style="max-width: 250px;">
                                            {{ $s->nama_seminar }}
                                        </span>
                                        <small class="text-muted d-flex align-items-center gap-1">
                                            <i class="bi bi-building" style="font-size: 0.7rem;"></i>
                                            {{ Str::limit($s->penyelenggara, 30) }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="badge bg-light text-primary border border-primary-subtle rounded-pill px-3 py-2 fw-medium">
                                    {{ $s->kategori_seminar }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span
                                        class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($s->tgl_seminar)->format('d M Y') }}</span>
                                    <small class="text-muted">{{ Str::limit($s->lokasi, 20) }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1 text-warning fw-bold">
                                    <i class="bi bi-star-fill"></i>
                                    <span>{{ $s->poin_seminar }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                @php $persen = $s->kapasitas > 0 ? ($s->pendaftarans_count / $s->kapasitas) * 100 : 0; @endphp
                                <div class="circular-chart" style="--percentage: {{ $persen }}%">
                                    <svg viewBox="0 0 36 36" class="circular-chart-svg">
                                        <path class="circle-bg"
                                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <path class="circle" stroke-dasharray="{{ $persen }}, 100"
                                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    </svg>
                                    <span class="percentage-label">{{ $s->pendaftarans_count }}</span>
                                </div>
                                <small class="d-block text-muted" style="font-size: 0.65rem;">dari {{ $s->kapasitas }}</small>
                            </td>
                            <td class="text-center">
                                @if($s->tgl_seminar >= now())
                                    <span class="status-badge active"><i class="bi bi-check-circle-fill me-1"></i> Aktif</span>
                                @else
                                    <span class="status-badge inactive"><i class="bi bi-check-all me-1"></i> Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn-icon btn-edit" data-id="{{ $s->kode_seminar }}" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="btn-icon btn-delete" data-id="{{ $s->kode_seminar }}"
                                        data-nama="{{ $s->nama_seminar }}" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon-sm mb-3">
                                        <i class="bi bi-calendar-x fs-1 text-muted opacity-25"></i>
                                    </div>
                                    <h6 class="text-muted mb-0">Belum ada data seminar.</h6>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODALS --}}

    {{-- 1. DELETE FORM (Hidden) --}}
    <form id="formDelete" method="POST" style="display: none;">
        @csrf @method('DELETE')
    </form>

    {{-- 2. MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambahSeminar" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-light p-4">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-calendar-plus me-2"></i>Tambah Seminar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.seminar.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating-custom">
                                    <label>Judul Seminar <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_seminar" class="form-control"
                                        placeholder="Ex: AI Tech Summit" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating-custom">
                                    <label>Penyelenggara <span class="text-danger">*</span></label>
                                    <input type="text" name="penyelenggara" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating-custom">
                                    <label class="text-success">Pendaftaran Dibuka <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tgl_dibuka" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating-custom">
                                    <label class="text-danger">Pendaftaran Ditutup <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tgl_ditutup" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating-custom">
                                    <label>Pelaksanaan <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_seminar" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating-custom">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori_seminar" id="selectKategori" class="form-select" required>
                                        <option value="" disabled selected>Pilih Kategori</option>
                                        <option value="Internasional">Internasional (10 Poin)</option>
                                        <option value="Nasional">Nasional (7 Poin)</option>
                                        <option value="Regional/Daerah">Regional/Daerah (5 Poin)</option>
                                        <option value="Internal">Internal (3 Poin)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating-custom">
                                    <label>Poin (Auto)</label>
                                    <input type="number" name="poin_seminar" id="inputPoin" class="form-control bg-light"
                                        readonly required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-floating-custom">
                                    <label>Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" name="lokasi" class="form-control" placeholder="Gedung / Zoom Link"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating-custom">
                                    <label>Kuota <span class="text-danger">*</span></label>
                                    <input type="number" name="kapasitas" class="form-control" min="1" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 bg-light">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold w-100">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 3. MODAL EDIT --}}
    <div class="modal fade" id="modalEditSeminar" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-light p-4">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-pencil-square me-2"></i>Edit Data Seminar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditSeminar" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body p-4">
                        {{-- Same fields as create, with IDs for JS population --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating-custom">
                                    <label>Judul Seminar</label>
                                    <input type="text" name="nama_seminar" id="edit_nama_seminar" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating-custom">
                                    <label>Penyelenggara</label>
                                    <input type="text" name="penyelenggara" id="edit_penyelenggara" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating-custom">
                                    <label class="text-success">Pendaftaran Dibuka</label>
                                    <input type="date" name="tgl_dibuka" id="edit_tgl_dibuka" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating-custom">
                                    <label class="text-danger">Pendaftaran Ditutup</label>
                                    <input type="date" name="tgl_ditutup" id="edit_tgl_ditutup" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating-custom">
                                    <label>Pelaksanaan</label>
                                    <input type="date" name="tgl_seminar" id="edit_tgl_seminar" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating-custom">
                                    <label>Kategori</label>
                                    <select name="kategori_seminar" id="edit_kategori" class="form-select" required>
                                        <option value="Internasional">Internasional</option>
                                        <option value="Nasional">Nasional</option>
                                        <option value="Regional/Daerah">Regional/Daerah</option>
                                        <option value="Internal">Internal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating-custom">
                                    <label>Poin</label>
                                    <input type="number" name="poin_seminar" id="edit_poin" class="form-control bg-light"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-floating-custom">
                                    <label>Lokasi</label>
                                    <input type="text" name="lokasi" id="edit_lokasi" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating-custom">
                                    <label>Kuota</label>
                                    <input type="number" name="kapasitas" id="edit_kapasitas" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 bg-light">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold w-100">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 4. MODAL DETAIL PENDAFTAR --}}
    <div class="modal fade" id="modalPendaftar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-primary p-4 text-white">
                    <div>
                        <h5 class="fw-bold mb-1"><i class="bi bi-people-fill me-2"></i>Daftar Pendaftar</h5>
                        <p class="small mb-0 opacity-75" id="modalSeminarTitle"></p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Stats Summary --}}
                    <div class="row g-3 mb-4">
                        <div class="col-4">
                            <div class="stat-box-sm bg-primary-subtle text-primary">
                                <small>TOTAL</small>
                                <h4 id="statTotal" class="mb-0">0</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box-sm bg-success-subtle text-success">
                                <small>TERSEDIA</small>
                                <h4 id="statTersedia" class="mb-0">0</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box-sm bg-info-subtle text-info">
                                <small>TERISI</small>
                                <h4 id="statPersen" class="mb-0">0%</h4>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="bg-light text-muted small">
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>NAMA PESERTA</th>
                                    <th>TGL DAFTAR</th>
                                </tr>
                            </thead>
                            <tbody id="listPendaftar"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STYLING --}}
    <style>
        /* Custom Table Styling */
        .custom-table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            padding: 1rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .custom-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .clickable-row {
            transition: all 0.2s;
            cursor: pointer;
        }

        .clickable-row:hover {
            background-color: #f8fafc;
            transform: translateX(4px);
        }

        /* Seminar Icon */
        .seminar-icon-sm {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Status Badges */
        .status-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35rem 0.8rem;
            border-radius: 50px;
        }

        .status-badge.active {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge.inactive {
            background: #f1f5f9;
            color: #64748b;
        }

        /* Action Buttons */
        .btn-icon {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-edit {
            background: #e0e7ff;
            color: #4f46e5;
        }

        .btn-edit:hover {
            background: #4f46e5;
            color: white;
        }

        .btn-delete {
            background: #fee2e2;
            color: #ef4444;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        /* Circular Chart */
        .circular-chart {
            display: inline-block;
            width: 40px;
            height: 40px;
            position: relative;
        }

        .circular-chart-svg {
            display: block;
            width: 100%;
        }

        .circle-bg {
            fill: none;
            stroke: #e2e8f0;
            stroke-width: 3.8;
        }

        .circle {
            fill: none;
            stroke: #6366f1;
            stroke-width: 3.8;
            stroke-linecap: round;
        }

        .percentage-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.75rem;
            font-weight: 700;
            color: #1e293b;
        }

        /* Forms */
        .form-floating-custom {
            margin-bottom: 0.5rem;
        }

        .form-floating-custom label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 0.35rem;
            display: block;
        }

        .form-control,
        .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        /* Stat Box Small (Modal) */
        .stat-box-sm {
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
        }

        .stat-box-sm small {
            font-weight: 700;
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.7rem;
        }
    </style>

    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto Point Logic
            const poinMap = { 'Internasional': 10, 'Nasional': 7, 'Regional/Daerah': 5, 'Internal': 3 };

            function updatePoin(select, output) {
                if (select && output) {
                    select.addEventListener('change', function () {
                        output.value = poinMap[this.value] || 0;
                    });
                }
            }

            updatePoin(document.getElementById('selectKategori'), document.getElementById('inputPoin'));
            updatePoin(document.getElementById('edit_kategori'), document.getElementById('edit_poin'));
        });

        $(document).ready(function () {
            // --- View Details ---
            $('.clickable-row').on('click', function (e) {
                if ($(e.target).closest('.btn-icon').length) return;

                let id = $(this).data('id');
                $('#listPendaftar').html('<tr><td colspan="4" class="text-center py-4"><div class="spinner-border text-primary spinner-border-sm"></div></td></tr>');

                $.get(`/admin/seminar/${id}/pendaftar`, function (data) {
                    $('#modalSeminarTitle').text(data.seminar.nama_seminar);
                    $('#statTotal').text(data.stats.total);
                    $('#statTersedia').text(data.stats.tersedia);
                    $('#statPersen').text(data.stats.persen + '%');

                    let rows = '';
                    if (data.seminar.pendaftarans?.length > 0) {
                        data.seminar.pendaftarans.forEach((p, i) => {
                            rows += `<tr>
                                        <td class="text-muted small">${i + 1}</td>
                                        <td class="fw-bold text-primary">${p.peserta?.nim_peserta || '-'}</td>
                                        <td>
                                            <div class="fw-semibold">${p.peserta?.nama_peserta || 'Unknown'}</div>
                                            <small class="text-muted">${p.peserta?.email || '-'}</small>
                                        </td>
                                        <td class="small text-muted">${new Date(p.tanggal_pendaftaran).toLocaleDateString('id-ID')}</td>
                                    </tr>`;
                        });
                    } else {
                        rows = '<tr><td colspan="4" class="text-center py-4 text-muted small">Belum ada pendaftar.</td></tr>';
                    }
                    $('#listPendaftar').html(rows);
                    $('#modalPendaftar').modal('show');
                }).fail(() => alert("Gagal memuat data!"));
            });

            // --- Edit ---
            $('.btn-edit').click(function (e) {
                e.preventDefault(); e.stopPropagation();
                let id = $(this).data('id');

                $.get(`/admin/seminar/${id}/edit`, function (data) {
                    $('#edit_nama_seminar').val(data.nama_seminar);
                    $('#edit_penyelenggara').val(data.penyelenggara);
                    $('#edit_tgl_dibuka').val(data.tgl_dibuka);
                    $('#edit_tgl_ditutup').val(data.tgl_ditutup);
                    $('#edit_tgl_seminar').val(data.tgl_seminar);
                    $('#edit_kategori').val(data.kategori_seminar);
                    $('#edit_poin').val(data.poin_seminar);
                    $('#edit_lokasi').val(data.lokasi);
                    $('#edit_kapasitas').val(data.kapasitas);
                    $('#formEditSeminar').attr('action', `/admin/seminar/${id}`);
                    $('#modalEditSeminar').modal('show');
                });
            });

            // --- Delete ---
            $('.btn-delete').click(function (e) {
                e.preventDefault(); e.stopPropagation();
                let id = $(this).data('id');
                let nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Seminar?',
                    html: `Yakin ingin menghapus <strong>"${nama}"</strong>?<br>Data tidak dapat dikembalikan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: { popup: 'rounded-4' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = $('#formDelete');
                        form.attr('action', `/admin/seminar/${id}`);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection