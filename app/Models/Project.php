<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    protected $fillable = [
        'status',
        'customer_id',
        'nama_pelanggan',
        'product_id',
        'nama_service',
        'jenis_layanan',
        'nama_pekerjaan',
        'nilai_pekerjaan_rkap',
        'nilai_pekerjaan_aktual',
        'nilai_pekerjaan_kontrak_tahun_berjalan',
        'total_nilai_rkap',
        'total_nilai_aktual',
        'total_nilai_kontrak',
        'plan_start_date',
        'plan_end_date',
        'actual_start_date',
        'actual_end_date',
        'account_marketing',
        'dirut',
        'dirop',
        'dirke',
        'kskmr',
        'ksham',
        'msdmu',
        'mkakt',
        'mbilp',
        'mppti',
        'mopti',
        'mbsar',
        'msadb',
        'comments'
    ];

    public function customer()
    {
        return $this->belongsTo(customers::class, 'customer_id');
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(produk::class, 'product_id');
    }
    public function updateTotalValue()
    {
        $totalNilaiRkap = self::sum('nilai_pekerjaan_rkap');
        $totalNilaiAktual = self::sum('nilai_pekerjaan_aktual');
        $totalNilaiKontrak = self::sum('nilai_pekerjaan_kontrak_tahun_berjalan');

        self::query()->update([
            'total_nilai_rkap' => $totalNilaiRkap,
            'total_nilai_aktual' => $totalNilaiAktual,
            'total_nilai_kontrak' => $totalNilaiKontrak,
        ]);
    }
}
