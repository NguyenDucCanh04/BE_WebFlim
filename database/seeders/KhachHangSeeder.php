<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KhachHangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('khach_hangs')->delete();
        DB::table('khach_hangs')->insert([
            [
                'ho_ten' => 'Nguyễn Văn A',
                'email' => 'khach1@gmail.com',
                'password' => Hash::make('123456'),
                'so_dien_thoai' => '0909000001',
                'gioi_tinh' => '1',
                'ngay_sinh' => '1990-01-01',
                'anh_dai_dien' => '',
                'trang_thai' => 1,
            ],
            [
                'ho_ten' => 'Trần Thị B',
                'email' => 'khach2@gmail.com',
                'password' => Hash::make('123456'),
                'so_dien_thoai' => '0909000002',
                'gioi_tinh' => '1',
                'ngay_sinh' => '1992-05-05',
                'anh_dai_dien' => '',
                'trang_thai' => 1,
            ]
        ]);
    }
}
