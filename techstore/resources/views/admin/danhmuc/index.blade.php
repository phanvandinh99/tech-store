@extends('admin.layout')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-folder"></i> Quản lý Danh mục</h2>
    <a href="{{ route('admin.danhmuc.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm danh mục
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($danhMucs as $danhMuc)
                    <tr>
                        <td>{{ $danhMuc->id }}</td>
                        <td>{{ $danhMuc->ten }}</td>
                        <td>{{ $danhMuc->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.danhmuc.edit', $danhMuc) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.danhmuc.destroy', $danhMuc) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Chưa có danh mục nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $danhMucs->links() }}
        </div>
    </div>
</div>
@endsection

