<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="sortable {{ request('sort_by') == 'id' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="id" 
                    style="width: 10%;">
                    ID
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th class="sortable {{ request('sort_by') == 'ten' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="ten"
                    style="width: 35%;">
                    Tên danh mục
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th class="sortable {{ request('sort_by') == 'created_at' ? 'sort-' . request('sort_order', 'desc') : '' }}" 
                    data-sort="created_at" 
                    style="width: 25%;">
                    Ngày tạo
                    <span class="sort-icon">
                        <i class="bi bi-arrow-down-up"></i>
                    </span>
                </th>
                <th style="width: 15%;" class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($danhMucs as $danhMuc)
            <tr>
                <td>{{ $danhMuc->id }}</td>
                <td>{{ $danhMuc->ten }}</td>
                <td>
                    <small class="text-muted">
                        {{ $danhMuc->created_at->format('d/m/Y H:i') }}
                    </small>
                </td>
                <td>
                    <div class="action-buttons justify-content-center">
                        <a href="{{ route('admin.danhmuc.edit', $danhMuc->id) }}" 
                           class="btn btn-sm btn-warning btn-icon-sm" 
                           title="Sửa">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.danhmuc.destroy', $danhMuc->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-danger btn-icon-sm" 
                                    title="Xóa">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Không tìm thấy danh mục nào</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
