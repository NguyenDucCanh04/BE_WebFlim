<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhachHangDangKyRequest extends FormRequest
{
    /**
     * Cho phép request hoạt động.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Các rule kiểm tra dữ liệu gửi lên.
     */
    public function rules(): array
    {
        return [
            'ho_ten' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-ZÀ-ỹ\s]+$/u' // chỉ chữ + khoảng trắng
            ],

            'email' => 'required|email|max:255|unique:khach_hangs,email',

            'password' => [
                'required',
                'min:6',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/' // có chữ + số
            ],

            're_password' => 'required|same:password',

            'so_dien_thoai' => [
                'required',
                'digits_between:10,11',
                'regex:/^[0-9]+$/'
            ],

            'gioi_tinh' => 'required|integer|in:0,1',

            'ngay_sinh' => 'nullable|date|before:today',
        ];
    }

    /**
     * Thông báo lỗi custom.
     */
    public function messages(): array
    {
        return [

            // họ tên
            'ho_ten.required' => 'Họ tên không được để trống',
            'ho_ten.min'      => 'Họ tên phải có ít nhất 3 ký tự',
            'ho_ten.max'      => 'Họ tên không vượt quá 255 ký tự',
            'ho_ten.regex'    => 'Họ tên không được chứa số hoặc ký tự đặc biệt',

            // email
            'email.required'  => 'Email không được để trống',
            'email.email'     => 'Email không đúng định dạng',
            'email.unique'    => 'Email đã tồn tại trong hệ thống',

            // password
            'password.required' => 'Mật khẩu không được để trống',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự',

            // nhập lại mật khẩu
            're_password.required' => 'Bạn phải nhập lại mật khẩu',
            're_password.same'     => 'Nhập lại mật khẩu phải giống mật khẩu',

            // số điện thoại
            'so_dien_thoai.required'       => 'Số điện thoại không được để trống',
            'so_dien_thoai.digits_between' => 'Số điện thoại phải từ 10 đến 11 chữ số',
            'so_dien_thoai.regex'          => 'Số điện thoại chỉ được chứa số',

            // giới tính
            'gioi_tinh.required' => 'Giới tính không được để trống',
            'gioi_tinh.in'       => 'Giới tính chỉ được chọn Nam hoặc Nữ',

            // ngày sinh
            'ngay_sinh.date'     => 'Ngày sinh phải đúng định dạng ngày',
            'ngay_sinh.before'   => 'Ngày sinh không được lớn hơn ngày hiện tại',
        ];
    }
}
