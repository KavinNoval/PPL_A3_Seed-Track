<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPerusahaan extends Model
{
    use HasFactory;

    // 1. Kasih tau Laravel nama tabel aslinya yang ada di phpMyAdmin
    protected $table = 'data_profil_perusahaan';

    // 2. Kasih tau Laravel nama Primary Key-nya (karena lu pake id_profil, bukan id)
    protected $primaryKey = 'id_profil';

    // 3. Biar semua field bisa diisi massal, kecuali id_profil (biar aman)
    protected $guarded = ['id_profil'];

    // 4. Karena di database lu cuma ada 'updated_at' dan ga ada 'created_at',
    // kita matiin fitur timestamps bawaan Laravel biar ga error pas nge-save.
    public $timestamps = false;
}
