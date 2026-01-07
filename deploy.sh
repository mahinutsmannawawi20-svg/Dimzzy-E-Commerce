#!/bin/bash

# Dimzzy E-Commerce - Automated Deployment Script
# Safe deployment for multi-project VPS

set -e  # Exit on error

echo "========================================="
echo "Dimzzy E-Commerce Deployment"
echo "========================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
PROJECT_DIR="/var/www/dimzzy"
REPO_URL="https://github.com/mahinutsmannawawi20-svg/Dimzzy-E-Commerce.git"
DB_NAME="dimzzy_db"
DB_USER="dimzzy_user"
DB_PASS="Dimzzy2025Secure!"
DOMAIN="dimzzy.my.id"

echo -e "${YELLOW}Step 1: Checking existing projects...${NC}"
ls -la /var/www/ | grep -v "^total" | grep -v "^d"
echo ""

echo -e "${YELLOW}Step 2: Cloning repository...${NC}"
if [ -d "$PROJECT_DIR" ]; then
    echo -e "${RED}Directory $PROJECT_DIR already exists!${NC}"
    read -p "Remove and re-clone? (y/n): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        rm -rf $PROJECT_DIR
    else
        echo "Deployment cancelled."
        exit 1
    fi
fi

cd /var/www
git clone $REPO_URL dimzzy
echo -e "${GREEN}✓ Repository cloned${NC}"
echo ""

echo -e "${YELLOW}Step 3: Installing dependencies...${NC}"
cd $PROJECT_DIR
composer install --optimize-autoloader --no-dev --no-interaction
echo -e "${GREEN}✓ Dependencies installed${NC}"
echo ""

echo -e "${YELLOW}Step 4: Setting up environment...${NC}"
cp .env.production .env

# Update .env with database credentials
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env
sed -i "s|APP_URL=.*|APP_URL=https://$DOMAIN|" .env

php artisan key:generate --force
echo -e "${GREEN}✓ Environment configured${NC}"
echo ""

echo -e "${YELLOW}Step 5: Creating database...${NC}"
mysql -u root -p"Mahin-200601" <<MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT
echo -e "${GREEN}✓ Database created${NC}"
echo ""

echo -e "${YELLOW}Step 6: Running migrations...${NC}"
php artisan migrate --force
echo -e "${GREEN}✓ Migrations completed${NC}"
echo ""

echo -e "${YELLOW}Step 7: Setting permissions...${NC}"
chown -R www-data:www-data $PROJECT_DIR
chmod -R 755 $PROJECT_DIR
chmod -R 775 $PROJECT_DIR/storage
chmod -R 775 $PROJECT_DIR/bootstrap/cache
echo -e "${GREEN}✓ Permissions set${NC}"
echo ""

echo -e "${YELLOW}Step 8: Optimizing application...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
echo -e "${GREEN}✓ Application optimized${NC}"
echo ""

echo -e "${YELLOW}Step 9: Configuring Nginx...${NC}"
cat > /etc/nginx/sites-available/dimzzy <<'NGINX_CONFIG'
server {
    listen 80;
    listen [::]:80;
    server_name dimzzy.my.id www.dimzzy.my.id;
    root /var/www/dimzzy/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;
    charset utf-8;

    access_log /var/log/nginx/dimzzy_access.log;
    error_log /var/log/nginx/dimzzy_error.log;

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
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
NGINX_CONFIG

ln -sf /etc/nginx/sites-available/dimzzy /etc/nginx/sites-enabled/
nginx -t && systemctl reload nginx
echo -e "${GREEN}✓ Nginx configured${NC}"
echo ""

echo -e "${YELLOW}Step 10: Installing SSL certificate...${NC}"
certbot --nginx -d $DOMAIN -d www.$DOMAIN --non-interactive --agree-tos --email mahinutsmannawawi20@gmail.com || echo "SSL installation skipped (may need manual setup)"
echo -e "${GREEN}✓ SSL configured${NC}"
echo ""

echo "========================================="
echo -e "${GREEN}Deployment Complete!${NC}"
echo "========================================="
echo ""
echo "Website: https://$DOMAIN"
echo "Database: $DB_NAME"
echo "Project Directory: $PROJECT_DIR"
echo ""
echo "Next steps:"
echo "1. Visit https://$DOMAIN to verify"
echo "2. Check logs: tail -f /var/log/nginx/dimzzy_error.log"
echo "3. Check Laravel logs: tail -f $PROJECT_DIR/storage/logs/laravel.log"
echo ""
