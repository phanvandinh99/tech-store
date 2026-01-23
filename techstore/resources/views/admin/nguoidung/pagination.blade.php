@if($nguoiDungs->hasPages())
<div class="d-flex justify-content-between align-items-center">
    <div class="text-muted">
        Hiển thị {{ $nguoiDungs->firstItem() }} - {{ $nguoiDungs->lastItem() }} 
        trong tổng số {{ $nguoiDungs->total() }} người dùng
    </div>
    
    <nav>
        {{ $nguoiDungs->appends(request()->query())->links('pagination::bootstrap-4') }}
    </nav>
</div>
@endif