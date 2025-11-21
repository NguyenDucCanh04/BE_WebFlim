<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatVe extends Model
{
    protected $table = 'dat_ves';

    protected $fillable = [
        'id_khach_hang',
        'id_suat_chieu',
        'tong_tien',
        'trang_thai',
        'ngay_dat'
    ];

}
