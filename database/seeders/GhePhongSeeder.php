<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GhePhongSeeder extends Seeder
{
    public function run(): void
    {
        $table = 'ghe_ngois';
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // kiểm tra bảng tồn tại
        $exists = DB::selectOne("SELECT COUNT(*) AS cnt FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?", [$table]);
        if (!$exists || $exists->cnt == 0) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            throw new \Exception("Bảng {$table} không tồn tại trong database.");
        }

        // Lấy meta cột để biết cột nào bắt buộc
        $cols = DB::select("SELECT COLUMN_NAME, IS_NULLABLE, COLUMN_DEFAULT, DATA_TYPE, COLUMN_KEY FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?", [$table]);
        $colMeta = [];
        foreach ($cols as $c) {
            $colMeta[$c->COLUMN_NAME] = [
                'nullable' => ($c->IS_NULLABLE === 'YES'),
                'default'  => $c->COLUMN_DEFAULT,
                'type'     => $c->DATA_TYPE,
                'key'      => $c->COLUMN_KEY,
            ];
        }

        // Xóa ghế hiện có cho phòng 1 nếu có cột id_phong, ngược lại xóa toàn bộ
        if (array_key_exists('id_phong', $colMeta)) {
            DB::table($table)->where('id_phong', 1)->delete();
        } else {
            DB::table($table)->delete();
        }

        // tìm tên cột chứa label ghế (so_ghe / ten / label)
        $seatLabelCol = null;
        foreach (['so_ghe','ten','label','seat'] as $candidate) {
            if (array_key_exists($candidate, $colMeta)) { $seatLabelCol = $candidate; break; }
        }
        if (!$seatLabelCol) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            throw new \Exception("Không tìm thấy cột chứa label ghế (so_ghe/ten/label) trong bảng {$table}.");
        }

        // chuẩn bị insert, phát hiện các cột bắt buộc thiếu default để điền giá trị
        $rows = 8; $colsCount = 10;
        $inserts = [];
        $now = now();

        for ($r=0;$r<$rows;$r++) {
            $rowLabel = chr(65 + $r);
            for ($c=1;$c<=$colsCount;$c++) {
                $label = $rowLabel . $c;
                $row = [];
                // điền label
                $row[$seatLabelCol] = $label;
                // nếu có id_phong, gán 1
                if (array_key_exists('id_phong', $colMeta)) $row['id_phong'] = 1;
                // nếu có cột loại ghế/loai_ghe/loai -> gán 'standard'
                foreach (['loai_ghe','loai','type','kieu'] as $name) {
                    if (array_key_exists($name, $colMeta)) {
                        $row[$name] = 'standard';
                        break;
                    }
                }
                // nếu có cột gia/price -> gán 80000
                foreach (['gia','price','cost','price_vnd'] as $name) {
                    if (array_key_exists($name, $colMeta)) {
                        $row[$name] = 80000;
                        break;
                    }
                }
                // gán timestamps nếu tồn tại
                if (array_key_exists('created_at', $colMeta)) $row['created_at'] = $now;
                if (array_key_exists('updated_at', $colMeta)) $row['updated_at'] = $now;

                // cho các cột khác bắt buộc nhưng chưa có giá trị, gán mặc định theo kiểu
                foreach ($colMeta as $colName => $meta) {
                    if (isset($row[$colName])) continue;
                    if ($meta['key'] === 'PRI') continue;
                    if ($meta['nullable']) continue;
                    if (!is_null($meta['default'])) continue;

                    // skip timestamps (đã gán)
                    if (in_array($colName, ['created_at','updated_at'])) continue;

                    // gán mặc định chung theo kiểu dữ liệu / tên cột
                    if (stripos($colName, 'id_') === 0) {
                        $row[$colName] = 1;
                        continue;
                    }
                    if (stripos($colName, 'ngay') !== false || stripos($colName, 'date') !== false) {
                        $row[$colName] = now();
                        continue;
                    }
                    // nếu numeric type
                    if (in_array($meta['type'], ['int','bigint','tinyint','smallint','mediumint','decimal','float','double'])) {
                        $row[$colName] = 0;
                        continue;
                    }
                    // mặc định chuỗi rỗng
                    $row[$colName] = '';
                }

                $inserts[] = $row;
            }
        }

        if (!empty($inserts)) {
            DB::table($table)->insert($inserts);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
