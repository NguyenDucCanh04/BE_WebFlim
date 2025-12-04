<?php

namespace App\Http\Controllers;

use App\Http\Requests\KhachHangDangKyRequest;
use App\Http\Requests\KhachHangDanNhapRequest;
use App\Http\Requests\KhachHangDoiMatKhauRequest;
use App\Mail\MasterMail;
use App\Models\ChiTietPhanQuyen;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class KhachHangController extends Controller
{
    public function dangNhap(KhachHangDanNhapRequest $request)
    {
        $check  =  Auth::guard('khachhang')->attempt([
            'email'     => $request->email,
            'password'  => $request->password
        ]);

        if ($check) {
            // Lấy thông tin tài khoản đã đăng nhập thành công
            $khachHang  =   Auth::guard('khachhang')->user(); // Lấy được thông tin khách hàng đã đăng nhập

            return response()->json([
                'status'    => true,
                'message'   => "Đã đăng nhập thành công!",
                'token'     => $khachHang->createToken('token_khach_hang')->plainTextToken,
                'ten_kh'    => $khachHang->ho_ten,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => "Sai tài khoản hoặc mật khẩu",
            ]);
        }
    }
    public function dangKy(KhachHangDangKyRequest $request)
    {
        $khachHang = KhachHang::create([
            'ho_ten'        =>  $request->ho_ten,
            'email'         =>  $request->email,
            'so_dien_thoai' =>  $request->so_dien_thoai,
            'ngay_sinh'     =>  $request->ngay_sinh,
            'password'      =>  bcrypt($request->password),
            'gioi_tinh'      =>  $request->gioi_tinh,
            'trang_thai'    =>  1,
        ]);
        return response()->json([
            'message'  =>   'Đã đăng ký tài khoản thành công!',
            'status'   =>   true
        ]);
    }
    public function kiemTraKhachHang()
    {
        $tai_khoan_dang_dang_nhap   = Auth::guard('sanctum')->user();
        if ($tai_khoan_dang_dang_nhap && $tai_khoan_dang_dang_nhap instanceof \App\Models\KhachHang) {
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
        $check = KhachHang::where('id', $tai_khoan_dang_dang_nhap->id)->update([
            'so_dien_thoai' => $request->so_dien_thoai,
            'ngay_sinh' => $request->ngay_sinh,
            'ho_ten'     => $request->ho_ten,
        ]);

        if ($check) {
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


    public function logout(Request $request)
    {
        $khach_hang   = Auth::guard('sanctum')->user();
        if ($khach_hang && $khach_hang instanceof \App\Models\KhachHang) {
            DB::table('personal_access_tokens')
                ->where('id', $khach_hang->currentAccessToken()->id)->delete();
            return response()->json([
                'status' => true,
                'message' => "Bạn đã đăng xuất thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "bạn chưa đăng nhập hệ thống!"
            ]);
        }
    }


    public function getData()
    {
        // ID chức năng 33: Xem Danh Sách Khách Hàng
        $id_chuc_nang = 33;
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

        $ds_khach_hang = KhachHang::all();

        return response()->json([
            'data' => $ds_khach_hang,
            'message' => "Lấy danh sách khách hàng thành công!"
        ]);
    }

    public function update(Request $request)
    {
        // ID chức năng 35: Cập Nhật Thông Tin Khách Hàng
        $id_chuc_nang = 35;
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

        $khach_hang = KhachHang::find($request->id);
        if (!$khach_hang) {
            return response()->json([
                'status' => false,
                'message' => 'Khách hàng không tồn tại'
            ]);
        }

        $khach_hang->ho_ten = $request->ho_ten;
        $khach_hang->email = $request->email;
        $khach_hang->so_dien_thoai = $request->so_dien_thoai;
        $khach_hang->ngay_sinh = $request->ngay_sinh;
        $khach_hang->gioi_tinh = $request->gioi_tinh;

        $check = $khach_hang->save();

        if ($check) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thông tin khách hàng thành công'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Cập nhật thông tin khách hàng thất bại'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        // ID chức năng 36: Xóa Tài Khoản Khách Hàng
        $id_chuc_nang = 36;
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

        $khach_hang = KhachHang::find($request->id);
        if (!$khach_hang) {
            return response()->json([
                'status' => false,
                'message' => 'Khách hàng không tồn tại'
            ]);
        }

        $check = $khach_hang->delete();

        if ($check) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa khách hàng thành công'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Xóa khách hàng thất bại'
            ]);
        }
    }

    public function chuyenTinhTrang(Request $request)
    {
        // ID chức năng 37: Đổi Trạng Thái Khách Hàng
        $id_chuc_nang = 37;
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

        $khach_hang = KhachHang::find($request->id);
        if (!$khach_hang) {
            return response()->json([
                'status' => false,
                'message' => 'Khách hàng không tồn tại'
            ]);
        }

        $khach_hang->trang_thai = $request->trang_thai;

        $check = $khach_hang->save();

        if ($check) {
            return response()->json([
                'status' => true,
                'message' => 'Đổi trạng thái khách hàng thành công'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Đổi trạng thái khách hàng thất bại'
            ]);
        }
    }
    public function dataKhachHang()
    {

        $id_chuc_nang = 28;
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
        $data = KhachHang::get();

        return response()->json([
            'data' => $data
        ]);
    }
    public function kichHoatTaiKhoan(Request $request)
    {

        $id_chuc_nang = 29;
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
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            if ($khach_hang->trang_thai == 0) {
                $khach_hang->trang_thai = 1;
                $khach_hang->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã kích hoạt tài khoản thành công!"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }
    public function doiTrangThaiKhachHang(Request $request)
    {

        $id_chuc_nang = 30;
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
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            $khach_hang->trang_thai = !$khach_hang->trang_thai;
            $khach_hang->save();

            return response()->json([
                'status' => true,
                'message' => "Đã đổi trạng thái tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }

    public function updateTaiKhoan(Request $request)
    {

        $id_chuc_nang = 31;
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
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            $khach_hang->update([
                'email'             => $request->email,
                'so_dien_thoai'     => $request->so_dien_thoai,
                'ho_va_ten'         => $request->ho_va_ten,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Đã cập nhật tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }

    public function deleteTaiKhoan(Request $request)
    {

        $id_chuc_nang = 32;
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
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            $khach_hang->delete();

            return response()->json([
                'status' => true,
                'message' => "Đã đổi trạng thái tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }
   public function quenMK(Request $request)
    {
        $khach_hang = KhachHang::where('email', $request->email)->first();
        if($khach_hang){
            $hash_reset         = Str::uuid();
            $x['ho_ten']     = $khach_hang->ho_ten;
            $x['link']          = 'http://localhost:5173/khach-hang/doi-mat-khau/' . $hash_reset;
            Mail::to($request->email)->send(new MasterMail('Đổi Mật Khẩu Của Bạn', 'quen_mat_khau', $x));
            $khach_hang->hash_reset = $hash_reset;
            $khach_hang->save();
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Vui Lòng kiểm tra lại email'
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Email không có trong hệ thống'
            ]);
        }
    }

    public function doiMK(KhachHangDoiMatKhauRequest $request)
    {
        $khachHang           = KhachHang::where('hash_reset', $request->id)->first();
        $khachHang->password = bcrypt($request->password);
        $khachHang->hash_reset = NULL;
        $khachHang->save();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã đổi mật khẩu thành công'
        ]);
    }

    public function doiMatKhauProfile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();// lấy khách hàng đang đăng nhậ
        // validate
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'same:new_password'
        ]);

        // kiểm tra mật khẩu cũ
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu cũ không chính xác!'
            ]);
        }

        // cập nhật mật khẩu
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Đổi mật khẩu thành công!'
        ]);
    }
}
