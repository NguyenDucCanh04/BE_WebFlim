<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietVeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chi_tiet_ves')->delete();
        DB::table('chi_tiet_ves')->truncate();
        DB::table('chi_tiet_ves')->insert([
            [
                'id_dat_ve' => 1,
                'id_ghe' => 1,
                'gia_ve' => 90000,
            ]
        ]);
    }
}
