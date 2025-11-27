<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdmimDanNhapRequest;
use App\Models\Admin;
use App\Models\ChiTietPhanQuyen;
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
                'message'   => "Sai tài khoản hoặc mật khẩu",
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

    public function getData()
    {
        // ID chức năng 40: Xem Danh Sách Admin
        $id_chuc_nang = 40;
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

        $ds_admin = Admin::all();
        return response()->json([
            'status'    => true,
            'data'      => $ds_admin
        ]);
    }

    public function dangKy(Request $request)
    {
        // ID chức năng 41: Thêm Admin Mới
        $id_chuc_nang = 41;
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

        $admin = new Admin();
        $admin->email = $request->email;
        $admin->ho_va_ten = $request->ho_va_ten;
        $admin->so_dien_thoai = $request->so_dien_thoai;
        $admin->dia_chi = $request->dia_chi;
        $admin->password = bcrypt($request->password);
        $admin->save();

        return response()->json([
            'status'    => true,
            'message'   => "Đã thêm admin thành công!"
        ]);
    }

    public function update(Request $request)
    {
        // ID chức năng 42: Cập Nhật Thông Tin Admin
        $id_chuc_nang = 42;
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

        $admin = Admin::find($request->id);
        if (!$admin) {
            return response()->json([
                'status'    => false,
                'message'   => "Admin không tồn tại!"
            ]);
        }

        $admin->email = $request->email;
        $admin->ho_va_ten = $request->ho_va_ten;
        $admin->so_dien_thoai = $request->so_dien_thoai;
        $admin->dia_chi = $request->dia_chi;
        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }
        $admin->save();

        return response()->json([
            'status'    => true,
            'message'   => "Đã cập nhật thông tin admin thành công!"
        ]);
    }

    public function destroy(Request $request)
    {
        // ID chức năng 43: Xóa Tài Khoản Admin
        $id_chuc_nang = 43;
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

        $admin = Admin::find($request->id);
        if (!$admin) {
            return response()->json([
                'status'    => false,
                'message'   => "Admin không tồn tại!"
            ]);
        }

        $admin->delete();

        return response()->json([
            'status'    => true,
            'message'   => "Đã xóa tài khoản admin thành công!"
        ]);
    }

    public function chuyenTinhTrang(Request $request)
    {
        // ID chức năng 44: Đổi Trạng Thái Admin
        $id_chuc_nang = 44;
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

        $admin = Admin::find($request->id);
        if (!$admin) {
            return response()->json([
                'status'    => false,
                'message'   => "Admin không tồn tại!"
            ]);
        }

        $admin->tinh_trang = !$admin->tinh_trang;
        $admin->save();

        return response()->json([
            'status'    => true,
            'message'   => "Đã đổi trạng thái admin thành công!"
        ]);
    }

}
