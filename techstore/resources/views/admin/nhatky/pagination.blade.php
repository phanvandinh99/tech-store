<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div class="text-muted small">
        Hiển thị {{ $nhatKys->firstItem() ?? 0 }} - {{ $nhatKys->lastItem() ?? 0 }} 
        trong tổng số {{ $nhatKys->total() }} hoạt động
    </div>
    {{ $nhatKys->links() }}
</div>

