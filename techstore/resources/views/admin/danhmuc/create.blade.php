@extends('admin.layout')

@section('title', 'Thêm Danh mục')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Thêm Danh mục mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.danhmuc.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten') is-invalid @enderror" 
                               id="ten" name="ten" value="{{ old('ten') }}" required>
                        @error('ten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.danhmuc.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

