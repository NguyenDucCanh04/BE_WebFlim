<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GheNgoi extends Model
{
    protected $table = 'ghe_ngois';

    protected $fillable = [
        'id_phong',
        'so_ghe',
        'loai_ghe'
    ];

 
}
