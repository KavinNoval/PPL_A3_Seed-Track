<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ControllerStaf extends Controller
{
    public function dataKiosGudang()
    {
        // Query Kios di-upgrade pakai leftJoin buat narik data wilayah
        $kios = DB::table('data_kios')
            ->leftJoin('kabupaten', 'data_kios.id_kabupaten', '=', 'kabupaten.id_kabupaten')
            ->leftJoin('kecamatan', 'data_kios.id_kecamatan', '=', 'kecamatan.id_kecamatan')
            ->leftJoin('kelurahan', 'data_kios.id_kelurahan', '=', 'kelurahan.id_kelurahan')
            ->select('data_kios.*', 'kabupaten.kabupaten', 'kecamatan.kecamatan', 'kelurahan.kelurahan')
            ->get();

        return view('datakios-gudang', compact('kios'));
    }

    public function dataMitraLapang()
    {
        // Sekalian di-upgrade juga buat Mitra Lapang biar wilayahnya ikut nongol
        $mitra = DB::table('data_mitra')
            ->leftJoin('kabupaten', 'data_mitra.id_kabupaten', '=', 'kabupaten.id_kabupaten')
            ->leftJoin('kecamatan', 'data_mitra.id_kecamatan', '=', 'kecamatan.id_kecamatan')
            ->leftJoin('kelurahan', 'data_mitra.id_kelurahan', '=', 'kelurahan.id_kelurahan')
            ->select('data_mitra.*', 'kabupaten.kabupaten', 'kecamatan.kecamatan', 'kelurahan.kelurahan')
            ->get();

        return view('datamitra-lapang', compact('mitra'));
    }
}
