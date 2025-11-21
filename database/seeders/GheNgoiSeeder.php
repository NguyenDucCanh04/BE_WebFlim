<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GheNgoiSeeder extends Seeder
{
    public function run()
    {
        DB::table('ghe_ngois')->delete();

        $rows = [];
        $hangs = range('A', 'H');  // A -> H (8 hàng)
        $so_ghe_moi_hang = 12;

        foreach ($hangs as $hang) {
            for ($i = 1; $i <= $so_ghe_moi_hang; $i++) {

                // Ghế VIP thực tế: ở khu vực giữa
                $loai_ghe = in_array($hang, ['D', 'E']) ? 'VIP' : 'Thường';

                $rows[] = [
                    'id_phong' => 1,
                    'so_ghe'   => $hang . $i,
                    'loai_ghe' => $loai_ghe,
                ];
            }
        }

        DB::table('ghe_ngois')->insert($rows);
    }
}
