@extends('admin.layout')

@section('title', 'Chi tiết Người dùng')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.nguoidung.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin người dùng</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Tên:</strong> {{ $user->ten }}
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> {{ $user->email }}
                </div>
                <div class="mb-3">
                    <strong>SĐT:</strong> {{ $user->sdt ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Địa chỉ:</strong> {{ $user->dia_chi ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Ngày đăng ký:</strong> {{ $user->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Lịch sử đơn hàng</h5>
            </div>
            <div class="card-body">
                @if($user->donHangs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->donHangs as $donHang)
                                <tr>
                                    <td>#{{ $donHang->id }}</td>
                                    <td>{{ number_format($donHang->tong_tien) }} đ</td>
                                    <td>
                                        <span class="badge bg-{{ $donHang->trang_thai === 'hoan_thanh' ? 'success' : ($donHang->trang_thai === 'da_huy' ? 'danger' : 'warning') }}">
                                            {{ ucfirst(str_replace('_', ' ', $donHang->trang_thai)) }}
                                        </span>
                                    </td>
                                    <td>{{ $donHang->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Chưa có đơn hàng nào</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

