@extends('layouts.SidebarDesa')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Surat Keluar</h1>
    <a href="{{ route('laporan.suratKeluar.cetak') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
        <i class="fas fa-print fa-sm text-white-50"></i> Cetak Laporan PDF
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Surat Keluar</h6>
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
                    @foreach($suratKeluar as $surat)
                    <tr>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->pengirim }}</td>
                        <td>{{ $surat->tujuan_surat }}</td>
                        <td>{{ $surat->tanggal_surat }}</td>
                        <td>{{ $surat->perihal }}</td>
                        <td>{{ $surat->sifat }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection