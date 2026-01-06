# 📚 TÀI LIỆU CHI TIẾT DỰ ÁN VPP_OSS_T10

## 📖 TỔNG QUAN DỰ ÁN

**VPP_OSS_T10** là hệ thống website thương mại điện tử chuyên cung cấp các sản phẩm văn phòng phẩm trực tuyến. Dự án được xây dựng bằng Laravel 9.52.21, sử dụng TailwindCSS cho giao diện và MySQL cho cơ sở dữ liệu.

### Thông tin nhóm phát triển
- **Nhóm:** T10
- **Thành viên:**
  1. Nguyễn Đình Nhật Huy - 110122223
  2. Hồ Hoàng Long - 110122107
  3. Phan Đăng Khoa - 110122227

### Công nghệ sử dụng
- **Backend:** Laravel 9.52.21 (PHP >= 8.0)
- **Frontend:** TailwindCSS 3.4, Alpine.js 3.13, Blade Templates
- **Database:** MySQL
- **Build Tool:** Vite 5.4
- **Authentication:** Laravel built-in Auth

---

## 🗂️ CẤU TRÚC THỦ MỤC VÀ FILE CHI TIẾT

### 📁 `app/` - Thư mục ứng dụng chính

Chứa toàn bộ logic nghiệp vụ của ứng dụng.

#### 📁 `app/Console/`
- **`Kernel.php`**: Định nghĩa các lệnh Artisan và lập lịch tác vụ (cron jobs)
- **Xử lý:** Quản lý các command line và scheduled tasks

#### 📁 `app/Exceptions/`
- **`Handler.php`**: Xử lý tất cả exceptions và errors trong ứng dụng
- **Xử lý:** Báo lỗi, logging, custom error responses

#### 📁 `app/Http/` - Xử lý HTTP requests

##### 📁 `app/Http/Controllers/` - Controllers chính

**Controllers cho khách hàng (Customer):**

1. **`HomeController.php`**
   - **Xử lý:** Trang chủ website
   - **Chức năng:** Hiển thị sản phẩm nổi bật, categories, banner
   - **Routes:** `GET /` (home)
   - **Views:** `resources/views/home.blade.php`

2. **`ProductController.php`**
   - **Xử lý:** Quản lý hiển thị sản phẩm cho khách hàng
   - **Chức năng:** 
     - Danh sách sản phẩm với lọc theo category, tìm kiếm
     - Chi tiết sản phẩm
     - Sản phẩm liên quan
   - **Routes:** 
     - `GET /products` - Danh sách sản phẩm
     - `GET /products/{slug}` - Chi tiết sản phẩm
   - **Views:** `resources/views/products/`

3. **`CartController.php`**
   - **Xử lý:** Quản lý giỏ hàng
   - **Chức năng:**
     - Thêm sản phẩm vào giỏ
     - Cập nhật số lượng
     - Xóa sản phẩm khỏi giỏ
     - Xóa toàn bộ giỏ hàng
   - **Routes:**
     - `GET /cart` - Xem giỏ hàng
     - `POST /cart/add/{product}` - Thêm vào giỏ
     - `PUT /cart/update/{cart}` - Cập nhật số lượng
     - `DELETE /cart/remove/{cart}` - Xóa sản phẩm
     - `DELETE /cart/clear` - Xóa toàn bộ giỏ
   - **Views:** `resources/views/cart/`
   - **Model:** `Cart.php`

4. **`CheckoutController.php`**
   - **Xử lý:** Thanh toán đơn hàng
   - **Chức năng:**
     - Hiển thị trang thanh toán
     - Xử lý thông tin giao hàng
     - Tạo đơn hàng mới
     - Xác nhận thanh toán
   - **Routes:**
     - `GET /checkout` - Trang thanh toán
     - `POST /checkout` - Xử lý thanh toán
     - `GET /checkout/success/{order}` - Thành công
   - **Views:** `resources/views/checkout/`
   - **Model:** `Order.php`, `OrderDetail.php`, `Cart.php`

