<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kiểm tra xem cột đã tồn tại chưa
        if (!Schema::hasColumn('sanpham', 'nhacungcap_id')) {
            Schema::table('sanpham', function (Blueprint $table) {
                $table->bigInteger('nhacungcap_id')->unsigned()->nullable()->after('thuong_hieu_id');
            });
        }
        
        // Kiểm tra xem foreign key đã tồn tại chưa
        $foreignKeyExists = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'sanpham' 
            AND COLUMN_NAME = 'nhacungcap_id' 
            AND CONSTRAINT_NAME LIKE '%foreign%'
            AND TABLE_SCHEMA = DATABASE()
        ");
        
        if (empty($foreignKeyExists)) {
            Schema::table('sanpham', function (Blueprint $table) {
                $table->foreign('nhacungcap_id')->references('id')->on('nha_cung_cap')->onDelete('set null');
                $table->index('nhacungcap_id');
            });
        }
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