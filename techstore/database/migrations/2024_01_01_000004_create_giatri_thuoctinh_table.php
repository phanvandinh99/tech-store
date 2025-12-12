<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('giatri_thuoctinh', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thuoctinh_id')->constrained('thuoctinh')->onDelete('cascade');
            $table->string('giatri', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['thuoctinh_id', 'giatri'], 'unique_giatri');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('giatri_thuoctinh');
    }
};