5. **`OrderController.php`**
   - **Xử lý:** Quản lý đơn hàng của khách
   - **Chức năng:**
     - Lịch sử đơn hàng
     - Chi tiết đơn hàng
     - Đặt lại đơn hàng (reorder)
   - **Routes:**
     - `GET /orders` - Danh sách đơn hàng
     - `GET /orders/{order}` - Chi tiết đơn hàng
     - `POST /orders/{order}/reorder` - Đặt lại
   - **Views:** `resources/views/orders/`
   - **Model:** `Order.php`, `OrderDetail.php`

6. **`ChatController.php`**
   - **Xử lý:** Hệ thống chat với admin
   - **Chức năng:**
     - Gửi tin nhắn cho admin
     - Nhận tin nhắn từ admin
     - Real-time messaging
   - **Routes:**
     - `GET /chat` - Danh sách chat
     - `GET /chat/{user}` - Cuộc hội thoại
     - `POST /chat/{user}/send` - Gửi tin nhắn
     - `GET /chat/{user}/messages` - Lấy tin nhắn
   - **Views:** `resources/views/chat/`
   - **Model:** `Chat.php`

##### 📁 `app/Http/Controllers/Auth/`

**`AuthController.php`**
- **Xử lý:** Xác thực người dùng
- **Chức năng:**
  - Đăng ký tài khoản mới
  - Đăng nhập
  - Đăng xuất
  - Validation thông tin
- **Routes:**
  - `GET /register` - Form đăng ký
  - `POST /register` - Xử lý đăng ký
  - `GET /login` - Form đăng nhập
  - `POST /login` - Xử lý đăng nhập
  - `POST /logout` - Đăng xuất
- **Views:** `resources/views/auth/`
- **Model:** `User.php`

##### 📁 `app/Http/Controllers/Admin/` - Controllers Admin

**1. `DashboardController.php`**
- **Xử lý:** Dashboard quản trị
- **Chức năng:**
  - Tổng quan doanh thu
  - Thống kê đơn hàng
  - Sản phẩm bán chạy
  - Biểu đồ doanh thu theo thời gian
- **Routes:** `GET /admin/dashboard`
- **Views:** `resources/views/admin/dashboard.blade.php`
- **Giao diện:** Dashboard với charts, thống kê, số liệu real-time

**2. `ProductManagementController.php`**
- **Xử lý:** Quản lý sản phẩm
- **Chức năng:**
  - CRUD sản phẩm (Create, Read, Update, Delete)
  - Upload hình ảnh sản phẩm
  - Quản lý tồn kho
  - Cập nhật giá, mô tả
  - Kích hoạt/vô hiệu hóa sản phẩm
- **Routes:**
  - `GET /admin/products` - Danh sách sản phẩm
  - `GET /admin/products/create` - Form thêm mới
  - `POST /admin/products` - Lưu sản phẩm mới
  - `GET /admin/products/{product}/edit` - Form chỉnh sửa
  - `PUT /admin/products/{product}` - Cập nhật sản phẩm
  - `DELETE /admin/products/{product}` - Xóa sản phẩm
  - `POST /admin/products/{product}/stock` - Cập nhật tồn kho
- **Views:** `resources/views/admin/products/`
- **Model:** `Product.php`, `Category.php`, `Supplier.php`, `StockMovement.php`
- **Giao diện:** DataTable với search, filter, pagination, modal form

**3. `CategoryManagementController.php`**
- **Xử lý:** Quản lý danh mục sản phẩm
- **Chức năng:**
  - CRUD danh mục
  - Quản lý cấu trúc danh mục
  - Kích hoạt/vô hiệu hóa danh mục
- **Routes:**
  - `GET /admin/categories` - Danh sách danh mục
  - `GET /admin/categories/create` - Form thêm danh mục
  - `POST /admin/categories` - Lưu danh mục
  - `GET /admin/categories/{category}/edit` - Form chỉnh sửa
  - `PUT /admin/categories/{category}` - Cập nhật
  - `DELETE /admin/categories/{category}` - Xóa
- **Views:** `resources/views/admin/categories/`
- **Model:** `Category.php`
- **Giao diện:** Bảng danh sách với các nút thao tác nhanh

