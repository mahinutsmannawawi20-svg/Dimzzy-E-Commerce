# Dimzzy E-Commerce - Deployment Guide

## 🚀 Deployment to VPS (dimzzy.my.id)

### Prerequisites

**VPS Requirements:**
- Ubuntu 20.04+ / Debian 11+
- PHP 8.2+
- MySQL 8.0+ / MariaDB 10.5+
- Nginx
- Composer
- Git
- SSL Certificate (Let's Encrypt)

**Server Info:**
- IP: 72.62.124.123
- Domain: dimzzy.my.id
- User: root

---

## 📦 Step 1: Server Setup

### 1.1 Connect to VPS
```bash
ssh root@72.62.124.123
```

### 1.2 Update System
```bash
apt update && apt upgrade -y
```

### 1.3 Install Required Packages
```bash
# Install PHP 8.2
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd

# Install MySQL
apt install -y mysql-server

# Install Nginx
apt install -y nginx

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install Git
apt install -y git

# Install Certbot for SSL
apt install -y certbot python3-certbot-nginx
```

---

## 📂 Step 2: Clone Repository

```bash
# Navigate to web root
cd /var/www

# Clone repository
git clone https://github.com/mahinutsmannawawi20-svg/Dimzzy-E-Commerce.git dimzzy

# Set permissions
cd dimzzy
chown -R www-data:www-data /var/www/dimzzy
chmod -R 755 /var/www/dimzzy
chmod -R 775 /var/www/dimzzy/storage
chmod -R 775 /var/www/dimzzy/bootstrap/cache
```

---

## 🔧 Step 3: Configure Application

### 3.1 Install Dependencies
```bash
cd /var/www/dimzzy
composer install --optimize-autoloader --no-dev
```

### 3.2 Setup Environment
```bash
# Copy production environment
cp .env.production .env

# Generate application key
php artisan key:generate

# Edit .env file
nano .env
```

**Update these values in .env:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://dimzzy.my.id

DB_DATABASE=dimzzy_production
DB_USERNAME=dimzzy_user
DB_PASSWORD=YOUR_SECURE_PASSWORD
```

### 3.3 Create Database
```bash
mysql -u root -p
```

```sql
CREATE DATABASE dimzzy_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'dimzzy_user'@'localhost' IDENTIFIED BY 'YOUR_SECURE_PASSWORD';
GRANT ALL PRIVILEGES ON dimzzy_production.* TO 'dimzzy_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3.4 Run Migrations
```bash
cd /var/www/dimzzy
php artisan migrate --force
```

### 3.5 Optimize Application
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

---

## 🌐 Step 4: Configure Nginx

### 4.1 Create Nginx Configuration
```bash
nano /etc/nginx/sites-available/dimzzy
```

**Add this configuration:**
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name dimzzy.my.id www.dimzzy.my.id;
    root /var/www/dimzzy/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 4.2 Enable Site
```bash
ln -s /etc/nginx/sites-available/dimzzy /etc/nginx/sites-enabled/
nginx -t
systemctl restart nginx
```

---

## 🔒 Step 5: Setup SSL Certificate

```bash
# Install SSL certificate
certbot --nginx -d dimzzy.my.id -d www.dimzzy.my.id

# Auto-renewal (already configured by certbot)
certbot renew --dry-run
```

---

## 🗂️ Step 6: Setup Cron Jobs (Optional)

```bash
crontab -e
```

Add this line:
```
* * * * * cd /var/www/dimzzy && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🧪 Step 7: Test Deployment

### 7.1 Check Application
```bash
# Visit in browser
https://dimzzy.my.id
```

### 7.2 Test Payment Flow
1. Add products to cart
2. Apply coupon
3. Checkout
4. Test QRIS payment

### 7.3 Check Logs
```bash
tail -f /var/www/dimzzy/storage/logs/laravel.log
tail -f /var/log/nginx/error.log
```

---

## 🔄 Step 8: Future Updates

### Pull Latest Changes
```bash
cd /var/www/dimzzy
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
systemctl restart php8.2-fpm
```

---

## 🛡️ Security Checklist

- [x] APP_DEBUG=false in production
- [x] Strong database password
- [x] SSL certificate installed
- [x] Proper file permissions
- [x] .env file not in git
- [x] Firewall configured (UFW)
- [x] Regular backups

### Configure Firewall
```bash
ufw allow 22
ufw allow 80
ufw allow 443
ufw enable
```

---

## 📊 Monitoring

### Check PHP-FPM Status
```bash
systemctl status php8.2-fpm
```

### Check Nginx Status
```bash
systemctl status nginx
```

### Check MySQL Status
```bash
systemctl status mysql
```

---

## 🆘 Troubleshooting

### Permission Issues
```bash
chown -R www-data:www-data /var/www/dimzzy
chmod -R 755 /var/www/dimzzy
chmod -R 775 /var/www/dimzzy/storage
chmod -R 775 /var/www/dimzzy/bootstrap/cache
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Database Connection Error
- Check .env database credentials
- Verify MySQL is running
- Test connection: `mysql -u dimzzy_user -p dimzzy_production`

---

## 📞 Support

For issues, check:
- Laravel logs: `/var/www/dimzzy/storage/logs/laravel.log`
- Nginx logs: `/var/log/nginx/error.log`
- PHP-FPM logs: `/var/log/php8.2-fpm.log`

---

**Deployment Complete! 🎉**

Visit: https://dimzzy.my.id
