@extends('layouts.SidebarAdmin')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Surat Keluar</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Surat Keluar</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('surat-admin.storeKeluar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nomor_surat">Nomor Surat</label>
                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ $nomorSurat }}" readonly>
            </div>
            <div class="form-group">
                <label for="tanggal_surat">Tanggal Surat</label>
                <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" required>
            </div>
            <div class="form-group">
                <label for="tujuan_surat">Tujuan Surat</label>
                <select class="form-control" id="tujuan_surat" name="tujuan_surat" required>
                    <option value="" disabled selected>Pilih Tujuan...</option>
                    <option value="Desa Cijayana">Desa Cijayana</option>
                    <option value="Desa Jagabaya">Desa Jagabaya</option>
                    <option value="Desa Karangwangi">Desa Karangwangi</option>
                    <option value="Desa Mekarmukti">Desa Mekarmukti</option>
                    <option value="Desa Mekarsari">Desa Mekarsari</option>
                </select>
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