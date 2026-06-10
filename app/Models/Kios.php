<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    use HasFactory;

    protected $table = 'data_kios';
    protected $primaryKey = 'id_kios';
    public $timestamps = false;
    protected $guarded = [];
}