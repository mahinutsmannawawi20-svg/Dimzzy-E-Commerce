# 🔧 Perbaikan Error "Gagal menyimpan skor: Unexpected token '<'"

## 📋 Masalah yang Diperbaiki

Error ini terjadi ketika JavaScript mencoba parse **HTML** sebagai **JSON**. Biasanya server mengembalikan HTML error page (dimulai dengan `<`) instead of JSON response yang diharapkan.

## ✅ Perbaikan yang Sudah Dilakukan

### 1. **Enhanced Error Handling di JavaScript** ✅

File yang diupdate:

-   `resources/views/games/pingpong.blade.php`
-   `resources/views/games/dimzzsnake.blade.php`

**Perubahan:**

```javascript
// BEFORE (error prone)
.then(response => response.json())

// AFTER (with proper validation)
.then(response => {
    // Check if response is JSON
    const contentType = response.headers.get('content-type');
    if (!contentType || !contentType.includes('application/json')) {
        throw new Error(`Server returned ${response.status}: ${response.statusText}. Expected JSON but got ${contentType}`);
    }

    if (!response.ok) {
        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }

    return response.json();
})
```

**Benefit:**

-   ✅ Mendeteksi jika server mengembalikan HTML instead of JSON
-   ✅ Memberikan error message yang lebih informatif
-   ✅ Menambahkan `'Accept': 'application/json'` header untuk memastikan server tahu kita expect JSON

### 2. **Route Naming untuk Better Reference** ✅

File: `routes/web.php`

```php
// Added route name
Route::post('/save-score', [ScoreMinigameController::class, 'store'])->name('score.save');
```

## 🔍 Troubleshooting Guide

### Jika Error Masih Terjadi di Production (dimzzy.my.id):

#### **1. Cek CSRF Token Issues**

Error console di browser akan menunjukkan:

```
Server returned 419: Page Expired. Expected JSON but got text/html
```

**Solusi:**

```bash
# Di server production
cd /var/www/dimzzy
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

#### **2. Cek Database Tables**

Pastikan tabel `score_minigame` dan `coupons` sudah ada:

```bash
# Via SSH
mysql -u dimzzy_user -p dimzzy_production

mysql> SHOW TABLES;
mysql> DESCRIBE score_minigame;
mysql> DESCRIBE coupons;
```

Expected tables:

-   `score_minigame` (player_name, score, timestamps)
-   `coupons` (code, player_name, game_type, score, discount_percentage, dll)

#### **3. Cek Session Configuration**

Di `.env` production:

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

# Pastikan session table exists
```

Jika session driver = database, pastikan tabel `sessions` ada:

```bash
php artisan session:table
php artisan migrate
```

#### **4. Cek Laravel Logs**

```bash
tail -f /var/www/dimzzy/storage/logs/laravel.log
```

Error yang mungkin muncul:

-   `SQLSTATE[42S02]: Base table or view not found` → Jalankan migration
-   `Class 'Coupon' not found` → Run `composer dump-autoload`
-   `Route [score.save] not defined` → Run `php artisan route:cache`

#### **5. Cek Nginx/Apache Error Logs**

```bash
tail -f /var/log/nginx/error.log
```

#### **6. Test Manual via cURL**

```bash
# Test dari server
curl -X POST https://dimzzy.my.id/save-score \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "player_name": "TestPlayer",
    "score": 1500,
    "game_type": "pingpong"
  }'
```

Expected response:

```json
{
    "status": "success",
    "coupon_generated": true,
    "coupon": {
        "code": "GAME-XXXXX",
        "discount_percentage": 7,
        "expired_at": "15 Jan 2026",
        "min_purchase": "10.000"
    }
}
```

## 🚀 Deployment Checklist

Setelah melakukan perubahan, deploy ke server:

```bash
# 1. Commit changes
git add .
git commit -m "Fix: Enhanced error handling for save-score endpoint"
git push origin main

# 2. Pull di server
cd /var/www/dimzzy
git pull origin main

# 3. Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 4. Rebuild assets (jika ada perubahan JS/CSS)
npm run build

# 5. Restart PHP-FPM
systemctl restart php8.2-fpm
```

## 📊 Testing Flow

### Test di Local (Development):

1. **Start Laravel**

    ```bash
    php artisan serve
    ```

2. **Buka Browser**

    - http://localhost:8000/pingpong
    - http://localhost:8000/dimzzsnake

3. **Main Game sampai Game Over**

    - Minimal score: 1000 untuk dapat kupon
    - Masukkan nama player

4. **Cek Console Browser (F12)**

    - Seharusnya TIDAK ada error
    - Response harus JSON

5. **Verify Data di Database**
    ```sql
    SELECT * FROM score_minigame ORDER BY created_at DESC LIMIT 5;
    SELECT * FROM coupons WHERE player_name = 'YourName';
    ```

### Test di Production:

1. **Buka** https://dimzzy.my.id/pingpong
2. **Main dan test** save score
3. **Cek** error di console browser
4. **Verify** di database production

## 🐛 Common Issues & Solutions

| Error                | Penyebab                       | Solusi                                      |
| -------------------- | ------------------------------ | ------------------------------------------- |
| `419 Page Expired`   | CSRF token expired/invalid     | Clear cache: `php artisan config:clear`     |
| `500 Internal Error` | Server error, cek Laravel logs | `tail -f storage/logs/laravel.log`          |
| `404 Not Found`      | Route tidak ditemukan          | `php artisan route:list \| grep save-score` |
| `Database error`     | Table tidak ada                | `php artisan migrate`                       |
| Unexpected token '<' | Server return HTML not JSON    | Fixed by enhanced error handling ✅         |

## 📝 Notes

-   ✅ CSRF token sudah ada di layout `app.blade.php` (line 6)
-   ✅ Route `/save-score` sudah terdaftar di `routes/web.php`
-   ✅ Controller `ScoreMinigameController` sudah handle JSON response
-   ✅ Error handling di frontend sudah improved
-   ⚠️ Pastikan database sudah di-migrate di production
-   ⚠️ Pastikan session driver berfungsi dengan baik

## 🎯 Kesimpulan

Perbaikan ini akan memberikan **error message yang lebih jelas** saat terjadi masalah, memudahkan debugging di production. Server sekarang **dipaksa** untuk mengembalikan JSON response dengan header `Accept: application/json`.

Jika masih ada error setelah perbaikan ini, cek:

1. Laravel logs: `/var/www/dimzzy/storage/logs/laravel.log`
2. Nginx logs: `/var/log/nginx/error.log`
3. Browser console untuk detail error message yang baru (lebih informatif)
