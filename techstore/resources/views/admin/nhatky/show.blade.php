@extends('admin.layout')

@section('title', 'Chi tiết nhật ký')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-clock-history"></i> Chi tiết nhật ký #{{ $nhatKy->id }}
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Người thực hiện:</strong>
                        <p>{{ $nhatKy->nguoiDung->name ?? 'N/A' }} ({{ $nhatKy->nguoiDung->email ?? '' }})</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Thời gian:</strong>
                        <p>{{ $nhatKy->created_at ? $nhatKy->created_at->format('d/m/Y H:i:s') : 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Hành động:</strong>
                        <p>
                            @switch($nhatKy->hanh_dong)
                                @case('create')
                                    <span class="badge bg-success">Tạo mới</span>
                                    @break
                                @case('update')
                                    <span class="badge bg-warning">Cập nhật</span>
                                    @break
                                @case('delete')
                                    <span class="badge bg-danger">Xóa</span>
                                    @break
                            @endswitch
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Loại đối tượng:</strong>
                        <p><code>{{ $nhatKy->loai_model }}</code> (ID: {{ $nhatKy->id_model ?? 'N/A' }})</p>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Mô tả:</strong>
                    <div class="bg-light p-3 rounded mt-2">
                        {{ $nhatKy->mo_ta ?: 'Không có mô tả' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Địa chỉ IP:</strong>
                        <p><code>{{ $nhatKy->dia_chi_ip ?? 'N/A' }}</code></p>
                    </div>
                </div>

                @if($nhatKy->trinh_duyet)
                <div class="mb-3">
                    <strong>Trình duyệt:</strong>
                    <p class="small text-muted">{{ $nhatKy->trinh_duyet }}</p>
                </div>
                @endif

                @if($nhatKy->gia_tri_cu)
                <div class="mb-3">
                    <strong>Giá trị cũ:</strong>
                    <pre class="bg-light p-3 rounded mt-2" style="max-height: 300px; overflow: auto;">{{ json_encode($nhatKy->gia_tri_cu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
                @endif

                @if($nhatKy->gia_tri_moi)
                <div class="mb-3">
                    <strong>Giá trị mới:</strong>
                    <pre class="bg-light p-3 rounded mt-2" style="max-height: 300px; overflow: auto;">{{ json_encode($nhatKy->gia_tri_moi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.nhatky.index') }}" class="btn btn-secondary w-100">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
    </div>
</div>
@endsection

