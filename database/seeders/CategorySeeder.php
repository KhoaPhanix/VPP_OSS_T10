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
                'image' => 'images/products/butviet.jpg'
            ],
            [
                'name' => 'Giấy tờ', 
                'description' => 'Giấy in, giấy photo, giấy note...',
                'image' => 'images/products/giayto.jpg'
            ],
            [
                'name' => 'Sổ tay', 
                'description' => 'Sổ tay, sổ ghi chú, sổ bìa da...',
                'image' => 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?w=600&h=600&fit=crop'
            ],
            [
                'name' => 'Dụng cụ học tập', 
                'description' => 'Thước kẻ, compa, tẩy, gọt bút chì...',
                'image' => 'images/products/dungcuhoctap.jpg'
            ],
            [
                'name' => 'Thiết bị văn phòng', 
                'description' => 'Máy tính, bàn phím, chuột, máy in...',
                'image' => 'images/products/thietbivanphong.jpg'
            ],
            [
                'name' => 'Kẹp & Bấm', 
                'description' => 'Kẹp giấy, bấm ghim, kim bấm...',
                'image' => 'images/products/kepbam.jpg'
            ],
            [
                'name' => 'File & Folder', 
                'description' => 'Bìa đựng tài liệu, file tài liệu...',
                'image' => 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=600&h=600&fit=crop'
            ],
            [
                'name' => 'Băng keo & Keo dán', 
                'description' => 'Băng keo trong, keo dán giấy...',
                'image' => 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=600&h=600&fit=crop'
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
