<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DatVeController extends Controller
{
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id_khach_hang' => 'required|integer',
            'id_suat_chieu' => 'required|integer',
            'selected_seats' => 'required|array|min:1',
            'tong_tien' => 'required|numeric',
        ]);
        if ($v->fails()) {
            return response()->json(['status' => false, 'message' => $v->errors()->first()], 422);
        }

        $selected = array_map('strval', $request->selected_seats);

        DB::beginTransaction();
        try {
            // lấy phòng của suất
            $suat = DB::table('lich_chieus')->where('id', $request->id_suat_chieu)->first();
            if (!$suat) return response()->json(['status'=>false,'message'=>'Suất chiếu không tồn tại'],404);

            // tìm id ghế theo label
            $gheRows = DB::table('ghe_ngois')
                ->where('id_phong', $suat->id_phong)
                ->whereIn('so_ghe', $selected)
                ->get()
                ->keyBy('so_ghe')
                ->all();

            // kiểm tra tồn tại và đã đặt
            $missing = array_filter($selected, fn($lbl) => !isset($gheRows[$lbl]));
            if (count($missing)) {
                DB::rollBack();
                return response()->json(['status'=>false,'message'=>'Ghế không tồn tại: '.implode(', ',$missing)],422);
            }

            $already = [];
            foreach ($selected as $lbl) {
                $g = $gheRows[$lbl];
                $exists = DB::table('chi_tiet_ves')
                    ->where('id_suat_chieu', $request->id_suat_chieu)
                    ->where('id_ghe', $g->id)
                    ->exists();
                if ($exists) $already[] = $lbl;
            }
            if (count($already)) {
                DB::rollBack();
                return response()->json(['status'=>false,'message'=>'Ghế đã bị đặt: '.implode(', ',$already)],409);
            }

            $idDatVe = DB::table('dat_ves')->insertGetId([
                'id_khach_hang' => $request->id_khach_hang,
                'id_suat_chieu' => $request->id_suat_chieu,
                'tong_tien' => $request->tong_tien,
                'trang_thai' => $request->input('trang_thai','pending'),
                'ngay_dat' => $request->ngay_dat ?? now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($selected as $lbl) {
                $g = $gheRows[$lbl];
                DB::table('chi_tiet_ves')->insert([
                    'id_dat_ve' => $idDatVe,
                    'id_ghe' => $g->id,
                    'so_ghe' => $lbl,
                    'id_suat_chieu' => $request->id_suat_chieu,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return response()->json(['status'=>true,'message'=>'Đặt vé thành công','id_dat_ve'=>$idDatVe]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>'Lỗi server: '.$e->getMessage()],500);
        }
    }
}
