<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringModel extends Model
{
    protected $table = 'data_monitoring';
    protected $primaryKey = 'id_monitoring';

    protected $fillable = [
        'id_user',
        'id_mitra', 
        'tgl_survei', 
        'fase_tanam', 
        'kondisi_tanaman', 
        'kondisi_lapangan', 
        'foto_bukti', 
        'perkiraan_panen', 
        'est_hasil_panen'
    ];

    public $timestamps = false;
}