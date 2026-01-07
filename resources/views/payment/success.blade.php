<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Pembayaran Berhasil - Dimzzy</title>
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .success-card { margin-top: 100px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center shadow-lg success-card">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <i class="fa-solid fa-check-circle text-success" style="font-size: 100px;"></i>
                        </div>
                        
                        <h2 class="mb-3">Pembayaran Berhasil!</h2>
                        <p class="lead text-muted">Terima kasih atas pembelian Anda di Dimzzy</p>
                        
                        <div class="alert alert-success mt-4">
                            <div class="row">
                                <div class="col-6 text-start">
                                    <strong>No. Order:</strong><br>
                                    <span class="text-muted">{{ $order->order_number }}</span>
                                </div>
                                <div class="col-6 text-end">
                                    <strong>Total Bayar:</strong><br>
                                    <span class="text-success fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded mb-4">
                            <p class="mb-2"><strong>Detail Pesanan:</strong></p>
                            @foreach($order->items as $item)
                                <div class="d-flex justify-content-between mb-1">
                                    <span>{{ $item['nama_produk'] }} ({{ $item['quantity'] }}x)</span>
                                    <span>Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <p class="text-muted">
                            <i class="fa-solid fa-envelope"></i> Konfirmasi pesanan telah dikirim ke email Anda
                        </p>

                        <div class="mt-4 d-grid gap-2">
                            <a href="/produk" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-shopping-bag"></i> Belanja Lagi
                            </a>
                            <a href="/" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-home"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
