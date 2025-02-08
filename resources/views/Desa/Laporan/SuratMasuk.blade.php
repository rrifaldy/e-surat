@extends('layouts.SidebarDesa')
@section('content')

{{-- Header halaman --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Surat Masuk</h1>
    <a href="{{ route('laporan.suratMasuk.cetak') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
        <i class="fas fa-print fa-sm text-white-50"></i> Cetak Semua Surat
    </a>
</div>

{{-- Tabel Data Surat Masuk --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Surat Masuk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Pengirim</th>
                        <th>Penerima</th>
                        <th>Tanggal Terima</th>
                        <th>Perihal</th>
                        <th>Sifat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratMasuk as $surat)
                    <tr>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->pengirim }}</td>
                        <td>{{ $surat->penerima }}</td>
                        <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-m-Y') }}</td>
                        <td>{{ $surat->perihal }}</td>
                        <td>{{ $surat->sifat }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada surat masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection