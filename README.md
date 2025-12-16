# VPP_OSS_T10 - Hệ thống Bán Văn phòng phẩm Online

Dự án xây dựng hệ thống website thương mại điện tử chuyên cung cấp các sản phẩm văn phòng phẩm, nhằm hỗ trợ người dùng mua sắm tiện lợi và giúp quản trị viên quản lý quy trình bán hàng hiệu quả.

## 🛠️ Công nghệ sử dụng

- **Framework:** Laravel 10.x
- **PHP:** >= 8.1
- **Database:** MySQL
- **Frontend:** Bootstrap 5.3, Blade Templates
- **Authentication:** Laravel Sanctum

## 👥 Thành viên nhóm phát triển

| STT | Họ và tên | Mã số sinh viên |
| :--- | :--- | :--- |
| 1 | Nguyễn Đình Nhật Huy | 110122223 |
| 2 | Hồ Hoàng Long | 110122107 |
| 3 | Phan Đăng Khoa | 110122227 |

---

## 📋 Yêu cầu hệ thống

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM (optional, cho asset compilation)

---

## 🚀 Hướng dẫn cài đặt

### 1. Clone repository

```bash
git clone https://github.com/KhoaPhanix/VPP_OSS_T10.git
cd VPP_OSS_T10
```

### 2. Cài đặt dependencies

```bash
composer install
```

### 3. Cấu hình môi trường

```bash
# Copy file .env.example thành .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Cấu hình database

Mở file `.env` và chỉnh sửa thông tin database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vpp_oss_t10
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Tạo database và chạy migration

```bash
# Tạo database trong MySQL
mysql -u root -p
CREATE DATABASE vpp_oss_t10;
exit;

# Chạy migration
php artisan migrate

# Seed dữ liệu mẫu
php artisan db:seed
```

### 6. Tạo symbolic link cho storage

```bash
php artisan storage:link
```

### 7. Chạy development server

```bash
php artisan serve
```

Truy cập: `http://localhost:8000`

---

## 📦 Cấu trúc Database

### Các bảng chính:

1. **users** - Quản lý thành viên & admin
2. **categories** - Danh mục sản phẩm
3. **suppliers** - Nhà cung cấp
4. **products** - Sản phẩm
5. **carts** - Giỏ hàng
6. **orders** - Đơn hàng
7. **order_details** - Chi tiết đơn hàng
8. **chats** - Tin nhắn chat
9. **stock_movements** - Lịch sử xuất nhập kho

---

## 🔑 Tài khoản mặc định

Sau khi seed dữ liệu, bạn có thể đăng nhập với:

### Admin:
- **Username:** `admin`
- **Password:** `admin123`

### Khách hàng:
- **Username:** `khachhang1`
- **Password:** `password`

---

## 📁 Cấu trúc thư mục

```
VPP_OSS_T10/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── AuthController.php
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ProductManagementController.php
│   │   │   │   ├── CategoryManagementController.php
│   │   │   │   ├── OrderManagementController.php
│   │   │   │   └── ReportController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProductController.php
│   │   │   ├── CartController.php
│   │   │   ├── OrderController.php
│   │   │   └── ChatController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       ├── Supplier.php
│       ├── Product.php
│       ├── Cart.php
│       ├── Order.php
│       ├── OrderDetail.php
│       ├── Chat.php
│       └── StockMovement.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── home.blade.php
│       └── ...
├── routes/
│   ├── web.php
│   └── api.php
├── .env.example
├── composer.json
├── README.md
└── WORKFLOW.md
```

---

## 🚀 Tổng quan hệ thống

Hệ thống phục vụ hai đối tượng chính:
1.  **Khách hàng (Thành viên):** Người dùng đã đăng ký và xác nhận thành viên, có thể mua hàng trực tuyến.
2.  **Quản trị viên (Admin):** Người vận hành, chịu trách nhiệm duyệt đơn hàng, quản lý kho và xem báo cáo.

---

## ✨ Tính năng chính

### 1. Quản lý Sản phẩm & Danh mục
* **Phân loại sản phẩm:** Quản lý theo nhóm (Bút viết, Giấy tờ, Sổ tay, Dụng cụ học tập, Thiết bị văn phòng...) để dễ dàng tra cứu và thống kê.
* **Thông tin chi tiết:** Mỗi sản phẩm bao gồm mã định danh, tên, mô tả, đơn vị tính, hình ảnh, giá bán, số lượng tồn kho và nhà cung cấp.
* **Quản lý kho:** Admin có quyền thêm mới sản phẩm/loại sản phẩm và cập nhật số lượng tồn kho khi có hàng nhập.

### 2. Quản lý Thành viên
* **Lưu trữ thông tin:** Tên đăng nhập, mật khẩu, họ tên, giới tính, ngày sinh, địa chỉ, số điện thoại và hình đại diện.
* **Bảo mật:** Yêu cầu đăng nhập để thực hiện mua hàng nhằm cá nhân hóa và bảo mật.

### 3. Quy trình Đặt hàng (Order Flow)
Hệ thống tuân thủ quy trình xử lý đơn hàng chặt chẽ:
1.  **Giỏ hàng:** Thành viên chọn sản phẩm, thêm/bớt hoặc chỉnh sửa số lượng trước khi gửi.
2.  **Gửi đơn hàng:** Sau khi thành viên gửi yêu cầu, đơn hàng được chuyển đến Admin.
    * *Lưu ý:* Tại bước này, khách hàng **không được phép hủy hoặc chỉnh sửa** để tránh xung đột dữ liệu.
3.  **Duyệt đơn:** Admin xem xét đơn hàng:
    * **Duyệt:** Đơn hàng hợp lệ, tiến hành giao hàng.
    * **Từ chối:** Phải cung cấp lý do cụ thể cho khách hàng.
4.  **Chính sách sau duyệt:** Khách hàng không được hủy/trả hàng sau khi đơn đã duyệt (trừ trường hợp hàng lỗi/hỏng hóc theo chính sách đổi trả).

### 4. Hệ thống Giao tiếp (Chat)
* Hỗ trợ tính năng chat trực tuyến[cite: 28].
* Cho phép thành viên trao đổi với nhau hoặc liên hệ Admin để nhận tư vấn, hỗ trợ kỹ thuật.

### 5. Thống kê & Báo cáo
Admin có thể theo dõi hiệu quả kinh doanh qua các chỉ số:
* **Doanh thu:** Báo cáo theo tuần, tháng, quý.
* **Phân tích hành vi:** Thời gian bán hàng cao điểm theo giờ trong ngày.
* **Sản phẩm nổi bật:** Danh sách 5 sản phẩm bán chạy nhất trong tuần.

---

## 📝 Ghi chú phát triển (Dành cho Dev)
* **Quy tắc dữ liệu:** Đảm bảo tính nhất quán của dữ liệu kho khi Admin cập nhật số lượng.
* **Validation:** Chặn các thao tác sửa/hủy đơn hàng từ phía Client sau khi trạng thái đơn chuyển sang "Chờ duyệt".
* **Logic duyệt đơn:** Bắt buộc nhập trường "Lý do" nếu Admin chọn từ chối đơn hàng.

