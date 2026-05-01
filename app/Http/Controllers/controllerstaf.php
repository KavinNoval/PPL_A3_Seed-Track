<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerStaf extends Controller
{
    public function dataKiosGudang()
    {
        $kios = DB::table('data_kios')->get(); 
        
        return view('datakios-gudang', compact('kios'));
    }

    public function dataMitraLapang()
    {
        $mitra = DB::table('data_mitra')->get(); 
        return view('datamitra-lapang', compact('mitra'));
    }
    
}