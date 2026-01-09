# 🧪 Tài liệu Kiểm thử - VPP Online Store

## Tổng quan

Dự án sử dụng **PHPUnit** để thực hiện Unit Tests và Feature Tests cho hệ thống quản lý văn phòng phẩm.

---

## 📁 Cấu trúc Tests

```
tests/
├── TestCase.php              # Base test class
├── CreatesApplication.php    # Application bootstrap trait
├── Unit/                     # Unit Tests
│   ├── ExampleTest.php
│   ├── ProductTest.php       # Test Model Product
│   ├── UserTest.php          # Test Model User
│   ├── OrderTest.php         # Test Model Order
│   └── CartTest.php          # Test Model Cart
└── Feature/                  # Feature Tests
    ├── ExampleTest.php
    ├── AuthenticationTest.php  # Test đăng nhập/đăng ký
    ├── ProductTest.php         # Test trang sản phẩm
    ├── CartTest.php            # Test giỏ hàng
    ├── CheckoutTest.php        # Test thanh toán
    ├── OrderTest.php           # Test đơn hàng
    └── AdminTest.php           # Test chức năng admin
```

---

## 🔧 Chạy Tests

### Chạy tất cả tests
```bash
# Trong Docker container
docker exec -it vpp_app php artisan test

# Hoặc với PHPUnit
docker exec -it vpp_app ./vendor/bin/phpunit
```

### Chạy test cụ thể
```bash
# Chạy Unit Tests
docker exec -it vpp_app php artisan test --testsuite=Unit

# Chạy Feature Tests
docker exec -it vpp_app php artisan test --testsuite=Feature

# Chạy file test cụ thể
docker exec -it vpp_app php artisan test tests/Feature/CartTest.php

# Chạy test method cụ thể
docker exec -it vpp_app php artisan test --filter=test_user_can_add_product_to_cart
```

### Chạy với coverage
```bash
docker exec -it vpp_app php artisan test --coverage
```

---

## 📋 Danh sách Test Cases

### Unit Tests

#### 1. ProductTest (9 test cases)

| # | Test Case | Mô tả |
|---|-----------|-------|
| 1 | `test_product_can_be_created` | Kiểm tra tạo sản phẩm mới |
| 2 | `test_product_belongs_to_category` | Kiểm tra quan hệ với Category |
| 3 | `test_product_belongs_to_supplier` | Kiểm tra quan hệ với Supplier |
| 4 | `test_product_has_stock_method` | Kiểm tra method hasStock() |
| 5 | `test_product_active_scope` | Kiểm tra filter sản phẩm active |
| 6 | `test_product_featured_scope` | Kiểm tra filter sản phẩm nổi bật |
| 7 | `test_product_price_is_decimal` | Kiểm tra kiểu dữ liệu price |
| 8 | `test_product_can_be_soft_deleted` | Kiểm tra soft delete |

#### 2. UserTest (7 test cases)

| # | Test Case | Mô tả |
|---|-----------|-------|
| 1 | `test_user_can_be_created` | Kiểm tra tạo user mới |
| 2 | `test_user_password_is_hashed` | Kiểm tra password được hash |
| 3 | `test_user_has_many_orders` | Kiểm tra quan hệ với Orders |
| 4 | `test_user_has_many_cart_items` | Kiểm tra quan hệ với Cart |
| 5 | `test_user_is_admin_method` | Kiểm tra method isAdmin() |
| 6 | `test_user_can_be_soft_deleted` | Kiểm tra soft delete |
| 7 | `test_user_password_is_hidden` | Kiểm tra hidden attributes |

#### 3. OrderTest (7 test cases)

| # | Test Case | Mô tả |
|---|-----------|-------|
| 1 | `test_order_can_be_created` | Kiểm tra tạo đơn hàng |
| 2 | `test_order_belongs_to_user` | Kiểm tra quan hệ với User |
| 3 | `test_order_has_many_order_details` | Kiểm tra quan hệ với OrderDetails |
| 4 | `test_order_status_methods` | Kiểm tra các method trạng thái |
| 5 | `test_order_total_amount` | Kiểm tra tổng tiền |
| 6 | `test_order_number_generation` | Kiểm tra mã đơn hàng unique |
| 7 | `test_order_filter_by_status` | Kiểm tra filter theo trạng thái |

