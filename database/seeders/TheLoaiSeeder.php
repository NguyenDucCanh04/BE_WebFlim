<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TheLoaiSeeder extends Seeder
{
    public function run()
    {
        DB::table('the_loais')->delete();


        DB::table('the_loais')->insert([
            ['id' => 1, 'ten_the_loai' => 'Hành động', 'trang_thai' => 1],
            ['id' => 2, 'ten_the_loai' => 'Tình cảm', 'trang_thai' => 1],
            ['id' => 3, 'ten_the_loai' => 'Hài', 'trang_thai' => 1],
            ['id' => 4, 'ten_the_loai' => 'Kinh dị', 'trang_thai' => 1],
            ['id' => 5, 'ten_the_loai' => 'Viễn tưởng', 'trang_thai' => 1],
            ['id' => 6, 'ten_the_loai' => 'Hoạt hình', 'trang_thai' => 1],
        ]);
    }
}
