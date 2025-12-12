@extends('admin.layout')

@section('title', 'Chi tiết Đơn hàng')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.donhang.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin đơn hàng #{{ $donHang->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Khách hàng:</strong> {{ $donHang->ten_khach }}
                    </div>
                    <div class="col-md-6">
                        <strong>SĐT:</strong> {{ $donHang->sdt_khach }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Email:</strong> {{ $donHang->email_khach ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Trạng thái:</strong>
                        <span class="badge bg-{{ $donHang->trang_thai === 'hoan_thanh' ? 'success' : ($donHang->trang_thai === 'da_huy' ? 'danger' : 'warning') }}">
                            {{ ucfirst(str_replace('_', ' ', $donHang->trang_thai)) }}
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Địa chỉ giao hàng:</strong><br>
                    {{ $donHang->dia_chi_khach }}
                </div>
                <div class="mb-3">
                    <strong>Ngày tạo:</strong> {{ $donHang->created_at->format('d/m/Y H:i') }}
                </div>

                <hr>
                <h6>Danh sách sản phẩm</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>SKU</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donHang->chiTietDonHangs as $ct)
                            <tr>
                                <td>{{ $ct->sanPham->ten }}</td>
                                <td>{{ $ct->bienThe->sku }}</td>
                                <td>{{ $ct->so_luong }}</td>
                                <td>{{ number_format($ct->gia_luc_mua) }} đ</td>
                                <td>{{ number_format($ct->gia_luc_mua * $ct->so_luong) }} đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Tổng tiền:</th>
                                <th>{{ number_format($donHang->tong_tien) }} đ</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cập nhật trạng thái</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.donhang.updateStatus', $donHang) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="trang_thai" class="form-label">Trạng thái</label>
                        <select class="form-select" id="trang_thai" name="trang_thai" required>
                            <option value="cho_xac_nhan" {{ $donHang->trang_thai == 'cho_xac_nhan' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="da_xac_nhan" {{ $donHang->trang_thai == 'da_xac_nhan' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="dang_giao" {{ $donHang->trang_thai == 'dang_giao' ? 'selected' : '' }}>Đang giao</option>
                            <option value="hoan_thanh" {{ $donHang->trang_thai == 'hoan_thanh' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="da_huy" {{ $donHang->trang_thai == 'da_huy' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle"></i> Cập nhật
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

