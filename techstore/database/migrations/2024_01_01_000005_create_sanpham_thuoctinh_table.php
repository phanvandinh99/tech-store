<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sanpham_thuoctinh', function (Blueprint $table) {
            $table->foreignId('sanpham_id')->constrained('sanpham')->onDelete('cascade');
            $table->foreignId('thuoctinh_id')->constrained('thuoctinh')->onDelete('cascade');
            $table->primary(['sanpham_id', 'thuoctinh_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanpham_thuoctinh');
    }
};

