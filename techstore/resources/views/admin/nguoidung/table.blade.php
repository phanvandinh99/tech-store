<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="sortable {{ request('sort_by') == 'id' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="id" 
                    style="width: 8%;">
                    ID
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th class="sortable {{ request('sort_by') == 'ten' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="ten"
                    style="width: 25%;">
                    Tên
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th class="sortable {{ request('sort_by') == 'email' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="email"
                    style="width: 30%;">
                    Email
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th style="width: 15%;">SĐT</th>
                <th class="sortable {{ request('sort_by') == 'created_at' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="created_at" 
                    style="width: 18%;">
                    Ngày đăng ký
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th style="width: 14%;" class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->ten }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <small class="text-muted">{{ $user->sdt ?? 'N/A' }}</small>
                </td>
                <td>
                    <small class="text-muted">
                        {{ $user->created_at->format('d/m/Y H:i') }}
                    </small>
                </td>
                <td>
                    <div class="action-buttons justify-content-center">
                        <a href="{{ route('admin.nguoidung.show', $user) }}" 
                           class="btn btn-sm btn-primary btn-icon-sm" 
                           title="Xem">
                            <i class="bi bi-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Không tìm thấy người dùng nào</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

