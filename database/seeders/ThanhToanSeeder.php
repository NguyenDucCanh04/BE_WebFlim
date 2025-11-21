<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThanhToanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('thanh_toans')->delete();
        DB::table('thanh_toans')->truncate();

        DB::table('thanh_toans')->insert([
            [
                'id_dat_ve' => 1,
                'phuong_thuc' => 'MoMo',
                'so_tien' => 90000,
                'thoi_gian' => now(),
                'trang_thai' => 'Thành công',
            ]
        ]);
    }
}
