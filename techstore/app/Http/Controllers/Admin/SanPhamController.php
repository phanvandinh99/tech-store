<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnhSanPham;
use App\Models\BienThe;
use App\Models\DanhMuc;
use App\Models\GiaTriThuocTinh;
use App\Models\SanPham;
use App\Models\ThuocTinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SanPhamController extends Controller
{
    public function index(Request $request)
    {
        $query = SanPham::with('danhMuc', 'nhaCungCap', 'bienThes', 'anhSanPhams');

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('ten', 'like', '%' . $request->search . '%')
                  ->orWhereHas('danhMuc', function($q) use ($request) {
                      $q->where('ten', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['id', 'ten', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination - 15 items per page
        $sanPhams = $query->paginate(15)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.sanpham.table', compact('sanPhams'))->render(),
                'pagination' => view('admin.sanpham.pagination', compact('sanPhams'))->render(),
            ]);
        }

        return view('admin.sanpham.index', compact('sanPhams'));
    }

    public function create()
    {
        $danhMucs = DanhMuc::all();
        $thuocTinhs = ThuocTinh::with('giaTriThuocTinhs')->get();
        $nhaCungCaps = \App\Models\NhaCungCap::all();
        $thuongHieus = \App\Models\ThuongHieu::all();
        // Tìm thuộc tính "Kích thước màn hình" để có thể filter
        $kichThuocManHinhId = ThuocTinh::where('ten', 'Kích thước màn hình')->value('id');
        return view('admin.sanpham.create', compact('danhMucs', 'thuocTinhs', 'nhaCungCaps', 'thuongHieus', 'kichThuocManHinhId'));
    }

    public function store(Request $request)
    {
        // Filter bỏ các giá trị rỗng trong giatri_thuoctinh_ids và convert so_luong_ton của từng biến thể
        if ($request->has('bien_the') && is_array($request->bien_the)) {
            foreach ($request->bien_the as $index => $bt) {
                // Filter giatri_thuoctinh_ids
                if (isset($bt['giatri_thuoctinh_ids']) && is_array($bt['giatri_thuoctinh_ids'])) {
                    $filtered = array_filter($bt['giatri_thuoctinh_ids'], function($value) {
                        return !empty($value) && $value !== '';
                    });
                    $request->merge([
                        "bien_the.{$index}.giatri_thuoctinh_ids" => array_values($filtered)
                    ]);
                }
                
                // Convert so_luong_ton từ string sang integer
                if (isset($bt['so_luong_ton'])) {
                    $request->merge([
                        "bien_the.{$index}.so_luong_ton" => (int) $bt['so_luong_ton']
                    ]);
                }
            }
        }
        
        // Validate cơ bản trước
        $rules = [
            'ten' => 'required|string|max:255',
            'danhmuc_id' => 'required|exists:danhmuc,id',
            'thuong_hieu_id' => 'nullable|exists:thuong_hieu,id',
            'nhacungcap_id' => 'required|exists:nha_cung_cap,id',
            'mota' => 'nullable|string',
            'trang_thai' => 'nullable|in:draft,active,inactive',
            'thuoc_tinh_ids' => 'nullable|array',
            'thuoc_tinh_ids.*' => 'exists:thuoctinh,id',
            'bien_the' => 'required|array|min:1',
            'bien_the.*.sku' => 'required|string|max:100',
            'bien_the.*.gia' => 'required|numeric|min:0',
            'bien_the.*.gia_von' => 'required|numeric|min:0',
            'bien_the.*.so_luong_ton' => 'nullable|integer|min:0',
            'bien_the.*.giatri_thuoctinh_ids' => 'nullable|array',
            'bien_the.*.giatri_thuoctinh_ids.*' => 'exists:giatri_thuoctinh,id',
        ];

        // Chỉ validate ảnh nếu có file được upload
        if ($request->hasFile('images')) {
            $rules['images'] = 'array';
            $rules['images.*'] = 'image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        // Validate ảnh cho từng biến thể nếu có
        if ($request->has('bien_the') && is_array($request->bien_the)) {
            foreach ($request->bien_the as $index => $bt) {
                if (isset($bt['images']) && $request->hasFile("bien_the.{$index}.images")) {
                    $rules["bien_the.{$index}.images"] = 'array';
                    $rules["bien_the.{$index}.images.*"] = 'image|mimes:jpeg,png,jpg,gif,webp|max:2048';
                }
            }
        }

        $request->validate($rules);

        DB::transaction(function () use ($request) {
            // Tạo slug từ tên sản phẩm
            $slug = Str::slug($request->ten);
            $uniqueSlug = $slug;
            $counter = 1;
            while (SanPham::where('slug', $uniqueSlug)->exists()) {
                $uniqueSlug = $slug . '-' . $counter;
                $counter++;
            }
            
            $sanPham = SanPham::create([
                'ten' => $request->ten,
                'slug' => $uniqueSlug,
                'danhmuc_id' => $request->danhmuc_id,
                'thuong_hieu_id' => $request->thuong_hieu_id ?? null,
                'nhacungcap_id' => $request->nhacungcap_id,
                'mo_ta_chi_tiet' => $request->mota ?? null,
                'trang_thai' => $request->trang_thai ?? 'draft',
            ]);

            // Attach thuộc tính
            if ($request->thuoc_tinh_ids) {
                $sanPham->thuocTinhs()->attach($request->thuoc_tinh_ids);
            }

            // Tạo biến thể
            foreach ($request->bien_the as $index => $bt) {
                // Tạo SKU unique nếu trùng
                $sku = $this->generateUniqueSku($bt['sku'] ?? null, $sanPham->id);
                
                $bienThe = BienThe::create([
                    'sanpham_id' => $sanPham->id,
                    'sku' => $sku,
                    'gia' => $bt['gia'],
                    'gia_von' => $bt['gia_von'],
                    'so_luong_ton' => $bt['so_luong_ton'] ?? 0,
                ]);

                // Attach giá trị thuộc tính cho biến thể (filter bỏ giá trị rỗng)
                if (isset($bt['giatri_thuoctinh_ids']) && is_array($bt['giatri_thuoctinh_ids'])) {
                    $giatriIds = array_filter($bt['giatri_thuoctinh_ids'], function($value) {
                        return !empty($value) && $value !== '';
                    });
                    if (!empty($giatriIds)) {
                        $bienThe->giaTriThuocTinhs()->attach(array_values($giatriIds));
                    }
                }

                // Upload ảnh cho biến thể (nếu có)
                if ($request->hasFile("bien_the.{$index}.images")) {
                    $files = $request->file("bien_the.{$index}.images");
                    if (is_array($files)) {
                        $this->uploadImages($files, $sanPham->id, $bienThe->id, $index === 0);
                    }
                }
            }

            // Upload ảnh chung cho sản phẩm (nếu có)
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                if (is_array($files)) {
                    $this->uploadImages($files, $sanPham->id, null, true);
                }
            }
        });

        return redirect()->route('admin.sanpham.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $sanPham = SanPham::with(['thuocTinhs', 'bienThes.giaTriThuocTinhs', 'anhSanPhams', 'danhMuc'])->findOrFail($id);
        $danhMucs = DanhMuc::all();
        $thuocTinhs = ThuocTinh::with('giaTriThuocTinhs')->get();
        $nhaCungCaps = \App\Models\NhaCungCap::all();
        $thuongHieus = \App\Models\ThuongHieu::all();
        // Tìm thuộc tính "Kích thước màn hình" để có thể filter
        $kichThuocManHinhId = ThuocTinh::where('ten', 'Kích thước màn hình')->value('id');
        // Kiểm tra xem danh mục có phải là điện thoại không (dựa vào tên danh mục)
        $isDienThoai = $sanPham->danhMuc && (
            stripos($sanPham->danhMuc->ten, 'điện thoại') !== false || 
            stripos($sanPham->danhMuc->ten, 'smartphone') !== false ||
            stripos($sanPham->danhMuc->ten, 'phone') !== false
        );
        return view('admin.sanpham.edit', compact('sanPham', 'danhMucs', 'thuocTinhs', 'nhaCungCaps', 'thuongHieus', 'kichThuocManHinhId', 'isDienThoai'));
    }

    public function update(Request $request, $id)
    {
        $sanPham = SanPham::findOrFail($id);
        
        $request->validate([
            'ten' => 'required|string|max:255',
            'danhmuc_id' => 'required|exists:danhmuc,id',
            'thuong_hieu_id' => 'nullable|exists:thuong_hieu,id',
            'nhacungcap_id' => 'required|exists:nha_cung_cap,id',
            'mota' => 'nullable|string',
            'trang_thai' => 'nullable|in:draft,active,inactive',
            'thuoc_tinh_ids' => 'nullable|array',
            'thuoc_tinh_ids.*' => 'exists:thuoctinh,id',
        ]);

        DB::transaction(function () use ($request, $sanPham) {
            // Tạo slug mới nếu tên thay đổi
            $updateData = [
                'ten' => $request->ten,
                'danhmuc_id' => $request->danhmuc_id,
                'thuong_hieu_id' => $request->thuong_hieu_id ?? null,
                'nhacungcap_id' => $request->nhacungcap_id,
                'mo_ta_chi_tiet' => $request->mota ?? null,
                'trang_thai' => $request->trang_thai ?? $sanPham->trang_thai,
            ];
            
            // Nếu tên thay đổi, tạo slug mới
            if ($sanPham->ten !== $request->ten) {
                $slug = Str::slug($request->ten);
                $uniqueSlug = $slug;
                $counter = 1;
                while (SanPham::where('slug', $uniqueSlug)->where('id', '!=', $sanPham->id)->exists()) {
                    $uniqueSlug = $slug . '-' . $counter;
                    $counter++;
                }
                $updateData['slug'] = $uniqueSlug;
            }
            
            $sanPham->update($updateData);

            // Sync thuộc tính
            if ($request->has('thuoc_tinh_ids')) {
                $sanPham->thuocTinhs()->sync($request->thuoc_tinh_ids);
            } else {
                $sanPham->thuocTinhs()->detach();
            }
        });

        return redirect()->route('admin.sanpham.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $sanPham = SanPham::findOrFail($id);
        
        // Xóa ảnh
        foreach ($sanPham->anhSanPhams as $anh) {
            if (Storage::disk('public')->exists($anh->duong_dan)) {
                Storage::disk('public')->delete($anh->duong_dan);
            }
        }
        
        $sanPham->delete();
        return redirect()->route('admin.sanpham.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }

    // Upload ảnh
    public function uploadImages($files, $sanPhamId, $bienTheId = null, $setFirstAsPrimary = false)
    {
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $index => $file) {
            $path = $file->store('products', 'public');
            
            AnhSanPham::create([
                'sanpham_id' => $sanPhamId,
                'bien_the_id' => $bienTheId,
                'duong_dan' => $path,
                'la_anh_chinh' => $setFirstAsPrimary && $index === 0,
            ]);
        }
    }

    // Xóa ảnh
    public function deleteImage($id)
    {
        $anh = AnhSanPham::findOrFail($id);
        
        if (Storage::disk('public')->exists($anh->duong_dan)) {
            Storage::disk('public')->delete($anh->duong_dan);
        }
        
        $anh->delete();
        
        return response()->json(['success' => true, 'message' => 'Xóa ảnh thành công!']);
    }

    // Đặt ảnh chính
    public function setPrimaryImage($id)
    {
        $anh = AnhSanPham::findOrFail($id);
        
        // Bỏ ảnh chính cũ
        AnhSanPham::where('sanpham_id', $anh->sanpham_id)
            ->where('bien_the_id', $anh->bien_the_id)
            ->update(['la_anh_chinh' => false]);
        
        // Đặt ảnh chính mới
        $anh->update(['la_anh_chinh' => true]);
        
        return response()->json(['success' => true, 'message' => 'Đặt ảnh chính thành công!']);
    }

    // Thêm ảnh mới
    public function addImages(Request $request, $id)
    {
        $sanPham = SanPham::findOrFail($id);
        
        // Kiểm tra có file được upload không
        if (!$request->hasFile('images')) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một ảnh để upload!');
        }

        $files = $request->file('images');
        
        // Lọc bỏ các file null hoặc không hợp lệ
        $validFiles = array_filter($files, function($file) {
            return $file && $file->isValid();
        });

        if (empty($validFiles)) {
            return redirect()->back()->with('error', 'Không có file ảnh hợp lệ nào được chọn!');
        }

        // Validate từng file
        foreach ($validFiles as $index => $file) {
            $request->validate([
                "images.{$index}" => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);
        }

        // Validate bien_the_id nếu có
        if ($request->has('bien_the_id') && $request->bien_the_id) {
            $request->validate([
                'bien_the_id' => 'exists:bien_the,id',
            ]);
        }

        $this->uploadImages(
            $validFiles,
            $sanPham->id,
            $request->bien_the_id,
            false
        );

        return redirect()->back()->with('success', 'Thêm ảnh thành công!');
    }

    // Thêm biến thể mới
    public function addVariant(Request $request, $id)
    {
        $sanPham = SanPham::findOrFail($id);
        
        // Filter bỏ các giá trị rỗng trong giatri_thuoctinh_ids
        $giatriIds = $request->giatri_thuoctinh_ids ?? [];
        $giatriIds = array_filter($giatriIds, function($value) {
            return !empty($value) && $value !== '';
        });
        $giatriIds = array_values($giatriIds); // Re-index array
        
        // Convert so_luong_ton từ string sang integer
        if ($request->has('so_luong_ton')) {
            $request->merge(['so_luong_ton' => (int) $request->so_luong_ton]);
        }
        
        // Merge lại vào request để validate
        $request->merge(['giatri_thuoctinh_ids' => $giatriIds]);
        
        $request->validate([
            'sku' => 'nullable|string|max:100',
            'gia' => 'required|numeric|min:0',
            'gia_von' => 'required|numeric|min:0',
            'so_luong_ton' => 'required|integer|min:0',
            'giatri_thuoctinh_ids' => 'nullable|array',
            'giatri_thuoctinh_ids.*' => 'exists:giatri_thuoctinh,id',
        ]);

        // Tạo SKU unique nếu trùng
        $sku = $this->generateUniqueSku($request->sku ?? null, $sanPham->id);

        $bienThe = BienThe::create([
            'sanpham_id' => $sanPham->id,
            'sku' => $sku,
            'gia' => $request->gia,
            'gia_von' => $request->gia_von,
            'so_luong_ton' => $request->so_luong_ton ?? 0,
        ]);

        if (!empty($giatriIds)) {
            $bienThe->giaTriThuocTinhs()->attach($giatriIds);
        }

        // Upload ảnh nếu có
        if ($request->hasFile('images')) {
            $this->uploadImages($request->file('images'), $sanPham->id, $bienThe->id, false);
        }

        return redirect()->back()->with('success', 'Thêm biến thể thành công!');
    }

    // Cập nhật biến thể
    public function updateVariant(Request $request, $id, $variantId)
    {
        $sanPham = SanPham::findOrFail($id);
        $bienThe = BienThe::where('sanpham_id', $sanPham->id)->findOrFail($variantId);
        
        // Filter bỏ các giá trị rỗng trong giatri_thuoctinh_ids
        $giatriIds = $request->giatri_thuoctinh_ids ?? [];
        $giatriIds = array_filter($giatriIds, function($value) {
            return !empty($value) && $value !== '';
        });
        $giatriIds = array_values($giatriIds); // Re-index array
        
        // Convert so_luong_ton từ string sang integer
        if ($request->has('so_luong_ton')) {
            $request->merge(['so_luong_ton' => (int) $request->so_luong_ton]);
        }
        
        // Merge lại vào request để validate
        $request->merge(['giatri_thuoctinh_ids' => $giatriIds]);
        
        $request->validate([
            'sku' => 'nullable|string|max:100',
            'gia' => 'required|numeric|min:0',
            'gia_von' => 'required|numeric|min:0',
            'so_luong_ton' => 'required|integer|min:0',
            'giatri_thuoctinh_ids' => 'nullable|array',
            'giatri_thuoctinh_ids.*' => 'exists:giatri_thuoctinh,id',
        ]);

        // Tạo SKU unique nếu trùng (trừ SKU hiện tại của biến thể này)
        $sku = $this->generateUniqueSku($request->sku ?? null, $bienThe->sanpham_id, $bienThe->id);

        $bienThe->update([
            'sku' => $sku,
            'gia' => $request->gia,
            'gia_von' => $request->gia_von,
            'so_luong_ton' => $request->so_luong_ton ?? $bienThe->so_luong_ton,
        ]);

        // Sync giá trị thuộc tính (chỉ sync các giá trị không rỗng)
        if (!empty($giatriIds)) {
            $bienThe->giaTriThuocTinhs()->sync($giatriIds);
        } else {
            $bienThe->giaTriThuocTinhs()->detach();
        }

        return redirect()->back()->with('success', 'Cập nhật biến thể thành công!');
    }

    // Xóa biến thể
    public function deleteVariant($id, $variantId)
    {
        $sanPham = SanPham::findOrFail($id);
        $bienThe = BienThe::where('sanpham_id', $sanPham->id)->findOrFail($variantId);
        
        // Xóa ảnh của biến thể
        foreach ($bienThe->anhSanPhams as $anh) {
            if (Storage::disk('public')->exists($anh->duong_dan)) {
                Storage::disk('public')->delete($anh->duong_dan);
            }
        }
        
        $bienThe->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Xóa biến thể thành công!']);
        }
        
        return redirect()->back()->with('success', 'Xóa biến thể thành công!');
    }

    /**
     * Tạo SKU unique tự động nếu trùng
     * 
     * @param string|null $inputSku SKU người dùng nhập (có thể null)
     * @param int $sanphamId ID sản phẩm
     * @param int|null $excludeId ID biến thể cần loại trừ (khi update)
     * @return string SKU unique
     */
    private function generateUniqueSku(?string $inputSku, int $sanphamId, ?int $excludeId = null): string
    {
        // Nếu không có SKU từ input, tạo SKU mặc định
        if (empty($inputSku)) {
            $baseSku = 'SP-' . $sanphamId . '-' . strtoupper(Str::random(6));
        } else {
            $baseSku = trim($inputSku);
        }

        // Kiểm tra SKU đã tồn tại chưa
        $query = BienThe::where('sku', $baseSku);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if (!$query->exists()) {
            return $baseSku;
        }

        // Nếu trùng, thêm suffix ngẫu nhiên
        $counter = 1;
        $uniqueSku = $baseSku;
        
        while (true) {
            // Thử format: SKU-RANDOM hoặc SKU-{counter}
            if ($counter === 1) {
                $uniqueSku = $baseSku . '-' . strtoupper(Str::random(4));
            } else {
                $uniqueSku = $baseSku . '-' . strtoupper(Str::random(4)) . '-' . $counter;
            }

            $checkQuery = BienThe::where('sku', $uniqueSku);
            if ($excludeId) {
                $checkQuery->where('id', '!=', $excludeId);
            }

            if (!$checkQuery->exists()) {
                break;
            }

            $counter++;
            
            // Tránh vòng lặp vô hạn
            if ($counter > 100) {
                $uniqueSku = $baseSku . '-' . time() . '-' . strtoupper(Str::random(4));
                break;
            }
        }

        return $uniqueSku;
    }
}