**4. `OrderManagementController.php`**
- **Xử lý:** Quản lý đơn hàng
- **Chức năng:**
  - Xem danh sách đơn hàng
  - Chi tiết đơn hàng
  - Duyệt đơn hàng (approve)
  - Từ chối đơn hàng (reject)
  - Hoàn thành đơn hàng (complete)
  - Theo dõi trạng thái đơn
- **Routes:**
  - `GET /admin/orders` - Danh sách đơn hàng
  - `GET /admin/orders/{order}` - Chi tiết đơn hàng
  - `POST /admin/orders/{order}/approve` - Duyệt đơn
  - `POST /admin/orders/{order}/reject` - Từ chối
  - `POST /admin/orders/{order}/complete` - Hoàn thành
- **Views:** `resources/views/admin/orders/`
- **Model:** `Order.php`, `OrderDetail.php`, `User.php`
- **Giao diện:** Danh sách với status badges, timeline tracking

**5. `ReportController.php`**
- **Xử lý:** Báo cáo và thống kê
- **Chức năng:**
  - Báo cáo doanh thu theo thời gian
  - Phân tích hành vi khách hàng
  - Top sản phẩm bán chạy
  - Xuất báo cáo (PDF/Excel)
- **Routes:**
  - `GET /admin/reports/revenue` - Báo cáo doanh thu
  - `GET /admin/reports/behavior` - Phân tích hành vi
  - `GET /admin/reports/top-products` - Sản phẩm bán chạy
- **Views:** `resources/views/admin/reports/`
- **Model:** `Order.php`, `Product.php`, `User.php`
- **Giao diện:** Charts, graphs, export buttons, date pickers

##### 📁 `app/Http/Middleware/`

Middleware xử lý các request trước khi đến controller:

- **`AdminMiddleware.php`**: Kiểm tra quyền admin, chặn user thường
- **`Authenticate.php`**: Xác thực đăng nhập
- **`EncryptCookies.php`**: Mã hóa cookies
- **`RedirectIfAuthenticated.php`**: Chuyển hướng nếu đã đăng nhập
- **`TrimStrings.php`**: Trim khoảng trắng input
- **`PreventRequestsDuringMaintenance.php`**: Chặn request khi bảo trì

#### 📁 `app/Models/` - Models (Database Entities)

**1. `User.php`**
- **Mục đích:** Quản lý người dùng
- **Thuộc tính:** name, email, password, role (admin/customer), phone, address
- **Quan hệ:** 
  - hasMany: Orders, Carts, Chats
- **Xử lý:** Authentication, authorization

**2. `Product.php`**
- **Mục đích:** Quản lý sản phẩm văn phòng phẩm
- **Thuộc tính:** code, name, slug, description, unit, price, stock_quantity, image, images, category_id, supplier_id, is_active, is_featured
- **Quan hệ:**
  - belongsTo: Category, Supplier
  - hasMany: OrderDetails, Carts, StockMovements
- **Xử lý:** CRUD, stock management, pricing

**3. `Category.php`**
- **Mục đích:** Phân loại sản phẩm
- **Thuộc tính:** name, slug, description, is_active
- **Quan hệ:**
  - hasMany: Products
- **Xử lý:** Danh mục sản phẩm

**4. `Supplier.php`**
- **Mục đích:** Quản lý nhà cung cấp
- **Thuộc tính:** name, contact_person, email, phone, address
- **Quan hệ:**
  - hasMany: Products
- **Xử lý:** Thông tin nhà cung cấp

**5. `Order.php`**
- **Mục đích:** Quản lý đơn hàng
- **Thuộc tính:** order_number, user_id, total_amount, status, shipping_address, payment_method, notes
- **Trạng thái:** pending, approved, rejected, completed
- **Quan hệ:**
  - belongsTo: User
  - hasMany: OrderDetails
- **Xử lý:** Quy trình đặt hàng, thanh toán

**6. `OrderDetail.php`**
- **Mục đích:** Chi tiết sản phẩm trong đơn hàng
- **Thuộc tính:** order_id, product_id, quantity, unit_price, subtotal
- **Quan hệ:**
  - belongsTo: Order, Product
