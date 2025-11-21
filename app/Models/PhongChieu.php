<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhongChieu extends Model
{
    protected $table = 'phong_chieus';

    protected $fillable = [
        'ten_phong',
        'so_ghe',
        'mo_ta'
    ];

   
}
