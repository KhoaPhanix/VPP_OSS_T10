# 📚 API Documentation - VPP Online Store

## Tổng quan

API RESTful cho hệ thống Quản lý Văn phòng phẩm trực tuyến. Sử dụng Laravel Sanctum để xác thực.

**Base URL:** `http://localhost:8000/api/v1`

**Content-Type:** `application/json`

---

## 🔐 Authentication

### Đăng ký tài khoản

```http
POST /api/v1/register
```

**Request Body:**
```json
{
    "username": "nguyenvana",
    "email": "nguyenvana@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "full_name": "Nguyễn Văn A",
    "phone": "0901234567"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Đăng ký thành công",
    "data": {
        "user": {
            "id": 1,
            "username": "nguyenvana",
            "email": "nguyenvana@example.com",
            "full_name": "Nguyễn Văn A",
            "phone": "0901234567",
            "role": "customer"
        },
        "token": "1|abc123xyz...",
        "token_type": "Bearer"
    }
}
```

---

### Đăng nhập

```http
POST /api/v1/login
```

**Request Body:**
```json
{
    "email": "nguyenvana@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Đăng nhập thành công",
    "data": {
        "user": {
            "id": 1,
            "username": "nguyenvana",
            "email": "nguyenvana@example.com",
            "full_name": "Nguyễn Văn A"
        },
        "token": "2|xyz789abc...",
        "token_type": "Bearer"
    }
}
```

**Response (401):**
```json
{
    "success": false,
    "message": "Email hoặc mật khẩu không chính xác"
}
```

---

### Đăng xuất

```http
POST /api/v1/logout
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Đăng xuất thành công"
}
```

---

### Lấy thông tin user

```http
GET /api/v1/user
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "id": 1,
    "username": "nguyenvana",
    "email": "nguyenvana@example.com",
    "full_name": "Nguyễn Văn A",
    "phone": "0901234567",
    "address": "123 Nguyễn Văn Linh, Q7, HCM",
    "role": "customer"
}
```

---

### Cập nhật thông tin

```http
PUT /api/v1/user/profile
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "full_name": "Nguyễn Văn A Updated",
    "phone": "0909999999",
    "address": "456 Lê Văn Việt, Q9, HCM",
    "gender": "male",
    "date_of_birth": "1990-01-15"
}
```

---

### Đổi mật khẩu

```http
PUT /api/v1/user/password
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "current_password": "password123",
    "password": "newpassword456",
    "password_confirmation": "newpassword456"
}
```

---

## 📦 Products

### Danh sách sản phẩm

```http
GET /api/v1/products
```

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `category` | string | Filter theo slug danh mục |
| `min_price` | number | Giá tối thiểu |
| `max_price` | number | Giá tối đa |
| `sort_by` | string | Sắp xếp theo (name, price, created_at) |
| `sort_order` | string | asc hoặc desc |
| `per_page` | number | Số sản phẩm mỗi trang (default: 12) |
| `page` | number | Số trang |

**Example:**
```http
GET /api/v1/products?category=but-viet&min_price=5000&max_price=50000&sort_by=price&sort_order=asc&per_page=10
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "code": "SP001",
                "name": "Bút bi Thiên Long TL-027",
                "slug": "but-bi-thien-long-tl-027",
                "price": "5000.00",
                "stock_quantity": 100,
                "image": "products/but-bi.jpg",
                "category": {
                    "id": 1,
                    "name": "Bút viết",
                    "slug": "but-viet"
                },
                "supplier": {
                    "id": 1,
                    "name": "Thiên Long"
                }
            }
        ],
        "per_page": 12,
        "total": 50,
        "last_page": 5
    }
}
```

---

### Chi tiết sản phẩm

```http
GET /api/v1/products/{slug}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "product": {
            "id": 1,
            "code": "SP001",
            "name": "Bút bi Thiên Long TL-027",
            "slug": "but-bi-thien-long-tl-027",
            "description": "Bút bi cao cấp, mực xanh, viết trơn",
            "unit": "cái",
            "price": "5000.00",
            "stock_quantity": 100,
            "image": "products/but-bi.jpg",
            "is_featured": true,
            "category": {...},
            "supplier": {...}
        },
        "related_products": [...]
    }
}
```

---

### Tìm kiếm sản phẩm

```http
GET /api/v1/products/search/{query}
```

**Example:**
```http
GET /api/v1/products/search/bút bi
```

---

## 📂 Categories

### Danh sách danh mục

```http
GET /api/v1/categories
```

