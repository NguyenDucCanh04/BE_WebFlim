<?php

use App\Http\Controllers\KhachHangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PhimController;
use App\Http\Controllers\SuatChieuController;
use App\Http\Controllers\DatVeController;
use App\Http\Controllers\TheLoaiController;
use App\Http\Controllers\QuyenController;
use App\Http\Controllers\ChucNangController;
use App\Http\Controllers\ChiTietPhanQuyenController;
use App\Http\Controllers\BaiVietController;

Route::post('khach-hang/dang-nhap', [KhachHangController::class, 'dangNhap']);
Route::post('khach-hang/dang-ky', [KhachHangController::class, 'dangKy']);
Route::get('/kiem-tra-khachhang', [KhachHangController::class, 'kiemTraKhachHang']);
Route::get('/khach-hang/profile/data', [KhachHangController::class, 'getDataProfile'])->middleware("KhachHangMiddle");
Route::post('/khach-hang/profile/update', [KhachHangController::class, 'updateProfile'])->middleware("KhachHangMiddle");
Route::post('/khach-hang/dang-xuat', [KhachHangController::class, 'logout']);
Route::post('/khach-hang/quen-mat-khau', [KhachHangController::class, 'quenMK']);
Route::post('/khach-hang/doi-mat-khau', [KhachHangController::class, 'doiMK']);
Route::post('/khach-hang/doi-mat-khau/profile', [KhachHangController::class, 'doiMatKhauProfile'])->middleware("KhachHangMiddle");



Route::post('/admin/dang-nhap', [AdminController::class, 'dangNhap']);
Route::post('/admin/dang-ky', [AdminController::class, 'dangKy']);
Route::get('/kiem-tra-admin', [AdminController::class, 'kiemTraAdmin']);
Route::post('/admin/dang-xuat', [AdminController::class, 'logout']);
Route::get('/admin/profile/data', [AdminController::class, 'getDataProfile'])->middleware("AdminMiddle");
Route::post('/admin/profile/update', [AdminController::class, 'updateProfile'])->middleware("AdminMiddle");

Route::get('/admin/khach-hang/data', [KhachHangController::class, 'dataKhachHang'])->middleware("AdminMiddle");
Route::post('/admin/khach-hang/kich-hoat-tai-khoan', [KhachHangController::class, 'kichHoatTaiKhoan'])->middleware("AdminMiddle");
Route::post('/admin/khach-hang/doi-trang-thai', [KhachHangController::class, 'doiTrangThaiKhachHang'])->middleware("AdminMiddle");
Route::post('/admin/khach-hang/update', [KhachHangController::class, 'updateTaiKhoan'])->middleware("AdminMiddle");
Route::post('/admin/khach-hang/delete', [KhachHangController::class, 'deleteTaiKhoan'])->middleware("AdminMiddle");

Route::get('suat-chieu', [SuatChieuController::class, 'index']);
Route::post('dat-ve', [DatVeController::class, 'store']);


Route::get('/the-loai/data-open', [TheLoaiController::class, 'getDataOpen']);
Route::get('/the-loai', [TheLoaiController::class, 'getData'])->middleware("AdminMiddle");
Route::post('/admin/the-loai', [TheLoaiController::class, 'store'])->middleware("AdminMiddle");
Route::post('/admin/the-loai/delete', [TheLoaiController::class, 'destroy'])->middleware("AdminMiddle");
Route::post('/admin/the-loai-update', [TheLoaiController::class, 'update'])->middleware("AdminMiddle");
Route::post('/admin/the-loai/doi-trang-thai', [TheLoaiController::class, 'changeStatus'])->middleware("AdminMiddle");
Route::get('/thong-tin-phim-tu-the-loai/{id}', [TheLoaiController::class, 'layThongTinPhimTuTheLoai']);
Route::get('/the-loai/data-open', [TheLoaiController::class, 'getDataOpen']);

// phân trang phim theo thể loại (frontend gọi: /api/layThongTinPhimTuTheLoai/{id})
Route::get('layThongTinPhimTuTheLoai/{id}', [TheLoaiController::class, 'layThongTinPhimTuTheLoai']);
Route::get('/getDataPhim', [PhimController::class, 'getData']);
Route::get('/phim/search', [PhimController::class, 'search']);
Route::get('/phim/{id}', [PhimController::class, 'show']);
Route::get('/phim/dang-chieu', [PhimController::class, 'getPhimDangChieu']);
Route::get('/phim/sap-chieu', [PhimController::class, 'getPhimSapChieu']);

// Admin routes (cần middleware)
Route::post('/admin/phim/create', [PhimController::class, 'store'])->middleware("AdminMiddle");
Route::post('/admin/phim/update', [PhimController::class, 'update'])->middleware("AdminMiddle");
Route::post('/admin/phim/delete', [PhimController::class, 'destroy'])->middleware("AdminMiddle");
Route::post('/admin/phim/chuyen-trang-thai', [PhimController::class, 'chuyenTinhTrang'])->middleware("AdminMiddle");
Route::post('/admin/phim/chuyen-trang-thai-chieu', [PhimController::class, 'chuyenTrangThaiChieu'])->middleware("AdminMiddle");
// ...existing code...
Route::get('/admin/phan-quyen/data', [QuyenController::class, 'getData'])->middleware("AdminMiddle");
Route::post('/admin/phan-quyen/create', [QuyenController::class, 'createData'])->middleware("AdminMiddle");
Route::delete('/admin/phan-quyen/delete/{id}', [QuyenController::class, 'deleteData'])->middleware("AdminMiddle");
Route::put('/admin/phan-quyen/update', [QuyenController::class, 'UpateData'])->middleware("AdminMiddle");
Route::post('/admin/phan-quyen/tim-kiem', [QuyenController::class, 'search'])->middleware("AdminMiddle");
Route::post('/admin/chi-tiet-phan-quyen/cap-quyen', [ChiTietPhanQuyenController::class, 'capQuyen'])->middleware("NhanVienMiddle");
Route::post('/admin/chi-tiet-phan-quyen/danh-sach', [ChiTietPhanQuyenController::class, 'getData'])->middleware("NhanVienMiddle");
Route::post('/admin/chi-tiet-phan-quyen/xoa-quyen', [ChiTietPhanQuyenController::class, 'xoaQuyen'])->middleware("NhanVienMiddle");
Route::get('/admin/chuc-nang/data', [ChucNangController::class, 'getData'])->middleware("NhanVienMiddle");


Route::get('/bai-viet/search', [BaiVietController::class, 'search']);
Route::get('/bai-viet', [BaiVietController::class, 'getData']);
Route::get('/bai-viet-moi', [BaiVietController::class, 'getDataBaiVietMoi']);
Route::get('/bai-viet/{id}', [BaiVietController::class, 'show']);
Route::post('/bai-viet/create', [BaiVietController::class, 'store']);
Route::post('/bai-viet/update', [BaiVietController::class, 'update']);
Route::post('/bai-viet/delete', [BaiVietController::class, 'destroy']);
Route::post('/bai-viet/trang-thai', [BaiVietController::class, 'chuyenTrangThai']);
