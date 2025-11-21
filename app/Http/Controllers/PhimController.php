<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhanQuyen;
use App\Models\Phim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhimController extends Controller
{
    public function search(Request $request)
    {
        $noi_dung_tim = '%' . $request->noi_dung_tim . '%';
        $data   =  Phim::where('ten_phim', 'like', $noi_dung_tim)
            ->orWhere('mo_ta_ngan', 'like', $noi_dung_tim)
            ->get();
        return response()->json([
            'data'  => $data
        ]);
    }
    public function getData()
    {
        $data = Phim::all();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }


    public function getDataNew()
    {
        $data = Phim::orderBy('id', 'DESC');
        return response()->json([
            'data' => $data
        ]);
    }
    public function getDataNoiBat()
    {
        $data = Phim::where('is_noi_bat', 1)->take(10)->get();
        return response()->json([
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $phim = Phim::find($id);

        if (!$phim) {
            return response()->json([
                'status' => false,
                'message' => 'Phim không tồn tại'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $phim
        ]);
    }
}
