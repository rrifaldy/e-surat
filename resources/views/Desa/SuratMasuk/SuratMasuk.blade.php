@extends('layouts.SidebarDesa')
@section('content')

{{-- Notifikasi sukses --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

{{-- Notifikasi error --}}
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

{{-- Header halaman --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Surat Masuk</h1>
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
                        <th>No</th> <!-- Tambahan kolom Nomor -->
                        <th>Nomor Surat</th>
                        <th>Pengirim</th>
                        <th>Penerima</th>
                        <th>Tanggal Terima</th>
                        <th>Perihal</th>
                        <th>Sifat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratMasuk as $surat)
                    <tr>
                        <td>{{ $loop->iteration }}</td> <!-- Nomor urut otomatis -->
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->pengirim }}</td>
                        <td>{{ $surat->penerima }}</td>
                        <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-m-Y') }}</td>
                        <td>{{ $surat->perihal }}</td>
                        <td>{{ $surat->sifat }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('desa.surat-masuk.detail', $surat->id) }}" class="btn btn-info btn-sm mr-2" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada surat masuk untuk desa ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
