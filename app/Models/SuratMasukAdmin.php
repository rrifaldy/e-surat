<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasukAdmin extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk_admin';

    protected $fillable = [
        'nomor_surat',
        'pengirim',
        'penerima',
        'tanggal_surat',
        'perihal',
        'sifat',
        'lampiran',
        'status',
    ];

    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluarDesa::class, 'id_surat_keluar', 'id');
    }

    public function scopeByDesa($query, $desa)
    {
        return $query->where('pengirim', $desa);
    }
}
