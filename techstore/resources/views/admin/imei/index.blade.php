@extends('admin.layout')

@section('title', 'Quản lý IMEI')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý IMEI</h2>
        <div>
            <a href="{{ route('admin.imei.bulk-create') }}" class="btn btn-info">
                <i class="fas fa-list"></i> Nhập nhiều IMEI
            </a>
            <a href="{{ route('admin.imei.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm IMEI
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.imei.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Sản phẩm</label>
                    <select name="sanpham_id" class="form-select" id="filterSanPham">
                        <option value="">Tất cả sản phẩm</option>
                        @foreach($sanPhams as $sp)
                            <option value="{{ $sp->id }}" {{ request('sanpham_id') == $sp->id ? 'selected' : '' }}>
                                {{ $sp->ten }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="trang_thai" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="available" {{ request('trang_thai') == 'available' ? 'selected' : '' }}>Có sẵn</option>
                        <option value="sold" {{ request('trang_thai') == 'sold' ? 'selected' : '' }}>Đã bán</option>
                        <option value="warranty" {{ request('trang_thai') == 'warranty' ? 'selected' : '' }}>Đang bảo hành</option>
                        <option value="returned" {{ request('trang_thai') == 'returned' ? 'selected' : '' }}>Đã trả lại</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tìm kiếm IMEI</label>
                    <input type="text" name="search" class="form-control" placeholder="Nhập số IMEI..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Lọc
                    </button>
                    <a href="{{ route('admin.imei.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Số IMEI</th>
                            <th>Sản phẩm</th>
                            <th>Biến thể</th>
                            <th>Trạng thái</th>
                            <th>Đơn hàng</th>
                            <th>Ngày bán</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($imeis as $imei)
                            <tr>
                                <td>{{ $imei->id }}</td>
                                <td><strong>{{ $imei->so_imei }}</strong></td>
                                <td>{{ $imei->bienThe->sanPham->ten }}</td>
                                <td>
                                    <small>SKU: {{ $imei->bienThe->sku }}</small><br>
                                    <small class="text-muted">{{ $imei->bienThe->gia_tri_thuoc_tinh }}</small>
                                </td>
                                <td>
                                    @if($imei->trang_thai == 'available')
                                        <span class="badge bg-success">Có sẵn</span>
                                    @elseif($imei->trang_thai == 'sold')
                                        <span class="badge bg-primary">Đã bán</span>
                                    @elseif($imei->trang_thai == 'warranty')
                                        <span class="badge bg-warning">Đang bảo hành</span>
                                    @else
                                        <span class="badge bg-secondary">Đã trả lại</span>
                                    @endif
                                </td>
                                <td>
                                    @if($imei->chiTietDonHang)
                                        <a href="{{ route('admin.donhang.show', $imei->chiTietDonHang->donhang_id) }}">
                                            {{ $imei->chiTietDonHang->donHang->ma_don_hang }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($imei->ngay_ban)
                                        {{ $imei->ngay_ban->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.imei.edit', $imei->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($imei->trang_thai == 'available')
                                        <form action="{{ route('admin.imei.destroy', $imei->id) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Bạn có chắc muốn xóa IMEI này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $imeis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
