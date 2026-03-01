<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Imei;
use App\Models\BienThe;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImeiController extends Controller
{
    public function index(Request $request)
    {
        $query = Imei::with(['bienThe.sanPham', 'chiTietDonHang.donHang']);

        // Filter by product
        if ($request->has('sanpham_id') && $request->sanpham_id) {
            $query->whereHas('bienThe', function($q) use ($request) {
                $q->where('sanpham_id', $request->sanpham_id);
            });
        }

        // Filter by variant
        if ($request->has('bien_the_id') && $request->bien_the_id) {
            $query->where('bien_the_id', $request->bien_the_id);
        }

        // Filter by status
        if ($request->has('trang_thai') && $request->trang_thai) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // Search by IMEI
        if ($request->has('search') && $request->search) {
            $query->where('so_imei', 'like', '%' . $request->search . '%');
        }

        $imeis = $query->orderBy('created_at', 'desc')->paginate(20);
        $sanPhams = SanPham::orderBy('ten')->get();

        return view('admin.imei.index', compact('imeis', 'sanPhams'));
    }

    public function create(Request $request)
    {
        $sanPhams = SanPham::with('bienThes')->orderBy('ten')->get();
        $bienTheId = $request->get('bien_the_id');
        
        return view('admin.imei.create', compact('sanPhams', 'bienTheId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bien_the_id' => 'required|exists:bien_the,id',
            'so_imei' => 'required|string|max:20|unique:imei,so_imei',
            'ghi_chu' => 'nullable|string'
        ], [
            'bien_the_id.required' => 'Vui lòng chọn biến thể sản phẩm',
            'so_imei.required' => 'Vui lòng nhập số IMEI',
            'so_imei.unique' => 'Số IMEI này đã tồn tại trong hệ thống'
        ]);

        Imei::create([
            'bien_the_id' => $request->bien_the_id,
            'so_imei' => $request->so_imei,
            'trang_thai' => Imei::TRANG_THAI_AVAILABLE,
            'ghi_chu' => $request->ghi_chu
        ]);

        return redirect()->route('admin.imei.index')
            ->with('success', 'Thêm IMEI thành công');
    }

    public function edit($id)
    {
        $imei = Imei::with('bienThe.sanPham')->findOrFail($id);
        $sanPhams = SanPham::with('bienThes')->orderBy('ten')->get();
        
        return view('admin.imei.edit', compact('imei', 'sanPhams'));
    }

    public function update(Request $request, $id)
    {
        $imei = Imei::findOrFail($id);

        $request->validate([
            'bien_the_id' => 'required|exists:bien_the,id',
            'so_imei' => 'required|string|max:20|unique:imei,so_imei,' . $id,
            'trang_thai' => 'required|in:available,sold,warranty,returned',
            'ghi_chu' => 'nullable|string'
        ]);

        $imei->update([
            'bien_the_id' => $request->bien_the_id,
            'so_imei' => $request->so_imei,
            'trang_thai' => $request->trang_thai,
            'ghi_chu' => $request->ghi_chu
        ]);

        return redirect()->route('admin.imei.index')
            ->with('success', 'Cập nhật IMEI thành công');
    }

    public function destroy($id)
    {
        $imei = Imei::findOrFail($id);

        // Không cho xóa IMEI đã bán hoặc đang bảo hành
        if (in_array($imei->trang_thai, [Imei::TRANG_THAI_SOLD, Imei::TRANG_THAI_WARRANTY])) {
            return redirect()->back()
                ->with('error', 'Không thể xóa IMEI đã bán hoặc đang bảo hành');
        }

        $imei->delete();

        return redirect()->route('admin.imei.index')
            ->with('success', 'Xóa IMEI thành công');
    }

    // API để lấy biến thể theo sản phẩm
    public function getBienTheByProduct($sanphamId)
    {
        $bienThes = BienThe::where('sanpham_id', $sanphamId)
            ->with('giaTriThuocTinhs')
            ->get()
            ->map(function($bt) {
                return [
                    'id' => $bt->id,
                    'sku' => $bt->sku,
                    'gia_tri' => $bt->gia_tri_thuoc_tinh,
                    'so_luong_ton' => $bt->so_luong_ton
                ];
            });

        return response()->json($bienThes);
    }

    // API để lấy IMEI có sẵn theo biến thể
    public function getImeiByBienThe($bienTheId)
    {
        $imeis = Imei::where('bien_the_id', $bienTheId)
            ->where('trang_thai', Imei::TRANG_THAI_AVAILABLE)
            ->get(['id', 'so_imei']);

        return response()->json($imeis);
    }

    // Nhập nhiều IMEI cùng lúc
    public function bulkCreate(Request $request)
    {
        $sanPhams = SanPham::with('bienThes')->orderBy('ten')->get();
        return view('admin.imei.bulk-create', compact('sanPhams'));
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'bien_the_id' => 'required|exists:bien_the,id',
            'imei_list' => 'required|string'
        ]);

        $imeiList = array_filter(array_map('trim', explode("\n", $request->imei_list)));
        $errors = [];
        $success = 0;

        DB::beginTransaction();
        try {
            foreach ($imeiList as $soImei) {
                // Kiểm tra trùng
                if (Imei::where('so_imei', $soImei)->exists()) {
                    $errors[] = "IMEI {$soImei} đã tồn tại";
                    continue;
                }

                Imei::create([
                    'bien_the_id' => $request->bien_the_id,
                    'so_imei' => $soImei,
                    'trang_thai' => Imei::TRANG_THAI_AVAILABLE
                ]);
                $success++;
            }

            DB::commit();

            $message = "Đã thêm {$success} IMEI thành công";
            if (count($errors) > 0) {
                $message .= '. Lỗi: ' . implode(', ', $errors);
            }

            return redirect()->route('admin.imei.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }
}
