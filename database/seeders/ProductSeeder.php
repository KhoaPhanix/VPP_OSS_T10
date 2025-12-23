<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $butVietCategory = Category::where('slug', 'but-viet')->first();
        $giayToCategory = Category::where('slug', 'giay-to')->first();
        $soTayCategory = Category::where('slug', 'so-tay')->first();
        $dungCuCategory = Category::where('slug', 'dung-cu-hoc-tap')->first();

        $thienLong = Supplier::where('name', 'Thiên Long')->first();
        $bic = Supplier::where('name', 'Bic')->first();
        $paper = Supplier::where('name', 'Paper.vn')->first();

        $products = [
            // Bút viết
            [
                'code' => 'BV001',
                'name' => 'Bút bi Thiên Long TL-079',
                'description' => 'Bút bi nước cao cấp, mực đen, viết trơn',
                'unit' => 'Cây',
                'price' => 5000,
                'stock_quantity' => 500,
                'category_id' => $butVietCategory->id,
                'supplier_id' => $thienLong->id,
                'is_featured' => true,
            ],
            [
                'code' => 'BV002',
                'name' => 'Bút bi Bic Cristal',
                'description' => 'Bút bi đầu tròn 1.0mm, mực xanh',
                'unit' => 'Cây',
                'price' => 3500,
                'stock_quantity' => 800,
                'category_id' => $butVietCategory->id,
                'supplier_id' => $bic->id,
                'is_featured' => true,
            ],
            [
                'code' => 'BV003',
                'name' => 'Bút chì 2B Thiên Long',
                'description' => 'Bút chì gỗ cao cấp, độ đậm 2B',
                'unit' => 'Cây',
                'price' => 2000,
                'stock_quantity' => 1000,
                'category_id' => $butVietCategory->id,
                'supplier_id' => $thienLong->id,
            ],
            // Giấy tờ
            [
                'code' => 'GT001',
                'name' => 'Giấy A4 Paper.One 70gsm',
                'description' => 'Giấy in A4 trắng, 500 tờ/ream',
                'unit' => 'Ream',
                'price' => 75000,
                'stock_quantity' => 200,
                'category_id' => $giayToCategory->id,
                'supplier_id' => $paper->id,
                'is_featured' => true,
            ],
            [
                'code' => 'GT002',
                'name' => 'Giấy note vàng 3x3',
                'description' => 'Giấy note màu vàng 76x76mm',
                'unit' => 'Xấp',
                'price' => 15000,
                'stock_quantity' => 300,
                'category_id' => $giayToCategory->id,
                'supplier_id' => $paper->id,
            ],
            // Sổ tay
            [
                'code' => 'ST001',
                'name' => 'Sổ tay bìa da A5',
                'description' => 'Sổ tay bìa da sang trọng, 200 trang',
                'unit' => 'Quyển',
                'price' => 85000,
                'stock_quantity' => 150,
                'category_id' => $soTayCategory->id,
                'supplier_id' => $thienLong->id,
                'is_featured' => true,
            ],
            [
                'code' => 'ST002',
                'name' => 'Sổ lò xo A4 200 trang',
                'description' => 'Sổ lò xo gáy đôi, giấy trắng',
                'unit' => 'Quyển',
                'price' => 35000,
                'stock_quantity' => 250,
                'category_id' => $soTayCategory->id,
                'supplier_id' => $thienLong->id,
            ],
            // Dụng cụ học tập
            [
                'code' => 'DC001',
                'name' => 'Thước kẻ nhựa 30cm',
                'description' => 'Thước kẻ trong suốt, vạch chia mm',
                'unit' => 'Cái',
                'price' => 8000,
                'stock_quantity' => 400,
                'category_id' => $dungCuCategory->id,
                'supplier_id' => $thienLong->id,
            ],
            [
                'code' => 'DC002',
                'name' => 'Tẩy trắng Thiên Long E-044',
                'description' => 'Tẩy không bụi, không làm rách giấy',
                'unit' => 'Cái',
                'price' => 4000,
                'stock_quantity' => 600,
                'category_id' => $dungCuCategory->id,
                'supplier_id' => $thienLong->id,
                'is_featured' => true,
            ],
            [
                'code' => 'DC003',
                'name' => 'Gọt bút chì kim loại',
                'description' => 'Gọt bút chì 2 lỗ, có hộp chứa phoi',
                'unit' => 'Cái',
                'price' => 12000,
                'stock_quantity' => 350,
                'category_id' => $dungCuCategory->id,
                'supplier_id' => $thienLong->id,
            ],
        ];

        foreach ($products as $product) {
            $product['slug'] = Str::slug($product['name']);
            Product::create($product);
        }
    }
}
