<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 'USR0001', // Sesuaikan dengan format ID yang Anda inginkan
            'name' => 'John Doe', // Ganti dengan nama pengguna
            'username' => 'admin', // Ganti dengan username
            'password' => Hash::make('password'), // Ganti dengan password yang di-hash
            'role' => 'admin', // Atur peran pengguna
        ]);
    }
}
