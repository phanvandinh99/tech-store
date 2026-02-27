<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThuocTinh;
use App\Models\GiaTriThuocTinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThuocTinhController extends Controller
{
    public function index()
    {
        $thuocTinhs = ThuocTinh::withCount('giaTriThuocTinhs')->paginate(15);
        return view('admin.thuoctinh.index', compact('thuocTinhs'));
    }

    public function create()
    {
        return view('admin.thuoctinh.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:thuoctinh,ten',
            'gia_tri' => 'required|array|min:1',
            'gia_tri.*' => 'required|string|max:100',
        ], [
            'ten.required' => 'Vui lòng nhập tên thuộc tính',
            'ten.unique' => 'Tên thuộc tính đã tồn tại',
            'gia_tri.required' => 'Vui lòng nhập ít nhất một giá trị',
            'gia_tri.*.required' => 'Giá trị không được để trống',
        ]);

        DB::beginTransaction();
        try {
            $thuocTinh = ThuocTinh::create([
                'ten' => $request->ten,
            ]);

            // Lọc và loại bỏ giá trị trùng lặp
            $giaTris = array_unique(array_filter($request->gia_tri));
            
            foreach ($giaTris as $giaTri) {
                GiaTriThuocTinh::create([
                    'thuoctinh_id' => $thuocTinh->id,
                    'giatri' => trim($giaTri),
                ]);
            }

            DB::commit();
            return redirect()->route('admin.thuoctinh.index')
                ->with('success', 'Thêm thuộc tính thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $thuocTinh = ThuocTinh::with('giaTriThuocTinhs')->findOrFail($id);
        return view('admin.thuoctinh.edit', compact('thuocTinh'));
    }

    public function update(Request $request, $id)
    {
        $thuocTinh = ThuocTinh::findOrFail($id);

        $request->validate([
            'ten' => 'required|string|max:100|unique:thuoctinh,ten,' . $id,
            'gia_tri' => 'required|array|min:1',
            'gia_tri.*' => 'required|string|max:100',
        ], [
            'ten.required' => 'Vui lòng nhập tên thuộc tính',
            'ten.unique' => 'Tên thuộc tính đã tồn tại',
            'gia_tri.required' => 'Vui lòng nhập ít nhất một giá trị',
            'gia_tri.*.required' => 'Giá trị không được để trống',
        ]);

        DB::beginTransaction();
        try {
            $thuocTinh->update([
                'ten' => $request->ten,
            ]);

            // Xóa các giá trị cũ
            $thuocTinh->giaTriThuocTinhs()->delete();

            // Thêm giá trị mới
            $giaTris = array_unique(array_filter($request->gia_tri));
            
            foreach ($giaTris as $giaTri) {
                GiaTriThuocTinh::create([
                    'thuoctinh_id' => $thuocTinh->id,
                    'giatri' => trim($giaTri),
                ]);
            }

            DB::commit();
            return redirect()->route('admin.thuoctinh.index')
                ->with('success', 'Cập nhật thuộc tính thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $thuocTinh = ThuocTinh::findOrFail($id);
            
            // Kiểm tra xem thuộc tính có đang được sử dụng không
            $isUsed = DB::table('sanpham_thuoctinh')
                ->where('thuoctinh_id', $id)
                ->exists();

            if ($isUsed) {
                return back()->with('error', 'Không thể xóa thuộc tính đang được sử dụng bởi sản phẩm!');
            }

            // Xóa các giá trị thuộc tính
            $thuocTinh->giaTriThuocTinhs()->delete();
            
            // Xóa thuộc tính
            $thuocTinh->delete();

            return redirect()->route('admin.thuoctinh.index')
                ->with('success', 'Xóa thuộc tính thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // API để xóa giá trị thuộc tính
    public function deleteValue($id)
    {
        try {
            $giaTri = GiaTriThuocTinh::findOrFail($id);
            
            // Kiểm tra xem giá trị có đang được sử dụng không
            $isUsed = DB::table('bien_the_giatri')
                ->where('giatri_thuoctinh_id', $id)
                ->exists();

            if ($isUsed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa giá trị đang được sử dụng bởi biến thể sản phẩm!'
                ]);
            }

            $giaTri->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa giá trị thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}
