<?php

namespace App\Http\Controllers;

use App\Models\SuratMasukAdmin;
use App\Models\SuratKeluarAdmin;
use App\Models\SuratMasukDesa;
use App\Models\SuratDisposisiCamat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;

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

        // Tambahkan surat ke tabel SuratDisposisiCamat dengan status "Belum Ditandatangani"
        SuratDisposisiCamat::create([
            'id_surat_keluar' => $suratKeluar->id,
            'nomor_surat' => $validatedData['nomor_surat'],
            'pengirim' => "Admin Kecamatan",
            'penerima' => $validatedData['tujuan_surat'],
            'tanggal_surat' => $validatedData['tanggal_surat'],
            'perihal' => $validatedData['perihal'],
            'sifat' => $validatedData['sifat'],
            'lampiran' => $validatedData['lampiran'] ?? null,
            'status' => 'Belum Ditandatangani',
        ]);
        return redirect()->route('surat-admin.indexKeluar')->with('success', 'Surat keluar berhasil dibuat.');
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

    public function indexDisposisiCamat()
    {
        $suratDisposisi = SuratDisposisiCamat::all();
        
        return view('Camat.SuratDisposisi.SuratDisposisi', compact('suratDisposisi'));
    }

    public function detailDisposisiCamat($id)
    {
        $suratDisposisi = SuratDisposisiCamat::findOrFail($id);

        return view('Camat.SuratDisposisi.DetailSuratDisposisi', compact('suratDisposisi'));
    }

    public function kirimDisposisi($id)
    {
        $suratDisposisi = SuratDisposisiCamat::findOrFail($id);
        $suratDisposisi->update(['status' => 'Sudah Ditandatangani']);

        $suratKeluar = SuratKeluarAdmin::where('nomor_surat', $suratDisposisi->nomor_surat)->first();
        if ($suratKeluar) {
            $suratKeluar->update(['status' => 'Sudah Ditandatangani']);
        }

        $folderPath = storage_path('app/public/lampiran_surat_keluar');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $pathPdfTtd = $folderPath . '/surat_disposisi_ttd_' . str_replace('/', '_', $suratDisposisi->nomor_surat) . '.pdf';

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile(storage_path('app/public/' . $suratDisposisi->lampiran));
        $ttdPath = public_path('images/ttd-camat.png');

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            $tplId = $pdf->importPage($pageNo);
            $pdf->useTemplate($tplId);

            $pdf->Image($ttdPath, 135, 220, 60, 40);
        }

        $pdfContent = $pdf->Output('', 'S');
        file_put_contents($pathPdfTtd, $pdfContent);

        if (str_contains($suratDisposisi->penerima, 'Desa')) {
            SuratMasukDesa::create([
                'nomor_surat' => $suratDisposisi->nomor_surat,
                'pengirim' => "Kecamatan Mekarmukti",
                'penerima' => $suratDisposisi->penerima,
                'tanggal_surat' => $suratDisposisi->tanggal_surat,
                'perihal' => $suratDisposisi->perihal,
                'sifat' => $suratDisposisi->sifat,
                'lampiran' => 'lampiran_surat_keluar/' . basename($pathPdfTtd),
                'id_surat_keluar' => $suratDisposisi->id_surat_keluar,
            ]);
        }

        return redirect()->route('surat-camat.indexDisposisiCamat')->with('success', 'Surat berhasil ditandatangani dan dikirim.');
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
