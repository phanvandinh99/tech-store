<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Dữ liệu đã được tạo sẵn trong Database/tech_store_db.sql
        // Chạy seeder để tạo dữ liệu đánh giá mẫu
        $this->call([
            DanhGiaSeeder::class,
        ]);
    }
}
