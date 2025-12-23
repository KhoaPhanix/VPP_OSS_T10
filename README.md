# VPP_OSS_T10 - Hệ thống Bán Văn phòng phẩm Online

Dự án xây dựng hệ thống website thương mại điện tử chuyên cung cấp các sản phẩm văn phòng phẩm, nhằm hỗ trợ người dùng mua sắm tiện lợi và giúp quản trị viên quản lý quy trình bán hàng hiệu quả.

## 🛠️ Công nghệ sử dụng

- **Framework:** Laravel 9.52.21
- **PHP:** >= 8.0
- **Database:** MySQL
- **Frontend:** TailwindCSS 3.4, Alpine.js 3.13, Blade Templates
- **Build Tool:** Vite 5.4
- **Authentication:** Laravel built-in Auth

## 👥 Thành viên nhóm phát triển

| STT | Họ và tên | Mã số sinh viên |
| :--- | :--- | :--- |
| 1 | Nguyễn Đình Nhật Huy | 110122223 |
| 2 | Hồ Hoàng Long | 110122107 |
| 3 | Phan Đăng Khoa | 110122227 |

---

## 📋 Yêu cầu hệ thống

- PHP >= 8.0
- Composer >= 2.0
- MySQL >= 5.7 hoặc 8.0
- Node.js >= 16.x & NPM
- Git

---

## 🚀 Hướng dẫn cài đặt

### 1. Clone repository

```bash
git clone https://github.com/KhoaPhanix/VPP_OSS_T10.git
cd VPP_OSS_T10
```

### 2. Cài đặt dependencies

```bash
# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies
npm install
```

### 3. Cấu hình môi trường

```bash
# Copy file .env.example thành .env
cp .env.example .env

# Hoặc trên Windows
copy .env.example .env

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
DB_PASSWORD=
```

### 5. Tạo database và chạy migration

```bash
# Tạo database trong MySQL
mysql -u root -p
CREATE DATABASE vpp_oss_t10;
exit;

# Chạy migration
php artisan migrate

# Seed dữ liệu mẫu (bao gồm tài khoản admin và sản phẩm mẫu)
php artisan db:seed
```

### 6. Build frontend assets

```bash
# Build assets với Vite
npm run build

# Hoặc chạy dev mode với hot reload
npm run dev
```

### 7. Tạo symbolic link cho storage

```bash
php artisan storage:link
```

### 8. Chạy development server

```bash
php artisan serve
```

Truy cập: `http://127.0.0.1:8000`

---

## 👤 Tài khoản mặc định

Sau khi chạy `php artisan db:seed`, hệ thống sẽ tạo sẵn các tài khoản sau:

### Tài khoản Admin
- **Username:** admin
- **Password:** admin123
- **Truy cập:** http://127.0.0.1:8000/admin/dashboard

### Tài khoản Khách hàng
- **Username:** khachhang1
- **Password:** password
- **Truy cập:** http://127.0.0.1:8000

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

## ✨ Tính năng chính

### Dành cho Khách hàng
- ✅ Đăng ký, đăng nhập tài khoản
- ✅ Xem danh sách sản phẩm theo danh mục
- ✅ Tìm kiếm sản phẩm
- ✅ Xem chi tiết sản phẩm
- ✅ Thêm sản phẩm vào giỏ hàng
- ✅ Quản lý giỏ hàng (cập nhật số lượng, xóa)
- ✅ Đặt hàng và thanh toán
- ✅ Xem lịch sử đơn hàng
- ✅ Chat với admin

### Dành cho Admin
- ✅ Dashboard thống kê tổng quan
- ✅ Quản lý sản phẩm (thêm, sửa, xóa)
- ✅ Quản lý danh mục
- ✅ Quản lý đơn hàng (duyệt, từ chối, hoàn thành)
- ✅ Báo cáo doanh thu theo tuần/tháng/quý
- ✅ Quản lý tồn kho
- ✅ Chat với khách hàng

---

## 🛡️ Bảo mật

- SQL Injection prevention với Eloquent ORM
- CSRF Protection
- Password Hashing với bcrypt
- XSS Protection
- Middleware Authentication & Authorization

---

## 🤝 Đóng góp

1. Fork dự án
2. Tạo branch mới (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

---

## 📞 Liên hệ

- **Email:** phandangkhoawork@gmail.com
- **GitHub:** [KhoaPhanix](https://github.com/KhoaPhanix)
- **Repository:** [VPP_OSS_T10](https://github.com/KhoaPhanix/VPP_OSS_T10)

---

## 📄 License

Dự án này được phát triển cho mục đích học tập.

---

## 📸 Screenshots

### Trang chủ
Hiển thị danh sách sản phẩm với giao diện Swiss design hiện đại.

### Admin Dashboard
Thống kê tổng quan về doanh thu, đơn hàng, sản phẩm.

### Quản lý đơn hàng
Duyệt, từ chối, hoàn thành đơn hàng với giao diện trực quan.

---

**Cảm ơn bạn đã quan tâm đến dự án VPP_OSS_T10! 🚀**

* **Sản phẩm nổi bật:** Danh sách 5 sản phẩm bán chạy nhất trong tuần.

---

## 📝 Ghi chú phát triển (Dành cho Dev)
* **Quy tắc dữ liệu:** Đảm bảo tính nhất quán của dữ liệu kho khi Admin cập nhật số lượng.
* **Validation:** Chặn các thao tác sửa/hủy đơn hàng từ phía Client sau khi trạng thái đơn chuyển sang "Chờ duyệt".
* **Logic duyệt đơn:** Bắt buộc nhập trường "Lý do" nếu Admin chọn từ chối đơn hàng.

