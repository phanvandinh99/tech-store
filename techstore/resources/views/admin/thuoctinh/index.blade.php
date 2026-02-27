@extends('admin.layout')

@section('title', 'Quản lý Thuộc tính')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Quản lý Thuộc tính</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.thuoctinh.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Thêm thuộc tính mới
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên thuộc tính</th>
                            <th>Số giá trị</th>
                            <th>Giá trị</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($thuocTinhs as $thuocTinh)
                        <tr>
                            <td>{{ $thuocTinh->id }}</td>
                            <td><strong>{{ $thuocTinh->ten }}</strong></td>
                            <td>
                                <span class="badge bg-info">{{ $thuocTinh->gia_tri_thuoc_tinhs_count }} giá trị</span>
                            </td>
                            <td>
                                @foreach($thuocTinh->giaTriThuocTinhs->take(5) as $giaTri)
                                    <span class="badge bg-secondary me-1">{{ $giaTri->giatri }}</span>
                                @endforeach
                                @if($thuocTinh->giaTriThuocTinhs->count() > 5)
                                    <span class="badge bg-light text-dark">+{{ $thuocTinh->giaTriThuocTinhs->count() - 5 }}</span>
                                @endif
                            </td>
                            <td>{{ $thuocTinh->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.thuoctinh.edit', $thuocTinh->id) }}" 
                                   class="btn btn-sm btn-warning" title="Sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.thuoctinh.destroy', $thuocTinh->id) }}" 
                                      method="POST" class="d-inline" 
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa thuộc tính này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="text-muted mt-2">Chưa có thuộc tính nào</p>
                                <a href="{{ route('admin.thuoctinh.create') }}" class="btn btn-primary">
                                    Thêm thuộc tính đầu tiên
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($thuocTinhs->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $thuocTinhs->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
