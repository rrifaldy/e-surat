@extends('layouts.SidebarDesa')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Surat Masuk</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Surat Masuk</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Nomor Surat</th>
                <td>{{ $suratMasuk->nomor_surat }}</td>
            </tr>
            <tr>
                <th>Tanggal Surat</th>
                <td>{{ $suratMasuk->tanggal_surat }}</td>
            </tr>
            <tr>
                <th>Pengirim</th>
                <td>{{ $suratMasuk->pengirim }}</td>
            </tr>
            <tr>
                <th>Tanggal Terima</th>
                <td>{{ $suratMasuk->created_at->format('Y-m-d') }}</td> <!-- Format Tanggal Terima -->
            </tr>
            <tr>
                <th>Perihal</th>
                <td>{{ $suratMasuk->perihal }}</td>
            </tr>
            <tr>
                <th>Sifat Surat</th>
                <td>{{ $suratMasuk->sifat }}</td>
            </tr>
            <tr>
                <th>Lampiran</th>
                <td>
                    @if($suratMasuk->lampiran)
                        <a href="{{ asset('storage/' . $suratMasuk->lampiran) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-file-alt"></i> Lihat Lampiran
                        </a>
                    @else
                        Tidak ada lampiran
                    @endif
                </td>
            </tr>
        </table>

        <!-- Tombol Kembali -->
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('desa.surat-masuk.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

@endsection
