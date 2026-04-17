<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'data_akun';
    protected $primaryKey = 'id_akun';

    // 1. Aktifkan timestamps tapi matikan updated_at
    public $timestamps = true;
    const UPDATED_AT = null; 

    protected $fillable = [
        'username',
        'password',
        'role',
        'status',
        'no_telp',
        'nama_lengkap',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [];
    }
}