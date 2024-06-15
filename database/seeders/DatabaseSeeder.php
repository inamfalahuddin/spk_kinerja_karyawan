<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(UsersSeeder::class);
        $this->call(KriteriaSeeder::class);
        $this->call(TrainSeeder::class);
        $this->call(KaryawanSeeder::class);
    }
}
