<?php

namespace App\Http\Controllers;

use App\Models\TheLoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChiTietPhanQuyen;
use App\Models\Phim;

class TheLoaiController extends Controller
{
    // ==========================================================
    // LẤY TẤT CẢ THỂ LOẠI (CÓ PHÂN QUYỀN)
    // ==========================================================
    public function getData()
    {
        $id_chuc_nang = 1;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;

        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();

        if ($check_quyen) {
            return response()->json([
                'status' => false,
                'message' => "Bạn không có quyền thực hiện chức năng này!"
            ], 403);
        }

        $data = TheLoai::orderBy('id', 'asc')->get();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    // ==========================================================
    // LẤY THỂ LOẠI HOẠT ĐỘNG (trang_thai = 1)
    // ==========================================================
    public function getDataOpen()
    {
        $data = TheLoai::where('trang_thai', 1)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    // ==========================================================
    // LẤY 1 THỂ LOẠI THEO ID
    // ==========================================================
    public function show($id)
    {
        $theLoai = TheLoai::find($id);

        if (!$theLoai) {
            return response()->json([
                'status'  => false,
                'message' => 'Thể loại không tồn tại'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $theLoai
        ]);
    }

    // ==========================================================
    // TẠO THỂ LOẠI
    // ==========================================================
    public function store(Request $request)
    {
        $id_chuc_nang = 2;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;

        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();

        if ($check_quyen) {
            return response()->json([
                'status'  => false,
                'message' => "Bạn không có quyền thực hiện chức năng này!"
            ]);
        }

        // Validate minimum
        $request->validate([
            'ten_the_loai' => 'required|min:3|max:255',
            'mo_ta'        => 'nullable|max:500',
            'trang_thai'   => 'required|in:0,1'
        ]);

        TheLoai::create([
            'ten_the_loai' => $request->ten_the_loai,
            'mo_ta'        => $request->mo_ta,
            'trang_thai'   => $request->trang_thai
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Đã tạo mới thể loại \"" . $request->ten_the_loai . "\" thành công."
        ]);
    }

    // ==========================================================
    // XÓA THỂ LOẠI
    // ==========================================================
    public function destroy(Request $request)
    {
        $id_chuc_nang = 4;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;

        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();

        if ($check_quyen) {
            return response()->json([
                'status' => false,
                'message' => "Bạn không có quyền thực hiện chức năng này!"
            ]);
        }

        $theLoai = TheLoai::find($request->id);
        if (!$theLoai) {
            return response()->json([
                'status' => false,
                'message' => "Thể loại không tồn tại!"
            ]);
        }

        $ten = $theLoai->ten_the_loai;
        $theLoai->delete();

        return response()->json([
            'status'  => true,
            'message' => "Đã xóa thể loại \"$ten\" thành công."
        ]);
    }

    // ==========================================================
    // CẬP NHẬT THỂ LOẠI
    // ==========================================================
    public function update(Request $request)
    {
        $id_chuc_nang = 5;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;

        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();

        if ($check_quyen) {
            return response()->json([
                'status'  => false,
                'message' => "Bạn không có quyền thực hiện chức năng này!"
            ]);
        }

        $theLoai = TheLoai::find($request->id);
        if (!$theLoai) {
            return response()->json([
                'status'  => false,
                'message' => "Thể loại không tồn tại!"
            ]);
        }

        $request->validate([
            'ten_the_loai' => 'required|min:3|max:255',
            'mo_ta'        => 'nullable|max:500',
            'trang_thai'   => 'required|in:0,1'
        ]);

        $theLoai->update([
            'ten_the_loai' => $request->ten_the_loai,
            'mo_ta'        => $request->mo_ta,
            'trang_thai'   => $request->trang_thai
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Đã cập nhật thể loại \"" . $request->ten_the_loai . "\" thành công."
        ]);
    }

    // ==========================================================
    // ĐỔI TRẠNG THÁI THỂ LOẠI
    // ==========================================================
    public function changeStatus(Request $request)
    {
        $id_chuc_nang = 6;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;

        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();

        if ($check_quyen) {
            return response()->json([
                'status'  => false,
                'message' => "Bạn không có quyền thực hiện chức năng này!"
            ]);
        }

        $theLoai = TheLoai::find($request->id);
        if (!$theLoai) {
            return response()->json([
                'status' => false,
                'message' => "Thể loại không tồn tại!"
            ]);
        }

        $theLoai->trang_thai = $theLoai->trang_thai == 1 ? 0 : 1;
        $theLoai->save();

        return response()->json([
            'status'  => true,
            'message' => "Cập nhật trạng thái thành công!"
        ]);
    }

    // ==========================================================
    // LẤY PHIM THEO THỂ LOẠI (có search, sort, pagination)
    // ==========================================================
    public function layThongTinPhimTuTheLoai(Request $request, $id)
    {
        $perPage = (int) $request->input('per_page', 12);
        $q = $request->input('q');
        $sort = $request->input('sort');

        $query = Phim::join('phim_the_loais', 'phims.id', '=', 'phim_the_loais.id_phim')
            ->where('phim_the_loais.id_the_loai', $id)
            ->where('phims.trang_thai', 1)
            ->where('phims.trang_thai_chieu', 1)
            ->select('phims.*')
            ->distinct();

        if ($q) {
            $query->where(function ($wr) use ($q) {
                $wr->where('phims.ten_phim', 'like', "%{$q}%")
                   ->orWhere('phims.mo_ta', 'like', "%{$q}%");
            });
        }

        switch ($sort) {
            case 'name_asc':
                $query->orderBy('phims.ten_phim', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('phims.ten_phim', 'desc');
                break;
            case 'year_asc':
                $query->orderBy('phims.nam_san_xuat', 'asc');
                break;
            case 'year_desc':
                $query->orderBy('phims.nam_san_xuat', 'desc');
                break;
            default:
                $query->orderBy('phims.id', 'desc');
        }

        $paginator = $query->paginate($perPage);

        return response()->json([
            'status'      => true,
            'data'        => $paginator->items(),
            'pagination'  => [
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
            ],
            'the_loai'    => TheLoai::find($id),
        ]);
    }
}
