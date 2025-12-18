<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div class="text-muted small">
        Hiển thị {{ $thuongHieus->firstItem() ?? 0 }} - {{ $thuongHieus->lastItem() ?? 0 }} 
        trong tổng số {{ $thuongHieus->total() }} thương hiệu
    </div>
    {{ $thuongHieus->links() }}
</div>

