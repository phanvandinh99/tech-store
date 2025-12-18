<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div class="text-muted small">
        Hiển thị {{ $maGiamGias->firstItem() ?? 0 }} - {{ $maGiamGias->lastItem() ?? 0 }} 
        trong tổng số {{ $maGiamGias->total() }} mã giảm giá
    </div>
    {{ $maGiamGias->links() }}
</div>

