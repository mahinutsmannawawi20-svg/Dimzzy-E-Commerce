# Dimzzy E-Commerce

E-Commerce platform with gamification-based coupon system and QRIS payment integration.

## Overview

Dimzzy is a Laravel-based e-commerce application that rewards customers with discount coupons for playing mini-games. The platform integrates with YoGateway for seamless QRIS payment processing.

## Key Features

### E-Commerce
- Product catalog and management
- Shopping cart system
- Checkout process with coupon support
- Order tracking and management

### Gamification System
- Mini-games (Ping Pong, Snake)
- Score-based reward mechanism
- Automatic coupon generation
- Daily earning limits (3 coupons per day)
- 7-day coupon validity period

### Payment Integration
- YoGateway QRIS payment gateway
- Real-time payment status verification
- Automatic order confirmation
- Mobile-optimized payment interface

### Coupon Management
- Dynamic discount calculation (5-45% based on score)
- Unique coupon code generation (GAME-XXXXX format)
- Expiration and usage tracking
- Minimum purchase requirements

## Technical Stack

- **Framework:** Laravel 12
- **PHP Version:** 8.2+
- **Database:** MySQL 8.0+
- **Frontend:** Blade Templates, Bootstrap 5, jQuery
- **Payment Gateway:** YoGateway API
- **Web Server:** Nginx with PHP-FPM

## System Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0 or MariaDB >= 10.5
- Node.js and NPM
- Git

## Installation

### Local Development Setup

```bash
git clone https://github.com/mahinutsmannawawi20-svg/Dimzzy-E-Commerce.git
cd Dimzzy-E-Commerce

composer install
npm install

cp .env.example .env
php artisan key:generate

# Configure database credentials in .env
php artisan migrate

php artisan serve
npm run dev
```

### Production Deployment

Refer to [DEPLOYMENT.md](DEPLOYMENT.md) for comprehensive deployment instructions.

## Configuration

### Environment Variables

```env
APP_NAME=Dimzzy
APP_ENV=production
APP_URL=https://your-domain.com

DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

YOGATEWAY_API_KEY=your_api_key
YOGATEWAY_BASE_URL=https://yogateway.web.id/api.php
```

## Application Flow

### Coupon Generation

1. User plays mini-game and achieves score >= 1000
2. System calculates discount: Score / 200 (maximum 45%)
3. Unique coupon code generated automatically
4. Coupon stored with 7-day expiration
5. User can view and manage coupons in dashboard

### Payment Process

1. Customer adds products to cart
2. Optional coupon application for discount
3. Checkout with customer information
4. QRIS code generation via YoGateway
5. Real-time payment status monitoring (3-second intervals)
6. Automatic order confirmation upon successful payment
7. Cart clearance and coupon usage marking

## Project Structure

```
app/
├── Http/Controllers/
│   ├── CartController.php
│   ├── CouponController.php
│   ├── PaymentController.php
│   └── ScoreMinigameController.php
├── Models/
│   ├── Coupon.php
│   ├── Order.php
│   ├── Payment.php
│   └── Products.php
├── Services/
│   └── YoGatewayService.php
└── Helpers/
    └── CartHelper.php

database/migrations/
├── create_coupons_table.php
├── create_orders_table.php
└── create_payments_table.php

resources/
├── views/
│   ├── cart.blade.php
│   ├── checkout.blade.php
│   ├── coupons/
│   ├── payment/
│   └── games/
└── js/
    └── pingpong.js
```

## Database Schema

### Coupons
Stores generated discount coupons with player information, game type, score, discount percentage, usage status, and expiration date.

### Orders
Contains customer details, purchased items (JSON), payment status, applied coupon, and YoGateway transaction reference.

### Payments
Tracks payment transactions with YoGateway response data, transaction IDs, amounts, and status updates.

## API Integration

### YoGateway Endpoints

**Create Payment**
```
GET https://yogateway.web.id/api.php?action=createpayment&apikey={key}&amount={amount}
```

**Check Status**
```
GET https://yogateway.web.id/api.php?action=checkstatus&apikey={key}&trxid={trxid}
```

## Testing

### Coupon System Test
```bash
# Access game interface
http://localhost:8000/pingpong

# Play until score reaches 1000+
# Verify coupon generation
http://localhost:8000/my-coupons
```

### Payment Flow Test
```bash
# Add products to cart
# Apply test coupon
# Complete checkout process
# Scan generated QRIS code
# Verify payment confirmation
```

## Security Considerations

- Environment variables for sensitive data
- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM
- XSS protection through Blade templating
- Secure payment verification

## Contributing

1. Fork the repository
2. Create feature branch
3. Commit changes with clear messages
4. Push to branch
5. Submit pull request

## License

Proprietary and confidential.

## Author

Mahinu Tsmann Awawi

## Acknowledgments

- Laravel Framework
- YoGateway Payment Gateway
- Bootstrap CSS Framework
- Font Awesome Icons
