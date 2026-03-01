<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('yeu_cau_bao_hanh', function (Blueprint $table) {
            $table->foreignId('imei_id')->nullable()->after('bien_the_id')
                  ->constrained('imei')->onDelete('set null')
                  ->comment('IMEI cụ thể đang được bảo hành');
        });
    }

    public function down(): void
    {
        Schema::table('yeu_cau_bao_hanh', function (Blueprint $table) {
            $table->dropForeign(['imei_id']);
            $table->dropColumn('imei_id');
        });
    }
};
