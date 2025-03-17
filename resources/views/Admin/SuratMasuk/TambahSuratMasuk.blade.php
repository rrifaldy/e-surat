@extends('layouts.SidebarAdmin')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Surat Masuk</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Surat Masuk</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('surat-admin.storeMasuk') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nomor_surat">Nomor Surat</label>
                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ $nomorSurat }}" readonly>
            </div>
            <div class="form-group">
                <label for="pengirim">Pengirim</label>
                <input type="text" class="form-control" id="pengirim" name="pengirim" required>
            </div>
            <div class="form-group">
                <label for="tanggal_surat">Tanggal Terima</label>
                <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" required>
            </div>
            <div class="form-group">
                <label for="perihal">Perihal</label>
                <textarea class="form-control" id="perihal" name="perihal" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="sifat">Sifat</label>
                <select class="form-control" id="sifat" name="sifat" required>
                    <option value="Biasa">Biasa</option>
                    <option value="Penting">Penting</option>
                    <option value="Rahasia">Rahasia</option>
                </select>
            </div>
            <div class="form-group">
                <label for="lampiran">Lampiran</label>
                <input type="file" class="form-control" id="lampiran" name="lampiran">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@endsection
