<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nguoiDungs as $nguoiDung)
            <tr>
                <td>{{ $nguoiDung->id }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                            {{ strtoupper(substr($nguoiDung->ten, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-medium">{{ $nguoiDung->ten }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $nguoiDung->email }}</td>
                <td>{{ $nguoiDung->sdt ?? '-' }}</td>
                <td>
                    @if($nguoiDung->vai_tro == 'admin')
                        <span class="badge bg-danger">Admin</span>
                    @else
                        <span class="badge bg-info">Khách hàng</span>
                    @endif
                </td>
                <td>
                    @if($nguoiDung->trang_thai == 'active')
                        <span class="badge bg-success">Hoạt động</span>
                    @else
                        <span class="badge bg-secondary">Tạm khóa</span>
                    @endif
                </td>
                <td>{{ $nguoiDung->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.nguoidung.show', $nguoiDung->id) }}" 
                           class="btn btn-outline-primary" title="Xem chi tiết">
                            <i class="bi bi-eye"></i>
                        </a>
                        
                        @if($nguoiDung->id != auth()->id())
                        <form action="{{ route('admin.nguoidung.toggleStatus', $nguoiDung->id) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="btn btn-outline-{{ $nguoiDung->trang_thai == 'active' ? 'warning' : 'success' }}"
                                    title="{{ $nguoiDung->trang_thai == 'active' ? 'Khóa tài khoản' : 'Kích hoạt tài khoản' }}"
                                    onclick="return confirm('Bạn có chắc muốn {{ $nguoiDung->trang_thai == 'active' ? 'khóa' : 'kích hoạt' }} tài khoản này?')">
                                <i class="bi bi-{{ $nguoiDung->trang_thai == 'active' ? 'lock' : 'unlock' }}"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4">
                    <div class="text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Không có người dùng nào
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
    font-weight: 600;
}
</style>