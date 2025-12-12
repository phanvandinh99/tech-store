<?php

namespace Database\Seeders;

use App\Models\DanhMuc;
use Illuminate\Database\Seeder;

class DanhMucSeeder extends Seeder
{
    public function run(): void
    {
        $danhMucs = [
            ['ten' => 'Dien thoai'],
            ['ten' => 'May tinh xach tay'],
            ['ten' => 'May tinh bang'],
            ['ten' => 'Phu kien'],
        ];

        foreach ($danhMucs as $danhMuc) {
            DanhMuc::updateOrCreate(
                ['ten' => $danhMuc['ten']],
                $danhMuc
            );
        }
    }
}

