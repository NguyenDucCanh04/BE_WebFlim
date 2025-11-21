<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuatChieuSeeder extends Seeder
{
    public function run()
    {
        DB::table('suat_chieus')->delete();
       
        DB::table('suat_chieus')->insert([
            [
                'id_phim'            => 1,
                'id_phong'           => 1,
                'thoi_gian_bat_dau'  => '2025-11-20 14:00:00',
                'thoi_gian_ket_thuc' => '2025-11-20 16:00:00',
            ],
            [
                'id_phim'            => 2,
                'id_phong'           => 2,
                'thoi_gian_bat_dau'  => '2025-11-20 18:00:00',
                'thoi_gian_ket_thuc' => '2025-11-20 20:30:00',
            ],
        ]);
    }
}
