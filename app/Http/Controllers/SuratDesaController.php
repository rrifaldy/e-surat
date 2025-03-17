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

    public function createKeluar()
    {
        $nomorSurat = $this->getNomorSuratDesa();
        return view('Desa.SuratKeluar.TambahSuratKeluar', compact('nomorSurat'));
    }

    public function storeKeluar(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_surat' => 'required|unique:surat_keluar_desa,nomor_surat',
            'tanggal_surat' => 'required|date',
            'tujuan_surat' => 'required',
            'perihal' => 'required',
            'sifat' => 'required',
            'lampiran' => 'nullable|file',
        ]);

        if ($request->hasFile('lampiran')) {
            $lampiranSuratKeluar = $request->file('lampiran')->store('lampiran_surat_keluar', 'public');
            $validatedData['lampiran'] = $lampiranSuratKeluar;
        }

        $desaUser = Auth::user()->desa;
        $validatedData['pengirim'] = "Desa " . $desaUser;

        // Cek apakah nomor surat sudah ada sebelum menyimpan
        if (SuratKeluarDesa::where('nomor_surat', $validatedData['nomor_surat'])->exists()) {
            return redirect()->back()->withErrors(['nomor_surat' => 'Nomor surat sudah digunakan.'])->withInput();
        }

        $suratKeluar = SuratKeluarDesa::create($validatedData);

        if (!empty($request->tujuan_surat)) {
            $lampiranSuratMasuk = null;

            if (!empty($lampiranSuratKeluar)) {
                $fileName = basename($lampiranSuratKeluar);
                $lampiranSuratMasuk = 'lampiran_surat_masuk/' . $fileName;
                Storage::disk('public')->copy($lampiranSuratKeluar, $lampiranSuratMasuk);
            }

            $dataSuratMasuk = [
                'nomor_surat' => $validatedData['nomor_surat'],
                'tanggal_surat' => $validatedData['tanggal_surat'],
                'pengirim' => $validatedData['pengirim'],
                'perihal' => $validatedData['perihal'],
                'sifat' => $validatedData['sifat'],
                'lampiran' => $lampiranSuratMasuk,
                'id_surat_keluar' => $suratKeluar->id,
                'penerima' => $validatedData['tujuan_surat'],
            ];

            if ($request->tujuan_surat === 'Kepala Camat') {
                \App\Models\SuratMasukAdmin::create($dataSuratMasuk);
            } else {
                \App\Models\SuratMasukDesa::create($dataSuratMasuk);
            }
        }

        return redirect()->route('desa.surat-keluar.index')->with('success', 'Surat keluar berhasil ditambahkan.');
    }


    public function editKeluar($id)
    {
        $suratKeluar = SuratKeluarDesa::findOrFail($id);
        return view('Desa.SuratKeluar.EditSuratKeluar', compact('suratKeluar'));
    }

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

    public function destroyKeluar($id)
    {
        $suratKeluar = SuratKeluarDesa::findOrFail($id);
        if ($suratKeluar->lampiran) {
            Storage::disk('public')->delete($suratKeluar->lampiran);
        }
        $suratKeluar->delete();

        return redirect()->route('desa.surat-keluar.index')->with('success', 'Surat keluar berhasil dihapus');
    }

    public function detailKeluar($id)
    {
        $suratKeluar = SuratKeluarDesa::findOrFail($id);
        return view('Desa.SuratKeluar.DetailSuratKeluar', compact('suratKeluar'));
    }

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

    public function getNomorSuratDesa()
    {
        $bulanTahun = date('my');
        $kode = 'SK/Desa/PMD';

        do {
            $lastSurat = SuratKeluarDesa::where('nomor_surat', 'LIKE', "%/$bulanTahun/$kode")
                ->orderBy('nomor_surat', 'desc')
                ->first();

            $urutan = $lastSurat ? intval(explode('/', $lastSurat->nomor_surat)[0]) + 1 : 1;

            $nomorSurat = str_pad($urutan, 3, '0', STR_PAD_LEFT) . "/$bulanTahun/$kode";

            $exists = SuratKeluarDesa::where('nomor_surat', $nomorSurat)->exists();
        } while ($exists);

        return $nomorSurat;
    }



}
