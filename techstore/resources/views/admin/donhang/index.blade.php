@extends('admin.layout')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cart-check"></i> Quản lý Đơn hàng</h2>
    <div>
        <form method="GET" action="{{ route('admin.donhang.index') }}" class="d-inline">
            <select name="trang_thai" class="form-select d-inline-block" style="width: auto;" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                <option value="cho_xac_nhan" {{ request('trang_thai') == 'cho_xac_nhan' ? 'selected' : '' }}>Chờ xác nhận</option>
                <option value="da_xac_nhan" {{ request('trang_thai') == 'da_xac_nhan' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="dang_giao" {{ request('trang_thai') == 'dang_giao' ? 'selected' : '' }}>Đang giao</option>
                <option value="hoan_thanh" {{ request('trang_thai') == 'hoan_thanh' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="da_huy" {{ request('trang_thai') == 'da_huy' ? 'selected' : '' }}>Đã hủy</option>
            </select>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>SĐT</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donHangs as $donHang)
                    <tr>
                        <td>#{{ $donHang->id }}</td>
                        <td>{{ $donHang->ten_khach }}</td>
                        <td>{{ $donHang->sdt_khach }}</td>
                        <td>{{ number_format($donHang->tong_tien) }} đ</td>
                        <td>
                            <span class="badge bg-{{ $donHang->trang_thai === 'hoan_thanh' ? 'success' : ($donHang->trang_thai === 'da_huy' ? 'danger' : 'warning') }}">
                                {{ ucfirst(str_replace('_', ' ', $donHang->trang_thai)) }}
                            </span>
                        </td>
                        <td>{{ $donHang->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.donhang.show', $donHang) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Xem
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Chưa có đơn hàng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $donHangs->links() }}
        </div>
    </div>
</div>
@endsection

