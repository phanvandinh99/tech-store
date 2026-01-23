<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 8%;">
                    <span style="cursor: pointer;" onclick="sort('id')">
                        Mã phiếu
                        <span class="sort-icon {{ request('sort_by') == 'id' ? 'active' : '' }}">
                            @if(request('sort_by') == 'id')
                                <i class="bi bi-arrow-{{ request('sort_order', 'desc') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up"></i>
                            @endif
                        </span>
                    </span>
                </th>
                <th style="width: 20%;">Nhà cung cấp</th>
                <th style="width: 15%;">Số lượng sản phẩm</th>
                <th style="width: 15%;">Tổng tiền</th>
                <th style="width: 15%;">
                    <span style="cursor: pointer;" onclick="sort('created_at')">
                        Ngày nhập
                        <span class="sort-icon {{ request('sort_by') == 'created_at' ? 'active' : '' }}">
                            @if(request('sort_by') == 'created_at')
                                <i class="bi bi-arrow-{{ request('sort_order', 'desc') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up"></i>
                            @endif
                        </span>
                    </span>
                </th>
                <th style="width: 12%;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($phieuNhaps as $phieuNhap)
            <tr>
                <td>{{ $phieuNhap->ma_phieu ?? '#' . $phieuNhap->id }}</td>
                <td>
                    @if($phieuNhap->nhaCungCap)
                        <strong>{{ $phieuNhap->nhaCungCap->ten }}</strong>
                        @if($phieuNhap->nhaCungCap->sdt)
                            <br><small class="text-muted">{{ $phieuNhap->nhaCungCap->sdt }}</small>
                        @endif
                    @else
                        <span class="text-muted">Không có</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $phieuNhap->chiTietPhieuNhaps->sum('so_luong_nhap') }}</strong> sản phẩm
                    <br><small class="text-muted">{{ $phieuNhap->chiTietPhieuNhaps->count() }} loại</small>
                </td>
                <td>
                    @php
                        $tongTien = $phieuNhap->chiTietPhieuNhaps->sum(function($ct) { 
                            return $ct->so_luong_nhap * $ct->gia_von_nhap; 
                        });
                    @endphp
                    <strong class="text-primary">{{ number_format($tongTien) }} đ</strong>
                </td>
                <td>
                    {{ $phieuNhap->created_at->format('d/m/Y') }}
                    <br><small class="text-muted">{{ $phieuNhap->created_at->format('H:i') }}</small>
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.phieunhap.show', $phieuNhap->id) }}" class="btn btn-outline-primary" title="Xem chi tiết">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button class="btn btn-outline-danger" onclick="deletePhieuNhap({{ $phieuNhap->id }})" title="Xóa">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">
                    <i class="bi bi-inbox" style="font-size: 2rem; color: var(--text-secondary);"></i>
                    <p class="text-muted mt-2 mb-0">Chưa có phiếu nhập nào</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function deletePhieuNhap(id) {
    if (!confirm('Bạn có chắc chắn muốn xóa phiếu nhập này? Số lượng tồn kho sẽ được hoàn trả!')) return;
    
    fetch(`/admin/phieunhap/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            loadData();
        } else {
            alert('Có lỗi xảy ra!');
        }
    });
}
</script>

