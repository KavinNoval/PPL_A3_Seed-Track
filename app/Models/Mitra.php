<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    // Kasih tau Laravel nama tabel aslinya di database lu
    protected $table = 'data_mitra';
    
    // Kasih tau primary key-nya
    protected $primaryKey = 'id_mitra';
    
    // Matiin timestamps kalau di tabel lu kaga ada kolom created_at & updated_at
    public $timestamps = false;

    // Biarin semua kolom bisa diisi
    protected $guarded = [];
}