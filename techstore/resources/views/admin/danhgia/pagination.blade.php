<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div class="text-muted small">
        Hiển thị {{ $danhGias->firstItem() ?? 0 }} - {{ $danhGias->lastItem() ?? 0 }} 
        trong tổng số {{ $danhGias->total() }} đánh giá
    </div>
    {{ $danhGias->links() }}
</div>

