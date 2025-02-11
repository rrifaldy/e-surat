@extends('layouts.SidebarAdmin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Surat Keluar</h1>
    <a href="{{ route('surat-admin.createKeluar') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Surat
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Surat Keluar</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th> <!-- Tambahan kolom Nomor -->
                        <th>Nomor Surat</th>
                        <th>Tujuan</th>
                        <th>Tanggal Kirim</th>
                        <th>Perihal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suratKeluar as $surat)
                    <tr>
                        <td>{{ $loop->iteration }}</td> <!-- Nomor urut otomatis -->
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->tujuan_surat }}</td>
                        <td>{{ $surat->tanggal_surat }}</td>
                        <td>{{ $surat->perihal }}</td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <a href="{{ route('surat-admin.editKeluar', $surat->id) }}" class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('surat-admin.destroyKeluar', $surat->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mr-2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('surat-admin.detailKeluar', $surat->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
