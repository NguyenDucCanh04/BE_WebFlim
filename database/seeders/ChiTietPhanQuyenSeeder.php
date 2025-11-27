<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietPhanQuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chi_tiet_phan_quyens')->delete();
        DB::table('chi_tiet_phan_quyens')->truncate();

        // ADMIN - Có tất cả quyền (id_quyen = 1)
        $adminPermissions = [];
        for ($i = 1; $i <= 66; $i++) {
            $adminPermissions[] = [
                'id_chuc_nang' => $i,
                'id_quyen' => 1
            ];
        }

        // NHÂN VIÊN - Quyền hạn chế (id_quyen = 2)
        $staffPermissions = [
            // Quản lý Phim
            ['id_chuc_nang' => 1, 'id_quyen' => 1], // Xem
            ['id_chuc_nang' => 2, 'id_quyen' => 1], // Thêm
            ['id_chuc_nang' => 3, 'id_quyen' => 1], // Sửa
            ['id_chuc_nang' => 5, 'id_quyen' => 1], // Đổi trạng thái
            ['id_chuc_nang' => 6, 'id_quyen' => 1], // Đổi trạng thái chiếu
            ['id_chuc_nang' => 7, 'id_quyen' => 1], // Tìm kiếm

            // Quản lý Thể Loại
            ['id_chuc_nang' => 8, 'id_quyen' => 1], // Xem
            ['id_chuc_nang' => 9, 'id_quyen' => 1], // Thêm
            ['id_chuc_nang' => 10, 'id_quyen' => 1], // Sửa

            // Quản lý Phòng Chiếu
            ['id_chuc_nang' => 13, 'id_quyen' => 1], // Xem
            ['id_chuc_nang' => 17, 'id_quyen' => 1], // Đổi trạng thái

            // Quản lý Ghế
            ['id_chuc_nang' => 18, 'id_quyen' => 1], // Xem
            ['id_chuc_nang' => 22, 'id_quyen' => 1], // Đổi trạng thái

            // Quản lý Suất Chiếu
            ['id_chuc_nang' => 23, 'id_quyen' => 1], // Xem
            ['id_chuc_nang' => 24, 'id_quyen' => 1], // Thêm
            ['id_chuc_nang' => 25, 'id_quyen' => 1], // Sửa
            ['id_chuc_nang' => 27, 'id_quyen' => 1], // Đổi trạng thái

            // Quản lý Vé
            ['id_chuc_nang' => 28, 'id_quyen' => 1], // Xem vé
            ['id_chuc_nang' => 31, 'id_quyen' => 1], // Xác nhận thanh toán
            ['id_chuc_nang' => 32, 'id_quyen' => 1], // In vé

            // Quản lý Khách Hàng - chỉ xem
            ['id_chuc_nang' => 33, 'id_quyen' => 1], // Xem

            // Đăng nhập
            ['id_chuc_nang' => 39, 'id_quyen' => 1], // Đăng nhập

            // Quản lý Đánh Giá
            ['id_chuc_nang' => 45, 'id_quyen' => 1], // Xem
            ['id_chuc_nang' => 49, 'id_quyen' => 1], // Duyệt

            // Thống kê cơ bản
            ['id_chuc_nang' => 60, 'id_quyen' => 1], // Xem thống kê
            ['id_chuc_nang' => 61, 'id_quyen' => 1], // Thống kê phim hot
        ];

        // KHÁCH HÀNG - Quyền cơ bản (id_quyen = 3)
        $customerPermissions = [
            // Xem phim
            ['id_chuc_nang' => 1, 'id_quyen' => 1], // Xem danh sách phim
            ['id_chuc_nang' => 7, 'id_quyen' => 1], // Tìm kiếm phim

            // Xem thể loại
            ['id_chuc_nang' => 8, 'id_quyen' => 1], // Xem thể loại

            // Xem suất chiếu
            ['id_chuc_nang' => 23, 'id_quyen' => 1], // Xem suất chiếu

            // Đặt vé
            ['id_chuc_nang' => 28, 'id_quyen' => 1], // Xem vé của mình
            ['id_chuc_nang' => 29, 'id_quyen' => 1], // Đặt vé
            ['id_chuc_nang' => 30, 'id_quyen' => 1], // Hủy vé
            ['id_chuc_nang' => 31, 'id_quyen' => 1], // Thanh toán
            ['id_chuc_nang' => 32, 'id_quyen' => 1], // In vé

            // Quản lý tài khoản
            ['id_chuc_nang' => 35, 'id_quyen' => 1], // Cập nhật thông tin cá nhân
            ['id_chuc_nang' => 38, 'id_quyen' => 1], // Đăng ký
            ['id_chuc_nang' => 39, 'id_quyen' => 1], // Đăng nhập

            // Đánh giá phim
            ['id_chuc_nang' => 45, 'id_quyen' => 1], // Xem đánh giá
            ['id_chuc_nang' => 46, 'id_quyen' => 1], // Thêm đánh giá
            ['id_chuc_nang' => 47, 'id_quyen' => 1], // Sửa đánh giá của mình
            ['id_chuc_nang' => 48, 'id_quyen' => 1], // Xóa đánh giá của mình

            // Xem bài viết
            ['id_chuc_nang' => 50, 'id_quyen' => 1], // Xem bài viết
        ];

      
    }
}
