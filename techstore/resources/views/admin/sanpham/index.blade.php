@extends('admin.layout')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box"></i> Quản lý Sản phẩm</h2>
    <a href="{{ route('admin.sanpham.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm sản phẩm
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Số biến thể</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sanPhams as $sanPham)
                    <tr>
                        <td>{{ $sanPham->id }}</td>
                        <td>{{ $sanPham->ten }}</td>
                        <td>{{ $sanPham->danhMuc->ten }}</td>
                        <td>{{ $sanPham->bienThes->count() }}</td>
                        <td>{{ $sanPham->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.sanpham.edit', $sanPham) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.sanpham.destroy', $sanPham) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
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
                        <td colspan="6" class="text-center">Chưa có sản phẩm nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $sanPhams->links() }}
        </div>
    </div>
</div>
@endsection

