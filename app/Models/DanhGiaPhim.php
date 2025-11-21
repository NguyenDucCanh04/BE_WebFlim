<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGiaPhim extends Model
{
    protected $table = 'danh_gia_phims';

    protected $fillable = [
        'id_phim',
        'id_khach_hang',
        'so_sao',
        'binh_luan',
        'ngay_danh_gia'
    ];

   
}
