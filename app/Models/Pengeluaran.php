<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'data_pengeluaran';
    protected $primaryKey = 'id_pengeluaran';

    public $timestamps = false;

    protected $fillable = [
        'id_akun',
        'tgl_pengeluaran',
        'nama_pengeluaran',
        'keterangan',
        'nominal',
        'bukti_nota'
    ];
}
