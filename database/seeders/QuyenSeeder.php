<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuyenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('quyens')->delete();
      
        DB::table('quyens')->insert([
            [
                'id'             =>  1,
                'ten_quyen'      =>  'Admin',
            ],
            [
                'id'             =>  2,
                'ten_quyen'      =>  'khách hàng',
            ],
        ]);
    }
}
