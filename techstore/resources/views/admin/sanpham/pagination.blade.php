@if($sanPhams->hasPages() || $sanPhams->total() > 0)
<div class="pagination-container">
    <div class="pagination-info">
        Hiển thị <strong>{{ $sanPhams->firstItem() ?? 0 }}</strong> - <strong>{{ $sanPhams->lastItem() ?? 0 }}</strong> 
        trong tổng số <strong>{{ $sanPhams->total() }}</strong> sản phẩm
    </div>
    <div>
        {{ $sanPhams->appends(request()->query())->links() }}
    </div>
</div>
@endif

