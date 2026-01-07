<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Dimzzy | Checkout</title>
</head>
<body>
    <div class="topbar">
        <marquee direction="left" loop="" behavior=scroll class="marque" bgcolor="#000000">Dimsum + Keju = Dimzzy!</marquee>
    </div>

    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-8">
                <h2><i class="fa-solid fa-shopping-cart"></i> Checkout</h2>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('payment.create') }}" method="POST">
                    @csrf
                    
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-user"></i> Informasi Customer</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap *</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. HP/WhatsApp *</label>
                                <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" placeholder="08xxxxxxxxxx" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class="fa-solid fa-qrcode"></i> Lanjut ke Pembayaran QRIS
                    </button>
                    
                    <a href="/cart" class="btn btn-outline-secondary btn-lg w-100 mt-2">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Keranjang
                    </a>
                </form>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fa-solid fa-receipt"></i> Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cart as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $item['nama_produk'] }} <small class="text-muted">({{ $item['quantity'] }}x)</small></span>
                                <strong>Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</strong>
                            </div>
                        @endforeach
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <strong>Rp {{ number_format($cartTotal, 0, ',', '.') }}</strong>
                        </div>
                        
                        @if($discountAmount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span><i class="fa-solid fa-ticket"></i> Diskon ({{ $coupon->discount_percentage }}%)</span>
                                <strong>- Rp {{ number_format($discountAmount, 0, ',', '.') }}</strong>
                            </div>
                        @endif
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <h5>Total Bayar</h5>
                            <h5 class="text-primary">Rp {{ number_format($finalTotal, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
