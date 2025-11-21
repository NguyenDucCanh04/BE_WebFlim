<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShowtimesSeeder extends Seeder
{
    public function run(): void
    {
        $table = 'lich_chieus';

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // kiểm tra bảng tồn tại
        $exists = DB::selectOne(
            "SELECT COUNT(*) AS cnt FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?",
            [$table]
        );
        if (!$exists || $exists->cnt == 0) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            throw new \Exception("Bảng {$table} không tồn tại trong database.");
        }

        // truncate/delete tùy cấu trúc
        if (Schema::hasColumn($table, 'id')) {
            DB::table($table)->truncate();
        } else {
            DB::table($table)->delete();
        }

        $now = now();
        DB::table($table)->insert([
            [
                'id_phim' => 1,
                'id_phong' => 1,
                'ngay_gio_bat_dau' => $now->copy()->addDay()->setTime(18, 0, 0),
                'gia' => 80000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_phim' => 1,
                'id_phong' => 1,
                'ngay_gio_bat_dau' => $now->copy()->addDay()->setTime(20, 30, 0),
                'gia' => 90000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
