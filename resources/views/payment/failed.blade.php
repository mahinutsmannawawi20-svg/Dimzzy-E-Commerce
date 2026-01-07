<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Pembayaran Gagal - Dimzzy</title>
    <style>
        body { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); min-height: 100vh; }
        .failed-card { margin-top: 100px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center shadow-lg failed-card">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <i class="fa-solid fa-times-circle text-danger" style="font-size: 100px;"></i>
                        </div>
                        
                        <h2 class="mb-3">Pembayaran Gagal</h2>
                        <p class="lead text-muted">Maaf, terjadi kesalahan dalam proses pembayaran</p>
                        
                        @if(session('error'))
                            <div class="alert alert-danger mt-4">
                                <i class="fa-solid fa-exclamation-triangle"></i> {{ session('error') }}
                            </div>
                        @endif

                        <div class="bg-light p-4 rounded mb-4">
                            <p class="mb-2"><strong>Kemungkinan Penyebab:</strong></p>
                            <ul class="text-start mb-0">
                                <li>Koneksi internet terputus</li>
                                <li>Saldo e-wallet tidak mencukupi</li>
                                <li>Pembayaran dibatalkan</li>
                                <li>Waktu pembayaran habis</li>
                            </ul>
                        </div>

                        <div class="mt-4 d-grid gap-2">
                            <a href="/cart" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-arrow-left"></i> Kembali ke Keranjang
                            </a>
                            <a href="/produk" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-shopping-bag"></i> Lanjut Belanja
                            </a>
                            <a href="/" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-home"></i> Ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