#### 4. CartTest (7 test cases)

| # | Test Case | Mô tả |
|---|-----------|-------|
| 1 | `test_cart_item_can_be_created` | Kiểm tra thêm vào giỏ |
| 2 | `test_cart_belongs_to_user` | Kiểm tra quan hệ với User |
| 3 | `test_cart_belongs_to_product` | Kiểm tra quan hệ với Product |
| 4 | `test_cart_quantity_can_be_updated` | Kiểm tra cập nhật số lượng |
| 5 | `test_cart_item_can_be_deleted` | Kiểm tra xóa item |
| 6 | `test_get_cart_items_for_user` | Kiểm tra lấy giỏ hàng theo user |
| 7 | `test_cart_subtotal` | Kiểm tra tính subtotal |

---

### Feature Tests

#### 1. AuthenticationTest (7 test cases)

| # | Test Case | Mô tả |
|---|-----------|-------|
| 1 | `test_login_page_can_be_rendered` | Trang login hiển thị đúng |
| 2 | `test_register_page_can_be_rendered` | Trang đăng ký hiển thị đúng |
| 3 | `test_user_can_register` | User có thể đăng ký |
| 4 | `test_user_can_login_with_correct_credentials` | Đăng nhập đúng |
| 5 | `test_user_cannot_login_with_wrong_credentials` | Đăng nhập sai |
| 6 | `test_user_can_logout` | Đăng xuất thành công |
| 7 | `test_authenticated_user_cannot_access_login_page` | Redirect khi đã login |

#### 2. CartTest (9 test cases)

| # | Test Case | Mô tả |
|---|-----------|-------|
| 1 | `test_guest_cannot_access_cart` | Guest bị redirect |
| 2 | `test_user_can_view_cart` | User xem được giỏ hàng |
| 3 | `test_user_can_add_product_to_cart` | Thêm sản phẩm thành công |
| 4 | `test_adding_same_product_increases_quantity` | Cộng dồn số lượng |
| 5 | `test_cannot_add_more_than_stock` | Không thêm quá tồn kho |
| 6 | `test_user_can_update_cart_quantity` | Cập nhật số lượng |
| 7 | `test_user_can_remove_item_from_cart` | Xóa sản phẩm |
| 8 | `test_user_can_clear_cart` | Xóa toàn bộ giỏ |
| 9 | `test_cart_shows_correct_total` | Hiển thị tổng tiền đúng |

#### 3. CheckoutTest (6 test cases)

| # | Test Case | Mô tả |
|---|-----------|-------|
| 1 | `test_guest_cannot_access_checkout` | Guest bị redirect |
| 2 | `test_user_with_empty_cart_cannot_checkout` | Giỏ trống không checkout |
| 3 | `test_user_can_view_checkout_page` | Xem trang checkout |
| 4 | `test_user_can_place_order` | Đặt hàng thành công |
| 5 | `test_checkout_reduces_stock` | Trừ tồn kho sau đặt hàng |
| 6 | `test_cannot_checkout_with_insufficient_stock` | Không đặt khi hết hàng |

#### 4. OrderTest (7 test cases)

| # | Test Case | Mô tả |
|---|-----------|-------|
| 1 | `test_guest_cannot_view_orders` | Guest bị redirect |
| 2 | `test_user_can_view_orders_list` | Xem danh sách đơn hàng |
| 3 | `test_user_can_view_order_detail` | Xem chi tiết đơn hàng |
| 4 | `test_user_cannot_view_other_user_order` | Không xem đơn user khác |
| 5 | `test_user_can_reorder_completed_order` | Mua lại thành công |
| 6 | `test_user_cannot_reorder_pending_order` | Không mua lại đơn pending |
| 7 | `test_order_shows_correct_status` | Hiển thị trạng thái đúng |

#### 5. AdminTest (12 test cases)

| # | Test Case | Mô tả |
|---|-----------|-------|
| 1 | `test_guest_cannot_access_admin_dashboard` | Guest bị redirect |
| 2 | `test_customer_cannot_access_admin_dashboard` | Customer bị 403 |
| 3 | `test_admin_can_access_dashboard` | Admin truy cập được |
| 4 | `test_admin_can_view_products_list` | Admin xem sản phẩm |
| 5 | `test_admin_can_create_product` | Admin tạo sản phẩm |
| 6 | `test_admin_can_update_product` | Admin sửa sản phẩm |
| 7 | `test_admin_can_delete_product` | Admin xóa sản phẩm |
| 8 | `test_admin_can_view_orders` | Admin xem đơn hàng |
| 9 | `test_admin_can_approve_order` | Admin duyệt đơn |
| 10 | `test_admin_can_reject_order` | Admin từ chối đơn |
| 11 | `test_admin_can_complete_order` | Admin hoàn thành đơn |
| 12 | `test_admin_can_view_revenue_report` | Admin xem báo cáo |

#### 6. ProductTest (9 test cases)

| # | Test Case | Mô tả |
|---|-----------|-------|
| 1 | `test_home_page_can_be_rendered` | Trang chủ hiển thị |
| 2 | `test_products_page_can_be_rendered` | Trang sản phẩm hiển thị |
| 3 | `test_products_are_displayed` | Sản phẩm được hiển thị |
| 4 | `test_product_detail_page_can_be_rendered` | Chi tiết sản phẩm |
| 5 | `test_can_filter_products_by_category` | Lọc theo danh mục |
| 6 | `test_can_search_products` | Tìm kiếm sản phẩm |
| 7 | `test_inactive_products_are_not_shown` | Ẩn sản phẩm inactive |
| 8 | `test_featured_products_on_home_page` | Sản phẩm nổi bật |
| 9 | `test_404_for_non_existent_product` | 404 khi không tìm thấy |

---

## 📊 Tổng kết Test Cases

| Loại | Số lượng Tests | Mô tả |
|------|----------------|-------|
| **Unit Tests** | 30 | Kiểm tra logic Models |
| **Feature Tests** | 50 | Kiểm tra chức năng HTTP |
| **Tổng cộng** | **80** | |

---

## 🎯 Test Coverage mục tiêu

| Module | Target Coverage |
|--------|-----------------|
| Models | 90%+ |
| Controllers | 80%+ |
| Middleware | 85%+ |
| Services | 85%+ |

---

## 📝 Viết Test mới

### Template Unit Test

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\YourModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class YourModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Mô tả test case
     */
    public function test_your_test_case(): void
    {
        // Arrange - Chuẩn bị dữ liệu
        $model = YourModel::factory()->create([
            'field' => 'value',
        ]);

        // Act - Thực hiện hành động
        $result = $model->yourMethod();

        // Assert - Kiểm tra kết quả
        $this->assertEquals('expected', $result);
    }
}
```

### Template Feature Test

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class YourFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Mô tả test case
     */
    public function test_your_feature(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/your-route');

        $response->assertStatus(200);
        $response->assertSee('Expected Text');
    }
}
```

---

## 🔄 CI/CD Integration

### GitHub Actions

```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: root
          MYSQL_DATABASE: testing
        ports:
          - 3306:3306
    
    steps:
      - uses: actions/checkout@v4
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.2
          extensions: pdo, pdo_mysql
          
      - name: Install Dependencies
        run: composer install --prefer-dist --no-progress
        
      - name: Run Tests
        run: php artisan test
```

---

## ✅ Best Practices

1. **Sử dụng RefreshDatabase** - Reset database sau mỗi test
2. **Dùng Factories** - Tạo dữ liệu test dễ dàng
3. **Test độc lập** - Mỗi test không phụ thuộc test khác
4. **Đặt tên rõ ràng** - `test_user_can_add_product_to_cart`
5. **AAA Pattern** - Arrange, Act, Assert
6. **Test cả happy path và edge cases**
