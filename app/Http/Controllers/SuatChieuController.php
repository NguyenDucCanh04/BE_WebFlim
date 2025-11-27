<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuatChieuController extends Controller
{
    public function index(Request $request)
    {
        $phimId = $request->query('phim_id');
        if (!$phimId) {
            return response()->json(['status' => false, 'message' => 'Thiếu phim_id'], 400);
        }

        $showtimes = DB::table('lich_chieus')
            ->where('id_phim', $phimId)
            ->orderBy('ngay_gio_bat_dau')
            ->get();

        $result = [];
        foreach ($showtimes as $s) {
            // lấy tất cả ghế của phòng
            $seats = DB::table('ghe_ngois')
                ->where('id_phong', $s->id_phong)
                ->orderBy('so_ghe') // giả định so_ghe như "A1","A2" sắp xếp ok
                ->get()
                ->map(function($g){
                    return [
                        'id' => $g->id,
                        'label' => (string)($g->so_ghe ?? $g->id),
                        'row' => preg_replace('/\d+/','', ($g->so_ghe ?? '')),
                        'col' => (int)preg_replace('/\D+/','', ($g->so_ghe ?? '0')),
                        'type' => $g->loai ?? 'standard',
                        'price' => $g->gia ?? null, // null => fallback to suatchieu price
                    ];
                })
                ->all();

            // ghế đã bị đặt cho suất này
            $reservedRows = DB::table('chi_tiet_ves as ct')
                ->join('ghe_ngois as g', 'ct.id_ghe', '=', 'g.id')
                ->where('ct.id_suat_chieu', $s->id)
                ->select('g.id','g.so_ghe')
                ->get()
                ->pluck('so_ghe')
                ->map(fn($v)=>(string)$v)
                ->all();

            // tính rows/cols
            $rowsLabels = collect($seats)->pluck('row')->unique()->values()->all();
            $colsMax = collect($seats)->pluck('col')->filter()->max() ?? 0;

            // build seat_map.seats with reserved flag
            $seatsMap = array_map(function($seat) use ($reservedRows) {
                $seat['reserved'] = in_array($seat['label'], $reservedRows);
                return $seat;
            }, $seats);

            $seat_map = [
                'rows' => count($rowsLabels),
                'cols' => $colsMax,
                'rows_labels' => $rowsLabels,
                'seats' => $seatsMap,
                'reserved_labels' => $reservedRows,
            ];

            $result[] = [
                'id' => $s->id,
                'ngay_gio' => $s->ngay_gio_bat_dau,
                'gia' => $s->gia ?? $s->price ?? 0,
                'id_phong' => $s->id_phong,
                'seat_map' => $seat_map,
            ];
        }

        return response()->json(['status' => true, 'data' => $result]);
    }

    // public function getData()
    // {
    //     // ID chức năng 23: Xem Danh Sách Suất Chiếu
    //     $id_chuc_nang = 23;
    //     $login = Auth::guard('sanctum')->user();
    //     if (!$login) {
    //         return response()->json([
    //             'data' => false,
    //             'message' => "Bạn chưa đăng nhập!"
    //         ], 401);
    //     }

    //     $id_quyen = $login->id_quyen;
    //     $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
    //         ->where('id_chuc_nang', $id_chuc_nang)
    //         ->first();
    //     if (!$check_quyen) {
    //         return response()->json([
    //             'data' => false,
    //             'message' => "Bạn không có quyền thực hiện chức năng này!"
    //         ], 403);
    //     }

    //     $phimId = $request->query('phim_id');
    //     if (!$phimId) {
    //         return response()->json(['status' => false, 'message' => 'Thiếu phim_id'], 400);
    //     }

    //     $showtimes = DB::table('lich_chieus')
    //         ->where('id_phim', $phimId)
    //         ->orderBy('ngay_gio_bat_dau')
    //         ->get();

    //     $result = [];
    //     foreach ($showtimes as $s) {
    //         // lấy tất cả ghế của phòng
    //         $seats = DB::table('ghe_ngois')
    //             ->where('id_phong', $s->id_phong)
    //             ->orderBy('so_ghe') // giả định so_ghe như "A1","A2" sắp xếp ok
    //             ->get()
    //             ->map(function($g){
    //                 return [
    //                     'id' => $g->id,
    //                     'label' => (string)($g->so_ghe ?? $g->id),
    //                     'row' => preg_replace('/\d+/','', ($g->so_ghe ?? '')),
    //                     'col' => (int)preg_replace('/\D+/','', ($g->so_ghe ?? '0')),
    //                     'type' => $g->loai ?? 'standard',
    //                     'price' => $g->gia ?? null, // null => fallback to suatchieu price
    //                 ];
    //             })
    //             ->all();

    //         // ghế đã bị đặt cho suất này
    //         $reservedRows = DB::table('chi_tiet_ves as ct')
    //             ->join('ghe_ngois as g', 'ct.id_ghe', '=', 'g.id')
    //             ->where('ct.id_suat_chieu', $s->id)
    //             ->select('g.id','g.so_ghe')
    //             ->get()
    //             ->pluck('so_ghe')
    //             ->map(fn($v)=>(string)$v)
    //             ->all();

    //         // tính rows/cols
    //         $rowsLabels = collect($seats)->pluck('row')->unique()->values()->all();
    //         $colsMax = collect($seats)->pluck('col')->filter()->max() ?? 0;

    //         // build seat_map.seats with reserved flag
    //         $seatsMap = array_map(function($seat) use ($reservedRows) {
    //             $seat['reserved'] = in_array($seat['label'], $reservedRows);
    //             return $seat;
    //         }, $seats);

    //         $seat_map = [
    //             'rows' => count($rowsLabels),
    //             'cols' => $colsMax,
    //             'rows_labels' => $rowsLabels,
    //             'seats' => $seatsMap,
    //             'reserved_labels' => $reservedRows,
    //         ];

    //         $result[] = [
    //             'id' => $s->id,
    //             'ngay_gio' => $s->ngay_gio_bat_dau,
    //             'gia' => $s->gia ?? $s->price ?? 0,
    //             'id_phong' => $s->id_phong,
    //             'seat_map' => $seat_map,
    //         ];
    //     }

    //     return response()->json(['status' => true, 'data' => $result]);
    // }

    public function store(Request $request)
    {
        // ID chức năng 24: Thêm Suất Chiếu Mới
        $id_chuc_nang = 24;
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

        $request->validate([
            'id_phim' => 'required|integer',
            'id_phong' => 'required|integer',
            'ngay_gio_bat_dau' => 'required|date',
            'gia' => 'required|numeric',
            'so_ghe' => 'required|array',
            'so_ghe.*' => 'string',
        ]);

        $idSuatChieu = DB::table('lich_chieus')->insertGetId([
            'id_phim' => $request->id_phim,
            'id_phong' => $request->id_phong,
            'ngay_gio_bat_dau' => $request->ngay_gio_bat_dau,
            'gia' => $request->gia,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $seats = $request->input('so_ghe');
        $seatData = [];
        foreach ($seats as $ghe) {
            $gheInfo = DB::table('ghe_ngois')->where('so_ghe', $ghe)->first();
            if ($gheInfo) {
                $seatData[] = [
                    'id_suat_chieu' => $idSuatChieu,
                    'id_ghe' => $gheInfo->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('chi_tiet_ves')->insert($seatData);

        return response()->json(['status' => true, 'message' => 'Thêm suất chiếu thành công']);
    }

    public function update(Request $request)
    {
        // ID chức năng 25: Cập Nhật Suất Chiếu
        $id_chuc_nang = 25;
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

        $request->validate([
            'id' => 'required|integer|exists:lich_chieus,id',
            'id_phim' => 'required|integer',
            'id_phong' => 'required|integer',
            'ngay_gio_bat_dau' => 'required|date',
            'gia' => 'required|numeric',
            'so_ghe' => 'required|array',
            'so_ghe.*' => 'string',
        ]);

        $idSuatChieu = $request->input('id');

        DB::table('lich_chieus')->where('id', $idSuatChieu)->update([
            'id_phim' => $request->id_phim,
            'id_phong' => $request->id_phong,
            'ngay_gio_bat_dau' => $request->ngay_gio_bat_dau,
            'gia' => $request->gia,
            'updated_at' => now(),
        ]);

        // Xóa ghế cũ
        DB::table('chi_tiet_ves')->where('id_suat_chieu', $idSuatChieu)->delete();

        $seats = $request->input('so_ghe');
        $seatData = [];
        foreach ($seats as $ghe) {
            $gheInfo = DB::table('ghe_ngois')->where('so_ghe', $ghe)->first();
            if ($gheInfo) {
                $seatData[] = [
                    'id_suat_chieu' => $idSuatChieu,
                    'id_ghe' => $gheInfo->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('chi_tiet_ves')->insert($seatData);

        return response()->json(['status' => true, 'message' => 'Cập nhật suất chiếu thành công']);
    }

    public function destroy(Request $request)
    {
        // ID chức năng 26: Xóa Suất Chiếu
        $id_chuc_nang = 26;
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

        $request->validate([
            'id' => 'required|integer|exists:lich_chieus,id',
        ]);

        $idSuatChieu = $request->input('id');

        // Xóa chi tiết vé liên quan
        DB::table('chi_tiet_ves')->where('id_suat_chieu', $idSuatChieu)->delete();

        // Xóa suất chiếu
        DB::table('lich_chieus')->where('id', $idSuatChieu)->delete();

        return response()->json(['status' => true, 'message' => 'Xóa suất chiếu thành công']);
    }
}