- **Xử lý:** Line items của đơn hàng

**7. `Cart.php`**
- **Mục đích:** Giỏ hàng tạm thời
- **Thuộc tính:** user_id, product_id, quantity
- **Quan hệ:**
  - belongsTo: User, Product
- **Xử lý:** Shopping cart logic

**8. `Chat.php`**
- **Mục đích:** Tin nhắn giữa khách và admin
- **Thuộc tính:** sender_id, receiver_id, message, is_read
- **Quan hệ:**
  - belongsTo: User (sender, receiver)
- **Xử lý:** Messaging system

**9. `StockMovement.php`**
- **Mục đích:** Theo dõi biến động tồn kho
- **Thuộc tính:** product_id, type (in/out), quantity, reference_type, reference_id, notes
- **Quan hệ:**
  - belongsTo: Product
- **Xử lý:** Inventory tracking

#### 📁 `app/Providers/`

- **`AppServiceProvider.php`**: Đăng ký services, bindings
- **`RouteServiceProvider.php`**: Cấu hình routing, rate limiting

---

### 📁 `config/` - Cấu hình ứng dụng

- **`app.php`**: Cấu hình chung (name, env, timezone, locale)
- **`auth.php`**: Cấu hình authentication (guards, providers)
- **`database.php`**: Kết nối database (MySQL config)
- **`filesystems.php`**: Cấu hình storage (local, public, s3)
- **`session.php`**: Cấu hình session (driver, lifetime)
- **`cache.php`**: Cấu hình cache
- **`queue.php`**: Cấu hình queue
- **`logging.php`**: Cấu hình logging
- **`view.php`**: Cấu hình views

---

### 📁 `database/` - Database

#### 📁 `database/migrations/` - Database Schema

**Các migration files (theo thứ tự):**

1. **`2024_01_01_000001_create_users_table.php`**
   - Tạo bảng users: id, name, email, password, role, phone, address
   - Vai trò: customer, admin

2. **`2024_01_01_000002_create_categories_table.php`**
   - Tạo bảng categories: id, name, slug, description, is_active

3. **`2024_01_01_000003_create_suppliers_table.php`**
   - Tạo bảng suppliers: id, name, contact_person, email, phone, address

4. **`2024_01_01_000004_create_products_table.php`**
   - Tạo bảng products: id, code, name, slug, description, unit, price, stock_quantity, image, images, category_id, supplier_id, is_active, is_featured

5. **`2024_01_01_000005_create_orders_table.php`**
   - Tạo bảng orders: id, order_number, user_id, total_amount, status, shipping_address, notes

6. **`2024_01_01_000006_create_order_details_table.php`**
   - Tạo bảng order_details: id, order_id, product_id, quantity, unit_price, subtotal

7. **`2024_01_01_000007_create_carts_table.php`**
   - Tạo bảng carts: id, user_id, product_id, quantity

8. **`2024_01_01_000008_create_chats_table.php`**
   - Tạo bảng chats: id, sender_id, receiver_id, message, is_read

9. **`2024_01_01_000009_create_stock_movements_table.php`**
   - Tạo bảng stock_movements: id, product_id, type, quantity, notes

10. **`2024_01_01_000010_add_payment_method_to_orders_table.php`**
    - Thêm cột payment_method vào orders

11. **`2024_01_01_000011_add_reference_to_stock_movements_table.php`**
    - Thêm reference_type, reference_id vào stock_movements

#### 📁 `database/seeders/` - Dữ liệu mẫu

- **`DatabaseSeeder.php`**: Main seeder, gọi các seeder khác
- **`UserSeeder.php`**: Tạo users mẫu (admin, customers)
- **`CategorySeeder.php`**: Tạo categories (Bút viết, Giấy, Văn phòng phẩm...)
- **`SupplierSeeder.php`**: Tạo suppliers mẫu
- **`ProductSeeder.php`**: Tạo products mẫu với đầy đủ thông tin

---

### 📁 `resources/` - Frontend Resources

#### 📁 `resources/views/` - Blade Templates

**Cấu trúc views:**

