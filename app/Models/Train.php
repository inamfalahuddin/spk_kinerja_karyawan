<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Train extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'selisih',
        'nilai',
        'keterangan',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = self::generateKodeTrain();
        });
    }

    private static function generateKodeTrain()
    {
        $latestUser = DB::table('trains')->orderBy('id', 'desc')->first();

        if (!$latestUser) {
            return 'TR0001';
        }

        $lastUserCode = $latestUser->id;
        $lastNumber = (int) substr($lastUserCode, 3);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return 'TR' . $newNumber;
    }
}
