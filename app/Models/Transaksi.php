<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'data_transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'id_akun',
        'id_pelanggan',
        'tgl_transaksi',
        'tipe_pelanggan',
        'total_tagihan',
        'total_bayar',
        'jumlah_hutang',
        'status_bayar'
    ];

    // 1. Relasi ke tabel data_mitra (nyambungin id_pelanggan ke id_mitra)
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_pelanggan', 'id_mitra');
    }

    // 2. Relasi ke tabel data_kios (nyambungin id_pelanggan ke id_kios)
    public function kios()
    {
        return $this->belongsTo(Kios::class, 'id_pelanggan', 'id_kios');
    }

    // 3. Relasi ke tabel detail_transaksi
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function getPembeliAttribute()
    {
        if ($this->tipe_pelanggan == 'Mitra') {
            return $this->mitra;
        } else {
            return $this->kios;
        }
    }
}
