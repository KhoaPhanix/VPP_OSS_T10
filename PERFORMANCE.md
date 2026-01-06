# Performance Optimization Tips

## Database Optimization

### 1. Use Eager Loading

```php
// Bad
$orders = Order::all();
foreach ($orders as $order) {
    echo $order->user->name;
}

// Good
$orders = Order::with('user')->get();
```

### 2. Index Important Columns

```php
$table->index('user_id');
$table->index('product_id');
$table->index(['category_id', 'is_active']);
```

### 3. Use Query Caching

```php
$products = Cache::remember('products', 3600, function () {
    return Product::active()->get();
});
```

## Frontend Optimization

### 1. Minify Assets

```bash
npm run build
```

### 2. Image Optimization

- Use WebP format
- Lazy load images
- Responsive images

### 3. Enable Browser Caching

Add to `.htaccess`:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
</IfModule>
```

## Laravel Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```
