<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdmimDanNhapRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dangNhap(AdmimDanNhapRequest $request)
    {
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        $check  =  Auth::guard('admin')->attempt($credentials);

        if ($check) {
            $admin  =   Auth::guard('admin')->user();

            return response()->json([
                'status'    => true,
                'message'   => "Đã đăng nhập thành công!",
                'token'     => $admin->createToken('token_nhan_vien')->plainTextToken,
                'ten_nv'    => $admin->ho_ten,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => "Tài khoản hoặc mật khẩu không đúng!",
            ]);
        }
    }
     public function kiemTraAdmin()
    {
        $tai_khoan_dang_dang_nhap   = Auth::guard('sanctum')->user();
        // Khi đang đăng nhập ở đây có thể là: Khách Hàng, Đại Lý, Admin
        // Chúng phải kiểm tra $tai_khoan_dang_dang_nhap có phải là tài khoản Admin/Nhân Viên hay kihoong?
        if($tai_khoan_dang_dang_nhap && $tai_khoan_dang_dang_nhap instanceof \App\Models\Admin) {
            return response()->json([
                'status'    =>  true
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Bạn cần đăng nhập hệ thống trước'
            ]);
        }
    }
     public function getDataProfile()
    {
        $tai_khoan_dang_dang_nhap   = Auth::guard('sanctum')->user();
        return response()->json([
            'data'    =>  $tai_khoan_dang_dang_nhap
        ]);
    }

    public function updateProfile(Request $request)
    {
        $tai_khoan_dang_dang_nhap   = Auth::guard('sanctum')->user();
        $check = Admin::where('id', $tai_khoan_dang_dang_nhap->id)->update([
            'email'         => $request->email,
            'ho_va_ten'     => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi'       => $request->dia_chi,
        ]);

        if($check) {
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Cập nhật profile thành công'
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Cập nhật thất bại'
            ]);
        }
    }
     public function changeStatus(Request $request)
    {

        $id_chuc_nang = 26;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        $nhanVien = Admin::where('id', $request->id)->first();

        if($nhanVien) {
            if($nhanVien->tinh_trang == 0) {
                $nhanVien->tinh_trang = 1;
            } else {
                $nhanVien->tinh_trang = 0;
            }
            $nhanVien->save();

            return response()->json([
                'status'    => true,
                'message'   => "Đã cập nhật trạng thái nhân viên thành công!"
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => "Nhân viên không tồn tại!"
            ]);
        }
    }

}
