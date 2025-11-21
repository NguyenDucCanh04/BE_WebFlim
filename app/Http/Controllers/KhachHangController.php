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
                'message'   => "Tài khoản hoặc mật khẩu không đúng!",
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
            'email'         => $request->email,
            'so_dien_thoai' => $request->so_dien_thoai,
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
     public function quenMK(Request $request)
    {
        $khach_hang = KhachHang::where('email', $request->email)->first();
        if($khach_hang){
            $hash_reset         = Str::uuid();
            $x['ho_va_ten']     = $khach_hang->ho_va_ten;
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
}
