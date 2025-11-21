<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhimTheLoai extends Model
{
    protected $table = 'phim_the_loais';

    protected $fillable = ['id_phim', 'id_the_loai'];
}
