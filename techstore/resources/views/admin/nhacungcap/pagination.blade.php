@if($nhaCungCaps->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted">
        Hiển thị {{ $nhaCungCaps->firstItem() }} - {{ $nhaCungCaps->lastItem() }} trong tổng số {{ $nhaCungCaps->total() }} nhà cung cấp
    </div>
    <div>
        {{ $nhaCungCaps->links() }}
    </div>
</div>
@endif

