<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donhang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoidung_id')->nullable()->constrained('nguoidung')->onDelete('set null');
            $table->string('ten_khach', 100);
            $table->string('sdt_khach', 20);
            $table->string('email_khach', 150)->nullable();
            $table->text('dia_chi_khach');
            $table->decimal('tong_tien', 13, 0);
            $table->enum('trang_thai', ['cho_xac_nhan', 'da_xac_nhan', 'dang_giao', 'hoan_thanh', 'da_huy'])->default('cho_xac_nhan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donhang');
    }
};

