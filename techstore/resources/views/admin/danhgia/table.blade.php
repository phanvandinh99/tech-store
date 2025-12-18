<table class="table table-hover">
    <thead>
        <tr>
            <th width="60">ID</th>
            <th>Sản phẩm</th>
            <th>Khách hàng</th>
            <th width="120">Đánh giá</th>
            <th>Nội dung</th>
            <th width="80">Ảnh</th>
            <th width="100">Trạng thái</th>
            <th width="130">Ngày tạo</th>
            <th width="150">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse($danhGias as $dg)
        <tr>
            <td>{{ $dg->id }}</td>
            <td>
                <strong>{{ Str::limit($dg->sanPham->ten ?? 'N/A', 30) }}</strong>
            </td>
            <td>{{ $dg->nguoiDung->name ?? 'N/A' }}</td>
            <td>
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= $dg->so_sao ? '-fill text-warning' : '' }}"></i>
                @endfor
            </td>
            <td>{{ Str::limit($dg->noi_dung, 50) }}</td>
            <td>
                @if($dg->anhDanhGia->count() > 0)
                    <span class="badge bg-info">{{ $dg->anhDanhGia->count() }} ảnh</span>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                @switch($dg->trang_thai)
                    @case('pending')
                        <span class="badge bg-warning">Chờ duyệt</span>
                        @break
                    @case('approved')
                        <span class="badge bg-success">Đã duyệt</span>
                        @break
                    @case('hidden')
                        <span class="badge bg-secondary">Đã ẩn</span>
                        @break
                    @case('rejected')
                        <span class="badge bg-danger">Từ chối</span>
                        @break
                @endswitch
            </td>
            <td>{{ $dg->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.danhgia.show', $dg->id) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                    <i class="bi bi-eye"></i>
                </a>
                @if($dg->trang_thai == 'pending')
                    <form action="{{ route('admin.danhgia.status', $dg->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="trang_thai" value="approved">
                        <button type="submit" class="btn btn-sm btn-outline-success" title="Duyệt">
                            <i class="bi bi-check"></i>
                        </button>
                    </form>
                @endif
                @if($dg->trang_thai != 'hidden')
                    <form action="{{ route('admin.danhgia.status', $dg->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="trang_thai" value="hidden">
                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Ẩn">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </form>
                @endif
                <form action="{{ route('admin.danhgia.destroy', $dg->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
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
            <td colspan="9" class="text-center text-muted py-4">Không có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>

