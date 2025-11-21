<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhongChieuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('phong_chieus')->delete();

        DB::table('phong_chieus')->insert([
            [
                'id'        => 1,
                'ten_phong' => 'Phòng 1',
                'so_ghe'    => 96,
                'mo_ta'     => 'Phòng tiêu chuẩn',
            ],
            [
                'id'        => 2,
                'ten_phong' => 'Phòng 2',
                'so_ghe'    => 140,
                'mo_ta'     => 'Phòng màn lớn',
            ],
            [
                'id'        => 3,
                'ten_phong' => 'Phòng 3',
                'so_ghe'    => 176,
                'mo_ta'     => 'Phòng VIP âm thanh 7.1',
            ],
        ]);
    }
}
