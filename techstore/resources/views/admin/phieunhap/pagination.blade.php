@if($phieuNhaps->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted">
        Hiển thị {{ $phieuNhaps->firstItem() }} - {{ $phieuNhaps->lastItem() }} trong tổng số {{ $phieuNhaps->total() }} phiếu nhập
    </div>
    <div>
        {{ $phieuNhaps->links() }}
    </div>
</div>
@endif