##### 📁 `resources/views/layouts/`
- **`app.blade.php`**: Layout chính cho customer
- **`admin.blade.php`**: Layout cho admin panel
- **`navigation.blade.php`**: Header navigation
- **`footer.blade.php`**: Footer

**Giao diện:** Responsive, Tailwind CSS, Alpine.js for interactivity

##### 📁 `resources/views/auth/`
- **`login.blade.php`**: Form đăng nhập
- **`register.blade.php`**: Form đăng ký

**Giao diện:** Clean form với validation messages, centered card layout

##### `resources/views/home.blade.php`
- **Mục đích:** Trang chủ website
- **Giao diện:**
  - Hero banner/slider
  - Sản phẩm nổi bật (featured products)
  - Categories grid
  - Sản phẩm mới nhất
  - Khuyến mãi

##### 📁 `resources/views/products/`
- **`index.blade.php`**: Danh sách sản phẩm với filters
- **`show.blade.php`**: Chi tiết sản phẩm

**Giao diện:**
- Grid layout responsive (3-4 columns)
- Product cards với image, name, price
- Sidebar filters (category, price range)
- Search bar
- Chi tiết: Image gallery, description, add to cart button

##### 📁 `resources/views/cart/`
- **`index.blade.php`**: Trang giỏ hàng

**Giao diện:**
- Table/list of cart items
- Quantity controls (+/-)
- Remove button
- Total price calculation
- Checkout button

##### 📁 `resources/views/checkout/`
- **`index.blade.php`**: Trang thanh toán
- **`success.blade.php`**: Thanh toán thành công

**Giao diện:**
- Multi-step form hoặc single page
- Shipping info form
- Order summary
- Payment method selection
- Success page với order details

##### 📁 `resources/views/orders/`
- **`index.blade.php`**: Lịch sử đơn hàng
- **`show.blade.php`**: Chi tiết đơn hàng

**Giao diện:**
- Order list với status badges
- Timeline tracking
- Order items table
- Reorder button

##### 📁 `resources/views/chat/`
- **`index.blade.php`**: Danh sách chat
- **`show.blade.php`**: Conversation window

**Giao diện:**
- Chat interface (similar to messaging apps)
- Message bubbles (left/right)
- Send message form
- Real-time updates

##### 📁 `resources/views/admin/`
- **`dashboard.blade.php`**: Admin dashboard
- **`products/`**: CRUD views cho sản phẩm
  - `index.blade.php`: DataTable
  - `create.blade.php`: Form thêm
  - `edit.blade.php`: Form sửa
- **`categories/`**: CRUD views cho danh mục
  - `index.blade.php`
  - `create.blade.php`
  - `edit.blade.php`
- **`orders/`**: Quản lý đơn hàng
  - `index.blade.php`: Order management table
  - `show.blade.php`: Order details với actions
- **`reports/`**: Báo cáo
  - `revenue.blade.php`: Charts, graphs
  - `behavior.blade.php`: Analytics
  - `top-products.blade.php`: Best sellers

**Giao diện Admin:**
- Sidebar navigation
- Top header with user menu
- DataTables với search, sort, pagination
- Modal forms
- Cards với statistics
- Charts (ChartJS hoặc ApexCharts)
- Action buttons (Edit, Delete, View)
- Status badges
- Responsive tables

#### 📁 `resources/css/`
- **`app.css`**: Main stylesheet, import Tailwind

#### 📁 `resources/js/`
- **`app.js`**: Main JavaScript file
- **`bootstrap.js`**: Bootstrap Axios, Echo

---

### 📁 `routes/` - Routing

#### `routes/web.php`
**Tổ chức routes:**

1. **Public Routes** (không cần đăng nhập):
   - `/` - Trang chủ
   - `/products` - Danh sách sản phẩm
   - `/products/{slug}` - Chi tiết sản phẩm
   - `/login`, `/register` - Auth

2. **Customer Routes** (middleware: auth):
   - `/cart/*` - Giỏ hàng
   - `/checkout/*` - Thanh toán
   - `/orders/*` - Đơn hàng
   - `/chat/*` - Chat

