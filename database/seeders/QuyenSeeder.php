<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quyens')->delete();
        DB::table('quyens')->truncate();

        DB::table('quyens')->insert([
             [
                'id'             =>  1,
                'ten_quyen'      =>  'Admin',
            ],
            [
                'id'             =>  2,
                'ten_quyen'      =>  'Nhân Viên',
            ],
        ]);
    }
}
