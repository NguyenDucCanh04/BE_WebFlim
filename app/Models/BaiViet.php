<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    protected $table = 'bai_viets';

    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'anh_dai_dien',
        'ngay_dang',
        'tac_gia'
    ];

    
}
