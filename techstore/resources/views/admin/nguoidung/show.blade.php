@extends('admin.layout')

@section('title', 'Chi tiết người dùng')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-person"></i> Thông tin người dùng</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="avatar-lg bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                                {{ strtoupper(substr($nguoidung->ten, 0, 2)) }}
                            </div>
                            <h6>{{ $nguoidung->ten }}</h6>
                            <p class="text-muted">{{ $nguoidung->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>ID:</strong></td>
                                <td>{{ $nguoidung->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tên:</strong></td>
                                <td>{{ $nguoidung->ten }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $nguoidung->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Số điện thoại:</strong></td>
                                <td>{{ $nguoidung->sdt ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Vai trò:</strong></td>
                                <td>
                                    @if($nguoidung->vai_tro == 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @else
                                        <span class="badge bg-info">Khách hàng</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Trạng thái:</strong></td>
                                <td>
                                    @if($nguoidung->trang_thai == 'active')
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Tạm khóa</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ngày tạo:</strong></td>
                                <td>{{ $nguoidung->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Cập nhật cuối:</strong></td>
                                <td>{{ $nguoidung->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if($nguoidung->vai_tro == 'customer')
        <!-- Thống kê đơn hàng -->
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="bi bi-cart"></i> Thống kê đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-primary">{{ $nguoidung->donHangs->count() }}</h4>
                            <small class="text-muted">Tổng đơn hàng</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success">{{ number_format($nguoidung->donHangs->sum('thanh_tien'), 0, ',', '.') }}đ</h4>
                            <small class="text-muted">Tổng chi tiêu</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-info">{{ $nguoidung->donHangs->where('trang_thai', 'hoan_thanh')->count() }}</h4>
                            <small class="text-muted">Đơn hoàn thành</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-warning">{{ $nguoidung->donHangs->where('trang_thai', 'da_huy')->count() }}</h4>
                            <small class="text-muted">Đơn đã hủy</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đơn hàng gần đây -->
        @if($nguoidung->donHangs->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="bi bi-clock-history"></i> Đơn hàng gần đây</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nguoidung->donHangs->take(5) as $donHang)
                            <tr>
                                <td>{{ $donHang->ma_don_hang }}</td>
                                <td>{{ $donHang->created_at->format('d/m/Y') }}</td>
                                <td>{{ number_format($donHang->thanh_tien, 0, ',', '.') }}đ</td>
                                <td>
                                    @switch($donHang->trang_thai)
                                        @case('cho_xac_nhan')
                                            <span class="badge bg-warning">Chờ xác nhận</span>
                                            @break
                                        @case('da_xac_nhan')
                                            <span class="badge bg-info">Đã xác nhận</span>
                                            @break
                                        @case('dang_giao')
                                            <span class="badge bg-primary">Đang giao</span>
                                            @break
                                        @case('hoan_thanh')
                                            <span class="badge bg-success">Hoàn thành</span>
                                            @break
                                        @case('da_huy')
                                            <span class="badge bg-danger">Đã hủy</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('admin.donhang.show', $donHang->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-gear"></i> Thao tác</h5>
            </div>
            <div class="card-body">
                @if($nguoidung->id != auth()->id())
                <form action="{{ route('admin.nguoidung.toggleStatus', $nguoidung->id) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="btn btn-{{ $nguoidung->trang_thai == 'active' ? 'warning' : 'success' }} w-100"
                            onclick="return confirm('Bạn có chắc muốn {{ $nguoidung->trang_thai == 'active' ? 'khóa' : 'kích hoạt' }} tài khoản này?')">
                        <i class="bi bi-{{ $nguoidung->trang_thai == 'active' ? 'lock' : 'unlock' }}"></i>
                        {{ $nguoidung->trang_thai == 'active' ? 'Khóa tài khoản' : 'Kích hoạt tài khoản' }}
                    </button>
                </form>
                @endif

                <a href="{{ route('admin.nguoidung.index') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-lg {
    width: 80px;
    height: 80px;
    font-size: 24px;
    font-weight: 600;
}
</style>
@endsection