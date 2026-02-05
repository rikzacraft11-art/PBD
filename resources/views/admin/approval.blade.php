@extends('layouts.admin_app')

@section('content')
<div class="container-fluid py-4">
    {{-- Bagian Judul Halaman --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Approval Pendaftaran</h3>
        <p class="text-muted small">Kelola dan setujui pendaftaran peserta seminar</p>
    </div>

    {{-- Kotak Statistik (Cards) --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <small class="text-muted d-block mb-1">Total Pendaftaran</small>
                <h2 class="fw-bold mb-0">{{ $stats['total'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-warning border-4">
                <small class="text-muted d-block mb-1">Menunggu Approval</small>
                <h2 class="fw-bold mb-0 text-warning">{{ $stats['menunggu'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-success border-4">
                <small class="text-muted d-block mb-1">Disetujui</small>
                <h2 class="fw-bold mb-0 text-success">{{ $stats['disetujui'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-danger border-4">
                <small class="text-muted d-block mb-1">Ditolak</small>
                <h2 class="fw-bold mb-0 text-danger">{{ $stats['ditolak'] }}</h2>
            </div>
        </div>
    </div>

    {{-- Konten Utama: Filter dan Tabel --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">
            {{-- Bagian Header Tabel: Search dan Filter --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="input-group w-50">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0 rounded-end-pill" placeholder="Cari nama, NIM, atau judul seminar...">
                </div>

                {{-- PERBAIKAN: Gunakan request('status') agar tidak error "Undefined variable" --}}
                <div class="btn-group">
                    <a href="{{ route('admin.approval') }}" 
                       class="btn {{ !request('status') ? 'btn-primary text-white' : 'btn-outline-primary' }} px-4 rounded-pill me-2">
                       Semua
                    </a>
                    <a href="{{ route('admin.approval', ['status' => 'Menunggu']) }}" 
                       class="btn {{ request('status') == 'Menunggu' ? 'btn-primary text-white' : 'btn-outline-primary' }} px-4 rounded-pill me-2">
                       Menunggu
                    </a>
                    <a href="{{ route('admin.approval', ['status' => 'Disetujui']) }}" 
                       class="btn {{ request('status') == 'Disetujui' ? 'btn-primary text-white' : 'btn-outline-primary' }} px-4 rounded-pill">
                       Disetujui
                    </a>
                </div>
            </div> {{-- Penutup d-flex yang tadi hilang --}}

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th>ID PENDAFTARAN</th>
                            <th>PESERTA</th>
                            <th>SEMINAR</th>
                            <th>TANGGAL DAFTAR</th>
                            <th>STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $p)
                        <tr>
                            <td class="fw-bold small">PD00{{ $p->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $p->peserta->nama_peserta }}</div>
                                <small class="text-muted">NIM: {{ $p->peserta->nim_peserta }}</small>
                            </td>
                            <td class="small">{{ $p->seminar->nama_seminar }}</td>
                            {{-- PERBAIKAN: Gunakan tanggal_pendaftaran karena created_at tidak ada --}}
                            <td class="small">{{ $p->tanggal_pendaftaran ? \Carbon\Carbon::parse($p->tanggal_pendaftaran)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($p->status_pendaftaran == 'Menunggu')
                                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2"><i class="bi bi-clock"></i> Menunggu</span>
                                @else
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2"><i class="bi bi-check-circle"></i> Disetujui</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->status_pendaftaran == 'Menunggu')
                                    <form action="{{ route('admin.approve', $p->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 fw-bold"><i class="bi bi-check-lg"></i> ACC</button>
                                    </form>
                                    <button class="btn btn-danger btn-sm rounded-pill px-3 fw-bold"><i class="bi bi-x-lg"></i> Tolak</button>
                                @else
                                    <span class="text-muted small fst-italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">Belum ada data pendaftaran masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-success-subtle { background-color: #d1e7dd; }
</style>
@endsection