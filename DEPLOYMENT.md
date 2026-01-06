# Deployment Guide

## Prerequisites

- VPS or shared hosting with PHP 8.0+
- MySQL database
- Composer installed
- Node.js and NPM

## Steps

### 1. Upload Files

Upload all project files to your server.

### 2. Configure Environment

```bash
cp .env.example .env
nano .env
```

Set your database credentials and app URL.

### 3. Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 4. Setup Database

```bash
php artisan migrate --force
php artisan db:seed --force
```

### 5. Optimize

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Set Permissions

```bash
chmod -R 755 storage bootstrap/cache
```

### 7. Point Domain

Point your domain to the `public` folder.

## SSL Certificate

Use Let's Encrypt for free SSL:

```bash
certbot --apache -d yourdomain.com
```
