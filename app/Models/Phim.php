<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phim extends Model
{
    protected $table = 'phims';

    protected $fillable = [
        'ten_phim',
        'mo_ta',
        'dao_dien',
        'dien_vien',
        'thoi_luong',
        'nam_san_xuat',
        'quoc_gia',
        'movie_url',
        'trailer_url',
        'poster_url',
        'ngay_tao',
        'trang_thai',
        'trang_thai_chieu',
        'ngay_tao',
        'ngay_khoi_chieu',
    ];


}
