@extends('admin.layout')

@section('title', 'Quản lý bình luận')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4 col-6">
        <div class="card text-center">
            <div class="card-body py-3">
                <h4 class="mb-0">{{ $thongKe['tong'] }}</h4>
                <small class="text-muted">Tổng bình luận</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-6">
        <div class="card text-center border-warning">
            <div class="card-body py-3">
                <h4 class="mb-0 text-warning">{{ $thongKe['cho_duyet'] }}</h4>
                <small class="text-muted">Chờ duyệt</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-chat-dots"></i> Danh sách bình luận</span>
        <a href="{{ route('admin.danhgia.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-star-half"></i> Quản lý đánh giá
        </a>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-3">
                <select class="form-select" onchange="window.location.href='{{ route('admin.danhgia.binhluan') }}?trang_thai=' + this.value">
                    <option value="">-- Trạng thái --</option>
                    <option value="pending" {{ request('trang_thai') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="approved" {{ request('trang_thai') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                    <option value="hidden" {{ request('trang_thai') == 'hidden' ? 'selected' : '' }}>Đã ẩn</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Người bình luận</th>
                        <th>Nội dung</th>
                        <th>Sản phẩm</th>
                        <th width="100">Trạng thái</th>
                        <th width="130">Ngày tạo</th>
                        <th width="150">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($binhLuans as $bl)
                    <tr>
                        <td>{{ $bl->id }}</td>
                        <td>{{ $bl->nguoiDung->name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($bl->noi_dung, 50) }}</td>
                        <td>{{ Str::limit($bl->danhGia->sanPham->ten ?? 'N/A', 30) }}</td>
                        <td>
                            @switch($bl->trang_thai)
                                @case('pending')
                                    <span class="badge bg-warning">Chờ duyệt</span>
                                    @break
                                @case('approved')
                                    <span class="badge bg-success">Đã duyệt</span>
                                    @break
                                @case('hidden')
                                    <span class="badge bg-secondary">Đã ẩn</span>
                                    @break
                            @endswitch
                        </td>
                        <td>{{ $bl->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($bl->trang_thai == 'pending')
                                <form action="{{ route('admin.danhgia.binhluan.status', $bl->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="trang_thai" value="approved">
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Duyệt">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                            @endif
                            @if($bl->trang_thai != 'hidden')
                                <form action="{{ route('admin.danhgia.binhluan.status', $bl->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="trang_thai" value="hidden">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="Ẩn">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.danhgia.binhluan.destroy', $bl->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Không có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $binhLuans->links() }}
    </div>
</div>
@endsection