3. **Admin Routes** (middleware: auth, admin):
   - `/admin/dashboard` - Dashboard
   - `/admin/products/*` - Quản lý sản phẩm
   - `/admin/categories/*` - Quản lý danh mục
   - `/admin/orders/*` - Quản lý đơn hàng
   - `/admin/reports/*` - Báo cáo

#### `routes/api.php`
- API routes (nếu có REST API)

#### `routes/console.php`
- Console commands

---

### 📁 `public/` - Tài nguyên công khai

- **`index.php`**: Entry point của ứng dụng
- **`images/products/`**: Hình ảnh sản phẩm upload
- Các file build (CSS, JS) từ Vite

---

### 📁 `storage/` - Lưu trữ

- **`framework/cache/`**: Cache files
- **`framework/sessions/`**: Session files
- **`framework/views/`**: Compiled Blade views
- **`logs/`**: Log files (laravel.log)

---

## 📄 CÁC FILE QUAN TRỌNG Ở THƯ MỤC GỐC

### `composer.json`
- **Mục đích:** Quản lý PHP dependencies
- **Chứa:** Laravel framework, Guzzle, Sanctum, dev dependencies
- **Xử lý:** `composer install` để cài đặt packages

### `package.json`
- **Mục đích:** Quản lý JavaScript dependencies
- **Chứa:** TailwindCSS, Alpine.js, Vite, Axios
- **Xử lý:** `npm install` để cài đặt packages
- **Scripts:**
  - `npm run dev` - Development server
  - `npm run build` - Production build

### `vite.config.js`
- **Mục đích:** Cấu hình Vite build tool
- **Xử lý:** Build CSS, JS, hot reload

### `tailwind.config.js`
- **Mục đích:** Cấu hình TailwindCSS
- **Xử lý:** Customization, plugins, theme

### `postcss.config.js`
- **Mục đích:** Cấu hình PostCSS
- **Xử lý:** Process CSS với Tailwind, Autoprefixer

### `artisan`
- **Mục đích:** CLI tool của Laravel
- **Xử lý:** 
  - `php artisan serve` - Chạy dev server
  - `php artisan migrate` - Chạy migrations
  - `php artisan db:seed` - Seed database
  - `php artisan make:*` - Generate code

### `.env.example`
- **Mục đích:** Template cho file cấu hình môi trường
- **Chứa:** Database config, app settings, mail settings

### `docker-compose.yml` & `Dockerfile`
- **Mục đích:** Docker containerization
- **Xử lý:** Deploy ứng dụng trong Docker

### `vpp_oss_t10.sql`
- **Mục đích:** Database dump/backup
- **Xử lý:** Import vào MySQL để có database hoàn chỉnh

### `README.md`
- **Mục đích:** Hướng dẫn cài đặt và sử dụng
- **Chứa:** Setup instructions, requirements

### `SETUP.md`
- **Mục đích:** Chi tiết cài đặt từng bước
- **Chứa:** Detailed installation guide

### `WORKFLOW.md`
- **Mục đích:** Quy trình làm việc của nhóm
- **Chứa:** Git workflow, development process

---

## 🔄 LUỒNG XỬ LÝ CHÍNH

### 1. Quy trình đặt hàng
```
User -> Browse Products (ProductController) 
     -> Add to Cart (CartController) 
     -> View Cart (CartController)
     -> Checkout (CheckoutController)
     -> Create Order (OrderController)
     -> Admin Approve (OrderManagementController)
     -> Complete Order
```

### 2. Quy trình quản lý sản phẩm
```
Admin Login -> Dashboard (DashboardController)
            -> Products (ProductManagementController)
            -> Create/Update Product
            -> Stock Movement (StockMovement Model)
```

### 3. Quy trình báo cáo
```
Admin -> Reports (ReportController)
      -> Revenue Analysis
      -> Behavior Analysis
      -> Top Products
      -> Export Data
```

---

## 🎨 THIẾT KẾ GIAO DIỆN

