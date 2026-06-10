<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonitoringModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Monitoring extends Controller
{
    public function tampilMonitoring(Request $request)
    {
        $query = DB::table('data_mitra')
            ->leftJoin('data_monitoring', 'data_mitra.id_mitra', '=', 'data_monitoring.id_mitra')
            ->select('data_mitra.*', 'data_monitoring.fase_tanam', 'data_monitoring.est_hasil_panen');

        if ($request->has('search') && $request->search != '') {
            $query->where('data_mitra.nama_mitra', 'like', '%' . $request->search . '%');
        }

        $dataMonitoring = $query->orderBy('data_monitoring.tgl_survei', 'desc')
            ->get()->unique('id_mitra')->values();

        return view('monitoring-admin', compact('dataMonitoring'));
    }

    public function tampilMonitoringStaf(Request $request)
    {
        $query = DB::table('data_mitra')
            ->leftJoin('data_monitoring', 'data_mitra.id_mitra', '=', 'data_monitoring.id_mitra')
            ->select('data_mitra.*', 'data_monitoring.fase_tanam', 'data_monitoring.est_hasil_panen');

        if ($request->has('search') && $request->search != '') {
            $query->where('data_mitra.nama_mitra', 'like', '%' . $request->search . '%');
        }

        $dataMonitoring = $query->orderBy('data_monitoring.tgl_survei', 'desc')
            ->get()->unique('id_mitra')->values();

        return view('monitoring-staf', compact('dataMonitoring'));
    }

    public function detail($id)
    {
        $mitra = DB::table('data_mitra')->where('id_mitra', $id)->first();

        $semuaRiwayat = MonitoringModel::where('id_mitra', $id)
                    ->orderBy('tgl_survei', 'asc')
                    ->get();

        $kumpulanSiklus = [];
        $siklusAktif = [];
        $udahPanen = false;

        foreach ($semuaRiwayat as $r) {
            if ($udahPanen) {
                $kumpulanSiklus[] = collect($siklusAktif);
                $siklusAktif = [];
                $udahPanen = false;
            }
            $siklusAktif[] = $r;

            if (strtolower($r->fase_tanam) == 'panen' || strtolower($r->fase_tanam) == 'masak') {
                $udahPanen = true;
            }
        }

        if (count($siklusAktif) > 0) {
            $kumpulanSiklus[] = collect($siklusAktif);
        }

        $kumpulanSiklus = array_reverse($kumpulanSiklus);

        return view('monitoring-detail', compact('mitra', 'kumpulanSiklus'));
    }

    public function create(Request $request, $id)
    {
        $mitra = DB::table('data_mitra')->where('id_mitra', $id)->first();

        if ($request->has('fase')) {
            $semuaRiwayat = MonitoringModel::where('id_mitra', $id)->orderBy('tgl_survei', 'asc')->get();
            $siklusAktif = [];
            $udahPanen = false;

            foreach ($semuaRiwayat as $r) {
                if ($udahPanen) {
                    $siklusAktif = [];
                    $udahPanen = false;
                }
                $siklusAktif[] = $r;

                if (strtolower($r->fase_tanam) == 'panen' || strtolower($r->fase_tanam) == 'masak') {
                    $udahPanen = true;
                }
            }
            $semuaFase = collect($siklusAktif);

            $monitoring = (object) [
                'id_monitoring' => null,
                'fase_tanam' => $request->query('fase'),
                'tgl_survei' => '',
                'kondisi_tanaman' => '',
                'kondisi_lapangan' => '',
                'perkiraan_panen' => '',
                'est_hasil_panen' => '',
                'foto_bukti' => null,
            ];

            return view('edit-monitoring', compact('mitra', 'monitoring', 'semuaFase'));
        }
        else {
            return view('tambah-monitoring', compact('mitra'));
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['id_user'] = Auth::id();

        if ($request->hasFile('foto_bukti')) {
            $foto = $request->file('foto_bukti');
            $nama_foto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('foto_monitoring'), $nama_foto);
            $input['foto_bukti'] = $nama_foto;
        }

        $monitoring = MonitoringModel::create($input);

        return redirect()->route('editmonitoring', $monitoring->id_monitoring)
                         ->with('success', 'Data Monitoring berhasil ditambahkan');
    }

    public function edit($id_monitoring)
    {
        $monitoring = MonitoringModel::find($id_monitoring);
        $id_mitra = $monitoring->id_mitra;
        $mitra = DB::table('data_mitra')->where('id_mitra', $id_mitra)->first();

        $semuaRiwayat = MonitoringModel::where('id_mitra', $id_mitra)->orderBy('tgl_survei', 'asc')->get();
        $semuaFase = collect([]);
        $siklusAktif = [];
        $udahPanen = false;

        foreach ($semuaRiwayat as $r) {
            if ($udahPanen) {
                if (collect($siklusAktif)->contains('id_monitoring', $id_monitoring)) {
                    $semuaFase = collect($siklusAktif);
                    break;
                }
                $siklusAktif = [];
                $udahPanen = false;
            }
            $siklusAktif[] = $r;

            if (strtolower($r->fase_tanam) == 'panen' || strtolower($r->fase_tanam) == 'masak') {
                $udahPanen = true;
            }
        }

        if ($semuaFase->isEmpty() && count($siklusAktif) > 0) {
            $semuaFase = collect($siklusAktif);
        }

        return view('edit-monitoring', compact('mitra', 'monitoring', 'semuaFase'));
    }

    // =======================================================
    // INI YANG GUE BENERIN! JANGAN LUPA DI COPAS!
    // =======================================================
    public function update(Request $request)
    {
        $monitoring = MonitoringModel::findOrFail($request->id_monitoring);

        // Ambil semua data KECUALI foto biar foto lama gak ke-replace null
        $input = $request->except(['foto_bukti']);

        // Kalau ada foto baru, baru masukin ke array $input
        if ($request->hasFile('foto_bukti')) {
            $foto = $request->file('foto_bukti');
            $nama_foto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('foto_monitoring'), $nama_foto);

            $input['foto_bukti'] = $nama_foto;

            // Hapus foto lama biar server lu gak penuh (Opsional tapi direkomendasiin)
            if ($monitoring->foto_bukti && file_exists(public_path('foto_monitoring/' . $monitoring->foto_bukti))) {
                unlink(public_path('foto_monitoring/' . $monitoring->foto_bukti));
            }
        }

        // Simpan perubahan ke database
        $monitoring->update($input);

        // Notif sukses diganti jadi 'diubah'
        return redirect()->back()->with('success', 'Data monitoring berhasil diubah');
    }
}
