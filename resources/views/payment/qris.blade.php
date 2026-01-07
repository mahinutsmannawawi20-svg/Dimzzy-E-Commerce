<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Pembayaran QRIS - {{ $order->order_number }}</title>
    <style>
        body { background: #f5f5f5; }
        .qris-container {
            max-width: 550px;
            margin: 50px auto;
        }
        .qris-image {
            width: 100%;
            max-width: 350px;
            border: 3px solid #007bff;
            border-radius: 15px;
            padding: 15px;
            background: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .status-checking {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        .instruction-list {
            text-align: left;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="qris-container">
            <div class="card shadow">
                <div class="card-body text-center p-4">
                    <h3 class="mb-4"><i class="fa-solid fa-qrcode"></i> Scan QRIS untuk Bayar</h3>
                    
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-6 text-start">
                                <strong>Order:</strong><br>
                                <span class="text-muted">{{ $order->order_number }}</span>
                            </div>
                            <div class="col-6 text-end">
                                <strong>Total:</strong><br>
                                <span class="text-primary fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <img src="{{ $paymentData['qris_image'] }}" alt="QRIS" class="qris-image">
                    </div>
                    
                    <div class="alert alert-warning status-checking" id="statusAlert">
                        <i class="fa-solid fa-spinner fa-spin"></i> Menunggu pembayaran...
                    </div>

                    <p class="text-muted mb-4">
                        <i class="fa-solid fa-clock"></i> Berlaku hingga: <strong>{{ \Carbon\Carbon::parse($paymentData['expired'])->format('d M Y H:i') }}</strong>
                    </p>

                    <div class="instruction-list">
                        <p class="fw-bold mb-2"><i class="fa-solid fa-info-circle"></i> Cara Bayar:</p>
                        <ol class="mb-0">
                            <li>Buka aplikasi e-wallet/m-banking Anda (GoPay, OVO, Dana, dll)</li>
                            <li>Pilih menu <strong>Scan QRIS</strong></li>
                            <li>Arahkan kamera ke kode QR di atas</li>
                            <li>Periksa detail pembayaran</li>
                            <li>Konfirmasi pembayaran</li>
                        </ol>
                    </div>

                    <div class="mt-3">
                        <a href="/cart" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Auto check payment status every 3 seconds
        let checkInterval = setInterval(function() {
            $.ajax({
                url: '{{ route("payment.checkStatus", $order->id) }}',
                method: 'GET',
                success: function(response) {
                    if (response.success && response.status === 'paid') {
                        clearInterval(checkInterval);
                        $('#statusAlert').removeClass('alert-warning status-checking')
                                       .addClass('alert-success')
                                       .html('<i class="fa-solid fa-check-circle"></i> Pembayaran Berhasil! Mengalihkan...');
                        
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000);
                    }
                },
                error: function() {
                    console.log('Error checking status');
                }
            });
        }, 3000);

        // Stop checking after 15 minutes
        setTimeout(function() {
            clearInterval(checkInterval);
            $('#statusAlert').removeClass('alert-warning status-checking')
                           .addClass('alert-danger')
                           .html('<i class="fa-solid fa-times-circle"></i> Waktu pembayaran habis. Silakan buat pesanan baru.');
        }, 900000);
    </script>
</body>
</html>
