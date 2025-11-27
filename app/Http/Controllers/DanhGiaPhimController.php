<?php

namespace App\Http\Controllers;

use App\Models\DanhGiaPhim;
use App\Models\ChiTietPhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanhGiaPhimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ID chức năng 46: Thêm Đánh Giá Phim
        $id_chuc_nang = 46;
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

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DanhGiaPhim $danhGiaPhim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DanhGiaPhim $danhGiaPhim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // ID chức năng 47: Cập Nhật Đánh Giá
        $id_chuc_nang = 47;
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

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // ID chức năng 48: Xóa Đánh Giá
        $id_chuc_nang = 48;
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

        //
    }

    public function getData()
    {
        // ID chức năng 45: Xem Đánh Giá Phim
        $id_chuc_nang = 45;
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

        // ...existing code...
    }
}
