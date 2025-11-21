<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\Quyen;
use App\Models\BaiViet;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'admins';

    protected $fillable = [
        'ho_ten',
        'email',
        'password',
        'so_dien_thoai',
        'gioi_tinh',
        'ngay_sinh',
        'anh_dai_dien',
        'trang_thai',
        'id_quyen'
    ];


}
