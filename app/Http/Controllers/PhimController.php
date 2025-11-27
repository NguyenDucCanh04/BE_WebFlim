<?php

namespace App\Http\Controllers;

use App\Models\Phim;
use Illuminate\Http\Request;

class PhimController extends Controller
{
    public function search(Request $request)
    {
        $noi_dung_tim = '%' . $request->noi_dung_tim . '%';
        $data = Phim::where('ten_phim', 'like', $noi_dung_tim)
            ->orWhere('mo_ta', 'like', $noi_dung_tim)
            ->orWhere('dao_dien', 'like', $noi_dung_tim)
            ->orWhere('dien_vien', 'like', $noi_dung_tim)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getData()
    {
        $data = Phim::orderBy('id', 'DESC')->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getDataPhimMoi()
    {
        $data = Phim::where('trang_thai', 1)
            ->orderBy('ngay_tao', 'DESC')
            ->take(10)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getPhimDangChieu()
    {
        $data = Phim::where('trang_thai_chieu', 1)
            ->where('trang_thai', 1)
            ->orderBy('ngay_tao', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getPhimSapChieu()
    {
        $data = Phim::where('trang_thai_chieu', 0)
            ->where('trang_thai', 1)
            ->orderBy('ngay_tao', 'ASC')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $phim = Phim::find($id);
        if (!$phim) {
            return response()->json([
                'data' => false,
                'message' => 'Phim không tồn tại'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $phim
        ]);
    }

    public function store(Request $request)
    {
        try {
            $phim = Phim::create([
                'ten_phim' => $request->ten_phim,
                'mo_ta' => $request->mo_ta,
                'dao_dien' => $request->dao_dien,
                'dien_vien' => $request->dien_vien,
                'thoi_luong' => $request->thoi_luong,
                'nam_san_xuat' => $request->nam_san_xuat,
                'quoc_gia' => $request->quoc_gia,
                'movie_url' => $request->movie_url,
                'trailer_url' => $request->trailer_url,
                'poster_url' => $request->poster_url,
                'ngay_tao' => $request->ngay_tao ?: now(),
                'ngay_khoi_chieu' => $request->ngay_khoi_chieu,
                'trang_thai_chieu' => $request->trang_thai_chieu == 'dang_chieu' ? 1 : 0,
                'trang_thai' => 1
            ]);

            return response()->json([
                'status' => true,
                'message' => "Thêm phim '{$request->ten_phim}' thành công",
                'data' => $phim
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => false,
                'message' => "Có lỗi xảy ra: " . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $phim = Phim::find($request->id);
        if (!$phim) {
            return response()->json([
                'data' => false,
                'message' => "Phim không tồn tại!"
            ], 404);
        }

        try {
            $phim->update([
                'ten_phim' => $request->ten_phim,
                'mo_ta' => $request->mo_ta,
                'dao_dien' => $request->dao_dien,
                'dien_vien' => $request->dien_vien,
                'thoi_luong' => $request->thoi_luong,
                'nam_san_xuat' => $request->nam_san_xuat,
                'quoc_gia' => $request->quoc_gia,
                'movie_url' => $request->movie_url,
                'trailer_url' => $request->trailer_url,
                'poster_url' => $request->poster_url,
                'ngay_tao' => $request->ngay_tao,
                'ngay_khoi_chieu' => $request->ngay_khoi_chieu,
                'trang_thai_chieu' => $request->trang_thai_chieu == 'dang_chieu' ? 1 : 0,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Cập nhật phim '{$phim->ten_phim}' thành công",
                'data' => $phim
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => false,
                'message' => "Có lỗi xảy ra: " . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        $phim = Phim::find($request->id);
        if (!$phim) {
            return response()->json([
                'data' => false,
                'message' => "Phim không tồn tại!"
            ], 404);
        }

        try {
            $ten_phim = $phim->ten_phim;
            $phim->delete();

            return response()->json([
                'status' => true,
                'message' => "Xóa phim '{$ten_phim}' thành công"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => false,
                'message' => "Có lỗi xảy ra: " . $e->getMessage()
            ], 500);
        }
    }

    public function chuyenTinhTrang(Request $request)
    {
        $phim = Phim::find($request->id);
        if (!$phim) {
            return response()->json([
                'data' => false,
                'message' => "Phim không tồn tại!"
            ], 404);
        }

        $phim->trang_thai = $phim->trang_thai == 1 ? 0 : 1;
        $phim->save();

        $message = $phim->trang_thai == 1 ?
            "Đã kích hoạt phim '{$phim->ten_phim}'" :
            "Đã tạm ngừng phim '{$phim->ten_phim}'";

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function chuyenTrangThaiChieu(Request $request)
    {
        $phim = Phim::find($request->id);
        if (!$phim) {
            return response()->json([
                'data' => false,
                'message' => "Phim không tồn tại!"
            ], 404);
        }

        $phim->trang_thai_chieu = $phim->trang_thai_chieu == 1 ? 0 : 1;
        $phim->save();

        $message = $phim->trang_thai_chieu == 1 ?
            "Phim '{$phim->ten_phim}' đã chuyển sang đang chiếu" :
            "Phim '{$phim->ten_phim}' đã chuyển sang sắp chiếu";

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
