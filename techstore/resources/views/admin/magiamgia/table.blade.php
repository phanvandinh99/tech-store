<table class="table table-hover">
    <thead>
        <tr>
            <th width="60">ID</th>
            <th>Mã voucher</th>
            <th>Tên</th>
            <th>Loại giảm</th>
            <th>Giá trị</th>
            <th>Đơn tối thiểu</th>
            <th>Đã dùng</th>
            <th>Thời gian</th>
            <th width="100">Trạng thái</th>
            <th width="120">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse($maGiamGias as $mg)
        <tr>
            <td>{{ $mg->id }}</td>
            <td><code class="bg-light px-2 py-1 rounded">{{ $mg->ma_voucher }}</code></td>
            <td>{{ $mg->ten }}</td>
            <td>
                @if($mg->loai_giam_gia == 'percent')
                    <span class="badge bg-info">Phần trăm</span>
                @else
                    <span class="badge bg-success">Cố định</span>
                @endif
            </td>
            <td>
                @if($mg->loai_giam_gia == 'percent')
                    <strong>{{ number_format($mg->gia_tri_giam) }}%</strong>
                @else
                    <strong>{{ number_format($mg->gia_tri_giam) }}đ</strong>
                @endif
            </td>
            <td>{{ number_format($mg->don_toi_thieu) }}đ</td>
            <td>
                {{ $mg->so_lan_da_su_dung }}/{{ $mg->so_lan_su_dung_toi_da ?? '∞' }}
            </td>
            <td class="small">
                @if($mg->ngay_bat_dau && $mg->ngay_ket_thuc)
                    {{ $mg->ngay_bat_dau->format('d/m/Y') }} - {{ $mg->ngay_ket_thuc->format('d/m/Y') }}
                @else
                    <span class="text-muted">Không giới hạn</span>
                @endif
            </td>
            <td>
                @switch($mg->trang_thai)
                    @case('active')
                        <span class="badge bg-success">Hoạt động</span>
                        @break
                    @case('inactive')
                        <span class="badge bg-secondary">Tạm dừng</span>
                        @break
                    @case('expired')
                        <span class="badge bg-danger">Hết hạn</span>
                        @break
                @endswitch
            </td>
            <td>
                <a href="{{ route('admin.magiamgia.edit', $mg->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('admin.magiamgia.toggle', $mg->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-outline-{{ $mg->trang_thai == 'active' ? 'warning' : 'success' }}" 
                        title="{{ $mg->trang_thai == 'active' ? 'Tạm dừng' : 'Kích hoạt' }}">
                        <i class="bi bi-{{ $mg->trang_thai == 'active' ? 'pause' : 'play' }}"></i>
                    </button>
                </form>
                <form action="{{ route('admin.magiamgia.destroy', $mg->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Bạn có chắc muốn xóa mã giảm giá này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="10" class="text-center text-muted py-4">Không có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>

