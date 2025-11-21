<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhachHangDangKyRequest extends FormRequest
{
    /**
     * Xác nhận quyền thực hiện request.
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
            'ho_ten'        => 'required|min:3|max:255',
            'email'         => 'required|email|max:255|unique:khach_hangs,email',
            'password'      => 'required|min:6',
            're_password'   => 'required|min:6|same:password',
            'so_dien_thoai' => 'required|digits_between:10,11',
            'gioi_tinh'     => 'required|integer|in:0,1',
            'ngay_sinh'     => 'nullable|date',
        ];
    }

    /**
     * Thông báo lỗi custom.
     */
    public function messages(): array
    {
        return [
            'ho_ten.required' => 'Họ tên không được để trống',
            'ho_ten.min'      => 'Họ tên phải có ít nhất 3 ký tự',
            'ho_ten.max'      => 'Họ tên không vượt quá 255 ký tự',

            'email.required'  => 'Email không được để trống',
            'email.email'     => 'Email không đúng định dạng',
            'email.unique'    => 'Email đã tồn tại trong hệ thống',

            'password.required' => 'Mật khẩu không được để trống',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự',

            're_password.required' => 'Bạn phải nhập lại mật khẩu',
            're_password.min'      => 'Nhập lại mật khẩu phải có ít nhất 6 ký tự',
            're_password.same'     => 'Nhập lại mật khẩu phải giống mật khẩu',

            'so_dien_thoai.required'        => 'Số điện thoại không được để trống',
            'so_dien_thoai.digits_between'  => 'Số điện thoại phải từ 10 đến 11 chữ số',

            'gioi_tinh.required' => 'Giới tính không được để trống',
            'gioi_tinh.in'       => 'Giới tính phải là Nam, Nữ hoặc Khác',

            'ngay_sinh.date'     => 'Ngày sinh phải đúng định dạng ngày',
        ];
    }
}
