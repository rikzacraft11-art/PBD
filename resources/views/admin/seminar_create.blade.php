@extends('layouts.admin_app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h4 class="fw-bold mb-4">Tambah Seminar Baru</h4>
        
        <form action="{{ route('admin.seminar.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold">Nama Seminar</label>
                    <input type="text" name="nama_seminar" class="form-control" placeholder="Contoh: Webinar AI Dasar" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold">Penyelenggara</label>
                    <input type="text" name="penyelenggara" class="form-control" placeholder="Contoh: Himpunan Mahasiswa" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold">Pendaftaran Dibuka</label>
                    <input type="date" name="tgl_dibuka" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold">Pendaftaran Ditutup</label>
                    <input type="date" name="tgl_ditutup" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label small fw-bold">Kategori</label>
                    <select name="kategori_seminar" class="form-select">
                        <option value="Nasional">Nasional</option>
                        <option value="Internasional">Internasional</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label small fw-bold">Tanggal Pelaksanaan Seminar</label>
                    <input type="date" name="tgl_seminar" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label small fw-bold">Poin</label>
                    <input type="number" name="poin_seminar" class="form-control" value="10" required>
                </div>

                <div class="col-md-8 mb-3">
                    <label class="form-label small fw-bold">Lokasi Pelaksanaan</label>
                    <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Zoom Meeting atau Aula Gedung A" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label small fw-bold">Kuota (Kapasitas)</label>
                    <input type="number" name="kapasitas" class="form-control" placeholder="Contoh: 100" required>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4 rounded-pill">Simpan Seminar</button>
                <a href="{{ route('admin.seminar') }}" class="btn btn-light px-4 rounded-pill">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection