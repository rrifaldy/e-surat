@extends('layouts.SidebarAdmin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah User</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah User</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="Admin">Admin</option>
                    <option value="Camat">Camat</option>
                    <option value="Desa">Perwakilan Desa</option>
                </select>
            </div>

            <div class="form-group">
                <label for="desa">Desa</label>
                <select class="form-control" id="desa" name="desa">
                    <option value="">- Pilih Desa -</option>
                    <option value="Cijayana">Desa Cijayana</option>
                    <option value="Jagabaya">Desa Jagabaya</option>
                    <option value="Karangwangi">Desa Karangwangi</option>
                    <option value="Mekarmukti">Desa Mekarmukti</option>
                    <option value="Mekarsari">Desa Mekarsari</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" required>
            </div>

            <div class="form-group">
                <label for="nomor_hp">Nomor HP</label>
                <input type="number" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Masukkan Nomor HP" required>
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@endsection
