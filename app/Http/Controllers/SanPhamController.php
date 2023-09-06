<?php

namespace App\Http\Controllers;

use App\Http\Requests\SanPham\CreateSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    public function index()
    {
        $danhMuc = DanhMuc::where('is_open', '=', 1)->get();
        return view('Admin.Pages.SanPham.index', compact('danhMuc'));
    }
    public function index_vue()
    {
        $check = $this->checkRule_get(6);
        if(!$check) {
            toastr()->error('Bạn không có quyền truy cập chức năng này!');
            return redirect('/admin-shop');
        }

        $danhMuc = DanhMuc::where('is_open', '=', 1)->get();
        return view('Admin.Pages.SanPham.index_vue', compact('danhMuc'));
    }
    public function store(CreateSanPhamRequest $request)
    {
        $check = $this->checkRule_post(7);
        if (!$check) {
            return response()->json([
                'status'  => false,
                'message' => 'Bạn không có quyền truy cập chức năng này!',
            ]);
        }
        $data = $request->all();
        SanPham::create($data);
        return response()->json([
            'status'    => true,
            'message'   => 'Đã thêm mới sản phẩm thành công!',
        ]);
    }
    public function getData()
    {
        $sanPham = SanPham::join('danh_mucs', 'san_phams.ma_danh_muc_id', 'danh_mucs.id')
            ->select('san_phams.*', 'danh_mucs.ten_danh_muc')
            ->get();
        return response()->json([
            'data' => $sanPham,
        ]);
    }
    public function edit($id)
    {
        $sanPham = SanPham::find($id);
        if ($sanPham) {
            return response()->json([
                'status'    => true,
                'data'  => $sanPham,
            ]);
        } else {
            return response()->json([
                'status'    => false,
            ]);
        }
    }
    public function checkProductId(Request $request)
    {
        $sanPham = SanPham::where('ma_san_pham', $request->ma_san_pham)->first();
        if ($sanPham) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function checkProductId2(Request $request)
    {
        $sanPham = SanPham::where('ten_san_pham', $request->ten_san_pham)->first();
        if ($sanPham) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
    public  function checkProductSlug(Request $request)
    {
        $sanPham = SanPham::where('slug_san_pham', $request->slug_san_pham)->first();
        if ($sanPham) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function update(UpdateSanPhamRequest $request)
    {
        $check = $this->checkRule_post(10);
        if (!$check) {
            return response()->json([
                'status'  => false,
                'message' => 'Bạn không có quyền truy cập chức năng này!',
            ]);
        }
        $sanPham = SanPham::find($request->id);
        $sanPham->ma_san_pham       = $request->ma_san_pham;
        $sanPham->ten_san_pham      = $request->ten_san_pham;
        $sanPham->slug_san_pham     = $request->slug_san_pham;
        $sanPham->ma_danh_muc_id    = $request->ma_danh_muc_id;
        $sanPham->hinh_anh          = $request->hinh_anh;
        $sanPham->gia               = $request->gia;
        $sanPham->gia_khuyen_mai    = $request->gia_khuyen_mai;
        $sanPham->chi_tiet          = $request->chi_tiet;
        $sanPham->is_open           = $request->is_open;
        $sanPham->so_luong          = $request->so_luong;
        $sanPham->save();
        return response()->json([
            'status'    => true,
        ]);
    }
    public function destroy($id)
    {
        $check = $this->checkRule_post(9);
        if (!$check) {
            return response()->json([
                'status'  => false,
                'message' => 'Bạn không có quyền truy cập chức năng này!',
            ]);
        }
        $sanPham = SanPham::find($id);
        if ($sanPham) {
            $sanPham->delete();
            return response()->json([
                'status'    => true,
                'message' => 'Đã xóa '.$sanPham->ten_san_pham. ' Thành Công!',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message' => 'Có lỗi!',
            ]);
        }
    }
    public function updateStatus($id)
    {
        $check = $this->checkRule_post(8);
        if (!$check) {
            return response()->json([
                'status'  => false,
                'message' => 'Bạn không có quyền truy cập chức năng này!',
            ]);
        }
        $sanPham = SanPham::find($id);
        if ($sanPham) {

            $sanPham->is_open = $sanPham->is_open == 0 ? 1 : 0;
            $sanPham->save();

            return response()->json([
                'status'  => true,
                'message' => 'Đổi trạng thái sản phẩm '.$sanPham->ten_san_pham. ' Thành Công!',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Có lỗi!',
            ]);
        }
    }

    public function search(Request $request)
    {
        $check = $this->checkRule_post(11);
        if (!$check) {
            return response()->json([
                'status'  => false,
                'message' => 'Bạn không có quyền truy cập chức năng này!',
            ]);
        }
        $search = $request->key_search;
        $listSanPham = SanPham::where('ma_san_pham', 'like', '%' . $search . '%')
            ->orwhere('ten_san_pham', 'like', '%' . $search . '%')
            // ->orwhere('slug_san_pham', 'like', '%'.$search.'%')
            ->join('danh_mucs', 'san_phams.ma_danh_muc_id', 'danh_mucs.id')
            ->select('san_phams.*', 'danh_mucs.ten_danh_muc')
            ->orwhere('ten_danh_muc', 'like', '%' . $search . '%')
            ->get();

        return response()->json([
            'status'  => true,
            'data'  => $listSanPham,

        ]);
    }
}
