<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhanQuyen;
use App\Models\GheNgoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GheNgoiController extends Controller
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
        // ID chức năng 19: Thêm Ghế Mới
        $id_chuc_nang = 19;
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
    public function show(GheNgoi $gheNgoi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GheNgoi $gheNgoi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GheNgoi $gheNgoi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GheNgoi $gheNgoi)
    {
        //
    }

    public function getData()
    {
        // ID chức năng 18: Xem Danh Sách Ghế
        $id_chuc_nang = 18;
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
