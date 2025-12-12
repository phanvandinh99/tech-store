<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nguoidung', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 100);
            $table->string('email', 150)->unique();
            $table->string('mat_khau', 255);
            $table->string('sdt', 20)->nullable();
            $table->text('dia_chi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nguoidung');
    }
};

