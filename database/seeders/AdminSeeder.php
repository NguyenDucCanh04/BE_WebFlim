<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
         DB::table('admins')->delete();
        DB::table('admins')->insert([
            [
                'ho_ten' => 'Admin Chính',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'so_dien_thoai' => '0988111222',
                'gioi_tinh' => 1,
                'ngay_sinh' => '1985-10-10',
                'anh_dai_dien' => '',
                'trang_thai' => 1,
            ]
        ]);
    }
}
