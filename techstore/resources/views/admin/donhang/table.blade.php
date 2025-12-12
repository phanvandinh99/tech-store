<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="sortable {{ request('sort_by') == 'id' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="id" 
                    style="width: 10%;">
                    Mã đơn
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th style="width: 18%;">Khách hàng</th>
                <th style="width: 12%;">SĐT</th>
                <th class="sortable {{ request('sort_by') == 'tong_tien' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="tong_tien" 
                    style="width: 15%;">
                    Tổng tiền
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th class="sortable {{ request('sort_by') == 'trang_thai' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="trang_thai" 
                    style="width: 15%;">
                    Trạng thái
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th class="sortable {{ request('sort_by') == 'created_at' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="created_at" 
                    style="width: 18%;">
                    Ngày tạo
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th style="width: 12%;" class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donHangs as $donHang)
            <tr>
                <td>{{ $donHang->id }}</td>
                <td>{{ $donHang->ten_khach }}</td>
                <td>
                    <small class="text-muted">{{ $donHang->sdt_khach }}</small>
                </td>
                <td>
                    <strong>{{ number_format($donHang->tong_tien) }} đ</strong>
                </td>
                <td>
                    <span class="badge bg-{{ $donHang->trang_thai === 'hoan_thanh' ? 'success' : ($donHang->trang_thai === 'da_huy' ? 'danger' : 'warning') }}">
                        {{ ucfirst(str_replace('_', ' ', $donHang->trang_thai)) }}
                    </span>
                </td>
                <td>
                    <small class="text-muted">
                        {{ $donHang->created_at->format('d/m/Y H:i') }}
                    </small>
                </td>
                <td>
                    <div class="action-buttons justify-content-center">
                        <a href="{{ route('admin.donhang.show', $donHang) }}" 
                           class="btn btn-sm btn-primary btn-icon-sm" 
                           title="Xem">
                            <i class="bi bi-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Không tìm thấy đơn hàng nào</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

