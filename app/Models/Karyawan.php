<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Karyawan extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'karyawans';

    protected $fillable = [
        'id',
        'nippt',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'email',
        'jabatan',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = self::generateUserCode();
        });
    }

    // public static function generateUserCode()
    // {
    //     $latestUser = DB::table('karyawans')->orderBy('id', 'desc')->first();

    //     if (!$latestUser) {
    //         return 'EMP0001';
    //     }

    //     $lastUserCode = $latestUser->id;
    //     $lastNumber = (int) substr($lastUserCode, 3);
    //     $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

    //     return 'EMP' . $newNumber;
    // }

    protected static function generateUserCode()
    {
        $prefix = 'EMP';
        $length = 4;

        $latestUser = DB::table('karyawans')
            ->where('id', 'LIKE', "$prefix%")
            ->orderBy('id', 'desc')
            ->lockForUpdate()
            ->first();

        if (!$latestUser) {
            return $prefix . str_pad(1, $length, '0', STR_PAD_LEFT);
        }

        $lastUserCode = substr($latestUser->id, strlen($prefix));
        $lastNumber = (int) $lastUserCode;
        $newNumber = str_pad($lastNumber + 1, $length, '0', STR_PAD_LEFT);
        return $prefix . $newNumber;
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'id_karyawan', 'id');
    }
}
