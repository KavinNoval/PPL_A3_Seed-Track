<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi'; 
    public $timestamps = false; 

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jmlh_beli',
        'harga_satuan',
        'subtotal'
    ];

    // INI JEMBATAN KE TABEL PRODUK BIAR NAMANYA BISA KETARIK
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    // Jembatan balik ke Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}