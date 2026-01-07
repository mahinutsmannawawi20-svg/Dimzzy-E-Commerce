<!-- Coupon Success Modal -->
<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; border: none;">
                <h5 class="modal-title w-100 text-center" id="couponModalLabel">
                    <i class="fa-solid fa-gift"></i> SELAMAT! <i class="fa-solid fa-gift"></i>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="padding: 30px;">
                <div class="mb-3">
                    <i class="fa-solid fa-ticket" style="font-size: 60px; color: #667eea;"></i>
                </div>
                <h4 class="mb-3">Kamu Mendapat Kupon Diskon!</h4>
                
                <div class="coupon-code-box" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <p class="mb-2" style="color: white; font-size: 14px; font-weight: bold;">KODE KUPON</p>
                    <h2 id="couponCode" style="color: white; font-weight: bold; letter-spacing: 2px; margin: 0;">-</h2>
                </div>

                <div class="discount-info" style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin: 20px 0;">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-0" style="font-size: 12px; color: #666;">Diskon</p>
                            <h4 id="discountPercentage" style="color: #667eea; margin: 0;">-</h4>
                        </div>
                        <div class="col-6">
                            <p class="mb-0" style="font-size: 12px; color: #666;">Berlaku Hingga</p>
                            <p id="expiredAt" style="font-weight: bold; margin: 0;">-</p>
                        </div>
                    </div>
                </div>

                <p style="font-size: 13px; color: #666;">
                    <i class="fa-solid fa-info-circle"></i> Minimal pembelian: <span id="minPurchase">Rp 10.000</span>
                </p>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" id="copyCouponBtn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 12px; font-weight: bold;">
                        <i class="fa-solid fa-copy"></i> Salin Kode Kupon
                    </button>
                    <a href="/my-coupons" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-list"></i> Lihat Semua Kupon Saya
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fa-solid fa-gamepad"></i> Lanjut Main
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Function to show coupon modal
function showCouponModal(couponData) {
    document.getElementById('couponCode').textContent = couponData.code;
    document.getElementById('discountPercentage').textContent = couponData.discount_percentage + '%';
    document.getElementById('expiredAt').textContent = couponData.expired_at;
    document.getElementById('minPurchase').textContent = 'Rp ' + couponData.min_purchase;
    
    var modal = new bootstrap.Modal(document.getElementById('couponModal'));
    modal.show();
}

// Copy coupon code to clipboard
document.getElementById('copyCouponBtn').addEventListener('click', function() {
    var couponCode = document.getElementById('couponCode').textContent;
    navigator.clipboard.writeText(couponCode).then(function() {
        var btn = document.getElementById('copyCouponBtn');
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-check"></i> Berhasil Disalin!';
        btn.style.background = 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)';
        
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        }, 2000);
    });
});
</script>
