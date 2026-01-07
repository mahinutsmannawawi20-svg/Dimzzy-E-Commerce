@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Coupons</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Player</th>
                        <th>Game</th>
                        <th>Score</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Expires At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                    <tr>
                        <td><code>{{ $coupon->code }}</code></td>
                        <td>{{ $coupon->player_name }}</td>
                        <td>{{ ucfirst($coupon->game_type) }}</td>
                        <td>{{ $coupon->score }}</td>
                        <td>{{ $coupon->discount_percentage }}%</td>
                        <td>
                            @if($coupon->is_used)
                                <span class="badge bg-secondary">Used</span>
                            @elseif($coupon->expired_at && $coupon->expired_at->isPast())
                                <span class="badge bg-danger">Expired</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->expired_at)
                                {{ $coupon->expired_at->format('d M Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">No coupons found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $coupons->links() }}
    </div>
</div>
@endsection
