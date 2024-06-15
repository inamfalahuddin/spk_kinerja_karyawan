<?php

namespace Database\Seeders;

use App\Models\Train;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'TR0001', // tambahkan id 'TR0001   
                'selisih' => 0,
                'nilai' => 5,
                'keterangan' => 'Tidak ada selisih (kompetensi sesuai dengan yang dibutuhkan)',
            ],
            [
                'id' => 'TR0002', // tambahkan id 'TR0002'
                'selisih' => 1,
                'nilai' => 4.5,
                'keterangan' => 'Kompetensi individu kelebihan 1 tingkat/level',
            ],
            [
                'id' => 'TR0003', // tambahkan id 'TR0003'
                'selisih' => -1,
                'nilai' => 4,
                'keterangan' => 'Kompetensi individu kekurangan 1 tingkat/level',
            ],
            [
                'id' => 'TR0004', // tambahkan id 'TR0004'
                'selisih' => 2,
                'nilai' => 3.5,
                'keterangan' => 'Kompetensi individu kelebihan 2 tingkat/level',
            ],
            [
                'id' => 'TR0005', // tambahkan id 'TR0005
                'selisih' => -2,
                'nilai' => 3,
                'keterangan' => 'Kompetensi individu kekurangan 2 tingkat/level',
            ],
            [
                'id' => 'TR0006', // tambahkan id 'TR0006
                'selisih' => 3,
                'nilai' => 2.5,
                'keterangan' => 'Kompetensi individu kelebihan 3 tingkat/level',
            ],
            [
                'id' => 'TR0007', // tambahkan id 'TR0007   
                'selisih' => -3,
                'nilai' => 2,
                'keterangan' => 'Kompetensi individu kekurangan 3 tingkat/level',
            ],
            [
                'id' => 'TR0008', // tambahkan id 'TR0008
                'selisih' => 4,
                'nilai' => 1.5,
                'keterangan' => 'Kompetensi individu kelebihan 4 tingkat/level',
            ],
            [
                'id' => 'TR0009', // tambahkan id 'TR0009
                'selisih' => -4,
                'nilai' => 1,
                'keterangan' => 'Kompetensi individu kekurangan 4 tingkat/level',
            ],
        ];

        Train::insert($data);
    }
}
