@extends('layouts.SidebarAdmin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data User</h1>
    <a href="{{ route('laporan.user.cetak') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
        <i class="fas fa-print fa-sm text-white-50"></i> Cetak Semua User
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Desa</th>
                        <th>Alamat</th>
                        <th>Nomor HP</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->desa ?? '-' }}</td>
                        <td>{{ $user->alamat }}</td>
                        <td>{{ $user->nomor_hp }}</td>
                        <td>{{ $user->tanggal_lahir }}</td>
                        <td>{{ $user->jenis_kelamin }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection