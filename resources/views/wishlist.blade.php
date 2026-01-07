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
    <title>Dimzzy | Wishlist</title>
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
                                        <a class="nav-link" href="/wishlist">
                                            <i class="fa-solid fa-heart"></i> 
                                            <span class="badge bg-danger" id="wishlistCount">{{ count($wishlist) }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/cart"><i class="fa-solid fa-cart-shopping"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/my-coupons"><i class="fa-solid fa-user"></i></a>
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
                    <h1><i class="fa-solid fa-heart"></i> My <span class="clrchange">Wishlist</span></h1>
                </div>
            </div>

            @if(empty($wishlist))
                <div class="row mt-5">
                    <div class="col-sm-12 text-center">
                        <i class="fa-solid fa-heart" style="font-size: 100px; color: #ddd;"></i>
                        <h3 class="mt-3">Wishlist Kosong</h3>
                        <p>Yuk tambahkan produk favorit ke wishlist!</p>
                        <a href="/produk" class="btn btn-primary mt-3">Lihat Produk</a>
                    </div>
                </div>
            @else
                <div class="row mt-4">
                    @foreach($wishlist as $item)
                        <div class="col-md-6 mb-4" id="wishlist-item-{{ $item['id'] }}">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <img src="{{ asset($item['foto']) }}" alt="{{ $item['nama_produk'] }}" class="img-fluid rounded">
                                        </div>
                                        <div class="col-md-8">
                                            <h5>{{ $item['nama_produk'] }}</h5>
                                            <h4 class="clrchange mb-3">Rp {{ number_format($item['harga'], 0, ',', '.') }}</h4>
                                            
                                            <div class="btn-group w-100" role="group">
                                                <button class="btn btn-success" onclick="moveToCart({{ $item['id'] }})">
                                                    <i class="fa-solid fa-cart-shopping"></i> Tambah ke Keranjang
                                                </button>
                                                <button class="btn btn-danger" onclick="removeFromWishlist({{ $item['id'] }})">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mt-3">
                    <div class="col-sm-12">
                        <a href="/produk" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                        </a>
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

        function removeFromWishlist(productId) {
            $.ajax({
                url: '/wishlist/remove/' + productId,
                method: 'DELETE',
                success: function(response) {
                    // Remove item from DOM with animation
                    $('#wishlist-item-' + productId).fadeOut(300, function() {
                        $(this).remove();
                        
                        // Update badge count
                        $('#wishlistCount').text(response.wishlist_count);
                        
                        // Reload if wishlist is now empty
                        if (response.wishlist_count === 0) {
                            location.reload();
                        }
                    });
                    
                    // Show toast message (optional)
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Gagal menghapus produk dari wishlist');
                }
            });
        }

        function moveToCart(productId) {
            $.ajax({
                url: '/wishlist/move-to-cart/' + productId,
                method: 'POST',
                success: function(response) {
                    // Remove item from DOM
                    $('#wishlist-item-' + productId).fadeOut(300, function() {
                        $(this).remove();
                        
                        // Update wishlist badge
                        $('#wishlistCount').text(response.wishlist_count);
                        
                        // Reload if wishlist is now empty
                        if (response.wishlist_count === 0) {
                            location.reload();
                        }
                    });
                    
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Gagal memindahkan produk ke keranjang');
                }
            });
        }
    </script>
</body>

</html>
