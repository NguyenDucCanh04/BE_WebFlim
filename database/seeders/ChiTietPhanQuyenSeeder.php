<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietPhanQuyenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('chi_tiet_phan_quyens')->delete();

        DB::table('chi_tiet_phan_quyens')->truncate();

        DB::table('chi_tiet_phan_quyens')->insert([
            ['id_chuc_nang' => '1', 'id_quyen' => 1],
            ['id_chuc_nang' => '2', 'id_quyen' => 1],
            ['id_chuc_nang' => '3', 'id_quyen' => 1],
            ['id_chuc_nang' => '4', 'id_quyen' => 1],
            ['id_chuc_nang' => '5', 'id_quyen' => 1],
            ['id_chuc_nang' => '6', 'id_quyen' => 1],
            ['id_chuc_nang' => '7', 'id_quyen' => 1],
            ['id_chuc_nang' => '8', 'id_quyen' => 1],
            ['id_chuc_nang' => '9', 'id_quyen' => 1],
            ['id_chuc_nang' => '10', 'id_quyen' => 1],
            ['id_chuc_nang' => '11', 'id_quyen' => 1],
            ['id_chuc_nang' => '12', 'id_quyen' => 1],
            ['id_chuc_nang' => '13', 'id_quyen' => 1],
            ['id_chuc_nang' => '14', 'id_quyen' => 1],
            ['id_chuc_nang' => '15', 'id_quyen' => 1],
            ['id_chuc_nang' => '16', 'id_quyen' => 1],
            ['id_chuc_nang' => '17', 'id_quyen' => 1],
            ['id_chuc_nang' => '18', 'id_quyen' => 1],
            ['id_chuc_nang' => '19', 'id_quyen' => 1],
            ['id_chuc_nang' => '20', 'id_quyen' => 1],
            ['id_chuc_nang' => '21', 'id_quyen' => 1],
            ['id_chuc_nang' => '22', 'id_quyen' => 1],

        ]);
    }
}
