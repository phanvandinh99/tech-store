<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imei', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bien_the_id')->constrained('bien_the')->onDelete('cascade');
            $table->string('so_imei', 20)->unique()->comment('Số IMEI/Serial Number');
            $table->enum('trang_thai', ['available', 'sold', 'warranty', 'returned'])->default('available')
                  ->comment('available: Có sẵn, sold: Đã bán, warranty: Đang bảo hành, returned: Đã trả lại');
            $table->foreignId('chitiet_donhang_id')->nullable()->constrained('chitiet_donhang')->onDelete('set null')
                  ->comment('Chi tiết đơn hàng mà IMEI này được bán');
            $table->timestamp('ngay_ban')->nullable()->comment('Ngày bán IMEI này');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
            
            $table->index(['bien_the_id', 'trang_thai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imei');
    }
};
