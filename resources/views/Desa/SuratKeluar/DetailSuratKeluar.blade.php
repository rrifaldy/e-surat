@extends('layouts.SidebarDesa')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Surat Keluar</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Surat Keluar</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th>Nomor Surat</th>
                        <td>{{ $suratKeluar->nomor_surat }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Surat</th>
                        <td>{{ \Carbon\Carbon::parse($suratKeluar->tanggal_surat)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Penerima</th>
                        <td>{{ $suratKeluar->tujuan_surat }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Kirim</th>
                        <td>{{ \Carbon\Carbon::parse($suratKeluar->created_at)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Perihal</th>
                        <td>{{ $suratKeluar->perihal }}</td>
                    </tr>
                    <tr>
                        <th>Sifat Surat</th>
                        <td>{{ $suratKeluar->sifat }}</td>
                    </tr>
                    <tr>
                        <th>Lampiran</th>
                        <td>
                            @if($suratKeluar->lampiran)
                                <a href="{{ asset('storage/' . $suratKeluar->lampiran) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-file-alt"></i> Lihat Lampiran
                                </a>
                            @else
                                Tidak ada lampiran
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('desa.surat-keluar.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

@endsection
