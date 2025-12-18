@extends('admin.layout')

@section('title', 'Sửa mã giảm giá')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-ticket-perforated"></i> Sửa mã giảm giá: {{ $maGiamGia->ma_voucher }}
    </div>
    <div class="card-body">
        <form action="{{ route('admin.magiamgia.update', $maGiamGia->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Mã voucher <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ma_voucher') is-invalid @enderror" 
                            name="ma_voucher" value="{{ old('ma_voucher', $maGiamGia->ma_voucher) }}" required 
                            style="text-transform: uppercase;">
                        @error('ma_voucher')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tên mã giảm giá <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten') is-invalid @enderror" 
                            name="ten" value="{{ old('ten', $maGiamGia->ten) }}" required>
                        @error('ten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Loại giảm giá <span class="text-danger">*</span></label>
                        <select class="form-select @error('loai_giam_gia') is-invalid @enderror" name="loai_giam_gia" required>
                            <option value="percent" {{ old('loai_giam_gia', $maGiamGia->loai_giam_gia) == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                            <option value="fixed" {{ old('loai_giam_gia', $maGiamGia->loai_giam_gia) == 'fixed' ? 'selected' : '' }}>Số tiền cố định (VNĐ)</option>
                        </select>
                        @error('loai_giam_gia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá trị giảm <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('gia_tri_giam') is-invalid @enderror" 
                            name="gia_tri_giam" value="{{ old('gia_tri_giam', $maGiamGia->gia_tri_giam) }}" required min="0">
                        @error('gia_tri_giam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select class="form-select @error('trang_thai') is-invalid @enderror" name="trang_thai" required>
                            <option value="active" {{ old('trang_thai', $maGiamGia->trang_thai) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="inactive" {{ old('trang_thai', $maGiamGia->trang_thai) == 'inactive' ? 'selected' : '' }}>Tạm dừng</option>
                            <option value="expired" {{ old('trang_thai', $maGiamGia->trang_thai) == 'expired' ? 'selected' : '' }}>Hết hạn</option>
                        </select>
                        @error('trang_thai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Đơn tối thiểu</label>
                        <input type="number" class="form-control @error('don_toi_thieu') is-invalid @enderror" 
                            name="don_toi_thieu" value="{{ old('don_toi_thieu', $maGiamGia->don_toi_thieu) }}" min="0">
                        @error('don_toi_thieu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số lần sử dụng tối đa</label>
                        <input type="number" class="form-control @error('so_lan_su_dung_toi_da') is-invalid @enderror" 
                            name="so_lan_su_dung_toi_da" value="{{ old('so_lan_su_dung_toi_da', $maGiamGia->so_lan_su_dung_toi_da) }}" min="1">
                        <small class="text-muted">Đã sử dụng: {{ $maGiamGia->so_lan_da_su_dung }} lần</small>
                        @error('so_lan_su_dung_toi_da')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ngày bắt đầu</label>
                                <input type="datetime-local" class="form-control @error('ngay_bat_dau') is-invalid @enderror" 
                                    name="ngay_bat_dau" value="{{ old('ngay_bat_dau', $maGiamGia->ngay_bat_dau?->format('Y-m-d\TH:i')) }}">
                                @error('ngay_bat_dau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ngày kết thúc</label>
                                <input type="datetime-local" class="form-control @error('ngay_ket_thuc') is-invalid @enderror" 
                                    name="ngay_ket_thuc" value="{{ old('ngay_ket_thuc', $maGiamGia->ngay_ket_thuc?->format('Y-m-d\TH:i')) }}">
                                @error('ngay_ket_thuc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="mo_ta" rows="3">{{ old('mo_ta', $maGiamGia->mo_ta) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Cập nhật
                </button>
                <a href="{{ route('admin.magiamgia.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-lg"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

