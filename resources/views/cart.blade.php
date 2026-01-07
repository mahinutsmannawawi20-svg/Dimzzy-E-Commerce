<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dimzzy | Keranjang</title>
</head>

<body>
    <div class="topbar">
        <marquee direction="left" loop="" behavior=scroll class="marque" bgcolor="#000000">Dimsum + Keju = Dimzzy!  
        Setiap Gigitan Lumer, Setiap Suapan Bikin Nagih!</marquee>
    </div>
    
    <header>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                        <div class="container">
                            <a class="navbar-brand" href="/">
                                <h1 class="logo">Dimzzy <span class="clrchange">.</span></h1>
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/">Beranda</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/tentang-kami">Tentang</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/produk">Produk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/minigames">Mini Games</a>
                                    </li>
                                </ul>

                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/my-coupons"><i class="fa-solid fa-ticket"></i> Kupon Saya</a>
                                    </li>
                                    <li class="nav-item active">
                                        <a class="nav-link" href="/cart">
                                            <i class="fa-solid fa-cart-shopping"></i> 
                                            <span class="badge bg-danger" id="cartCount">{{ count($cart) }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section class="cart-section" style="padding: 120px 0 50px 0;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Keranjang <span class="clrchange">Belanja</span></h1>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(empty($cart))
                <div class="row mt-5">
                    <div class="col-sm-12 text-center">
                        <i class="fa-solid fa-cart-shopping" style="font-size: 100px; color: #ddd;"></i>
                        <h3 class="mt-3">Keranjang Kosong</h3>
                        <p>Yuk belanja produk Dimzzy!</p>
                        <a href="/produk" class="btn btn-primary mt-3">Lihat Produk</a>
                    </div>
                </div>
            @else
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                @foreach($cart as $item)
                                    <div class="cart-item mb-3 pb-3 border-bottom">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <img src="{{ asset($item['foto']) }}" alt="{{ $item['nama_produk'] }}" class="img-fluid rounded">
                                            </div>
                                            <div class="col-md-4">
                                                <h5>{{ $item['nama_produk'] }}</h5>
                                                <p class="text-muted mb-0">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})">-</button>
                                                    <input type="text" class="form-control form-control-sm text-center" value="{{ $item['quantity'] }}" readonly style="max-width: 60px;">
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})">+</button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <strong>Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</strong>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-danger btn-sm" onclick="removeItem({{ $item['id'] }})">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Ringkasan Belanja</h5>
                                
                                <div class="mb-3">
                                    <label class="form-label">Punya Kupon?</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="couponCode" placeholder="Masukkan kode kupon">
                                        <button class="btn btn-primary" type="button" onclick="applyCoupon()">Pakai</button>
                                    </div>
                                    <div id="couponMessage" class="mt-2"></div>
                                </div>

                                @if($coupon)
                                    <div class="alert alert-success">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i class="fa-solid fa-ticket"></i> {{ $coupon->code }} ({{ $coupon->discount_percentage }}%)</span>
                                            <button class="btn btn-sm btn-outline-danger" onclick="removeCoupon()">Hapus</button>
                                        </div>
                                    </div>
                                @endif

                                <hr>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <strong id="subtotal">Rp {{ number_format($cartTotal, 0, ',', '.') }}</strong>
                                </div>

                                @if($discountAmount > 0)
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span>Diskon ({{ $coupon->discount_percentage }}%)</span>
                                        <strong id="discount">- Rp {{ number_format($discountAmount, 0, ',', '.') }}</strong>
                                    </div>
                                @endif

                                <hr>

                                <div class="d-flex justify-content-between mb-3">
                                    <h5>Total</h5>
                                    <h5 class="clrchange" id="finalTotal">Rp {{ number_format($finalTotal, 0, ',', '.') }}</h5>
                                </div>

                                <a href="{{ route('checkout.show') }}" class="btn btn-success w-100">
                                    <i class="fa-solid fa-check"></i> Checkout
                                </a>

                                <a href="/produk" class="btn btn-outline-secondary w-100 mt-2">
                                    <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <footer class="footer">
        <div class="row copy-right">
            <div class="col-sm-12">
                <p>Dimzzy | 2025</p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function updateQuantity(productId, quantity) {
            if (quantity < 1) {
                removeItem(productId);
                return;
            }

            $.ajax({
                url: '{{ route("cart.update") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Gagal mengupdate keranjang');
                }
            });
        }

        function removeItem(productId) {
            if (!confirm('Hapus produk ini dari keranjang?')) return;

            $.ajax({
                url: '/cart/remove/' + productId,
                method: 'DELETE',
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Gagal menghapus produk');
                }
            });
        }

        function applyCoupon() {
            var code = $('#couponCode').val().trim();
            if (!code) {
                showCouponMessage('Masukkan kode kupon!', 'danger');
                return;
            }

            $.ajax({
                url: '{{ route("cart.applyCoupon") }}',
                method: 'POST',
                data: { code: code },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    var message = xhr.responseJSON?.message || 'Kupon tidak valid';
                    showCouponMessage(message, 'danger');
                }
            });
        }

        function removeCoupon() {
            $.ajax({
                url: '{{ route("cart.removeCoupon") }}',
                method: 'POST',
                success: function(response) {
                    location.reload();
                }
            });
        }

        function showCouponMessage(message, type) {
            $('#couponMessage').html(
                '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                '</div>'
            );
        }
    </script>
</body>

</html>
