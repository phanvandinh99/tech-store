<table class="table table-hover">
    <thead>
        <tr>
            <th width="60">ID</th>
            <th>Mã yêu cầu</th>
            <th>Khách hàng</th>
            <th>Sản phẩm</th>
            <th>Hình thức</th>
            <th width="120">Trạng thái</th>
            <th width="130">Ngày tạo</th>
            <th width="120">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse($yeuCaus as $yc)
        <tr>
            <td>{{ $yc->id }}</td>
            <td><code class="bg-light px-2 py-1 rounded">{{ $yc->ma_yeu_cau }}</code></td>
            <td>
                <strong>{{ $yc->nguoiDung->name ?? 'N/A' }}</strong>
                <br><small class="text-muted">{{ $yc->nguoiDung->email ?? '' }}</small>
            </td>
            <td>{{ Str::limit($yc->bienThe->sanPham->ten ?? 'N/A', 30) }}</td>
            <td>
                @switch($yc->hinh_thuc_bao_hanh)
                    @case('sua_chua')
                        <span class="badge bg-info">Sửa chữa</span>
                        @break
                    @case('thay_the')
                        <span class="badge bg-warning">Thay thế</span>
                        @break
                    @case('doi_moi')
                        <span class="badge bg-primary">Đổi mới</span>
                        @break
                @endswitch
            </td>
            <td>
                @switch($yc->trang_thai)
                    @case('cho_tiep_nhan')
                        <span class="badge bg-warning">Chờ tiếp nhận</span>
                        @break
                    @case('dang_xu_ly')
                        <span class="badge bg-info">Đang xử lý</span>
                        @break
                    @case('hoan_tat')
                        <span class="badge bg-success">Hoàn tất</span>
                        @break
                    @case('tu_choi')
                        <span class="badge bg-danger">Từ chối</span>
                        @break
                @endswitch
            </td>
            <td>{{ $yc->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.baohanh.show', $yc->id) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                    <i class="bi bi-eye"></i>
                </a>
                <form action="{{ route('admin.baohanh.destroy', $yc->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Bạn có chắc muốn xóa yêu cầu này?')">
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
            <td colspan="8" class="text-center text-muted py-4">Không có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>

