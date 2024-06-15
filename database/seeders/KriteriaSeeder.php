<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'CRT0001', // tambahkan id 'KR0001'
                'nama' => 'Kompeten',
                'tipe' => 'core',
                'nilai' => 5,
            ],
            [
                'id' => 'CRT0002', // tambahkan id 'KR0002'
                'nama' => 'Akuntabel',
                'tipe' => 'core',
                'nilai' => 3,
            ],
            [
                'id' => 'CRT0003', // tambahkan id 'KR0003'
                'nama' => 'Berorientasi Pelayanan',
                'tipe' => 'core',
                'nilai' => 2,
            ],
            [
                'id' => 'CRT0004', // tambahkan id 'KR0004'
                'nama' => 'Loyal',
                'tipe' => 'core',
                'nilai' => 2,
            ],
            [
                'id' => 'CRT0005', // tambahkan id 'KR0005'
                'nama' => 'Harmonis',
                'tipe' => 'secondary',
                'nilai' => 2,
            ],
            [
                'id' => 'CRT0006', // tambahkan id 'KR0006'
                'nama' => 'Adaptif',
                'tipe' => 'secondary',
                'nilai' => 4,
            ],
            [
                'id' => 'CRT0007', // tambahkan id 'KR0007'
                'nama' => 'Kolaboratif',
                'tipe' => 'secondary',
                'nilai' => 5,
            ],
        ];

        Kriteria::insert($data);
    }
}
