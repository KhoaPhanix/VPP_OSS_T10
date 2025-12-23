<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Bút viết', 'description' => 'Các loại bút bi, bút mực, bút chì...'],
            ['name' => 'Giấy tờ', 'description' => 'Giấy in, giấy photo, giấy note...'],
            ['name' => 'Sổ tay', 'description' => 'Sổ tay, sổ ghi chú, sổ bìa da...'],
            ['name' => 'Dụng cụ học tập', 'description' => 'Thước kẻ, compa, tẩy, gọt bút chì...'],
            ['name' => 'Thiết bị văn phòng', 'description' => 'Máy tính, bàn phím, chuột, máy in...'],
            ['name' => 'Kẹp & Bấm', 'description' => 'Kẹp giấy, bấm ghim, kim bấm...'],
            ['name' => 'File & Folder', 'description' => 'Bìa đựng tài liệu, file tài liệu...'],
            ['name' => 'Băng keo & Keo dán', 'description' => 'Băng keo trong, keo dán giấy...'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }
    }
}
