@extends('layouts.SidebarAdmin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail User</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail User</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label><strong>Nama Lengkap:</strong></label>
                <p>{{ $user->name }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <label><strong>Email:</strong></label>
                <p>{{ $user->email }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <label><strong>Role:</strong></label>
                <p>{{ $user->role }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <label><strong>Alamat:</strong></label>
                <p>{{ $user->alamat }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <label><strong>Nomor HP:</strong></label>
                <p>{{ $user->nomor_hp }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <label><strong>Tanggal Lahir:</strong></label>
                <p>{{ $user->tanggal_lahir }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <label><strong>Jenis Kelamin:</strong></label>
                <p>{{ $user->jenis_kelamin }}</p>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

@endsection
