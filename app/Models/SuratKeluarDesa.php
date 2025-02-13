<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluarDesa extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar_desa';

    protected $fillable = [
        'nomor_surat',
        'tujuan_surat',
        'pengirim',
        'tanggal_surat',
        'perihal',
        'sifat',
        'lampiran',
    ];

    public function suratMasuk()
    {
        return $this->hasOne(SuratMasukDesa::class, 'id_surat_keluar', 'id');
    }

    public function suratMasukAdmin()
    {
        return $this->hasOne(SuratMasukAdmin::class, 'id_surat_keluar', 'id');
    }

    public function scopeByDesa($query, $desa)
    {
        return $query->where('tujuan_surat', $desa);
    }
}
