<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\YeuCauBaoHanh;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\AnhBaoHanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WarrantyController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('customer')->user();
        
        $query = YeuCauBaoHanh::with([
            'donHang',
            'bienThe.sanPham.danhMuc',
            'bienThe.sanPham.anhSanPhams',
            'anhBaoHanh'
        ])->where('nguoi_dung_id', $user->id);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('trang_thai', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $warranties = $query->paginate(10)->withQueryString();

        // Thống kê
        $statusCounts = [
            'all' => YeuCauBaoHanh::where('nguoi_dung_id', $user->id)->count(),
            'cho_tiep_nhan' => YeuCauBaoHanh::where('nguoi_dung_id', $user->id)->where('trang_thai', 'cho_tiep_nhan')->count(),
            'dang_xu_ly' => YeuCauBaoHanh::where('nguoi_dung_id', $user->id)->where('trang_thai', 'dang_xu_ly')->count(),
            'hoan_tat' => YeuCauBaoHanh::where('nguoi_dung_id', $user->id)->where('trang_thai', 'hoan_tat')->count(),
            'tu_choi' => YeuCauBaoHanh::where('nguoi_dung_id', $user->id)->where('trang_thai', 'tu_choi')->count(),
        ];

        return view('frontend.warranty.index', compact('warranties', 'statusCounts'));
    }

    public function create(Request $request)
    {
        $user = Auth::guard('customer')->user();
        
        // Lấy danh sách đơn hàng đã hoàn thành của khách hàng
        $orders = DonHang::with(['chiTietDonHangs.bienThe.sanPham.danhMuc'])
            ->where('nguoi_dung_id', $user->id)
            ->where('trang_thai', 'hoan_thanh')
            ->orderBy('created_at', 'desc')
            ->get();

        // Nếu có order_id trong request, lấy chi tiết đơn hàng đó
        $selectedOrder = null;
        $orderItems = [];
        
        if ($request->has('order_id')) {
            $selectedOrder = DonHang::with(['chiTietDonHangs.bienThe.sanPham.danhMuc', 'chiTietDonHangs.bienThe.sanPham.anhSanPhams'])
                ->where('nguoi_dung_id', $user->id)
                ->where('trang_thai', 'hoan_thanh')
                ->find($request->order_id);
            
            if ($selectedOrder) {
                $orderItems = $selectedOrder->chiTietDonHangs;
            }
        }

        return view('frontend.warranty.create', compact('orders', 'selectedOrder', 'orderItems'));
    }

    public function store(Request $request)
    {
        $user = Auth::guard('customer')->user();

        $request->validate([
            'donhang_id' => 'required|exists:donhang,id',
            'bien_the_id' => 'required|exists:bien_the,id',
            'mo_ta_loi' => 'required|string|min:10|max:2000',
            'hinh_thuc_bao_hanh' => 'required|in:sua_chua,thay_the,doi_moi',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Kiểm tra đơn hàng thuộc về khách hàng và đã hoàn thành
        $donHang = DonHang::where('nguoi_dung_id', $user->id)
            ->where('trang_thai', 'hoan_thanh')
            ->findOrFail($request->donhang_id);

        // Kiểm tra biến thể có trong đơn hàng không
        $chiTiet = ChiTietDonHang::where('donhang_id', $donHang->id)
            ->where('bien_the_id', $request->bien_the_id)
            ->firstOrFail();

        $maYeuCau = DB::transaction(function () use ($request, $user, $donHang) {
            // Tạo mã yêu cầu
            $maYeuCau = YeuCauBaoHanh::taoMaYeuCau();
            
            // Tạo yêu cầu bảo hành
            $yeuCau = YeuCauBaoHanh::create([
                'nguoi_dung_id' => $user->id,
                'donhang_id' => $donHang->id,
                'bien_the_id' => $request->bien_the_id,
                'ma_yeu_cau' => $maYeuCau,
                'mo_ta_loi' => $request->mo_ta_loi,
                'hinh_thuc_bao_hanh' => $request->hinh_thuc_bao_hanh,
                'trang_thai' => 'cho_tiep_nhan',
            ]);

            // Upload ảnh nếu có
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('warranty', 'public');
                    
                    AnhBaoHanh::create([
                        'yeu_cau_id' => $yeuCau->id,
                        'duong_dan' => $path,
                    ]);
                }
            }

            return $maYeuCau;
        });

        return redirect()->route('warranty.index')
            ->with('success', 'Yêu cầu bảo hành đã được gửi thành công! Mã yêu cầu: ' . $maYeuCau);
    }

    public function show($id)
    {
        $user = Auth::guard('customer')->user();
        
        $warranty = YeuCauBaoHanh::with([
            'donHang',
            'bienThe.sanPham.danhMuc',
            'bienThe.sanPham.anhSanPhams',
            'anhBaoHanh',
            'nguoiDung'
        ])->where('nguoi_dung_id', $user->id)
          ->findOrFail($id);

        return view('frontend.warranty.show', compact('warranty'));
    }
}
