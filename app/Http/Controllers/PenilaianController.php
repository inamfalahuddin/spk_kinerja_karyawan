<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    //
    public function index()
    {
        $data = DB::table('nilais')
            ->join('karyawans', 'nilais.id_karyawan', '=', 'karyawans.id')
            ->join('kriterias', 'kriterias.id', '=', 'nilais.id_kriteria')
            ->select(
                'nilais.*',
                'kriterias.nilai as nilai_kriteria',
                'kriterias.tipe as tipe_kriteria',
                'karyawans.nama',
                DB::raw('(nilais.nilai - kriterias.nilai) AS selisih'),
                DB::raw("(SELECT trains.nilai FROM trains WHERE trains.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) AS bobot_nilai")
            )
            ->get();

        $groupedData = [];
        foreach ($data as $item) {
            $id_karyawan = $item->id_karyawan;
            $nama_karyawan = $item->nama;

            if (!isset($groupedData[$id_karyawan])) {
                $groupedData[$id_karyawan] = [
                    'id_karyawan' => $id_karyawan,
                    'nama_karyawan' => $nama_karyawan,
                    'nilai' => []
                ];
            }

            $groupedData[$id_karyawan]['nilai'][] = [
                'id_kriteria' => $item->id_kriteria,
                'nilai' => $item->nilai,
                'selisih' => $item->selisih,
                'bobot_nilai' => $item->bobot_nilai,
                'tipe_kriteria' => $item->tipe_kriteria,
            ];
        }

        $result = array_values($groupedData);

        $data_header = ["ID", "Nama Karyawan", "CF", "SF", "CF * 75%", "SF * 25%", "Total", "Rangking"];
        $data_body = $result;

        $nilai_model = new Nilai();
        $data_result = $nilai_model->get_rank_result();

        return view('pages.penilaian', compact('result', 'data_body', 'data_header', 'data_result'));
    }
}
