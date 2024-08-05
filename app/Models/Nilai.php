<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Nilai extends Model
{
    use HasFactory;

    public $incrementing = true;
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

        // static::creating(function ($model) {
        //     $model->id = self::generateKodeNilai();
        // });

        DB::statement("SET SQL_MODE= ''");
    }

    private static function generateKodeNilai()
    {
        $prefix = 'SCR';
        $newNumber = '0001';

        // Start a database transaction
        DB::transaction(function () use ($prefix, &$newNumber) {
            $latestRecord = self::orderBy('id', 'desc')->first();

            if ($latestRecord) {
                $lastId = $latestRecord->id;
                $lastNumber = (int) substr($lastId, strlen($prefix)); // Mengambil angka setelah prefix
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // Menghasilkan nomor baru
            }

            $newKodeNilai = $prefix . $newNumber;

            // Check if the generated code already exists
            while (self::where('id', $newKodeNilai)->exists()) {
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // Increment the number
                $newKodeNilai = $prefix . $newNumber;
            }
        });

        return $prefix . $newNumber;
    }


    // private static function generateKodeNilai()
    // {
    //     $prefix = 'SCR';
    //     $unixTimestamp = microtime(true);
    //     $randomNumber = (int) ($unixTimestamp * 1000);
    //     $uniqueHash = substr(md5(uniqid(mt_rand(), true)), 0, 8); // Menghasilkan hash unik
    //     $kodeNilai = $prefix . $randomNumber . $uniqueHash;
    //     return $kodeNilai;
    // }


    // private static function generateKodeNilai()
    // {
    //     $prefix = 'SCR';
    //     $unixTimestamp = microtime(true);
    //     $randomNumber = (int) ($unixTimestamp * 1000);
    //     $kodeNilai = $prefix . str_pad($randomNumber, 8, '0', STR_PAD_LEFT);
    //     return $kodeNilai;
    // }

    // protected static function generateKodeNilaiKey($key)
    // {
    //     $latestNilai = self::orderBy('id', 'desc')->first();

    //     if (!$latestNilai) {
    //         return 'SCR00' . 1 + $key;
    //     }

    //     $lastKodeNilai = $latestNilai->id;
    //     $lastNumber = (int) substr($lastKodeNilai, 3);
    //     $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

    //     return 'SCR00' . $newNumber + $key;
    // }

    public static function generateKodeNilaiKey($key)
    {
        $prefix = 'SCR';
        $length = 8; // Panjang kode acak setelah prefix

        do {
            // Generate a random unique code
            $randomCode = Str::upper(Str::random($length));
            $kodeNilai = $prefix . $randomCode . $key;

            // Check if the generated code already exists in the database
            $exists = DB::table('nilais')->where('id', $kodeNilai)->exists();
        } while ($exists);

        return $kodeNilai;
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
            DB::raw('ROUND(AVG(CASE WHEN kriterias.tipe = \'core\' THEN (SELECT bobots.nilai FROM bobots WHERE bobots.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) AS cf'),
            DB::raw('ROUND(AVG(CASE WHEN kriterias.tipe = \'secondary\' THEN (SELECT bobots.nilai FROM bobots WHERE bobots.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) AS sf'),
            DB::raw('ROUND(AVG(CASE WHEN kriterias.tipe = \'core\' THEN (SELECT bobots.nilai FROM bobots WHERE bobots.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) * 0.75 AS cf_x_percent'),
            DB::raw('ROUND(AVG(CASE WHEN kriterias.tipe = \'secondary\' THEN (SELECT bobots.nilai FROM bobots WHERE bobots.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) * 0.25 AS sf_x_percent'),
            DB::raw('ROUND(AVG(CASE WHEN kriterias.tipe = \'core\' THEN (SELECT bobots.nilai FROM bobots WHERE bobots.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) * 0.75 + ROUND(AVG(CASE WHEN kriterias.tipe = \'secondary\' THEN (SELECT bobots.nilai FROM bobots WHERE bobots.selisih = (nilais.nilai - kriterias.nilai) LIMIT 1) ELSE NULL END), 3) * 0.25 AS total_percent')
        )
            ->join('karyawans', 'nilais.id_karyawan', '=', 'karyawans.id')
            ->join('kriterias', 'kriterias.id', '=', 'nilais.id_kriteria')
            ->groupBy('nilais.id_karyawan', 'karyawans.nama')
            ->orderBy('total_percent', 'desc')
            ->get();

        return $data->toArray();
    }
}
