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
            [
                'name' => 'Bút viết', 
                'description' => 'Các loại bút bi, bút mực, bút chì...',
                'image' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=600&h=600&fit=crop'
            ],
            [
                'name' => 'Giấy tờ', 
                'description' => 'Giấy in, giấy photo, giấy note...',
                'image' => 'https://images.unsplash.com/photo-1544256718-3bcf237f3974?w=600&h=600&fit=crop'
            ],
            [
                'name' => 'Sổ tay', 
                'description' => 'Sổ tay, sổ ghi chú, sổ bìa da...',
                'image' => 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?w=600&h=600&fit=crop'
            ],
            [
                'name' => 'Dụng cụ học tập', 
                'description' => 'Thước kẻ, compa, tẩy, gọt bút chì...',
                'image' => 'https://images.unsplash.com/photo-1612538498456-e861df91d4d0?w=600&h=600&fit=crop'
            ],
            [
                'name' => 'Thiết bị văn phòng', 
                'description' => 'Máy tính, bàn phím, chuột, máy in...',
                'image' => 'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=600&h=600&fit=crop'
            ],
            [
                'name' => 'Kẹp & Bấm', 
                'description' => 'Kẹp giấy, bấm ghim, kim bấm...',
                'image' => 'https://images.unsplash.com/photo-1611537568047-33592b7e8098?w=600&h=600&fit=crop'
            ],
            [
                'name' => 'File & Folder', 
                'description' => 'Bìa đựng tài liệu, file tài liệu...',
                'image' => 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=600&h=600&fit=crop'
            ],
            [
                'name' => 'Băng keo & Keo dán', 
                'description' => 'Băng keo trong, keo dán giấy...',
                'image' => 'https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=600&h=600&fit=crop'
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'image' => $category['image'],
                'is_active' => true,
            ]);
        }
    }
}
