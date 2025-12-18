<table class="table table-hover">
    <thead>
        <tr>
            <th width="60">ID</th>
            <th width="80">Logo</th>
            <th>Tên thương hiệu</th>
            <th>Mô tả</th>
            <th width="100">Số SP</th>
            <th width="150">Ngày tạo</th>
            <th width="120">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse($thuongHieus as $th)
        <tr>
            <td>{{ $th->id }}</td>
            <td>
                @if($th->hinh_logo)
                    <img src="{{ asset('storage/' . $th->hinh_logo) }}" alt="{{ $th->ten }}" class="img-thumbnail" style="max-width: 50px;">
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td><strong>{{ $th->ten }}</strong></td>
            <td>{{ Str::limit($th->mo_ta, 50) }}</td>
            <td><span class="badge bg-info">{{ $th->san_phams_count ?? 0 }}</span></td>
            <td>{{ $th->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-primary" 
                    onclick="openEditModal({{ $th->id }}, '{{ addslashes($th->ten) }}', '{{ addslashes($th->mo_ta) }}', '{{ $th->hinh_logo }}')">
                    <i class="bi bi-pencil"></i>
                </button>
                <form action="{{ route('admin.thuonghieu.destroy', $th->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Bạn có chắc muốn xóa thương hiệu này?')">
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
            <td colspan="7" class="text-center text-muted py-4">Không có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>

