<div id="couponResultSection" style="background: #fff; width: 100%; border-top: 5px solid #667eea; padding: 20px 0; margin-top: 20px; box-shadow: 0 -5px 20px rgba(0,0,0,0.1);">
    <div class="container text-center">
        <!-- Game Result Header -->
        <div style="background: #333; padding: 10px 20px; border-radius: 50px; color: white; display: inline-block; margin-bottom: 20px;">
            <h4 class="mb-0" style="font-family: 'Poppins', sans-serif;">SKOR ANDA: <span id="finalScoreDisplay" style="color: #4fd1c5; font-weight: bold;">0</span></h4>
        </div>

        <!-- Coupon Container (Initially Hidden via d-none, toggled by JS) -->
        <div id="couponDataSection" class="d-none">
            <!-- Header -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 15px; border-radius: 15px; color: white; display: inline-block; min-width: 300px; margin-bottom: 20px;">
                <h3 class="mb-0" style="font-weight: bold; font-family: 'Poppins', sans-serif;">🎉 CONGRATULATIONS! 🎉</h3>
                <p class="mb-0" style="font-size: 14px;">Selamat! Skor 1000+ Mendapat Kupon!</p>
            </div>

            <!-- Coupon Code Box -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div style="background: #fff0f6; border: 2px dashed #ff85a2; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
                        <p style="color: #ff5277; font-weight: bold; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">KODE KUPON ANDA</p>
                        <h2 id="generatedCouponCode" style="color: #333; font-weight: 800; letter-spacing: 3px; margin: 0; font-size: 32px;">-</h2>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                        <div class="row">
                            <div class="col-4 border-end">
                                <p class="mb-0 text-muted small">Diskon</p>
                                <h4 id="modal-discountPercentage" class="text-primary fw-bold">-</h4>
                            </div>
                            <div class="col-4 border-end">
                                <p class="mb-0 text-muted small">Berlaku Hingga</p>
                                <p id="modal-expiredAt" class="fw-bold mb-0">-</p>
                            </div>
                            <div class="col-4">
                                <p class="mb-0 text-muted small">Min. Belanja</p>
                                <p id="modal-minPurchase" class="fw-bold mb-0">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div>
                <button type="button" class="btn btn-primary btn-lg" id="copyCouponBtn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 10px 30px; border-radius: 50px;">
                    <i class="fa-regular fa-copy"></i> Salin Kode
                </button>
                <a href="/my-coupons" class="btn btn-outline-dark btn-lg ms-2" style="border-radius: 50px; padding: 10px 30px;">
                    Lihat Kupon Saya
                </a>
            </div>
        </div>

        <!-- No Coupon Message (Initially Hidden) -->
        <div id="noCouponMessage" class="d-none mt-3">
             <p class="text-muted">Kumpulkan skor minimal 1000 untuk mendapatkan kupon diskon!</p>
        </div>
    </div>
</div>
