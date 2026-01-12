<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BienThe;
use App\Models\ChiTietPhieuNhap;
use App\Models\NhaCungCap;
use App\Models\PhieuNhap;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhieuNhapController extends Controller
{
    public function index(Request $request)
    {
        $query = PhieuNhap::with('nhaCungCap', 'chiTietPhieuNhaps.bienThe.sanPham');

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('nhaCungCap', function($q) use ($request) {
                      $q->where('ten', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter by date
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['id', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $phieuNhaps = $query->paginate(15)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.phieunhap.table', compact('phieuNhaps'))->render(),
                'pagination' => view('admin.phieunhap.pagination', compact('phieuNhaps'))->render(),
            ]);
        }

        return view('admin.phieunhap.index', compact('phieuNhaps'));
    }

    public function create()
    {
        $nhaCungCaps = NhaCungCap::all();
        $sanPhams = SanPham::with(['bienThes', 'danhMuc'])->get();
        
        // Format dữ liệu sản phẩm cho JavaScript
        $sanPhamsFormatted = $sanPhams->map(function($sp) {
            return [
                'id' => $sp->id,
                'ten' => $sp->ten,
                'danh_muc' => $sp->danhMuc->ten ?? '',
                'bien_thes' => $sp->bienThes->map(function($bt) {
                    return [
                        'id' => $bt->id,
                        'sku' => $bt->sku,
                        'gia' => $bt->gia,
                        'so_luong_ton' => $bt->so_luong_ton
                    ];
                })->toArray()
            ];
        })->toArray();
        
        return view('admin.phieunhap.create', compact('nhaCungCaps', 'sanPhams', 'sanPhamsFormatted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nha_cung_cap_id' => 'nullable|exists:nha_cung_cap,id',
            'ghi_chu' => 'nullable|string',
            'chi_tiet' => 'required|array|min:1',
            'chi_tiet.*.bien_the_id' => 'required|exists:bien_the,id',
            'chi_tiet.*.so_luong_nhap' => 'required|integer|min:1',
            'chi_tiet.*.gia_von_nhap' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Tạo phiếu nhập
            $phieuNhap = PhieuNhap::create([
                'nha_cung_cap_id' => $request->nha_cung_cap_id,
                'ghi_chu' => $request->ghi_chu,
            ]);

            // Tạo chi tiết và cập nhật tồn kho
            foreach ($request->chi_tiet as $ct) {
                $bienThe = BienThe::findOrFail($ct['bien_the_id']);
                
                // Tạo chi tiết phiếu nhập
                ChiTietPhieuNhap::create([
                    'phieu_nhap_id' => $phieuNhap->id,
                    'bien_the_id' => $ct['bien_the_id'],
                    'so_luong_nhap' => $ct['so_luong_nhap'],
                    'gia_von_nhap' => $ct['gia_von_nhap'],
                ]);

                // Cập nhật số lượng tồn kho
                $bienThe->so_luong_ton += $ct['so_luong_nhap'];
                
                // Cập nhật giá vốn (có thể tính trung bình hoặc giá mới nhất)
                // Ở đây tôi sẽ cập nhật giá vốn mới nhất
                $bienThe->gia_von = $ct['gia_von_nhap'];
                
                $bienThe->save();
            }
        });

        return redirect()->route('admin.phieunhap.index')
            ->with('success', 'Tạo phiếu nhập thành công!');
    }

    public function show($id)
    {
        $phieuNhap = PhieuNhap::with([
            'nhaCungCap',
            'chiTietPhieuNhaps.bienThe.sanPham.danhMuc'
        ])->findOrFail($id);

        // Tính tổng tiền
        $phieuNhap->tong_tien = $phieuNhap->chiTietPhieuNhaps->sum(function($ct) {
            return $ct->so_luong_nhap * $ct->gia_von_nhap;
        });

        return view('admin.phieunhap.show', compact('phieuNhap'));
    }

    public function destroy($id)
    {
        $phieuNhap = PhieuNhap::with('chiTietPhieuNhaps.bienThe')->findOrFail($id);

        DB::transaction(function () use ($phieuNhap) {
            // Hoàn trả số lượng tồn kho
            foreach ($phieuNhap->chiTietPhieuNhaps as $ct) {
                $bienThe = $ct->bienThe;
                $bienThe->so_luong_ton = max(0, $bienThe->so_luong_ton - $ct->so_luong_nhap);
                $bienThe->save();
            }

            // Xóa phiếu nhập (chi tiết sẽ tự động xóa do cascade)
            $phieuNhap->delete();
        });

        return redirect()->route('admin.phieunhap.index')
            ->with('success', 'Xóa phiếu nhập thành công!');
    }
}

