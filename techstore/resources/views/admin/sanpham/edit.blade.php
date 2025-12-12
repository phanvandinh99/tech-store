@extends('admin.layout')

@section('title', 'Sửa Sản phẩm')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Sửa Sản phẩm</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sanpham.update', $sanPham->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ten" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ten') is-invalid @enderror" 
                                   id="ten" name="ten" value="{{ old('ten', $sanPham->ten) }}" required>
                            @error('ten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="danhmuc_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-select @error('danhmuc_id') is-invalid @enderror" 
                                    id="danhmuc_id" name="danhmuc_id" required>
                                @foreach($danhMucs as $danhMuc)
                                    <option value="{{ $danhMuc->id }}" 
                                        {{ old('danhmuc_id', $sanPham->danhmuc_id) == $danhMuc->id ? 'selected' : '' }}>
                                        {{ $danhMuc->ten }}
                                    </option>
                                @endforeach
                            </select>
                            @error('danhmuc_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="mota" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mota') is-invalid @enderror" 
                                  id="mota" name="mota" rows="3">{{ old('mota', $sanPham->mota) }}</textarea>
                        @error('mota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.sanpham.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

