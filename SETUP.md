# Hướng dẫn Setup & Deploy - VPP_OSS_T10

## 📋 Checklist Setup

- [ ] Cài đặt PHP 8.1+
- [ ] Cài đặt Composer
- [ ] Cài đặt MySQL
- [ ] Clone repository
- [ ] Chạy `composer install`
- [ ] Copy `.env.example` → `.env`
- [ ] Generate app key
- [ ] Tạo database
- [ ] Chạy migrations
- [ ] Seed dữ liệu mẫu
- [ ] Test đăng nhập admin & customer

---

## 🚀 Quick Start

```bash
# 1. Clone project
git clone https://github.com/KhoaPhanix/VPP_OSS_T10.git
cd VPP_OSS_T10

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
# DB_DATABASE=vpp_oss_t10
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 5. Run migrations & seed
php artisan migrate --seed

# 6. Start server
php artisan serve
```

Truy cập: http://localhost:8000

---

## 🔑 Default Accounts

**Admin:**
- Username: `admin`
- Password: `admin123`

**Customer:**
- Username: `khachhang1`
- Password: `password`

---

## ⚙️ Configuration

### Database (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vpp_oss_t10
DB_USERNAME=root
DB_PASSWORD=
```

### Mail (Optional)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

---

## 📦 Production Deployment

### 1. Optimize for Production

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 2. Set .env for Production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 3. Set Permissions (Linux)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Test specific feature
php artisan test --filter ProductTest
```

---

## 📊 Monitoring

### Check Logs
```bash
tail -f storage/logs/laravel.log
```

### Database Backup
```bash
mysqldump -u root -p vpp_oss_t10 > backup.sql
```

---

## 🔄 Update & Maintenance

```bash
# Pull latest changes
git pull origin main

# Update dependencies
composer update

# Run new migrations
php artisan migrate

# Clear all cache
php artisan optimize:clear
```

---

## 📞 Support

- **Email:** khoaphan@example.com
- **Repository:** [github.com/KhoaPhanix/VPP_OSS_T10](https://github.com/KhoaPhanix/VPP_OSS_T10)

---

**Version:** 1.0  
**Last Updated:** 16/12/2025
