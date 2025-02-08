@extends('layouts.SidebarDesa')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Surat Keluar</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Surat Keluar</h6>
    </div>
    <div class="card-body">
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Nomor Surat -->
            <div class="form-group">
                <label for="nomor_surat">Nomor Surat</label>
                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $suratKeluar->nomor_surat ?? '') }}" required>
            </div>
            <!-- Tanggal Surat -->
            <div class="form-group">
                <label for="tanggal_surat">Tanggal Surat</label>
                <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat ?? '') }}" required>
            </div>
            <!-- Tujuan Surat -->
            <div class="form-group">
                <label for="tujuan_surat">Tujuan Surat</label> <!-- Changed to "Tujuan Surat" -->
                <input type="text" class="form-control" id="tujuan_surat" name="tujuan_surat" value="{{ old('tujuan_surat', $suratKeluar->tujuan_surat ?? '') }}" required>
            </div>
            <!-- Perihal -->
            <div class="form-group">
                <label for="perihal">Perihal</label>
                <textarea class="form-control" id="perihal" name="perihal" rows="3" required>{{ old('perihal', $suratKeluar->perihal ?? '') }}</textarea>
            </div>
            <!-- Sifat -->
            <div class="form-group">
                <label for="sifat">Sifat</label>
                <select class="form-control" id="sifat" name="sifat" required>
                    <option value="Biasa" {{ (old('sifat', $suratKeluar->sifat ?? '') == 'Biasa') ? 'selected' : '' }}>Biasa</option>
                    <option value="Penting" {{ (old('sifat', $suratKeluar->sifat ?? '') == 'Penting') ? 'selected' : '' }}>Penting</option>
                    <option value="Rahasia" {{ (old('sifat', $suratKeluar->sifat ?? '') == 'Rahasia') ? 'selected' : '' }}>Rahasia</option>
                </select>
            </div>
            <!-- Lampiran -->
            <div class="form-group">
                <label for="lampiran">Lampiran</label>
                <input type="file" class="form-control" id="lampiran" name="lampiran">
            </div>
            <!-- Disposisi -->
            <div class="form-group">
                <label for="disposisi">Disposisi Jabatan</label>
                <select class="form-control" id="disposisi" name="disposisi" required>
                    <option value="Kepala desa" {{ (old('disposisi', $suratKeluar->disposisi ?? '') == 'Kepala desa') ? 'selected' : '' }}>Kepala desa</option>
                    <option value="Sekretaris desa" {{ (old('disposisi', $suratKeluar->disposisi ?? '') == 'Sekretaris desa') ? 'selected' : '' }}>Sekretaris desa</option>
                    <option value="Kepala Desa" {{ (old('disposisi', $suratKeluar->disposisi ?? '') == 'Kepala Desa') ? 'selected' : '' }}>Kepala Desa</option>
                    <option value="Bendahara" {{ (old('disposisi', $suratKeluar->disposisi ?? '') == 'Bendahara') ? 'selected' : '' }}>Bendahara</option>
                    <option value="Sekretaris Desa" {{ (old('disposisi', $suratKeluar->disposisi ?? '') == 'Sekretaris Desa') ? 'selected' : '' }}>Sekretaris Desa</option>
                </select>
            </div>
            <!-- Status Tanda Tangan desa -->
            <div class="form-group">
                <label for="status_ttd_desa">Status Tanda Tangan desa</label> <!-- New field for signature status -->
                <select class="form-control" id="status_ttd_desa" name="status_ttd_desa" required>
                    <option value="Belum Ditandatangani" {{ (old('status_ttd_desa', $suratKeluar->status_ttd_desa ?? '') == 'Belum Ditandatangani') ? 'selected' : '' }}>Belum Ditandatangani</option>
                    <option value="Sudah Ditandatangani" {{ (old('status_ttd_desa', $suratKeluar->status_ttd_desa ?? '') == 'Sudah Ditandatangani') ? 'selected' : '' }}>Sudah Ditandatangani</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

@endsection
