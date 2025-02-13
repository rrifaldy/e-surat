@extends('layouts.SidebarCamat')

@section('content')

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
        <h6 class="m-0 font-weight-bold text-primary">Data Surat Masuk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Pengirim</th>
                        <th>Tanggal Terima</th>
                        <th>Perihal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suratMasuk as $index => $surat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->pengirim }}</td>
                        <td>{{ $surat->tanggal_surat }}</td>
                        <td>{{ $surat->perihal }}</td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <a href="{{ route('surat-camat.detailMasuk', $surat->id) }}" class="btn btn-info btn-sm">
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
