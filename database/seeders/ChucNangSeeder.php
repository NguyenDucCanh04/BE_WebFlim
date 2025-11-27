<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucNangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chuc_nangs')->delete();
        DB::table('chuc_nangs')->truncate();

        DB::table('chuc_nangs')->insert([
            // Quản lý Phim
            ['id' => 1, 'ten_chuc_nang' => 'Xem Danh Sách Phim'],
            ['id' => 2, 'ten_chuc_nang' => 'Thêm Phim Mới'],
            ['id' => 3, 'ten_chuc_nang' => 'Cập Nhật Thông Tin Phim'],
            ['id' => 4, 'ten_chuc_nang' => 'Xóa Phim'],
            ['id' => 5, 'ten_chuc_nang' => 'Đổi Trạng Thái Phim'],
            ['id' => 6, 'ten_chuc_nang' => 'Đổi Trạng Thái Chiếu Phim'],
            ['id' => 7, 'ten_chuc_nang' => 'Tìm Kiếm Phim'],

            // Quản lý Thể Loại
            ['id' => 8, 'ten_chuc_nang' => 'Xem Danh Sách Thể Loại'],
            ['id' => 9, 'ten_chuc_nang' => 'Thêm Thể Loại Mới'],
            ['id' => 10, 'ten_chuc_nang' => 'Cập Nhật Thể Loại'],
            ['id' => 11, 'ten_chuc_nang' => 'Xóa Thể Loại'],
            ['id' => 12, 'ten_chuc_nang' => 'Đổi Trạng Thái Thể Loại'],

            // Quản lý Phòng Chiếu
            ['id' => 13, 'ten_chuc_nang' => 'Xem Danh Sách Phòng Chiếu'],
            ['id' => 14, 'ten_chuc_nang' => 'Thêm Phòng Chiếu Mới'],
            ['id' => 15, 'ten_chuc_nang' => 'Cập Nhật Phòng Chiếu'],
            ['id' => 16, 'ten_chuc_nang' => 'Xóa Phòng Chiếu'],
            ['id' => 17, 'ten_chuc_nang' => 'Đổi Trạng Thái Phòng Chiếu'],

            // Quản lý Ghế Ngồi
            ['id' => 18, 'ten_chuc_nang' => 'Xem Danh Sách Ghế'],
            ['id' => 19, 'ten_chuc_nang' => 'Thêm Ghế Mới'],
            ['id' => 20, 'ten_chuc_nang' => 'Cập Nhật Thông Tin Ghế'],
            ['id' => 21, 'ten_chuc_nang' => 'Xóa Ghế'],
            ['id' => 22, 'ten_chuc_nang' => 'Đổi Trạng Thái Ghế'],

            // Quản lý Suất Chiếu
            ['id' => 23, 'ten_chuc_nang' => 'Xem Danh Sách Suất Chiếu'],
            ['id' => 24, 'ten_chuc_nang' => 'Thêm Suất Chiếu Mới'],
            ['id' => 25, 'ten_chuc_nang' => 'Cập Nhật Suất Chiếu'],
            ['id' => 26, 'ten_chuc_nang' => 'Xóa Suất Chiếu'],
            ['id' => 27, 'ten_chuc_nang' => 'Đổi Trạng Thái Suất Chiếu'],

            // Quản lý Đặt Vé
            ['id' => 28, 'ten_chuc_nang' => 'Xem Danh Sách Vé Đã Đặt'],
            ['id' => 29, 'ten_chuc_nang' => 'Đặt Vé Phim'],
            ['id' => 30, 'ten_chuc_nang' => 'Hủy Vé Đã Đặt'],
            ['id' => 31, 'ten_chuc_nang' => 'Xác Nhận Thanh Toán'],
            ['id' => 32, 'ten_chuc_nang' => 'In Vé Điện Tử'],

            // Quản lý Khách Hàng
            ['id' => 33, 'ten_chuc_nang' => 'Xem Danh Sách Khách Hàng'],
            ['id' => 34, 'ten_chuc_nang' => 'Thêm Khách Hàng Mới'],
            ['id' => 35, 'ten_chuc_nang' => 'Cập Nhật Thông Tin Khách Hàng'],
            ['id' => 36, 'ten_chuc_nang' => 'Xóa Tài Khoản Khách Hàng'],
            ['id' => 37, 'ten_chuc_nang' => 'Đổi Trạng Thái Khách Hàng'],
            ['id' => 38, 'ten_chuc_nang' => 'Đăng Ký Tài Khoản'],
            ['id' => 39, 'ten_chuc_nang' => 'Đăng Nhập Hệ Thống'],

            // Quản lý Admin/Nhân Viên
            ['id' => 40, 'ten_chuc_nang' => 'Xem Danh Sách Admin'],
            ['id' => 41, 'ten_chuc_nang' => 'Thêm Admin Mới'],
            ['id' => 42, 'ten_chuc_nang' => 'Cập Nhật Thông Tin Admin'],
            ['id' => 43, 'ten_chuc_nang' => 'Xóa Tài Khoản Admin'],
            ['id' => 44, 'ten_chuc_nang' => 'Đổi Trạng Thái Admin'],

            // Quản lý Đánh Giá
            ['id' => 45, 'ten_chuc_nang' => 'Xem Đánh Giá Phim'],
            ['id' => 46, 'ten_chuc_nang' => 'Thêm Đánh Giá Phim'],
            ['id' => 47, 'ten_chuc_nang' => 'Cập Nhật Đánh Giá'],
            ['id' => 48, 'ten_chuc_nang' => 'Xóa Đánh Giá'],
            ['id' => 49, 'ten_chuc_nang' => 'Duyệt Đánh Giá'],

            // Quản lý Bài Viết
            ['id' => 50, 'ten_chuc_nang' => 'Xem Danh Sách Bài Viết'],
            ['id' => 51, 'ten_chuc_nang' => 'Thêm Bài Viết Mới'],
            ['id' => 52, 'ten_chuc_nang' => 'Cập Nhật Bài Viết'],
            ['id' => 53, 'ten_chuc_nang' => 'Xóa Bài Viết'],
            ['id' => 54, 'ten_chuc_nang' => 'Đổi Trạng Thái Bài Viết'],

            // Quản lý Phân Quyền
            ['id' => 55, 'ten_chuc_nang' => 'Xem Danh Sách Quyền'],
            ['id' => 56, 'ten_chuc_nang' => 'Thêm Quyền Mới'],
            ['id' => 57, 'ten_chuc_nang' => 'Cập Nhật Quyền'],
            ['id' => 58, 'ten_chuc_nang' => 'Xóa Quyền'],
            ['id' => 59, 'ten_chuc_nang' => 'Phân Quyền Cho User'],

            // Thống Kê & Báo Cáo
            ['id' => 60, 'ten_chuc_nang' => 'Xem Thống Kê Doanh Thu'],
            ['id' => 61, 'ten_chuc_nang' => 'Thống Kê Phim Hot'],
            ['id' => 62, 'ten_chuc_nang' => 'Báo Cáo Tổng Quan'],
            ['id' => 63, 'ten_chuc_nang' => 'Xuất Báo Cáo Excel'],

            // Cài Đặt Hệ Thống
            ['id' => 64, 'ten_chuc_nang' => 'Cấu Hình Hệ Thống'],
            ['id' => 65, 'ten_chuc_nang' => 'Backup Dữ Liệu'],
            ['id' => 66, 'ten_chuc_nang' => 'Quản Lý Log Hệ Thống'],
        ]);
    }
}
