<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::select(
            "SELECT 
                id, 
                nama, 
                (
                    SELECT 
                        CONCAT(
                            '[',
                            GROUP_CONCAT(
                                JSON_OBJECT(
                                    'id_kriteria', kr.id, 
                                    'nama_kriteria', kr.nama, 
                                    'nilai', IFNULL(n.nilai, 0)
                                )
                            ),
                            ']'
                        ) 
                    FROM kriterias kr 
                    LEFT JOIN nilais n ON kr.id = n.id_kriteria AND k.id = n.id_karyawan
                ) AS kriteria_data
            FROM karyawans k"
        );

        $data = collect($data)->map(function ($karyawan) {
            $karyawan->kriteria_data = json_decode($karyawan->kriteria_data, true);
            return $karyawan;
        })->toJson(JSON_PRETTY_PRINT);

        $data_body = json_decode($data, true) ?? [];
        $data_header = ["No", "ID", "Nama Karyawan"];
        $data_aspek = [
            '1' => 'Sangat Kurang',
            '2' => 'Kurang',
            '3' => 'Cukup',
            '4' => 'Baik',
            '5' => 'Sangat Baik',
        ];

        return view('pages.nilai', compact('data_body', 'data_header', 'data_aspek'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except(['_token', '_method']);
        $id_karyawan = $id;
        $id_nilai = Nilai::generateKodeNilaiKey(1);

        foreach ($data as $id_kriteria => $nilai) {
            $nilaiExist = Nilai::where('id_karyawan', $id_karyawan)
                ->where('id_kriteria', $id_kriteria)
                ->first();

            if ($nilaiExist === null) {
                $nilaiExist = Nilai::create([
                    'id' => Nilai::generateKodeNilaiKey(1),
                    'id_karyawan' => $id_karyawan,
                    'id_kriteria' => $id_kriteria,
                    'nilai' => $nilai,
                ]);
            }

            Nilai::where('id_karyawan', $id_karyawan)
                ->where('id_kriteria', $id_kriteria)
                ->update(['nilai' => $nilai, 'updated_at' => now()]);
        }

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    protected static function generateKodeNilaiKey()
    {
        $prefix = 'SCR';
        $unixTimestamp = microtime(true);
        $randomNumber = (int) ($unixTimestamp * 1000);
        $kodeNilai = $prefix . str_pad($randomNumber, 8, '0', STR_PAD_LEFT);
        return $kodeNilai;
    }
}
