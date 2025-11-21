<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaiVietSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bai_viets')->delete();
        DB::table('bai_viets')->truncate();
        DB::table('bai_viets')->insert([
            [
                'tieu_de' => 'Review Endgame',
                'noi_dung' => 'Phim rất hay…',
                'anh_dai_dien' => '',
                'ngay_dang' => now(),
                'tac_gia' => 1,
            ]
        ]);
    }
}
