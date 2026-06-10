<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Kasih tau Laravel nama tabel aslinya di database
    protected $table = 'data_pelanggan';

    // Kasih tau Laravel kalau primary key-nya bukan 'id', tapi 'id_pelanggan'
    protected $primaryKey = 'id_pelanggan';

    // Set false kalau di tabel lu kaga ada kolom created_at & updated_at
    public $timestamps = false;

    // Kolom apa aja yang boleh diisi (sesuain sama field database lu)
    protected $fillable = [
        'nama_pelanggan', 
        'nomor_telepon', 
        'tipe_pelanggan', 
        'alamat' // Tambahin kalau ada
    ];

    // Relasi ke tabel Transaksi (1 Pelanggan bisa punya banyak Transaksi)
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pelanggan', 'id_pelanggan');
    }
}