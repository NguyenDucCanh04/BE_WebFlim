<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaiVietSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bai_viets')->truncate();

        DB::table('bai_viets')->insert([

            [
                'tieu_de' => '🎉 Combo Siêu Tiết Kiệm – Mua 2 Vé Tặng 1 Bắp Nước!',
                'noi_dung' =>
                "Thưởng thức phim hay cùng ưu đãi hấp dẫn tại WebFlim!
                Từ ngày 01/12 – 31/12:
                - Mua **2 vé bất kỳ** sẽ được TẶNG ngay **01 combo bắp + nước** trị giá 79.000đ.
                - Áp dụng cho tất cả các suất chiếu trong ngày.
                - Không giới hạn số combo!
                Nhanh tay đặt vé để không bỏ lỡ ưu đãi siêu hot tháng này!",
                'anh_dai_dien' => 'https://starlight.vn/Areas/Admin/Content/Fileuploads/images/POSTER/z4614096556317_5981a2574bdf8edc35012ce8055b3475.jpg',
                'ngay_dang' => now()->subDays(3),
                'tac_gia' => 1,
                'trang_thai' => 1,
            ],

            [
                'tieu_de' => '🔥 Thứ 4 Vui Vẻ – Đồng Giá Vé Chỉ 45K!',
                'noi_dung' =>
                "Mỗi thứ 4 hàng tuần, WebFlim triển khai chương trình **ĐỒNG GIÁ 45.000đ** toàn rạp.
                🎬 Áp dụng:
                - Tất cả phim 2D
                - Ghế thường và VIP (tùy rạp)
                - Không giới hạn số lượng vé
                Nhanh tay đặt vé để cùng bạn bè thưởng thức phim giá rẻ nhé!",
                'anh_dai_dien' => 'https://gigamall.com.vn/data/2022/03/10/02471131_cgv.png',
                'ngay_dang' => now()->subDays(7),
                'tac_gia' => 1,
                'trang_thai' => 1,
            ],

            [
                'tieu_de' => '✨ Khai Trương Phòng Chiếu Laser – Giảm 30% Vé Phim',
                'noi_dung' =>
                "WebFlim ra mắt phòng chiếu công nghệ **Laser Digital** chuẩn Hollywood.
                🎁 Ưu đãi:
                - Giảm **30% giá vé**
                - Tặng voucher nước miễn phí
                - Áp dụng từ 05/12 đến 20/12
                Trải nghiệm điện ảnh đỉnh cao ngay hôm nay!",
                'anh_dai_dien' => 'https://bvhttdl.mediacdn.vn/2020/9/23/a6-16008516124242014943308.jpg',
                'ngay_dang' => now()->subDays(10),
                'tac_gia' => 1,
                'trang_thai' => 1,
            ],

            [
                'tieu_de' => '🍿 Combo Gia Đình – 4 Vé + 2 Bắp + 2 Nước Chỉ 199K',
                'noi_dung' =>
                "Combo siêu tiết kiệm dành cho gia đình:
                🎁 Gồm:
                - 4 vé phim 2D
                - 2 bắp lớn
                - 2 nước 650ml
                Giá chỉ **199.000đ**, áp dụng cuối tuần!",
                'anh_dai_dien' => 'https://channel.mediacdn.vn/prupload/879/2018/05/img20180510214548269.jpg',
                'ngay_dang' => now()->subDays(12),
                'tac_gia' => 1,
                'trang_thai' => 1,
            ],

            [
                'tieu_de' => '🎓 Ưu Đãi Sinh Viên – Vé Xem Phim Chỉ 39K',
                'noi_dung' =>
                "Sinh viên được ưu đãi cực lớn tại WebFlim!
                📌 Ưu đãi:
                - Vé: **39.000đ**
                - Giảm 10% combo bắp nước
                - Áp dụng Thứ 2–6 trước 17h
                Chỉ cần mang thẻ sinh viên!",
                'anh_dai_dien' => 'https://static.vivnpay.vn/202506241615/ma-giam-gia-cgv-doc-quyen-chi-39000-dong_1254726592208650240.png',
                'ngay_dang' => now()->subDays(15),
                'tac_gia' => 1,
                'trang_thai' => 1,
            ],

            [
                'tieu_de' => '💖 Combo Couple – 2 Vé + 1 Bắp + 1 Nước Đôi Chỉ 99K',
                'noi_dung' =>
                "Ưu đãi cực dễ thương dành cho các cặp đôi:
                ❤️ Combo bao gồm:
                - 2 vé phim
                - 1 bắp lớn
                - 1 nước đôi
                Giá chỉ **99.000đ** – áp dụng cuối tuần.",
                'anh_dai_dien' => 'https://starlight.vn/Areas/Admin/Content/Fileuploads/images/POSTER/358456703_662531539248301_7975704718166601407_n.jpg',
                'ngay_dang' => now()->subDays(18),
                'tac_gia' => 1,
                'trang_thai' => 1,
            ],

            [
                'tieu_de' => '🎁 Thành Viên Mới – Nhận Ngay Voucher 50K',
                'noi_dung' =>
                "Đăng ký tài khoản WebFlim để nhận:
                - Voucher giảm **50.000đ**
                - Ưu tiên nhận thông báo phim mới
                - Tích điểm đổi quà hấp dẫn
                Hoàn toàn miễn phí!",
                'anh_dai_dien' => 'https://cdn-together.hellohealthgroup.com/2024/05/1716541464_66505818033164.4410243000.jpg',
                'ngay_dang' => now()->subDays(20),
                'tac_gia' => 1,
                'trang_thai' => 1,
            ],

            [
                'tieu_de' => '🎉 Super Sale Cuối Năm – Vé Chỉ 35K Khi Đặt Online',
                'noi_dung' =>
                "Siêu ưu đãi cuối năm từ WebFlim:
                🔥 Vé chỉ **35.000đ** khi đặt qua website/app
                🔥 Áp dụng tất cả phim 2D
                🔥 Số lượng có hạn mỗi ngày
                Nhanh tay săn vé ngay!",
                'anh_dai_dien' => 'https://www.bigc.vn/files/banners/2022/july-trang/mega/combo35k-1080x540-go.png',
                'ngay_dang' => now()->subDays(23),
                'tac_gia' => 1,
                'trang_thai' => 1,
            ],

        ]);
    }
}
