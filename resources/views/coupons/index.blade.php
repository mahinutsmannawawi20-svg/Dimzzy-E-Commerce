<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dimzzy | Kupon Saya</title>
    <style>
        .coupon-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .coupon-card:hover {
            transform: translateY(-5px);
        }
        .coupon-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
        }
        .coupon-header.used {
            background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%);
        }
        .coupon-header.expired {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }
        .badge-status {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
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
                                    <li class="nav-item active">
                                        <a class="nav-link" href="/my-coupons"><i class="fa-solid fa-ticket"></i> Kupon Saya</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/cart"><i class="fa-solid fa-cart-shopping"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section class="coupons-section" style="padding: 120px 0 50px 0;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1><i class="fa-solid fa-ticket"></i> Kupon <span class="clrchange">Saya</span></h1>
                    <p class="text-muted">Player: {{ $playerName }}</p>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="row mt-4">
                <div class="col-sm-12">
                    <ul class="nav nav-pills mb-4" id="couponTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button">
                                Semua ({{ $coupons->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="active-tab" data-bs-toggle="pill" data-bs-target="#active" type="button">
                                Aktif ({{ $activeCoupons->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="used-tab" data-bs-toggle="pill" data-bs-target="#used" type="button">
                                Terpakai ({{ $usedCoupons->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="expired-tab" data-bs-toggle="pill" data-bs-target="#expired" type="button">
                                Kadaluarsa ({{ $expiredCoupons->count() }})
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="couponTabsContent">
                <!-- All Coupons -->
                <div class="tab-pane fade show active" id="all" role="tabpanel">
                    @if($coupons->isEmpty())
                        <div class="text-center py-5">
                            <i class="fa-solid fa-ticket" style="font-size: 80px; color: #ddd;"></i>
                            <h4 class="mt-3">Belum Ada Kupon</h4>
                            <p class="text-muted">Main game dan raih skor 1000+ untuk mendapatkan kupon!</p>
                            <a href="/minigames" class="btn btn-primary mt-3">
                                <i class="fa-solid fa-gamepad"></i> Main Game
                            </a>
                        </div>
                    @else
                        <div class="row">
                            @foreach($coupons as $coupon)
                                @include('coupons.partials.coupon-card', ['coupon' => $coupon])
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Active Coupons -->
                <div class="tab-pane fade" id="active" role="tabpanel">
                    @if($activeCoupons->isEmpty())
                        <div class="text-center py-5">
                            <p class="text-muted">Tidak ada kupon aktif</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($activeCoupons as $coupon)
                                @include('coupons.partials.coupon-card', ['coupon' => $coupon])
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Used Coupons -->
                <div class="tab-pane fade" id="used" role="tabpanel">
                    @if($usedCoupons->isEmpty())
                        <div class="text-center py-5">
                            <p class="text-muted">Belum ada kupon yang digunakan</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($usedCoupons as $coupon)
                                @include('coupons.partials.coupon-card', ['coupon' => $coupon])
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Expired Coupons -->
                <div class="tab-pane fade" id="expired" role="tabpanel">
                    @if($expiredCoupons->isEmpty())
                        <div class="text-center py-5">
                            <p class="text-muted">Tidak ada kupon kadaluarsa</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($expiredCoupons as $coupon)
                                @include('coupons.partials.coupon-card', ['coupon' => $coupon])
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
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
        function copyCouponCode(code, button) {
            navigator.clipboard.writeText(code).then(function() {
                var originalText = button.innerHTML;
                button.innerHTML = '<i class="fa-solid fa-check"></i> Tersalin!';
                button.classList.remove('btn-primary');
                button.classList.add('btn-success');
                
                setTimeout(function() {
                    button.innerHTML = originalText;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-primary');
                }, 2000);
            });
        }
    </script>
</body>

</html>
