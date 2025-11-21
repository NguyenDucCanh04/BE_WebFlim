<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietVe extends Model
{
    protected $table = 'chi_tiet_ves';

    protected $fillable = [
        'id_dat_ve',
        'id_ghe',
        'gia_ve'
    ];

   
}
