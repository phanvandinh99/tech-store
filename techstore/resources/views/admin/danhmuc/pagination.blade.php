@if($danhMucs->hasPages() || $danhMucs->total() > 0)
<div class="pagination-container">
    <div class="pagination-info">
        Hiển thị <strong>{{ $danhMucs->firstItem() ?? 0 }}</strong> - <strong>{{ $danhMucs->lastItem() ?? 0 }}</strong> 
        trong tổng số <strong>{{ $danhMucs->total() }}</strong> danh mục
    </div>
    <div>
        {{ $danhMucs->appends(request()->query())->links() }}
    </div>
</div>
@endif
