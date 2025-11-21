<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhGiaPhimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('danh_gia_phims')->delete();
        DB::table('danh_gia_phims')->truncate();

        DB::table('danh_gia_phims')->insert([
            [
                'id_phim' => 1,
                'id_khach_hang' => 1,
                'so_sao' => 5,
                'binh_luan' => 'Hay xuất sắc!',
                'ngay_danh_gia' => now(),
            ]
        ]);
    }
}
