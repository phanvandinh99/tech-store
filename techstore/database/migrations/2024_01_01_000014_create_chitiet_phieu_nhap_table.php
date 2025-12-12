<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chitiet_phieu_nhap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phieu_nhap_id')->constrained('phieu_nhap')->onDelete('cascade');
            $table->foreignId('bien_the_id')->constrained('bien_the')->onDelete('cascade');
            $table->unsignedInteger('so_luong_nhap');
            $table->decimal('gia_von_nhap', 13, 0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chitiet_phieu_nhap');
    }
};

