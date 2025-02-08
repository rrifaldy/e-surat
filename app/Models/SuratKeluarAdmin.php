<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluarAdmin extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar_admin';

    protected $fillable = [
        'nomor_surat',
        'tujuan_surat',
        'tanggal_surat',
        'perihal',
        'sifat',
        'lampiran',
        'status',
    ];

    // Relasi ke SuratMasukDesa
    public function suratMasukDesa()
    {
        return $this->hasOne(SuratMasukDesa::class, 'id_surat_keluar', 'id');
    }

    // Scope untuk filter berdasarkan tujuan surat (desa)
    public function scopeByDesa($query, $desa)
    {
        return $query->where('tujuan_surat', $desa);
    }
}
