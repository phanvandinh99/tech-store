@if($users->hasPages() || $users->total() > 0)
<div class="pagination-container">
    <div class="pagination-info">
        Hiển thị <strong>{{ $users->firstItem() ?? 0 }}</strong> - <strong>{{ $users->lastItem() ?? 0 }}</strong> 
        trong tổng số <strong>{{ $users->total() }}</strong> người dùng
    </div>
    <div>
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endif

