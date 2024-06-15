<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nilai extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_karyawan',
        'id_kriteria',
        'nilai',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = self::generateKodeNilai();
        });

        DB::statement("SET SQL_MODE= ''");
    }

    private static function generateKodeNilai()
    {
        $prefix = 'SCR';
        $unixTimestamp = microtime(true);
        $randomNumber = (int) ($unixTimestamp * 1000);
        $kodeNilai = $prefix . str_pad($randomNumber, 8, '0', STR_PAD_LEFT);
        return $kodeNilai;
    }

    protected static function generateKodeNilaiKey($key)
    {
        $latestNilai = self::orderBy('id', 'desc')->first();

        if (!$latestNilai) {
            return 'SCR00' . 1 + $key;
        }

        $lastKodeNilai = $latestNilai->id;
        $lastNumber = (int) substr($lastKodeNilai, 3);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return 'SCR00' . $newNumber + $key;
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id');
    }

    public function get_rank_result()
    {
        $data = Nilai::select(
            'nilais.id_karyawan',
            'karyawans.nama',
            DB::raw('ROUND(AVG(CASE WHEN kriterias.tipe = \'core\' THEN (SELECT trains.nilai FROM trains WHERE trains.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) AS cf'),
            DB::raw('ROUND(AVG(CASE WHEN kriterias.tipe = \'secondary\' THEN (SELECT trains.nilai FROM trains WHERE trains.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) AS sf'),
            DB::raw('ROUND(AVG(CASE WHEN kriterias.tipe = \'core\' THEN (SELECT trains.nilai FROM trains WHERE trains.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) * 0.75 AS cf_x_percent'),
            DB::raw('ROUND(AVG(CASE WHEN kriterias.tipe = \'secondary\' THEN (SELECT trains.nilai FROM trains WHERE trains.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) * 0.25 AS sf_x_percent'),
            DB::raw('ROUND(AVG(CASE WHEN kriterias.tipe = \'core\' THEN (SELECT trains.nilai FROM trains WHERE trains.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) * 0.75 + ROUND(AVG(CASE WHEN kriterias.tipe = \'secondary\' THEN (SELECT trains.nilai FROM trains WHERE trains.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) * 0.25 AS total_percent')
        )
            ->join('karyawans', 'nilais.id_karyawan', '=', 'karyawans.id')
            ->join('kriterias', 'kriterias.id', '=', 'nilais.id_kriteria')
            ->groupBy('nilais.id_karyawan', 'karyawans.nama')
            ->orderBy('total_percent', 'desc')
            ->get();

        return $data->toArray();
    }
}
