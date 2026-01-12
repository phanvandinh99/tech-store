<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 8%;">
                    <span style="cursor: pointer;" onclick="sort('id')">
                        ID
                        <span class="sort-icon {{ request('sort_by') == 'id' ? 'active' : '' }}">
                            @if(request('sort_by') == 'id')
                                <i class="bi bi-arrow-{{ request('sort_order', 'desc') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up"></i>
                            @endif
                        </span>
                    </span>
                </th>
                <th style="width: 25%;">
                    <span style="cursor: pointer;" onclick="sort('ten')">
                        Tên nhà cung cấp
                        <span class="sort-icon {{ request('sort_by') == 'ten' ? 'active' : '' }}">
                            @if(request('sort_by') == 'ten')
                                <i class="bi bi-arrow-{{ request('sort_order', 'desc') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up"></i>
                            @endif
                        </span>
                    </span>
                </th>
                <th style="width: 15%;">Số điện thoại</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 20%;">Địa chỉ</th>
                <th style="width: 12%;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nhaCungCaps as $ncc)
            <tr>
                <td>{{ $ncc->id }}</td>
                <td><strong>{{ $ncc->ten }}</strong></td>
                <td>{{ $ncc->sdt ?? '-' }}</td>
                <td>{{ $ncc->email ?? '-' }}</td>
                <td>
                    @if($ncc->dia_chi)
                        <small>{{ Str::limit($ncc->dia_chi, 50) }}</small>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" 
                                data-edit-id="{{ $ncc->id }}"
                                data-edit-ten="{{ htmlspecialchars($ncc->ten, ENT_QUOTES, 'UTF-8') }}"
                                data-edit-sdt="{{ htmlspecialchars($ncc->sdt ?? '', ENT_QUOTES, 'UTF-8') }}"
                                data-edit-email="{{ htmlspecialchars($ncc->email ?? '', ENT_QUOTES, 'UTF-8') }}"
                                data-edit-diachi="{{ htmlspecialchars($ncc->dia_chi ?? '', ENT_QUOTES, 'UTF-8') }}"
                                onclick="editNhaCungCapFromButton(this)" 
                                title="Sửa">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteNhaCungCap({{ $ncc->id }})" title="Xóa">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">
                    <i class="bi bi-inbox" style="font-size: 2rem; color: var(--text-secondary);"></i>
                    <p class="text-muted mt-2 mb-0">Chưa có nhà cung cấp nào</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