### Customer Interface
- **Layout:** Clean, modern, responsive
- **Colors:** Professional (theo Tailwind theme)
- **Components:**
  - Navigation bar với search
  - Product cards với hover effects
  - Shopping cart icon với counter
  - Footer với links
  - Breadcrumbs
  - Alert messages

### Admin Interface
- **Layout:** Sidebar + main content
- **Components:**
  - Sidebar navigation menu
  - Dashboard cards với statistics
  - DataTables với advanced features
  - Modal dialogs
  - Form validation
  - Charts and graphs
  - Status badges
  - Action buttons

### Technologies cho UI
- **Styling:** TailwindCSS utility classes
- **Interactivity:** Alpine.js for lightweight reactivity
- **Icons:** Heroicons hoặc FontAwesome
- **Forms:** TailwindCSS Forms plugin
- **Typography:** TailwindCSS Typography plugin

---

## 🗄️ DATABASE SCHEMA

### Bảng chính và mối quan hệ:

```
users (1) ---> (N) orders
users (1) ---> (N) carts
users (1) ---> (N) chats (as sender)
users (1) ---> (N) chats (as receiver)

categories (1) ---> (N) products
suppliers (1) ---> (N) products

products (1) ---> (N) order_details
products (1) ---> (N) carts
products (1) ---> (N) stock_movements

orders (1) ---> (N) order_details
```

---

## 🔐 AUTHENTICATION & AUTHORIZATION

### Roles
- **Customer:** Xem sản phẩm, mua hàng, chat
- **Admin:** Full access, quản lý toàn bộ hệ thống

### Middleware
- `auth`: Yêu cầu đăng nhập
- `admin`: Yêu cầu role admin
- `guest`: Chỉ cho user chưa đăng nhập

---

## 📊 FEATURES CHÍNH

### Khách hàng
✅ Đăng ký/Đăng nhập
✅ Xem danh sách sản phẩm
✅ Tìm kiếm, lọc sản phẩm
✅ Thêm vào giỏ hàng
✅ Thanh toán đơn hàng
✅ Theo dõi đơn hàng
✅ Chat với admin
✅ Xem lịch sử mua hàng

### Admin
✅ Dashboard thống kê
✅ Quản lý sản phẩm (CRUD)
✅ Quản lý danh mục
✅ Quản lý đơn hàng (duyệt, từ chối, hoàn thành)
✅ Quản lý tồn kho
✅ Báo cáo doanh thu
✅ Phân tích khách hàng
✅ Báo cáo sản phẩm bán chạy

---

## 🚀 CÀI ĐẶT VÀ CHẠY DỰ ÁN

### Yêu cầu hệ thống
- PHP >= 8.0
- Composer >= 2.0
- MySQL >= 5.7
- Node.js >= 16.x

### Các bước cài đặt

```bash
# 1. Clone repository
git clone <repo-url>
cd VPP_OSS_T10

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Copy .env file
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Configure database trong .env
DB_DATABASE=vpp_oss_t10
DB_USERNAME=root
DB_PASSWORD=

# 7. Run migrations
php artisan migrate

# 8. Seed database
php artisan db:seed

# 9. Build assets
npm run dev

# 10. Start server
php artisan serve
```

Truy cập: http://localhost:8000

---

## 📝 GHI CHÚ QUAN TRỌNG

1. **Storage Link:** Chạy `php artisan storage:link` để link storage với public
2. **Permissions:** Đảm bảo storage/ và bootstrap/cache/ có quyền write
3. **Image Upload:** Hình ảnh sản phẩm lưu tại `public/images/products/`
4. **Default Admin:** Tạo bởi UserSeeder (kiểm tra trong seeder)
5. **Stock Management:** Tự động cập nhật khi có đơn hàng hoặc nhập kho

---

## 🔧 TROUBLESHOOTING

**Lỗi thường gặp:**
- **500 Error:** Kiểm tra file permissions, .env config
- **Database Connection:** Verify database credentials trong .env
- **Assets not loading:** Chạy `npm run build`
- **Class not found:** Chạy `composer dump-autoload`

---

**Tài liệu này cung cấp cái nhìn tổng quan và chi tiết về toàn bộ dự án VPP_OSS_T10.**

_Last updated: January 2026_
