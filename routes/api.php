<?php

use App\Http\Controllers\KhachHangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PhimController;
use App\Http\Controllers\SuatChieuController;
use App\Http\Controllers\DatVeController;
use App\Http\Controllers\TheLoaiController;

Route::post('khach-hang/dang-nhap', [KhachHangController::class, 'dangNhap']);
Route::post('khach-hang/dang-ky', [KhachHangController::class, 'dangKy']);
Route::get('/kiem-tra-khachhang', [KhachHangController::class, 'kiemTraKhachHang']);
Route::get('/khach-hang/profile/data', [KhachHangController::class, 'getDataProfile'])->middleware("KhachHangMiddle");
Route::post('/khach-hang/profile/update', [KhachHangController::class, 'updateProfile'])->middleware("KhachHangMiddle");
Route::post('/khach-hang/dang-xuat', [KhachHangController::class, 'logout']);
Route::post('/khach-hang/quen-mat-khau', [KhachHangController::class, 'quenMK']);
Route::post('/khach-hang/doi-mat-khau', [KhachHangController::class, 'doiMK']);



Route::post('/admin/dang-nhap', [AdminController::class, 'dangNhap']);
Route::post('/admin/dang-ky', [AdminController::class, 'dangKy']);
Route::get('/kiem-tra-admin', [AdminController::class, 'kiemTraAdmin']);

Route::get('/getDataPhim', [PhimController::class, 'getData']);
Route::get('phim/{id}', [PhimController::class, 'show']);
Route::get('suat-chieu', [SuatChieuController::class, 'index']); // ?phim_id=
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
