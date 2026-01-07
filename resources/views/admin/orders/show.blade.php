@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Order #{{ $order->order_number }}</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to List</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(is_array($order->items))
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item['name'] ?? 'Unknown Product' }}</td>
                                    <td>Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $item['quantity'] ?? 0 }}</td>
                                    <td class="text-end">Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Subtotal</td>
                                <td class="text-end">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @if($order->discount_amount > 0)
                            <tr>
                                <td colspan="3" class="text-end text-success">Discount ({{ $order->coupon_code }})</td>
                                <td class="text-end text-success">-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            <tr class="table-light fw-bold">
                                <td colspan="3" class="text-end">Total Amount</td>
                                <td class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Customer Details</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong></p>
                <p>{{ $order->customer_name }}</p>
                
                <p class="mb-1"><strong>Email:</strong></p>
                <p>{{ $order->customer_email }}</p>
                
                <p class="mb-1"><strong>Phone:</strong></p>
                <p>{{ $order->customer_phone }}</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Payment Info</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="fw-bold">Current Status:</label>
                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning text-dark' : 'secondary') }} fs-6 ms-2">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>

                @if($order->yogateway_trxid)
                <div class="mb-3">
                    <small class="text-muted">Transaction ID:</small><br>
                    <code>{{ $order->yogateway_trxid }}</code>
                </div>
                @endif
                
                @if($order->qris_image_url)
                <div class="mb-3">
                    <a href="{{ $order->qris_image_url }}" target="_blank" class="btn btn-sm btn-outline-info w-100">
                        <i class="fas fa-qrcode"></i> View QRIS Image
                    </a>
                </div>
                @endif

                <hr>
                
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Update Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
