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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <title>Dimzzy | Produk</title>
</head>

<body id="top-product">
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
                            <a class="navbar-brand" href="#">
                                <h1 class="logo">Dimzzy <span class="clrchange">.</span></h1>
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="/">Beranda</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/">Tentang</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#product">Produk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/">Tim Dimzzy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/">Hubungi Kami</a>
                                    </li>
                                </ul>

                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/my-coupons"><i class="fa-solid fa-ticket"></i> Kupon</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('wishlist.index') }}">
                                            <i class="fa-solid fa-heart"></i>
                                            <span class="badge bg-danger" id="wishlistCount" style="font-size: 10px; vertical-align: super;">{{ $wishlistCount ?? 0 }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/cart">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            <span class="badge bg-danger" id="cartCount">0</span>
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

    <section class="product-section" id="product">
        <div class="container">
            <div class="row">
                <div class="col-sm-12" data-aos="fade-down">
                    <h1>List <span class="clrchange">Products</span></h1>
                </div>
            </div>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-sm-4" data-aos="fade-up">
                        <div class="innerproductsection">
                            <img src="{{ asset($product->foto) }}" alt="{{ $product->nama_produk }}" style="height: 250px; object-fit: cover;" />
                            <div class="cartcontainer">
                                <button class="wishlist" onclick="toggleWishlist({{ $product->id }})"><i class="fa-solid fa-heart"></i></button>
                                <button class="btn" onclick="addToCart({{ $product->id }})"><i class="fa-solid fa-cart-shopping"></i></button>
                                <button class="share" onclick="alert('Fitur Share segera hadir! 🔗')"><i class="fa-solid fa-share"></i></button>
                            </div>
                            <h2>{{ $product->nama_produk }}</h2>
                            <h1 class="price"><span class="clrchange">Rp {{ number_format($product->harga, 0, ',', '.') }}</span></h1>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    

    <footer class="footer">
            <div class="row copy-right">
                <div class="col-sm-12">
                    <p>Dimzzy</span> | 2025</p>
                    <div class="topbtn">
                        <a href="#top-product" class="topbtninner"><i class="fa-solid fa-arrow-up"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <script>
        // Setup CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add to cart function
        function addToCart(productId) {
            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1
                },
                success: function(response) {
                    if (response.success) {
                        alert('Produk berhasil ditambahkan ke keranjang! 🛒');
                        // Update cart badge
                        if (response.cart_count) {
                            $('#cartCount').text(response.cart_count);
                        }
                    } else {
                        alert('Gagal: ' + response.message);
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Terjadi kesalahan saat menambahkan ke keranjang.');
                }
            });
        }

        // Toggle Wishlist Function
        function toggleWishlist(productId) {
            $.ajax({
                url: '/wishlist/toggle',
                method: 'POST',
                data: {
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        // Update wishlist badge
                        if (response.wishlist_count !== undefined) {
                            $('#wishlistCount').text(response.wishlist_count);
                        }
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Terjadi kesalahan saat menambahkan ke wishlist.');
                }
            });
        }

        // Update cart count on page load
        $(document).ready(function() {
            // You can add AJAX call here to get current cart count
        });
    </script>

</body>

</html>