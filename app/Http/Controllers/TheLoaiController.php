<?php

namespace App\Http\Controllers;

use App\Models\TheLoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChiTietPhanQuyen;
use App\Models\Phim;

class TheLoaiController extends Controller
{
       public function getData()
    {
        $id_chuc_nang = 1;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'status' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ], 403);
        }
        $data = TheLoai::orderBy('id','asc')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getDataOpen()
    {
        $data = TheLoai::where('trang_thai', 1)->orderBy('id','asc')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    // bổ sung: trả thông tin thể loại theo id (frontend gọi /api/the-loai/{id})
    public function show($id)
    {
        $theLoai = TheLoai::find($id);
        if (! $theLoai) {
            return response()->json([
                'status' => false,
                'message' => 'Thể loại không tồn tại'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'data' => $theLoai
        ]);
    }

    public function store(Request $request)
    {

        $id_chuc_nang = 2;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        TheLoai::create([
               'ten_the_loai' => $request->ten_the_loai,
               'mo_ta' => $request->mo_ta,
               'trang_thai' => $request->trang_thai

        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã tạo mới the loai" . $request->ten_the_loai . " thành công.",
        ]);
    }
    public function destroy(Request $request)
    {

        $id_chuc_nang = 4;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        //table danh mục tìm id = $request->id và sau đó xóa nó đi
        TheLoai::find($request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Đã xóa the loai" . $request->ten_the_loai . " thành công.",
        ]);
    }
      public function update(Request $request)
    {

        $id_chuc_nang = 5;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        TheLoai::find($request->id)->update([
            'ten_the_loai' => $request->ten_the_loai,
            'mo_ta' => $request->mo_ta,
            'trang_thai' => $request->trang_thai
        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã update the loai" . $request->ten_the_loai . " thành công.",
        ]);
    }
    public function changeStatus(Request $request)
    {

        $id_chuc_nang = 6;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        $TheLoai = TheLoai::where('id', $request->id)->first();

        if ($TheLoai) {
            if ($TheLoai->trang_thai == 0) {
                $TheLoai->trang_thai = 1;
            } else {
                $TheLoai->trang_thai = 0;
            }
            $TheLoai->save();

            return response()->json([
                'status'    => true,
                'message'   => "Đã cập nhật trạng thái the loai thành công!"
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => "The loai không tồn tại!"
            ]);
        }
    }
       public function layThongTinPhimTuTheLoai(Request $request, $id)
    {
        $perPage = (int) $request->input('per_page', 12);
        $q = $request->input('q', null);
        $sort = $request->input('sort', null);

        // join với bảng pivot phim_the_loais để lấy phim theo thể loại
        $query = Phim::join('phim_the_loais', 'phims.id', '=', 'phim_the_loais.id_phim')
            ->where('phim_the_loais.id_the_loai', $id)
            ->select('phims.*')
            ->distinct();

        if ($q) {
            $query->where(function ($wr) use ($q) {
                $wr->where('phims.ten_phim', 'like', "%{$q}%")
                   ->orWhere('phims.mo_ta', 'like', "%{$q}%");
            });
        }

        if ($sort === 'name_asc') {
            $query->orderBy('phims.ten_phim', 'asc');
        } elseif ($sort === 'name_desc') {
            $query->orderBy('phims.ten_phim', 'desc');
        } elseif ($sort === 'year_asc') {
            $query->orderBy('phims.nam_san_xuat', 'asc');
        } elseif ($sort === 'year_desc') {
            $query->orderBy('phims.nam_san_xuat', 'desc');
        } else {
            $query->orderBy('phims.id', 'desc');
        }

        $paginator = $query->paginate($perPage);

        return response()->json([
            'status'     => true,
            'data'       => $paginator->items(),
            'pagination' => [
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
            ],
            'the_loai' => TheLoai::find($id),
        ]);
    }
}
