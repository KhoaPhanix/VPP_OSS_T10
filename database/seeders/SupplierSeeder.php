<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Thiên Long',
                'company_name' => 'Công ty Cổ phần Thiên Long',
                'email' => 'contact@thienlong.com',
                'phone' => '02838362639',
                'address' => 'TP. Hồ Chí Minh',
            ],
            [
                'name' => 'Bic',
                'company_name' => 'Công ty TNHH Bic Việt Nam',
                'email' => 'info@bic.vn',
                'phone' => '02838123456',
                'address' => 'TP. Hồ Chí Minh',
            ],
            [
                'name' => 'Paper.vn',
                'company_name' => 'Công ty TNHH Giấy Việt',
                'email' => 'sales@paper.vn',
                'phone' => '02437654321',
                'address' => 'Hà Nội',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
