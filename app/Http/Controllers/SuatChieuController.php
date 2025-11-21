<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
