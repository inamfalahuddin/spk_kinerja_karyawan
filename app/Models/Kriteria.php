<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'tipe',
        'nilai',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = self::generateKodeKriteria();
        });
    }

    private static function generateKodeKriteria()
    {
        $latestKriteria = self::orderBy('id', 'desc')->first();

        if (!$latestKriteria) {
            return 'CRT0001';
        }

        $lastKodeKriteria = $latestKriteria->id;
        $lastNumber = (int) substr($lastKodeKriteria, 3);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return 'CRT' . $newNumber;
    }
}
