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
                'description' => 'Bút bi nước cao cấp, mực đen, viết trơn mượt. Thân bút trong suốt, độ bền cao',
                'unit' => 'Cây',
                'price' => 5000,
                'stock_quantity' => 500,
                'category_id' => $butVietCategory->id,
                'supplier_id' => $thienLong->id,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'BV002',
                'name' => 'Bút bi Bic Cristal',
                'description' => 'Bút bi đầu tròn 1.0mm, mực xanh. Thiết kế cổ điển, viết êm tay',
                'unit' => 'Cây',
                'price' => 3500,
                'stock_quantity' => 800,
                'category_id' => $butVietCategory->id,
                'supplier_id' => $bic->id,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1565282564265-83d07f83ad2c?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'BV003',
                'name' => 'Bút chì 2B Thiên Long',
                'description' => 'Bút chì gỗ cao cấp, độ đậm 2B. Ruột chì không gẫy, dễ tẩy xóa',
                'unit' => 'Cây',
                'price' => 2000,
                'stock_quantity' => 1000,
                'category_id' => $butVietCategory->id,
                'supplier_id' => $thienLong->id,
                'image' => 'https://images.unsplash.com/photo-1603354350317-6f7aaa5911c5?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'BV004',
                'name' => 'Bút gel Thiên Long GEL-08',
                'description' => 'Bút gel mực nước cao cấp 0.5mm, màu đen. Mực không lem, khô nhanh',
                'unit' => 'Cây',
                'price' => 7000,
                'stock_quantity' => 450,
                'category_id' => $butVietCategory->id,
                'supplier_id' => $thienLong->id,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1588166524941-3bf9f8b09a8a?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'BV005',
                'name' => 'Bút lông dầu Artline 700',
                'description' => 'Bút lông dầu màu đen, không phai. Thích hợp viết trên nhiều bề mặt',
                'unit' => 'Cây',
                'price' => 15000,
                'stock_quantity' => 200,
                'category_id' => $butVietCategory->id,
                'supplier_id' => $thienLong->id,
                'image' => 'https://images.unsplash.com/photo-1511548774318-563182fe8d03?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'BV006',
                'name' => 'Bút dạ quang Stabilo Boss',
                'description' => 'Bút highlight màu vàng neon, không thấm qua giấy. Đầu bút dẹt tiện lợi',
                'unit' => 'Cây',
                'price' => 25000,
                'stock_quantity' => 300,
                'category_id' => $butVietCategory->id,
                'supplier_id' => $bic->id,
                'image' => 'https://images.unsplash.com/photo-1594834818808-ba3b7d9e96c9?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'BV007',
                'name' => 'Bút máy Thiên Long Lửa Thiêng',
                'description' => 'Bút máy cao cấp,촉 inox bền đẹp. Thiết kế sang trọng, viết êm',
                'unit' => 'Cây',
                'price' => 120000,
                'stock_quantity' => 80,
                'category_id' => $butVietCategory->id,
                'supplier_id' => $thienLong->id,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1565266339552-88f4b0f99654?w=400&h=400&fit=crop',
            ],
            
            // Giấy tờ
            [
                'code' => 'GT001',
                'name' => 'Giấy A4 Paper.One 70gsm',
                'description' => 'Giấy in A4 trắng, 500 tờ/ream. Độ trắng cao, thích hợp in văn bản',
                'unit' => 'Ream',
                'price' => 75000,
                'stock_quantity' => 200,
                'category_id' => $giayToCategory->id,
                'supplier_id' => $paper->id,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1544256718-3bcf237f3974?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'GT002',
                'name' => 'Giấy note vàng 3x3',
                'description' => 'Giấy note dán màu vàng 76x76mm. Keo dán không để lại vết, 100 tờ/xấp',
                'unit' => 'Xấp',
                'price' => 15000,
                'stock_quantity' => 300,
                'category_id' => $giayToCategory->id,
                'supplier_id' => $paper->id,
                'image' => 'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'GT003',
                'name' => 'Giấy A4 màu IK Plus',
                'description' => 'Giấy màu A4 đa sắc, 100 tờ/ream. Thích hợp in tờ rơi, thiệp',
                'unit' => 'Ream',
                'price' => 95000,
                'stock_quantity' => 150,
                'category_id' => $giayToCategory->id,
                'supplier_id' => $paper->id,
                'image' => 'https://images.unsplash.com/photo-1612538498456-e861df91d4d0?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'GT004',
                'name' => 'Giấy bìa A4 cứng 250gsm',
                'description' => 'Giấy bìa cứng màu trắng A4, 100 tờ. Dùng làm bìa tài liệu, danh thiếp',
                'unit' => 'Tập',
                'price' => 120000,
                'stock_quantity' => 100,
                'category_id' => $giayToCategory->id,
                'supplier_id' => $paper->id,
                'image' => 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'GT005',
                'name' => 'Giấy photo A3',
                'description' => 'Giấy photocopy A3 80gsm, 500 tờ/ream. Trắng mịn, thích hợp in ấn',
                'unit' => 'Ream',
                'price' => 135000,
                'stock_quantity' => 120,
                'category_id' => $giayToCategory->id,
                'supplier_id' => $paper->id,
                'image' => 'https://images.unsplash.com/photo-1602140022939-e0c5ad9f1471?w=400&h=400&fit=crop',
            ],
            
            // Sổ tay
            [
                'code' => 'ST001',
                'name' => 'Sổ tay bìa da A5',
                'description' => 'Sổ tay bìa da sang trọng, 200 trang giấy kem. Có dây đánh dấu trang',
                'unit' => 'Quyển',
                'price' => 85000,
                'stock_quantity' => 150,
                'category_id' => $soTayCategory->id,
                'supplier_id' => $thienLong->id,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'ST002',
                'name' => 'Sổ lò xo A4 200 trang',
                'description' => 'Sổ lò xo gáy đôi, giấy trắng kẻ ngang. Bìa cứng màu đen sang trọng',
                'unit' => 'Quyển',
                'price' => 35000,
                'stock_quantity' => 250,
                'category_id' => $soTayCategory->id,
                'supplier_id' => $thienLong->id,
                'image' => 'https://images.unsplash.com/photo-1517842645767-c639042777db?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'ST003',
                'name' => 'Sổ tay Moleskine Classic',
                'description' => 'Sổ tay Moleskine bìa cứng A5, 240 trang. Giấy không lem, chất lượng cao',
                'unit' => 'Quyển',
                'price' => 250000,
                'stock_quantity' => 60,
                'category_id' => $soTayCategory->id,
                'supplier_id' => $paper->id,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'ST004',
                'name' => 'Planner 2026 kế hoạch năm',
                'description' => 'Sổ lập kế hoạch 2026, có lịch tháng và tuần. Bìa cứng chống nước',
                'unit' => 'Quyển',
                'price' => 95000,
                'stock_quantity' => 180,
                'category_id' => $soTayCategory->id,
                'supplier_id' => $thienLong->id,
                'image' => 'https://images.unsplash.com/photo-1611224885990-ab7363d1f2a8?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'ST005',
                'name' => 'Sổ vẽ Sketch A4',
                'description' => 'Sổ vẽ chuyên dụng A4, giấy dày 180gsm. 50 trang, thích hợp vẽ màu nước',
                'unit' => 'Quyển',
                'price' => 65000,
                'stock_quantity' => 100,
                'category_id' => $soTayCategory->id,
                'supplier_id' => $paper->id,
                'image' => 'https://images.unsplash.com/photo-1579762593131-b7a2e76d98d5?w=400&h=400&fit=crop',
            ],
            
            // Dụng cụ học tập
            [
                'code' => 'DC001',
                'name' => 'Thước kẻ nhựa 30cm',
                'description' => 'Thước kẻ trong suốt, vạch chia mm chính xác. Không cong vênh',
                'unit' => 'Cái',
                'price' => 8000,
                'stock_quantity' => 400,
                'category_id' => $dungCuCategory->id,
                'supplier_id' => $thienLong->id,
                'image' => 'https://images.unsplash.com/photo-1612892483236-52d32a0e0ac1?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'DC002',
                'name' => 'Tẩy trắng Thiên Long E-044',
                'description' => 'Tẩy không bụi, không làm rách giấy. Tẩy sạch mực chì và bút bi',
                'unit' => 'Cái',
                'price' => 4000,
                'stock_quantity' => 600,
                'category_id' => $dungCuCategory->id,
                'supplier_id' => $thienLong->id,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'DC003',
                'name' => 'Gọt bút chì kim loại',
                'description' => 'Gọt bút chì 2 lỗ, có hộp chứa phoi. Lưỡi dao sắc bén, bền',
                'unit' => 'Cái',
                'price' => 12000,
                'stock_quantity' => 350,
                'category_id' => $dungCuCategory->id,
                'supplier_id' => $thienLong->id,
                'image' => 'https://images.unsplash.com/photo-1581450214665-0b0b37ce6b6c?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'DC004',
                'name' => 'Bộ compa học sinh',
                'description' => 'Bộ compa kim loại 4 món: compa, thước đo góc, thước kẻ, bút chì',
                'unit' => 'Bộ',
                'price' => 45000,
                'stock_quantity' => 180,
                'category_id' => $dungCuCategory->id,
                'supplier_id' => $thienLong->id,
                'image' => 'https://images.unsplash.com/photo-1572461405471-8a5f73ecc5bd?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'DC005',
                'name' => 'Bấm kim số 10',
                'description' => 'Bấm ghim số 10 cỡ nhỏ, dễ cầm nắm. Bấm được 20 tờ giấy',
                'unit' => 'Cái',
                'price' => 18000,
                'stock_quantity' => 220,
                'category_id' => $dungCuCategory->id,
                'supplier_id' => $thienLong->id,
                'image' => 'https://images.unsplash.com/photo-1611537568047-33592b7e8098?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'DC006',
                'name' => 'Hộp bút nhựa trong suốt',
                'description' => 'Hộp đựng bút trong suốt có nắp đậy. Đựng được 20-30 cây bút',
                'unit' => 'Cái',
                'price' => 22000,
                'stock_quantity' => 280,
                'category_id' => $dungCuCategory->id,
                'supplier_id' => $thienLong->id,
                'image' => 'https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=400&h=400&fit=crop',
            ],
            [
                'code' => 'DC007',
                'name' => 'Kéo cắt văn phòng 21cm',
                'description' => 'Kéo inox cán nhựa ABS, lưỡi sắc bén. Cắt được giấy dày và vải',
                'unit' => 'Cái',
                'price' => 35000,
                'stock_quantity' => 160,
                'category_id' => $dungCuCategory->id,
                'supplier_id' => $thienLong->id,
                'image' => 'https://images.unsplash.com/photo-1587467512961-120760940315?w=400&h=400&fit=crop',
            ],
        ];

        foreach ($products as $product) {
            $product['slug'] = Str::slug($product['name']);
            Product::create($product);
        }
    }
}
