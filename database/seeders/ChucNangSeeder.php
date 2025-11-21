<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucNangSeeder extends Seeder
{
    public function run(): void {
        DB::table('chuc_nangs')->delete();
       
        DB::table('chuc_nangs')->insert([
            // Nhóm người dùng
            ['id' => 1, 'ten_chuc_nang' => 'Đăng Nhập'],
            ['id' => 2, 'ten_chuc_nang' => 'Đăng Ký'],
            ['id' => 3, 'ten_chuc_nang' => 'Đăng Xuất'],
            ['id' => 4, 'ten_chuc_nang' => 'Quản Lý Thông Tin Cá Nhân'],
            ['id' => 5, 'ten_chuc_nang' => 'Quên Mật Khẩu'],

            // Nghiệp vụ khách hàng
            ['id' => 6, 'ten_chuc_nang' => 'Xem Vé Đã Đặt'],
            ['id' => 7, 'ten_chuc_nang' => 'Tìm Kiếm Phim'],
            ['id' => 8, 'ten_chuc_nang' => 'Đặt Vé'],
            ['id' => 9, 'ten_chuc_nang' => 'Thanh Toán'],
            ['id' => 10, 'ten_chuc_nang' => 'Xem Bài Viết / Tin Tức'],
            ['id' => 11, 'ten_chuc_nang' => 'Xem Thông Tin Phim'],
            ['id' => 12, 'ten_chuc_nang' => 'Đánh Giá Phim'],

            // Nhóm quản lý
            ['id' => 13, 'ten_chuc_nang' => 'Quản Lý Tài Khoản Người Dùng'],
            ['id' => 14, 'ten_chuc_nang' => 'Quản Lý Suất Chiếu'],
            ['id' => 15, 'ten_chuc_nang' => 'Quản Lý Vé'],
            ['id' => 16, 'ten_chuc_nang' => 'Quản Lý Phòng Chiếu'],
            ['id' => 17, 'ten_chuc_nang' => 'Quản Lý Ghế'],
            ['id' => 18, 'ten_chuc_nang' => 'Quản Lý Phim'],
            ['id' => 19, 'ten_chuc_nang' => 'Quản Lý Bài Viết'],
            ['id' => 20, 'ten_chuc_nang' => 'Quản Lý Đánh Giá'],
            ['id' => 21, 'ten_chuc_nang' => 'Báo Cáo Thống Kê'],
            ['id' => 22, 'ten_chuc_nang' => 'Chatbox & AI Hỗ Trợ Khách Hàng']
        ]);
    }
}
