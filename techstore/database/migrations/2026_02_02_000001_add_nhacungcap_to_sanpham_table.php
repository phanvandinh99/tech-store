<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sanpham', function (Blueprint $table) {
            $table->bigInteger('nhacungcap_id')->unsigned()->nullable()->after('thuong_hieu_id');
            $table->foreign('nhacungcap_id')->references('id')->on('nha_cung_cap')->onDelete('set null');
            $table->index('nhacungcap_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sanpham', function (Blueprint $table) {
            $table->dropForeign(['nhacungcap_id']);
            $table->dropIndex(['nhacungcap_id']);
            $table->dropColumn('nhacungcap_id');
        });
    }
};