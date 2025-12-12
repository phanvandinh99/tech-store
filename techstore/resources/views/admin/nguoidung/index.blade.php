@extends('admin.layout')

@section('title', 'Quản lý Người dùng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Quản lý Người dùng</h2>
    <form method="GET" action="{{ route('admin.nguoidung.index') }}" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i>
        </button>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Ngày đăng ký</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->ten }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->sdt ?? 'N/A' }}</td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.nguoidung.show', $user) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Xem
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Không tìm thấy người dùng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

