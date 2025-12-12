@if($donHangs->hasPages() || $donHangs->total() > 0)
<div class="pagination-container">
    <div class="pagination-info">
        Hiển thị <strong>{{ $donHangs->firstItem() ?? 0 }}</strong> - <strong>{{ $donHangs->lastItem() ?? 0 }}</strong> 
        trong tổng số <strong>{{ $donHangs->total() }}</strong> đơn hàng
    </div>
    <div>
        {{ $donHangs->appends(request()->query())->links() }}
    </div>
</div>
@endif

