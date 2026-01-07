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
    <title>Dimzzy</title>
</head>

<body>
    <div class="topbar">
        <marquee direction="left" loop="" behavior=scroll class="marque" bgcolor="#000000">Dimsum + Keju = Dimzzy!  
        Setiap Gigitan Lumer, Setiap Suapan Bikin Nagih! | Yang Beli Dimsum Auto Sigma Loh Ya | Mas Rusdi Pernah Beli Mojito Disini
        | Katanya Sayang, Kok Ga Beliin Pacarnya Mojito Sih | Cintaku Hanya Sebatas Dimsum Keju | Musmid Keju</marquee>
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
                                        <a class="nav-link" href="#">Beranda</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#about">Tentang</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#product">Produk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#review">Tim Dimzzy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#contact">Hubungi Kami</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('minigames') }}">Mini Games</a>
                                    </li>
                                </ul>

                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i class="fa-solid fa-heart"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i class="fa-solid fa-user"></i></a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

        </div>
    </header>

    <section class="section1" id="top">
        <div class="container">
            <div class="row" data-aos="fade-right">
                <div class="col-sm-12">
                    <h1>Dimsum + Keju = Dimzzy!</h1>
                    <h2>Goreng, Leleh, Mantap!</h2>
                    <p>Dimsum goreng keju yang renyah di luar, meleleh di dalam. Pesan sekarang dan rasakan kenikmatannya!</p>
                    <a href="#" class="links">Beli Sekarang</a>
                </div>
            </div>
        </div>
    </section>
    <section class="section2" id="about">
        <div class="container">
            <div class="row">
                <div class="col-sm-12" data-aos="fade-down">
                    <h1 class="mainheading"><span class="clrchange">Tentang</span> Dimzzy</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6" data-aos="fade-right">
                    <img src="{{ asset('images/dimzzy_intro.png') }}" alt="Intro Image" id="img-1" style="width: 100%; border-radius: 15px;">
                </div>
                <div class="col-sm-6" data-aos="fade-left">
                    <h2>Kenapa Harus Cobain Dimzzy</h2>
                    <p>Di Dimzzy, kami menyajikan dimsum goreng keju yang lezat dan menggoda. Dari kampus untuk kampus, setiap gigitan penuh rasa dan keju meleleh yang bikin nagih.</p>
                    <a href="#" class="links">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section4" id="product">
        <div class="container">
            <div class="row">
                <div class="col-sm-12" data-aos="fade-down">
                    <h1>Our <span class="clrchange">Products</span></h1>
                </div>
            </div>
            <div class="row">
                @forelse($products as $product)
                <div class="col-sm-4" data-aos="fade-up">
                    <div class="innerproductsection">
                        <img src="{{ asset($product->foto) }}" alt="{{ $product->nama_produk }}" style="height: 250px; object-fit: cover;" />
                        <div class="cartcontainer">
                            <button class="wishlist"><i class="fa-solid fa-heart"></i></button>
                            <button class="btn" onclick="addToCart({{ $product->id }})">Tambah ke Keranjang <i class="fa-solid fa-cart-plus"></i></button>
                            <button class="share"><i class="fa-solid fa-share"></i></button>
                        </div>

                        <h2>{{ $product->nama_produk }}</h2>
                        <h1 class="price"><span class="clrchange">Rp {{ number_format($product->harga, 0, ',', '.') }}</span></h1>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p>Belum ada produk yang tersedia.</p>
                </div>
                @endforelse
            </div>
            <a href="{{ url('/produk') }}" class="btn btn-danger m-3 d-block mx-auto" style="width: fit-content;">
                Show More Products
            </a>
    </section>

    <section class="section5" id="review">
        <div class="container">
            <div class="row">
                <div class="col-sm-12" data-aos="fade-down">
                    <h1 class="mainheading">Tim <span class="clrchange">Dimzzy</span></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="owl-carousel client-testimonial-carousel">
                        <div class="single-testimonial-item">
                            <div class="reviewinner">
                                <ul class="ratings">
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <p>Memimpin Dimzzy untuk menghadirkan dimsum goreng keju yang selalu fresh, lezat, dan bikin ketagihan.</p>
                                <div class="txtwithicon">
                                    <div class="iconcol">
                                        <img src="{{ asset('assets/Ari.png') }}" alt="" class="testimg1">
                                    </div>
                                    <div class="txtcol">
                                        <h1>Alfansuri Akhyar</h1>
                                        <p>CEO</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-testimonial-item">
                            <div class="reviewinner">

                                <ul class="ratings">
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <p>Memastikan setiap orang tahu Dimzzy itu enak dan selalu bikin penasaran lewat strategi marketing kreatif.</p>
                                <div class="txtwithicon">
                                    <div class="iconcol">
                                        <img src="{{ asset('assets/Gray.png') }}" alt="" class="testimg1">
                                    </div>
                                    <div class="txtcol">
                                        <h1>Margaretha Gratia</h1>
                                        <p>CMO</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-testimonial-item">
                            <div class="reviewinner">

                                <ul class="ratings">
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <p>Bertanggung jawab memastikan setiap produk Dimzzy punya kualitas terbaik dan konsisten di setiap gigitan.</p>
                                <div class="txtwithicon">
                                    <div class="iconcol">
                                        <img src="{{ asset('assets/Najma.png') }}" alt="" class="testimg1">
                                    </div>
                                    <div class="txtcol">
                                        <h1>Najma</h1>
                                        <p>CPO</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-testimonial-item">
                            <div class="reviewinner">

                                <ul class="ratings">
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <p>Mengatur desain & konsep Dimzzy agar tampil menarik, cozy, dan mudah diingat pelanggan </p>
                                <div class="txtwithicon">
                                    <div class="iconcol">
                                        <img src="{{ asset('assets/Nanas.png') }}" alt="" class="testimg1">
                                    </div>
                                    <div class="txtcol">
                                        <h1>Nasywa Azizah K</h1>
                                        <p>CPO</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-testimonial-item">
                            <div class="reviewinner">

                                <ul class="ratings">
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <p>Bekerja menjaga kepuasan pelanggan dan komunikasi agar pengalaman menikmati Dimzzy selalu menyenangkan.</p>
                                <div class="txtwithicon">
                                    <div class="iconcol">
                                        <img src="{{ asset('assets/Vera.png') }}" alt="" class="testimg1">
                                    </div>
                                    <div class="txtcol">
                                        <h1>Jasmine Xaviera</h1>
                                        <p>CCO</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section6" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-sm-12" data-aos="fade-down">
                    <h1 class="mainheading">
                        <span class="clrchange">
                            Hubungi
                        </span>
                        Kami
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6" data-aos="fade-right">
                   <form id="whatsappForm" onsubmit="sendToWhatsApp(event)">
                        <input type="text" id="nama" placeholder="Nama" required>
                        <input type="text" id="alamat" placeholder="Alamat Lengkap" required>
                        <textarea id="pesan" placeholder="Pesanan Anda" cols="30" rows="10" required></textarea>
                        <button type="submit" class="submit">Kirim Pesan</button>
                    </form>


                </div>
                <div class="col-sm-6" data-aos="fade-left">
                    <img src="{{ asset('assets/Dimzzy.jpg') }}" alt="Contact img" class="contactimg">
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
            <div class="row copy-right">
                <div class="col-sm-12">
                    <p>Dimzzy</span> | 2025</p>
                    <div class="topbtn">
                        <a href="#top" class="topbtninner"><i class="fa-solid fa-arrow-up"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- jQuery Must be Full Version for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    
    <!-- Custom CSS to Fix Mobile Buttons -->
    <style>
        /* Force Buttons to be Top Layer */
        .cartcontainer {
            z-index: 1000 !important;
            position: relative;
        }
        .innerproductsection {
            z-index: 1; /* Establish stacking context */
        }
        
        /* On Mobile, keep buttons visible */
        @media (max-width: 768px) {
            section.section4 .col-sm-4 .innerproductsection .cartcontainer {
                opacity: 1 !important;
                bottom: 10px !important;
            }
        }
    </style>
    
    <script>
        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add to Cart Function
        function addToCart(productId) {
            $.ajax({
                url: '/cart/add',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1
                },
                success: function(response) {
                    if (response.success) {
                        alert('Produk berhasil ditambahkan ke keranjang! 🛒');
                        // Optional: Update cart badge if you have one
                        // $('#cartCount').text(response.cart_count);
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
    </script>
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
function sendToWhatsApp(event) {
  event.preventDefault();

  const nama   = document.getElementById('nama').value.trim();
  const alamat = document.getElementById('alamat').value.trim();
  const pesan  = document.getElementById('pesan').value.trim();

  // 🟢 Ganti dengan nomor WhatsApp kamu (tanpa +, contoh 6281234567890)
  const adminPhone = '6283873397411';

  // Format pesan ke WhatsApp
  const text = 
    `Halo, saya ingin memesan 😊\n\n` +
    `Nama: ${nama}\n` +
    `Alamat: ${alamat}\n` +
    `Pesanan:\n${pesan}`;

  const waUrl = `https://wa.me/${adminPhone}?text=${encodeURIComponent(text)}`;

  // Arahkan ke WhatsApp
  window.location.href = waUrl;
}
</script>



</body>

</html>