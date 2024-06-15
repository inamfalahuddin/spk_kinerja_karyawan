<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false; // Tidak menggunakan auto-increment
    protected $primaryKey = 'id'; // Menggunakan 'id' sebagai primary key
    protected $keyType = 'string'; // Menentukan tipe data primary key

    protected $fillable = [
        'id', // Add this line
        'name',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = self::generateUserCode();
        });
    }

    private static function generateUserCode()
    {
        $latestUser = DB::table('users')->orderBy('id', 'desc')->first();

        if (!$latestUser) {
            return 'USR0001';
        }

        $lastUserCode = $latestUser->id;
        $lastNumber = (int) substr($lastUserCode, 3);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return 'USR' . $newNumber;
    }
}
