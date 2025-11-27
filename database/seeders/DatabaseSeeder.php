<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
{

     Schema::disableForeignKeyConstraints();
    $this->call([
        KhachHangSeeder::class,
        AdminSeeder::class,
        QuyenSeeder::class,
        ChucNangSeeder::class,
        ChiTietPhanQuyenSeeder::class,

        TheLoaiSeeder::class,
        PhimSeeder::class,
        PhimTheLoaiSeeder::class,

        PhongChieuSeeder::class,
        GheNgoiSeeder::class,
        SuatChieuSeeder::class,

        DatVeSeeder::class,
        ChiTietVeSeeder::class,
        ThanhToanSeeder::class,

        BaiVietSeeder::class,
        DanhGiaPhimSeeder::class,
    ]);
    Schema::enableForeignKeyConstraints();
}
}
