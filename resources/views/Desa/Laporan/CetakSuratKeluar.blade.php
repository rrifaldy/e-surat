<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Keluar</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px 0;
            border-bottom: 2px solid black;
        }

        .kop-surat h2,
        .kop-surat h3 {
            margin: 0;
        }

        .alamat {
            font-size: 12px;
            margin-top: 5px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <h2>PEMERINTAH KABUPATEN GARUT</h2>
        <h3>KECAMATAN MEKARMUKTI</h3>
        <p class="alamat">
            Jl. Mekarmukti, Kabupaten Garut, Jawa Barat, 44165 <br>
            Telepon: (0262) 233273, Email: kec.mekarmukti@garut.go.id
        </p>
    </div>

    <!-- Judul Laporan -->
    <h2>Laporan Surat Keluar</h2>

    <!-- Tabel Laporan -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Penerima</th>
                <th>Tanggal Kirim</th>
                <th>Perihal</th>
                <th>Sifat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratKeluar as $index => $surat)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $surat->nomor_surat }}</td>
                <td>{{ $surat->tujuan_surat }}</td>
                <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-m-Y') }}</td>
                <td>{{ $surat->perihal }}</td>
                <td>{{ $surat->sifat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>