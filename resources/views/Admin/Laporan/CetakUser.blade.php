<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan User</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 10px;
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
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px; /* Reduce padding */
            text-align: left;
            font-size: 12px; /* Reduce font size */
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
    <h2>Laporan User</h2>

    <!-- Tabel Laporan -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th> <!-- Shortened column name -->
                <th>Email</th>
                <th>Role</th>
                <th>Desa</th>
                <th>Alamat</th>
                <th>HP</th> <!-- Shortened column name -->
                <th>Tgl Lahir</th> <!-- Shortened column name -->
                <th>JK</th> <!-- Shortened column name -->
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->desa ?? '-' }}</td>
                <td>{{ $user->alamat }}</td>
                <td>{{ $user->nomor_hp }}</td>
                <td>{{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d-m-Y') }}</td>
                <td>{{ $user->jenis_kelamin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
