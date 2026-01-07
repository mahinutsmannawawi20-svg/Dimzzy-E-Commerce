# Dimzzy E-Commerce

🍜 **Dimsum + Keju = Dimzzy!** - E-Commerce platform dengan sistem kupon berbasis game dan payment gateway QRIS.

## 🎮 Features

### 1. **E-Commerce Core**
- 🛒 Shopping Cart System
- 📦 Product Management
- 💳 Checkout Process

### 2. **Gamification & Rewards**
- 🎯 Mini Games (Ping Pong, Snake)
- 🎟️ Score-based Coupon System
- 💰 Discount Rewards (5-45%)
- ⏰ Daily Limits (3 coupons/day)
- 📅 7-day Validity Period

### 3. **Payment Integration**
- 💳 YoGateway QRIS Payment
- ⚡ Real-time Status Checking
- 🔄 Auto-redirect on Success
- 📱 Mobile-friendly Payment

### 4. **Coupon System**
- 🎁 Auto-generation on Game Completion
- 🔢 Score-based Discount Calculation
- ✅ Validation & Expiry Management
- 📊 Usage Tracking

## 🚀 Tech Stack

- **Framework:** Laravel 12
- **PHP:** 8.2+
- **Database:** MySQL 8.0+
- **Frontend:** Blade, Bootstrap 5, jQuery
- **Payment:** YoGateway API
- **Server:** Nginx, PHP-FPM

## 📋 Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM (for Vite)
- Git

## 🛠️ Installation

### Local Development

```bash
# Clone repository
git clone https://github.com/mahinutsmannawawi20-svg/Dimzzy-E-Commerce.git
cd Dimzzy-E-Commerce

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_DATABASE=dimzzy_larvel
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Start development server
php artisan serve
npm run dev
```

### Production Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed deployment instructions.

## 🎯 How It Works

### Coupon Generation Flow

1. **Play Game** → Score ≥ 1000 points
2. **Earn Coupon** → Discount = Score ÷ 200 (max 45%)
3. **Receive Code** → Format: GAME-XXXXX
4. **Use Coupon** → Apply at checkout
5. **Get Discount** → Percentage off total

### Payment Flow

1. **Add to Cart** → Select products
2. **Apply Coupon** → Optional discount
3. **Checkout** → Fill customer info
4. **QRIS Payment** → Scan with e-wallet
5. **Auto-verify** → Status checked every 3s
6. **Success** → Order confirmed, cart cleared

## 📁 Project Structure

```
Dimzzy-E-Commerce/
├── app/
│   ├── Http/Controllers/
│   │   ├── CartController.php
│   │   ├── CouponController.php
│   │   ├── PaymentController.php
│   │   └── ScoreMinigameController.php
│   ├── Models/
│   │   ├── Coupon.php
│   │   ├── Order.php
│   │   ├── Payment.php
│   │   └── Products.php
│   ├── Services/
│   │   └── YoGatewayService.php
│   └── Helpers/
│       └── CartHelper.php
├── database/
│   └── migrations/
│       ├── create_coupons_table.php
│       ├── create_orders_table.php
│       └── create_payments_table.php
├── resources/
│   ├── views/
│   │   ├── cart.blade.php
│   │   ├── checkout.blade.php
│   │   ├── coupons/
│   │   ├── payment/
│   │   └── games/
│   └── js/
│       └── pingpong.js
└── routes/
    └── web.php
```

## 🔑 Environment Variables

```env
# Application
APP_NAME=Dimzzy
APP_ENV=production
APP_URL=https://dimzzy.my.id

# Database
DB_DATABASE=dimzzy_production
DB_USERNAME=dimzzy_user
DB_PASSWORD=your_password

# YoGateway Payment
YOGATEWAY_API_KEY=yo_sec_xxxxx
YOGATEWAY_BASE_URL=https://yogateway.web.id/api.php
```

## 🧪 Testing

### Test Coupon System
```bash
# Visit game
http://localhost:8000/pingpong

# Play until score ≥ 1000
# Check coupon generated
http://localhost:8000/my-coupons
```

### Test Payment
```bash
# Add products to cart
# Apply coupon
# Checkout with test data
# Scan QRIS (sandbox mode)
```

## 📊 Database Schema

### Coupons Table
- Stores generated coupons
- Tracks usage and expiry
- Links to player and game

### Orders Table
- Customer information
- Cart items (JSON)
- Payment status
- Coupon applied

### Payments Table
- Transaction records
- YoGateway response data
- Payment status tracking

## 🎨 Screenshots

*Coming soon...*

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 License

This project is private and proprietary.

## 👨‍💻 Developer

**Mahinu Tsmann Awawi**
- GitHub: [@mahinutsmannawawi20-svg](https://github.com/mahinutsmannawawi20-svg)

## 🙏 Acknowledgments

- Laravel Framework
- YoGateway Payment Gateway
- Bootstrap
- Font Awesome

---

**Made with ❤️ for Dimzzy**

*Setiap Gigitan Lumer, Setiap Suapan Bikin Nagih!*
