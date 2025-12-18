<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div class="text-muted small">
        Hiển thị {{ $yeuCaus->firstItem() ?? 0 }} - {{ $yeuCaus->lastItem() ?? 0 }} 
        trong tổng số {{ $yeuCaus->total() }} yêu cầu
    </div>
    {{ $yeuCaus->links() }}
</div>

