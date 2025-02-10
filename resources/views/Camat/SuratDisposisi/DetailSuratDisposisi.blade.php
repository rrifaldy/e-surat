@extends('layouts.SidebarCamat')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Surat Disposisi</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Surat Disposisi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <tr>
                    <th>Nomor Surat</th>
                    <td>{{ $suratDisposisi->nomor_surat }}</td>
                </tr>
                <tr>
                    <th>Tanggal Surat</th>
                    <td>{{ $suratDisposisi->tanggal_surat }}</td>
                </tr>
                <tr>
                    <th>Pengirim</th>
                    <td>{{ $suratDisposisi->pengirim }}</td>
                </tr>
                <tr>
                    <th>Penerima</th>
                    <td>{{ $suratDisposisi->penerima }}</td>
                </tr>
                <tr>
                    <th>Tanggal Terima</th>
                    <td>{{ $suratDisposisi->created_at->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th>Perihal</th>
                    <td>{{ $suratDisposisi->perihal }}</td>
                </tr>
                <tr>
                    <th>Sifat Surat</th>
                    <td>{{ $suratDisposisi->sifat }}</td>
                </tr>
                <tr>
                    <th>Lampiran</th>
                    <td>
                        @if($suratDisposisi->lampiran)
                        <a href="{{ asset('storage/'.$suratDisposisi->lampiran) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-file-alt"></i> Lihat Lampiran
                        </a>
                        @else
                        Tidak ada lampiran
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $suratDisposisi->status }}</td>
                </tr>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('surat-camat.indexDisposisiCamat') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            @if($suratDisposisi->status == "Belum Ditandatangani")
                <form action="{{ route('surat-camat.kirimDisposisi', $suratDisposisi->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> TTD dan Kirim
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection
