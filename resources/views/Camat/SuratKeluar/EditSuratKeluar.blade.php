@extends('layouts.SidebarCamat')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Surat Keluar</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Surat Keluar</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('surat-camat.updateKeluarCamat', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nomor_surat">Nomor Surat</label>
                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $suratKeluar->nomor_surat) }}" required>
            </div>
            <div class="form-group">
                <label for="tanggal_surat">Tanggal Surat</label>
                <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat) }}" required>
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
                <textarea class="form-control" id="perihal" name="perihal" rows="3" required>{{ old('perihal', $suratKeluar->perihal) }}</textarea>
            </div>
            <div class="form-group">
                <label for="sifat">Sifat</label>
                <select class="form-control" id="sifat" name="sifat" required>
                    <option value="Biasa" {{ (old('sifat', $suratKeluar->sifat) == 'Biasa') ? 'selected' : '' }}>Biasa</option>
                    <option value="Penting" {{ (old('sifat', $suratKeluar->sifat) == 'Penting') ? 'selected' : '' }}>Penting</option>
                    <option value="Rahasia" {{ (old('sifat', $suratKeluar->sifat) == 'Rahasia') ? 'selected' : '' }}>Rahasia</option>
                </select>
            </div>

            <div class="form-group">
                <label for="lampiran">Lampiran</label>

                @if($suratKeluar->lampiran)
                <p>File saat ini: <a href="{{ asset('storage/' . $suratKeluar->lampiran) }}" target="_blank" class="btn btn-primary btn-sm">Lihat Lampiran</a></p>
                @else
                <p>Tidak ada lampiran</p>
                @endif

                <input type="file" class="form-control" id="lampiran" name="lampiran">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti lampiran</small>
            </div>

            <div class="form-group">
                <label for="status">Status Tanda Tangan Camat</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Belum Ditandatangani" {{ (old('status', $suratKeluar->status) == 'Belum Ditandatangani') ? 'selected' : '' }}>Belum Ditandatangani</option>
                    <option value="Sudah Ditandatangani" {{ (old('status', $suratKeluar->status) == 'Sudah Ditandatangani') ? 'selected' : '' }}>Sudah Ditandatangani</option>
                </select>
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

@endsection