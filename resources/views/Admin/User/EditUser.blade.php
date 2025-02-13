@extends('layouts.SidebarAdmin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Camat" {{ $user->role == 'Camat' ? 'selected' : '' }}>Camat</option>
                    <option value="Desa" {{ $user->role == 'Desa' ? 'selected' : '' }}>Perwakilan Desa</option>
                </select>
            </div>

            <div class="form-group">
                <label for="desa">Desa</label>
                <select class="form-control" id="desa" name="desa">
                    <option value="">- Pilih Desa -</option>
                    <option value="Cijayana" {{ $user->desa == 'Cijayana' ? 'selected' : '' }}>Desa Cijayana</option>
                    <option value="Jagabaya" {{ $user->desa == 'Jagabaya' ? 'selected' : '' }}>Desa Jagabaya</option>
                    <option value="Karangwangi" {{ $user->desa == 'Karangwangi' ? 'selected' : '' }}>Desa Karangwangi</option>
                    <option value="Mekarmukti" {{ $user->desa == 'Mekarmukti' ? 'selected' : '' }}>Desa Mekarmukti</option>
                    <option value="Mekarsari" {{ $user->desa == 'Mekarsari' ? 'selected' : '' }}>Desa Mekarsari</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat }}">
            </div>

            <div class="form-group">
                <label for="nomor_hp">Nomor HP</label>
                <input type="number" class="form-control" id="nomor_hp" name="nomor_hp" value="{{ $user->nomor_hp }}">
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}">
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                    <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@endsection
