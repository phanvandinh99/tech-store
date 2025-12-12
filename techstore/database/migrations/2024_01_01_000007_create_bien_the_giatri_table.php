<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bien_the_giatri', function (Blueprint $table) {
            $table->foreignId('bien_the_id')->constrained('bien_the')->onDelete('cascade');
            $table->foreignId('giatri_thuoctinh_id')->constrained('giatri_thuoctinh')->onDelete('cascade');
            $table->primary(['bien_the_id', 'giatri_thuoctinh_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bien_the_giatri');
    }
};

