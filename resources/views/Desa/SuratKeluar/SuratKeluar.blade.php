@extends('layouts.SidebarDesa')

@section('content')

{{-- Menampilkan notifikasi sukses --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

{{-- Menampilkan notifikasi error --}}
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
    <h1 class="h3 mb-0 text-gray-800">Surat Keluar</h1>
    <a href="{{ route('desa.surat-keluar.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Surat
    </a>
</div>

{{-- Tabel Data Surat Keluar --}}
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
                        <th>Tanggal Kirim</th>
                        <th>Perihal</th>
                        <th>Sifat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratKeluar as $surat)
                    <tr>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->pengirim }}</td>
                        <td>{{ $surat->tujuan_surat }}</td>
                        <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-m-Y') }}</td>
                        <td>{{ $surat->perihal }}</td>
                        <td>{{ $surat->sifat }}</td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <a href="{{ route('desa.surat-keluar.detail', $surat->id) }}" class="btn btn-info btn-sm mr-2" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('desa.surat-keluar.destroy', $surat->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Surat" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada surat keluar dari desa ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
