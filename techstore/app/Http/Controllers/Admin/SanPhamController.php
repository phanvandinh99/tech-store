<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BienThe;
use App\Models\DanhMuc;
use App\Models\GiaTriThuocTinh;
use App\Models\SanPham;
use App\Models\ThuocTinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SanPhamController extends Controller
{
    public function index()
    {
        $sanPhams = SanPham::with('danhMuc', 'bienThes')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.sanpham.index', compact('sanPhams'));
    }

    public function create()
    {
        $danhMucs = DanhMuc::all();
        $thuocTinhs = ThuocTinh::with('giaTriThuocTinhs')->get();
        return view('admin.sanpham.create', compact('danhMucs', 'thuocTinhs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'danhmuc_id' => 'required|exists:danhmuc,id',
            'mota' => 'nullable|string',
            'thuoc_tinh_ids' => 'nullable|array',
            'thuoc_tinh_ids.*' => 'exists:thuoctinh,id',
            'bien_the' => 'required|array|min:1',
            'bien_the.*.sku' => 'required|string|max:100',
            'bien_the.*.gia' => 'required|numeric|min:0',
            'bien_the.*.gia_von' => 'required|numeric|min:0',
            'bien_the.*.so_luong_ton' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $sanPham = SanPham::create([
                'ten' => $request->ten,
                'danhmuc_id' => $request->danhmuc_id,
                'mota' => $request->mota,
            ]);

            if ($request->thuoc_tinh_ids) {
                $sanPham->thuocTinhs()->attach($request->thuoc_tinh_ids);
            }

            foreach ($request->bien_the as $bt) {
                $bienThe = BienThe::create([
                    'sanpham_id' => $sanPham->id,
                    'sku' => $bt['sku'],
                    'gia' => $bt['gia'],
                    'gia_von' => $bt['gia_von'],
                    'so_luong_ton' => $bt['so_luong_ton'],
                ]);

                if (isset($bt['giatri_thuoctinh_ids'])) {
                    $bienThe->giaTriThuocTinhs()->attach($bt['giatri_thuoctinh_ids']);
                }
            }
        });

        return redirect()->route('admin.sanpham.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(SanPham $sanPham)
    {
        $sanPham->load('thuocTinhs', 'bienThes.giaTriThuocTinhs');
        $danhMucs = DanhMuc::all();
        $thuocTinhs = ThuocTinh::with('giaTriThuocTinhs')->get();
        return view('admin.sanpham.edit', compact('sanPham', 'danhMucs', 'thuocTinhs'));
    }

    public function update(Request $request, SanPham $sanPham)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'danhmuc_id' => 'required|exists:danhmuc,id',
            'mota' => 'nullable|string',
        ]);

        $sanPham->update($request->only(['ten', 'danhmuc_id', 'mota']));

        return redirect()->route('admin.sanpham.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(SanPham $sanPham)
    {
        $sanPham->delete();
        return redirect()->route('admin.sanpham.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }
}

