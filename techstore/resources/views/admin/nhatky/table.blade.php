<table class="table table-hover">
    <thead>
        <tr>
            <th width="60">ID</th>
            <th>Người thực hiện</th>
            <th width="100">Hành động</th>
            <th>Loại</th>
            <th>Mô tả</th>
            <th width="130">Thời gian</th>
            <th width="80">Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        @forelse($nhatKys as $nk)
        <tr>
            <td>{{ $nk->id }}</td>
            <td>
                <strong>{{ $nk->nguoiDung->name ?? 'N/A' }}</strong>
                <br><small class="text-muted">{{ $nk->dia_chi_ip }}</small>
            </td>
            <td>
                @switch($nk->hanh_dong)
                    @case('create')
                        <span class="badge bg-success">Tạo mới</span>
                        @break
                    @case('update')
                        <span class="badge bg-warning">Cập nhật</span>
                        @break
                    @case('delete')
                        <span class="badge bg-danger">Xóa</span>
                        @break
                    @default
                        <span class="badge bg-secondary">{{ $nk->hanh_dong }}</span>
                @endswitch
            </td>
            <td><code>{{ $nk->loai_model }}</code></td>
            <td>{{ Str::limit($nk->mo_ta, 50) }}</td>
            <td>{{ $nk->created_at ? $nk->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
            <td>
                <a href="{{ route('admin.nhatky.show', $nk->id) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                    <i class="bi bi-eye"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center text-muted py-4">Không có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>

