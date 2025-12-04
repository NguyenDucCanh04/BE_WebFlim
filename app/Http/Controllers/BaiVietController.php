<?php

namespace App\Http\Controllers;

use App\Models\BaiViet;
use Illuminate\Http\Request;

class BaiVietController extends Controller
{
    // Tìm kiếm bài viết
    public function search(Request $request)
    {
        $keyword = '%' . $request->noi_dung_tim . '%';

        $data = BaiViet::where('tieu_de', 'like', $keyword)
            ->orWhere('noi_dung', 'like', $keyword)
            ->orWhereHas('tacGia', function ($q) use ($keyword) {
                $q->where('name', 'like', $keyword);
            })
            ->orderBy('ngay_dang', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    // Lấy tất cả bài viết
    public function getData()
    {
        $data = BaiViet::orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    // Lấy bài viết mới nhất
    public function getDataBaiVietMoi()
    {
        $data = BaiViet::where('trang_thai', 1)
            ->orderBy('ngay_dang', 'DESC')
            ->take(10)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    // Hiển thị 1 bài viết theo id
    public function show($id)
    {
        $bv = BaiViet::find($id);

        if (!$bv) {
            return response()->json([
                'status' => false,
                'message' => 'Bài viết không tồn tại'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $bv,
        ]);
    }

    // Thêm bài viết
    public function store(Request $request)
    {
        try {
            $bv = BaiViet::create([
                'tieu_de'      => $request->tieu_de,
                'noi_dung'     => $request->noi_dung,
                'anh_dai_dien' => $request->anh_dai_dien,
                'ngay_dang'    => $request->ngay_dang ?: now(),
                'tac_gia'      => $request->tac_gia,
                'trang_thai'   => 1,
            ]);

            return response()->json([
                'status'  => true,
                'message' => "Thêm bài viết '{$request->tieu_de}' thành công",
                'data'    => $bv,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Lỗi: " . $e->getMessage(),
            ], 500);
        }
    }

    // Cập nhật bài viết
    public function update(Request $request)
    {
        $bv = BaiViet::find($request->id);

        if (!$bv) {
            return response()->json([
                'status' => false,
                'message' => 'Bài viết không tồn tại'
            ], 404);
        }

        try {
            $bv->update([
                'tieu_de'      => $request->tieu_de,
                'noi_dung'     => $request->noi_dung,
                'anh_dai_dien' => $request->anh_dai_dien,
                'ngay_dang'    => $request->ngay_dang,
                'tac_gia'      => $request->tac_gia,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Cập nhật bài viết '{$bv->tieu_de}' thành công",
                'data' => $bv,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Lỗi: " . $e->getMessage(),
            ], 500);
        }
    }

    // Xoá bài viết
    public function destroy(Request $request)
    {
        $bv = BaiViet::find($request->id);

        if (!$bv) {
            return response()->json([
                'status' => false,
                'message' => 'Bài viết không tồn tại'
            ], 404);
        }

        try {
            $title = $bv->tieu_de;
            $bv->delete();

            return response()->json([
                'status' => true,
                'message' => "Đã xoá bài viết '{$title}' thành công"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Lỗi: " . $e->getMessage(),
            ], 500);
        }
    }

    // Chuyển trạng thái (ẩn/hiện)
    public function chuyenTrangThai(Request $request)
    {
        $bv = BaiViet::find($request->id);

        if (!$bv) {
            return response()->json([
                'status' => false,
                'message' => 'Bài viết không tồn tại'
            ], 404);
        }

        $bv->trang_thai = $bv->trang_thai == 1 ? 0 : 1;
        $bv->save();

        $message = $bv->trang_thai == 1
            ? "Bài viết '{$bv->tieu_de}' đã được bật hiển thị"
            : "Bài viết '{$bv->tieu_de}' đã bị ẩn";

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
