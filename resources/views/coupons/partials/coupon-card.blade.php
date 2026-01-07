<div class="col-md-4 mb-4">
    <div class="card coupon-card position-relative">
        @if($coupon->status === 'used')
            <span class="badge badge-status bg-secondary">Terpakai</span>
        @elseif($coupon->status === 'expired')
            <span class="badge badge-status bg-danger">Kadaluarsa</span>
        @else
            <span class="badge badge-status bg-success">Aktif</span>
        @endif

        <div class="coupon-header {{ $coupon->status === 'active' ? '' : $coupon->status }}">
            <div class="text-center">
                <i class="fa-solid fa-ticket" style="font-size: 40px;"></i>
                <h2 class="mt-2 mb-0">{{ $coupon->discount_percentage }}%</h2>
                <p class="mb-0">DISKON</p>
            </div>
        </div>

        <div class="card-body">
            <div class="text-center mb-3">
                <div class="p-3" style="background: #f8f9fa; border-radius: 10px;">
                    <p class="mb-1" style="font-size: 12px; color: #666;">KODE KUPON</p>
                    <h4 class="mb-0" style="letter-spacing: 2px; font-weight: bold;">{{ $coupon->code }}</h4>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <span style="font-size: 13px;"><i class="fa-solid fa-gamepad"></i> Game:</span>
                    <strong style="font-size: 13px;">{{ ucfirst($coupon->game_type) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="font-size: 13px;"><i class="fa-solid fa-star"></i> Skor:</span>
                    <strong style="font-size: 13px;">{{ number_format($coupon->score) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="font-size: 13px;"><i class="fa-solid fa-shopping-bag"></i> Min. Belanja:</span>
                    <strong style="font-size: 13px;">Rp {{ number_format($coupon->min_purchase, 0, ',', '.') }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span style="font-size: 13px;"><i class="fa-solid fa-calendar"></i> Berlaku s/d:</span>
                    <strong style="font-size: 13px;">{{ $coupon->expired_at->format('d M Y') }}</strong>
                </div>
            </div>

            @if($coupon->status === 'active')
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-sm" onclick="copyCouponCode('{{ $coupon->code }}', this)">
                        <i class="fa-solid fa-copy"></i> Salin Kode
                    </button>
                    <a href="/produk" class="btn btn-outline-primary btn-sm">
                        <i class="fa-solid fa-shopping-cart"></i> Gunakan Sekarang
                    </a>
                </div>
            @elseif($coupon->status === 'used')
                <div class="alert alert-secondary mb-0" style="font-size: 12px;">
                    <i class="fa-solid fa-check-circle"></i> Digunakan pada {{ $coupon->used_at->format('d M Y H:i') }}
                </div>
            @else
                <div class="alert alert-danger mb-0" style="font-size: 12px;">
                    <i class="fa-solid fa-times-circle"></i> Kupon sudah kadaluarsa
                </div>
            @endif
        </div>
    </div>
</div>
