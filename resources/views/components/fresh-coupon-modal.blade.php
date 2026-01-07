<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: white; border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            <!-- Header with Decor -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 20px 20px; text-align: center; position: relative;">
                <div style="position: absolute; top: -20px; left: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; right: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                
                <h3 class="modal-title mb-2" id="couponModalLabel" style="color: white; font-weight: bold; font-family: 'Poppins', sans-serif;">CONGRATULATIONS! 🎉</h3>
                <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 14px;">Kamu Mendapat Kupon Diskon!</p>
            </div>

            <!-- Body -->
            <div class="modal-body text-center" style="padding: 30px 25px;">
                <div style="background: #fff0f6; border: 2px dashed #ff85a2; border-radius: 12px; padding: 15px; margin-bottom: 25px;">
                    <p style="color: #ff5277; font-weight: bold; margin-bottom: 5px; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">KODE KUPON</p>
                    <h2 id="generatedCouponCode" style="color: #333; font-weight: 800; letter-spacing: 2px; margin: 0; font-size: 28px;">-</h2>
                </div>

                <div class="discount-info" style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin: 20px 0;">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-0" style="font-size: 12px; color: #666;">Diskon</p>
                            <h4 id="modal-discountPercentage" style="color: #667eea; margin: 0;">-</h4>
                        </div>
                        <div class="col-6">
                            <p class="mb-0" style="font-size: 12px; color: #666;">Berlaku Hingga</p>
                            <p id="modal-expiredAt" style="font-weight: bold; margin: 0;">-</p>
                        </div>
                    </div>
                </div>

                <p style="font-size: 13px; color: #666;">
                    <i class="fa-solid fa-info-circle"></i> Minimal pembelian: <span id="modal-minPurchase">Rp 10.000</span>
                </p>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" id="copyCouponBtn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 12px; font-weight: bold; border-radius: 10px;">
                        <i class="fa-regular fa-copy"></i> Salin Kode Kupon
                    </button>
                    <a href="/my-coupons" class="btn btn-outline-dark" style="border-radius: 10px; padding: 12px;">Lihat Semua Kupon Saya</a>
                    <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal" style="text-decoration: none; font-size: 13px;">Lanjut Main</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
console.log('New Game Coupon Modal loaded!');

function showCouponModal(couponData) {
    if (!couponData) {
        console.error('Invalid coupon data received');
        alert('Gagal menampilkan kupon: Data kosong');
        return;
    }

    console.log('Displaying coupon:', couponData);

    const codeEl = document.getElementById('generatedCouponCode');
    const discountEl = document.getElementById('modal-discountPercentage');
    const expiredEl = document.getElementById('modal-expiredAt');
    const minPurchaseEl = document.getElementById('modal-minPurchase');

    if (codeEl) codeEl.textContent = couponData.code;
    if (discountEl) discountEl.textContent = couponData.discount_percentage + '%';
    if (expiredEl) expiredEl.textContent = couponData.expired_at;
    if (minPurchaseEl) minPurchaseEl.textContent = 'Rp ' + couponData.min_purchase;
    
    // Use fallback if bootstrap object is missing (common issue in some environments)
    try {
        var modalEl = document.getElementById('couponModal');
        var modal = new bootstrap.Modal(modalEl);
        modal.show();
    } catch (e) {
        console.error('Bootstrap modal error:', e);
        // Fallback: manually show
        document.getElementById('couponModal').style.display = 'block';
        document.getElementById('couponModal').classList.add('show');
        document.body.classList.add('modal-open');
        var backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
    }
}

// Copy coupon code to clipboard
document.getElementById('copyCouponBtn').addEventListener('click', function() {
    var couponCode = document.getElementById('generatedCouponCode').textContent;
    navigator.clipboard.writeText(couponCode).then(function() {
        var originalText = this.innerHTML;
        this.innerHTML = '<i class="fa-solid fa-check"></i> Tersalin!';
        var btn = this;
        setTimeout(function() {
            btn.innerHTML = originalText;
        }, 2000);
    }.bind(this));
});
</script>
