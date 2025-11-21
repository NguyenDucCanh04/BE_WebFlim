<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanh_toans';

    protected $fillable = [
        'id_dat_ve',
        'phuong_thuc',
        'so_tien',
        'thoi_gian',
        'trang_thai'
    ];

   
}
