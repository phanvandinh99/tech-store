<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phieu_nhap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nha_cung_cap_id')->nullable()->constrained('nha_cung_cap')->onDelete('set null');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phieu_nhap');
    }
};

