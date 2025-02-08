<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluarDesa;
use App\Models\SuratMasukDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratDesaController extends Controller
{
    public function indexKeluar()
    {
        $desaUser = Auth::user()->desa;

        $suratKeluar = SuratKeluarDesa::where('pengirim', 'Desa ' . $desaUser)->get();

        return view('Desa.SuratKeluar.SuratKeluar', compact('suratKeluar'));
    }

    // Show form to create new Surat Keluar
    public function createKeluar()
    {
        return view('Desa.SuratKeluar.TambahSuratKeluar');
    }

    // Store new Surat Keluar


    public function storeKeluar(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'tujuan_surat' => 'required',
            'perihal' => 'required',
            'sifat' => 'required',
            'lampiran' => 'nullable|file',
        ]);

        // Menyimpan lampiran untuk Surat Keluar
        if ($request->hasFile('lampiran')) {
            $lampiranSuratKeluar = $request->file('lampiran')->store('lampiran_surat_keluar', 'public');
            $validatedData['lampiran'] = $lampiranSuratKeluar;
        }

        $desaUser = Auth::user()->desa;
        $validatedData['pengirim'] = "Desa " . $desaUser;

        // Membuat Surat Keluar
        $suratKeluar = SuratKeluarDesa::create($validatedData);

        // Distribusi ke Surat Masuk terkait
        if (!empty($request->tujuan_surat)) {
            $lampiranSuratMasuk = null;

            if (!empty($lampiranSuratKeluar)) {
                $fileName = basename($lampiranSuratKeluar);
                $lampiranSuratMasuk = 'lampiran_surat_masuk/' . $fileName;

                // Salin file lampiran
                Storage::disk('public')->copy($lampiranSuratKeluar, $lampiranSuratMasuk);
            }

            // Distribusi surat masuk
            if ($request->tujuan_surat === 'Kepala Camat') {
                \App\Models\SuratMasukAdmin::create([
                    'nomor_surat' => $validatedData['nomor_surat'],
                    'tanggal_surat' => $validatedData['tanggal_surat'],
                    'pengirim' => $validatedData['pengirim'],
                    'perihal' => $validatedData['perihal'],
                    'sifat' => $validatedData['sifat'],
                    'lampiran' => $lampiranSuratMasuk,
                    'id_surat_keluar' => $suratKeluar->id,
                    'penerima' => $validatedData['tujuan_surat'],
                ]);
            } else {
                \App\Models\SuratMasukDesa::create([
                    'nomor_surat' => $validatedData['nomor_surat'],
                    'tanggal_surat' => $validatedData['tanggal_surat'],
                    'pengirim' => $validatedData['pengirim'],
                    'perihal' => $validatedData['perihal'],
                    'sifat' => $validatedData['sifat'],
                    'lampiran' => $lampiranSuratMasuk,
                    'id_surat_keluar' => $suratKeluar->id,
                    'penerima' => $validatedData['tujuan_surat'],
                ]);
            }
        }

        return redirect()->route('desa.surat-keluar.index')->with('success', 'Surat keluar berhasil ditambahkan.');
    }


    // Show form to edit existing Surat Keluar
    public function editKeluar($id)
    {
        $suratKeluar = SuratKeluarDesa::findOrFail($id);
        return view('Desa.SuratKeluar.EditSuratKeluar', compact('suratKeluar'));
    }

    // Update existing Surat Keluar
    public function updateKeluar(Request $request, $id)
    {
        $suratKeluar = SuratKeluarDesa::findOrFail($id);

        $validatedData = $request->validate([
            'nomor_surat' => 'required',
            'tujuan_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'sifat' => 'required',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($suratKeluar->lampiran) {
                Storage::disk('public')->delete($suratKeluar->lampiran);
            }

            $validatedData['lampiran'] = $request->file('lampiran')->store('lampiran_surat_keluar', 'public');
        }

        $suratKeluar->update($validatedData);

        return redirect()->route('desa.surat-keluar.index')->with('success', 'Surat keluar berhasil diperbarui.');
    }

    // Delete Surat Keluar
    public function destroyKeluar($id)
    {
        $suratKeluar = SuratKeluarDesa::findOrFail($id);
        if ($suratKeluar->lampiran) {
            Storage::disk('public')->delete($suratKeluar->lampiran);
        }
        $suratKeluar->delete();

        return redirect()->route('desa.surat-keluar.index')->with('success', 'Surat keluar berhasil dihapus');
    }

    // Show details of Surat Keluar
    public function detailKeluar($id)
    {
        $suratKeluar = SuratKeluarDesa::findOrFail($id);
        return view('Desa.SuratKeluar.DetailSuratKeluar', compact('suratKeluar'));
    }

    // Surat Masuk
    public function indexMasuk()
    {
        $desaUser = Auth::user()->desa;
        $suratMasuk = SuratMasukDesa::where('penerima', 'Desa ' . $desaUser)->get();
        return view('Desa.SuratMasuk.SuratMasuk', compact('suratMasuk'));
    }

    public function detailMasuk($id)
    {
        $suratMasuk = SuratMasukDesa::findOrFail($id);
        return view('Desa.SuratMasuk.DetailSuratMasuk', compact('suratMasuk'));
    }

    public function laporanSuratMasuk()
    {
        $desaUser = Auth::user()->desa;
        $suratMasuk = SuratMasukDesa::where('penerima', 'Desa ' . $desaUser)->get();
        return view('Desa.Laporan.SuratMasuk', compact('suratMasuk'));
    }

    public function laporanSuratKeluar()
    {
        $desaUser = Auth::user()->desa;
        $suratKeluar = SuratKeluarDesa::where('pengirim', 'Desa ' . $desaUser)->get();
        return view('Desa.Laporan.SuratKeluar', compact('suratKeluar'));
    }

    public function cetakSuratKeluar()
    {
        $desaUser = Auth::user()->desa;
        $suratKeluar = SuratKeluarDesa::where('pengirim', 'Desa ' . $desaUser)->get();
        $pdf = Pdf::loadView('Desa.Laporan.CetakSuratKeluar', compact('suratKeluar'));
        return $pdf->stream('laporan_surat_keluar.pdf');
    }

    public function cetakSuratMasuk()
    {
        $desaUser = Auth::user()->desa;
        $suratMasuk = SuratMasukDesa::where('penerima', 'Desa ' . $desaUser)->get();
        $pdf = Pdf::loadView('Desa.Laporan.CetakSuratMasuk', compact('suratMasuk'));
        return $pdf->stream('laporan_surat_masuk.pdf');
    }

    public function totalSuratMasukDanKeluar()
    {
        $desaUser = Auth::user()->desa;

        $totalSuratMasuk = SuratMasukDesa::where('penerima', 'Desa ' . $desaUser)->count();
        $totalSuratKeluar = SuratKeluarDesa::where('pengirim', 'Desa ' . $desaUser)->count();

        $suratMasukPerBulan = SuratMasukDesa::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('penerima', 'Desa ' . $desaUser)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $suratKeluarPerBulan = SuratKeluarDesa::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('pengirim', 'Desa ' . $desaUser)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $dataSuratMasuk = [];
        $dataSuratKeluar = [];

        for ($i = 1; $i <= 12; $i++) {
            $dataSuratMasuk[] = $suratMasukPerBulan->get($i, 0);
            $dataSuratKeluar[] = $suratKeluarPerBulan->get($i, 0);
        }

        // Kirim semua data ke view
        return view('Desa.Home', compact('totalSuratMasuk', 'totalSuratKeluar', 'dataSuratMasuk', 'dataSuratKeluar'));
    }

    public function totalSuratMasukPerPengirim()
    {
        $desaUser = Auth::user()->desa;

        $suratMasukPerPengirim = SuratMasukDesa::selectRaw('pengirim, COUNT(*) as total')
            ->where('penerima', 'Desa ' . $desaUser)
            ->where('pengirim', '!=', 'Desa ' . $desaUser)
            ->groupBy('pengirim')
            ->pluck('total', 'pengirim');

        $dataSuratMasukPerPengirim = $suratMasukPerPengirim->toArray();

        return view('Desa.Home', compact('dataSuratMasukPerPengirim'));
    }

}
