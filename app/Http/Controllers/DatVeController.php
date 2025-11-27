<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function getData()
    {
        // ID chức năng 28: Xem Danh Sách Vé Đã Đặt
        $id_chuc_nang = 28;
        $login = Auth::guard('sanctum')->user();
        if (!$login) {
            return response()->json([
                'data' => false,
                'message' => "Bạn chưa đăng nhập!"
            ], 401);
        }

        $id_quyen = $login->id_quyen;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if (!$check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "Bạn không có quyền thực hiện chức năng này!"
            ], 403);
        }

        $khachHangId = $login->id_khach_hang;

        $datVe = DB::table('dat_ves')
            ->where('id_khach_hang', $khachHangId)
            ->orderBy('ngay_dat', 'desc')
            ->get();

        return response()->json([
            'data' => true,
            'dat_ve' => $datVe
        ]);
    }

    public function datVe(Request $request)
    {
        // ID chức năng 29: Đặt Vé Phim
        $id_chuc_nang = 29;
        $login = Auth::guard('sanctum')->user();
        if (!$login) {
            return response()->json([
                'data' => false,
                'message' => "Bạn chưa đăng nhập!"
            ], 401);
        }

        $id_quyen = $login->id_quyen;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if (!$check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "Bạn không có quyền thực hiện chức năng này!"
            ], 403);
        }

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

    public function huyVe(Request $request)
    {
        // ID chức năng 30: Hủy Vé Đã Đặt
        $id_chuc_nang = 30;
        $login = Auth::guard('sanctum')->user();
        if (!$login) {
            return response()->json([
                'data' => false,
                'message' => "Bạn chưa đăng nhập!"
            ], 401);
        }

        $id_quyen = $login->id_quyen;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if (!$check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "Bạn không có quyền thực hiện chức năng này!"
            ], 403);
        }

        $v = Validator::make($request->all(), [
            'id_dat_ve' => 'required|integer',
        ]);
        if ($v->fails()) {
            return response()->json(['status' => false, 'message' => $v->errors()->first()], 422);
        }

        $idDatVe = $request->id_dat_ve;

        DB::beginTransaction();
        try {
            // kiểm tra vé
            $datVe = DB::table('dat_ves')->where('id', $idDatVe)->first();
            if (!$datVe) return response()->json(['status'=>false,'message'=>'Vé không tồn tại'],404);

            // kiểm tra quyền hủy vé
            $khachHangId = $login->id_khach_hang;
            if ($datVe->id_khach_hang != $khachHangId) {
                DB::rollBack();
                return response()->json(['status'=>false,'message'=>'Bạn không có quyền hủy vé này'],403);
            }

            // xóa chi tiết vé
            DB::table('chi_tiet_ves')->where('id_dat_ve', $idDatVe)->delete();

            // xóa vé
            DB::table('dat_ves')->where('id', $idDatVe)->delete();

            DB::commit();
            return response()->json(['status'=>true,'message'=>'Hủy vé thành công']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>'Lỗi server: '.$e->getMessage()],500);
        }
    }
}
