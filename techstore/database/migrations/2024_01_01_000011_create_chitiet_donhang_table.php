<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chitiet_donhang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donhang_id')->constrained('donhang')->onDelete('cascade');
            $table->foreignId('sanpham_id')->constrained('sanpham');
            $table->foreignId('bien_the_id')->constrained('bien_the');
            $table->unsignedInteger('so_luong');
            $table->decimal('gia_luc_mua', 13, 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chitiet_donhang');
    }
};

