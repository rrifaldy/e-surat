<?php

namespace App\Http\Controllers;

use App\Models\SuratMasukAdmin;
use App\Models\SuratKeluarAdmin;
use App\Models\SuratMasukDesa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SuratAdminController extends Controller
{

    
    // --------------- Surat Masuk ---------------

    public function indexMasuk()
    {
        $suratMasuk = SuratMasukAdmin::all();
        return view('Admin.SuratMasuk.SuratMasuk', compact('suratMasuk'));
    }

    public function createMasuk()
    {
        return view('Admin.SuratMasuk.TambahSuratMasuk');
    }

    public function detailMasukAdmin($id)
    {
        $suratMasuk = SuratMasukAdmin::findOrFail($id);
        return view('Admin.SuratMasuk.DetailSuratMasuk', compact('suratMasuk'));
    }

    public function storeMasuk(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_surat' => 'required',
            'pengirim' => 'required',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'sifat' => 'required',
            'lampiran' => 'nullable|file',
        ]);

        if ($request->hasFile('lampiran')) {
            $validatedData['lampiran'] = $request->file('lampiran')->store('lampiran_surat_masuk', 'public');
        }

        SuratMasukAdmin::create($validatedData);

        return redirect()->route('surat-admin.indexMasuk')->with('success', 'Surat masuk berhasil ditambahkan');
    }

    public function updateMasuk(Request $request, $id)
    {
        $suratMasuk = SuratMasukAdmin::findOrFail($id);

        $validatedData = $request->validate([
            'nomor_surat' => 'required',
            'pengirim' => 'required',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'sifat' => 'required',
            'lampiran' => 'nullable|file',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($suratMasuk->lampiran) {
                Storage::disk('public')->delete($suratMasuk->lampiran);
            }
            $validatedData['lampiran'] = $request->file('lampiran')->store('lampiran_surat_masuk', 'public');
        }

        $suratMasuk->update($validatedData);

        return redirect()->route('surat-admin.indexMasuk')->with('success', 'Surat masuk berhasil diperbarui');
    }


    public function editMasuk($id)
    {
        $suratMasuk = SuratMasukAdmin::findOrFail($id);
        return view('Admin.SuratMasuk.EditSuratMasuk', compact('suratMasuk'));
    }

    public function destroyMasuk($id)
    {
        $suratMasuk = SuratMasukAdmin::findOrFail($id);

        // Hapus file lampiran jika ada
        if ($suratMasuk->lampiran) {
            Storage::disk('public')->delete($suratMasuk->lampiran);
        }

        $suratMasuk->delete();

        return redirect()->route('surat-admin.indexMasuk')->with('success', 'Surat masuk berhasil dihapus');
    }

    // --------------- Surat Keluar ---------------

    public function indexKeluar()
    {
        $suratKeluar = SuratKeluarAdmin::all();
        return view('Admin.SuratKeluar.SuratKeluar', compact('suratKeluar'));
    }

    public function detailKeluarAdmin($id)
    {
        $suratKeluar = SuratKeluarAdmin::findOrFail($id);
        return view('Admin.SuratKeluar.DetailSuratKeluar', compact('suratKeluar'));
    }


    public function createKeluar()
    {
        return view('Admin.SuratKeluar.TambahSuratKeluar');
    }

    public function storeKeluar(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tujuan_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string',
            'sifat' => 'required|string',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        // Jika ada lampiran, simpan file ke penyimpanan
        if ($request->hasFile('lampiran')) {
            $validatedData['lampiran'] = $request->file('lampiran')->store('lampiran_surat_keluar', 'public');
        }

        // Buat surat keluar di tabel SuratKeluarAdmin
        $suratKeluar = SuratKeluarAdmin::create($validatedData);

        // Tambahkan data ke SuratMasukDesa jika tujuan adalah desa
        if (str_contains($validatedData['tujuan_surat'], 'Desa')) {
            SuratMasukDesa::create([
                'nomor_surat' => $validatedData['nomor_surat'],
                'pengirim' => "Admin Kecamatan",
                'penerima' => $validatedData['tujuan_surat'],
                'tanggal_surat' => $validatedData['tanggal_surat'],
                'perihal' => $validatedData['perihal'],
                'sifat' => $validatedData['sifat'],
                'lampiran' => $validatedData['lampiran'],
                'id_surat_keluar' => $suratKeluar->id, // Relasi ke SuratKeluarAdmin
            ]);
        }

        // Redirect kembali ke halaman daftar surat keluar
        return redirect()->route('surat-admin.indexKeluar')->with('success', 'Surat keluar berhasil dikirim ke surat masuk desa.');
    }

    public function editKeluar($id)
    {
        $suratKeluar = SuratKeluarAdmin::findOrFail($id);
        return view('Admin.SuratKeluar.EditSuratKeluar', compact('suratKeluar'));
    }

    public function updateKeluar(Request $request, $id)
    {
        $suratKeluar = SuratKeluarAdmin::findOrFail($id);

        $validatedData = $request->validate([
            'nomor_surat' => 'required',
            'tujuan_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'sifat' => 'required',
            'status' => 'required',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($suratKeluar->lampiran) {
                Storage::disk('public')->delete($suratKeluar->lampiran);
            }

            $filePath = $request->file('lampiran')->store('lampiran_surat_keluar', 'public');
            $validatedData['lampiran'] = $filePath;
        }

        $suratKeluar->update($validatedData);

        return redirect()->route('surat-admin.indexKeluar')->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function destroyKeluar($id)
    {
        $suratKeluar = SuratKeluarAdmin::findOrFail($id);
        $suratKeluar->delete();

        return redirect()->route('surat-admin.indexKeluar')->with('success', 'Surat keluar berhasil dihapus');
    }

    // --------------- Laporan Admin -------------------

    public function laporanSuratMasuk()
    {
        $suratMasuk = SuratMasukAdmin::all();
        return view('Admin.Laporan.SuratMasuk', compact('suratMasuk'));
    }

    public function laporanSuratKeluar()
    {
        $suratKeluar = SuratKeluarAdmin::all();
        return view('Admin.Laporan.SuratKeluar', compact('suratKeluar'));
    }

    public function cetakSuratKeluar()
    {
        $suratKeluar = SuratKeluarAdmin::all();

        $pdf = Pdf::loadView('Admin.Laporan.CetakSuratKeluar', compact('suratKeluar'));
        return $pdf->stream('laporan_surat_keluar.pdf');
    }

    public function cetakSuratMasuk()
    {
        $suratMasuk = SuratMasukAdmin::all();

        $pdf = Pdf::loadView('Admin.Laporan.CetakSuratMasuk', compact('suratMasuk'));

        return $pdf->stream('laporan_surat_masuk.pdf');
    }



    // --------------- Camat: Surat Masuk ---------------
    public function indexMasukCamat()
    {
        $suratMasuk = SuratMasukAdmin::all();
        return view('Camat.SuratMasuk.SuratMasuk', compact('suratMasuk'));
    }

    public function detailMasukCamat($id)
    {
        $suratMasuk = SuratMasukAdmin::findOrFail($id);
        return view('Camat.SuratMasuk.DetailSuratMasuk', compact('suratMasuk'));
    }

    // --------------- Camat: Surat Keluar ---------------
    public function indexKeluarCamat()
    {
        $suratKeluar = SuratKeluarAdmin::all();
        return view('Camat.SuratKeluar.SuratKeluar', compact('suratKeluar'));
    }

    public function detailKeluarCamat($id)
    {
        $suratKeluar = SuratKeluarAdmin::findOrFail($id);
        return view('Camat.SuratKeluar.DetailSuratKeluar', compact('suratKeluar'));
    }

    public function editKeluarCamat($id)
    {
        $suratKeluar = SuratKeluarAdmin::findOrFail($id);
        return view('Camat.SuratKeluar.EditSuratKeluar', compact('suratKeluar'));
    }

    public function updateKeluarCamat(Request $request, $id)
    {
        $suratKeluar = SuratKeluarAdmin::findOrFail($id);

        $validatedData = $request->validate([
            'nomor_surat' => 'required',
            'tujuan_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'sifat' => 'required',
            'status' => 'required',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($suratKeluar->lampiran) {
                Storage::disk('public')->delete($suratKeluar->lampiran);
            }

            $filePath = $request->file('lampiran')->store('lampiran_surat_keluar', 'public');
            $validatedData['lampiran'] = $filePath;
        }

        $suratKeluar->update($validatedData);

        return redirect()->route('surat-camat.indexKeluarCamat')->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function storeKeluarCamat(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tujuan_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string',
            'sifat' => 'required|string',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        // Jika ada lampiran, simpan file ke penyimpanan
        if ($request->hasFile('lampiran')) {
            $validatedData['lampiran'] = $request->file('lampiran')->store('lampiran_surat_keluar', 'public');
        }

        // Buat surat keluar di tabel SuratKeluarAdmin
        $suratKeluar = SuratKeluarAdmin::create($validatedData);

        // Tambahkan data ke SuratMasukDesa jika tujuan adalah desa
        if (str_contains($validatedData['tujuan_surat'], 'Desa')) {
            SuratMasukDesa::create([
                'nomor_surat' => $validatedData['nomor_surat'],
                'pengirim' => "Camat Kecamatan Mekarmukti",
                'penerima' => $validatedData['tujuan_surat'],
                'tanggal_surat' => $validatedData['tanggal_surat'],
                'perihal' => $validatedData['perihal'],
                'sifat' => $validatedData['sifat'],
                'lampiran' => $validatedData['lampiran'],
                'id_surat_keluar' => $suratKeluar->id, // Relasi ke SuratKeluarAdmin
            ]);
        }

        // Redirect kembali ke halaman daftar surat keluar
        return redirect()->route('surat-camat.indexKeluarCamat')->with('success', 'Surat keluar berhasil dikirim ke surat masuk desa.');
    }

    public function createKeluarCamat()
    {
        return view('Camat.SuratKeluar.TambahSuratKeluar');
    }

    public function laporanSuratMasukCamat()
    {
        $suratMasuk = SuratMasukAdmin::all();
        return view('Camat.Laporan.SuratMasuk', compact('suratMasuk'));
    }

    public function laporanSuratKeluarCamat()
    {
        $suratKeluar = SuratKeluarAdmin::all();
        return view('Camat.Laporan.SuratKeluar', compact('suratKeluar'));
    }

    public function totalSuratMasukDanKeluarAdmin()
    {
        $totalSuratMasuk = SuratMasukAdmin::count();
        $totalSuratKeluar = SuratKeluarAdmin::count();
        $totalUsers = User::count();

        $suratMasukPerBulan = SuratMasukAdmin::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $suratKeluarPerBulan = SuratKeluarAdmin::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $dataSuratMasuk = [];
        $dataSuratKeluar = [];

        for ($i = 1; $i <= 12; $i++) {
            $dataSuratMasuk[] = $suratMasukPerBulan->get($i, 0);
            $dataSuratKeluar[] = $suratKeluarPerBulan->get($i, 0);
        }

        return view('Admin.Home', compact('totalSuratMasuk', 'totalSuratKeluar', 'dataSuratMasuk', 'dataSuratKeluar', 'totalUsers'));
    }

    public function totalSuratMasukDanKeluarCamat()
    {
        $totalSuratMasuk = SuratMasukAdmin::count();
        $totalSuratKeluar = SuratKeluarAdmin::count();
        $totalUsers = User::count();

        $suratMasukPerBulan = SuratMasukAdmin::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $suratKeluarPerBulan = SuratKeluarAdmin::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $dataSuratMasuk = [];
        $dataSuratKeluar = [];

        for ($i = 1; $i <= 12; $i++) {
            $dataSuratMasuk[] = $suratMasukPerBulan->get($i, 0);
            $dataSuratKeluar[] = $suratKeluarPerBulan->get($i, 0);
        }

        return view('Camat.Home', compact('totalSuratMasuk', 'totalSuratKeluar', 'dataSuratMasuk', 'dataSuratKeluar', 'totalUsers'));
    }

}