**Response (200):**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Bút viết",
            "slug": "but-viet",
            "description": "Các loại bút viết",
            "products_count": 25
        },
        {
            "id": 2,
            "name": "Vở - Sổ",
            "slug": "vo-so",
            "products_count": 18
        }
    ]
}
```

---

### Chi tiết danh mục

```http
GET /api/v1/categories/{slug}
```

---

### Sản phẩm theo danh mục

```http
GET /api/v1/categories/{slug}/products
```

---

## 🛒 Cart (Yêu cầu đăng nhập)

### Xem giỏ hàng

```http
GET /api/v1/cart
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "items": [
            {
                "id": 1,
                "product_id": 1,
                "quantity": 3,
                "product": {
                    "id": 1,
                    "name": "Bút bi Thiên Long",
                    "price": "5000.00",
                    "stock_quantity": 100,
                    "image": "products/but-bi.jpg"
                }
            }
        ],
        "total": 15000,
        "count": 3
    }
}
```

---

### Thêm sản phẩm vào giỏ

```http
POST /api/v1/cart
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "product_id": 1,
    "quantity": 2
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Đã thêm vào giỏ hàng",
    "data": {
        "id": 1,
        "product_id": 1,
        "quantity": 2,
        "product": {...}
    }
}
```

**Response (400) - Hết hàng:**
```json
{
    "success": false,
    "message": "Sản phẩm không đủ số lượng trong kho"
}
```

---

### Cập nhật số lượng

```http
PUT /api/v1/cart/{id}
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "quantity": 5
}
```

---

### Xóa sản phẩm khỏi giỏ

```http
DELETE /api/v1/cart/{id}
Authorization: Bearer {token}
```

---

### Xóa toàn bộ giỏ hàng

```http
DELETE /api/v1/cart
Authorization: Bearer {token}
```

---

## 📋 Orders (Yêu cầu đăng nhập)

### Danh sách đơn hàng

```http
GET /api/v1/orders
Authorization: Bearer {token}
```

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `per_page` | number | Số đơn hàng mỗi trang |
| `page` | number | Số trang |

**Response (200):**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "order_number": "ORD-1704123456-1",
                "total_amount": "150000.00",
                "status": "pending",
                "payment_method": "cod",
                "created_at": "2024-01-01T10:00:00.000000Z",
                "order_details": [
                    {
                        "id": 1,
                        "quantity": 5,
                        "price": "5000.00",
                        "subtotal": "25000.00",
                        "product": {...}
                    }
                ]
            }
        ]
    }
}
```

---

### Tạo đơn hàng mới

```http
POST /api/v1/orders
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "shipping_address": "123 Nguyễn Văn Linh, Q7, HCM",
    "phone": "0901234567",
    "payment_method": "cod",
    "notes": "Giao hàng giờ hành chính"
}
```

**Payment Methods:**
- `cod` - Thanh toán khi nhận hàng
- `bank_transfer` - Chuyển khoản ngân hàng

**Response (201):**
```json
{
    "success": true,
    "message": "Đặt hàng thành công",
    "data": {
        "id": 1,
        "order_number": "ORD-1704123456-1",
        "total_amount": "150000.00",
        "status": "pending",
        "order_details": [...]
    }
}
```

---

### Chi tiết đơn hàng

```http
GET /api/v1/orders/{id}
Authorization: Bearer {token}
```

---

### Mua lại đơn hàng

```http
POST /api/v1/orders/{id}/reorder
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Đã thêm sản phẩm vào giỏ hàng",
    "data": {
        "added_products": ["Bút bi Thiên Long", "Vở ô ly 200 trang"],
        "out_of_stock_products": ["Thước kẻ 30cm"]
    }
}
```

---

## 📊 Order Statuses

| Status | Description |
|--------|-------------|
| `pending` | Chờ duyệt |
| `approved` | Đã duyệt |
| `completed` | Hoàn thành |
| `rejected` | Từ chối |

---

## ⚠️ Error Responses

### 400 Bad Request
```json
{
    "success": false,
    "message": "Dữ liệu không hợp lệ"
}
```

### 401 Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

### 404 Not Found
```json
{
    "success": false,
    "message": "Không tìm thấy tài nguyên"
}
```

### 422 Validation Error
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["Email đã tồn tại"],
        "password": ["Mật khẩu phải có ít nhất 6 ký tự"]
    }
}
```

### 500 Server Error
```json
{
    "success": false,
    "message": "Có lỗi xảy ra"
}
```

---

## 🔧 Sử dụng với cURL

### Đăng nhập
```bash
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'
```

### Lấy danh sách sản phẩm
```bash
curl http://localhost:8000/api/v1/products
```

### Thêm vào giỏ hàng (có token)
```bash
curl -X POST http://localhost:8000/api/v1/cart \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"product_id":1,"quantity":2}'
```

---

## 📱 Sử dụng với JavaScript (Fetch)

```javascript
// Đăng nhập
const login = async () => {
    const response = await fetch('http://localhost:8000/api/v1/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: 'test@example.com',
            password: 'password123'
        })
    });
    const data = await response.json();
    localStorage.setItem('token', data.data.token);
    return data;
};

// Lấy giỏ hàng
const getCart = async () => {
    const token = localStorage.getItem('token');
    const response = await fetch('http://localhost:8000/api/v1/cart', {
        headers: {
            'Authorization': `Bearer ${token}`,
        }
    });
    return response.json();
};

// Đặt hàng
const placeOrder = async (orderData) => {
    const token = localStorage.getItem('token');
    const response = await fetch('http://localhost:8000/api/v1/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
        },
        body: JSON.stringify(orderData)
    });
    return response.json();
};
```

---

## 📝 Postman Collection

Import collection vào Postman để test API:

1. Mở Postman
2. Click "Import"
3. Chọn "Raw text" và paste collection JSON
4. Thêm biến môi trường:
   - `base_url`: `http://localhost:8000/api/v1`
   - `token`: Token nhận được sau khi đăng nhập

---

## 🔒 Rate Limiting

API có giới hạn request:
- 60 requests/phút cho các endpoint public
- 120 requests/phút cho các endpoint authenticated

Khi vượt quá giới hạn, sẽ nhận response 429:
```json
{
    "message": "Too Many Attempts."
}
```
