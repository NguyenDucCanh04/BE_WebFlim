<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatVeSeeder extends Seeder
{
    public function run()
    {


        DB::table('dat_ves')->delete();
        



        // 5. Seed dữ liệu đặt vé
        DB::table('dat_ves')->insert([
            [
                'id_khach_hang' => 1,
                'id_suat_chieu' => 1,
                'tong_tien'     => 150000,
                'trang_thai'    => 'Đã thanh toán',
                'ngay_dat'      => now(),
            ],
            [
                'id_khach_hang' => 2,
                'id_suat_chieu' => 2,
                'tong_tien'     => 200000,
                'trang_thai'    => 'Chưa thanh toán',
                'ngay_dat'      => now(),
            ],
        ]);
    }
}
