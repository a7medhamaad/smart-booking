@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">💳 Payments Overview</h2>

    {{-- 📊 إجمالي المبالغ لكل Provider --}}
    @php
        $totalPerProvider = $payments->groupBy('provider_id')->map(function ($group) {
            return $group->sum('amount');
        });
    @endphp

    @if($totalPerProvider->count() > 0)
    <div class="row mb-4">
        @foreach($totalPerProvider as $providerId => $total)
            @php
                $provider = \App\Models\User::find($providerId);
            @endphp
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $provider->name ?? 'Unknown Provider' }}</h5>
                        <p class="text-muted mb-1">Total Earnings</p>
                        <h4 class="text-success fw-bold">${{ number_format($total, 2) }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    {{-- 🧾 جدول المدفوعات --}}
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Provider</th>
                <th>Service</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Transaction ID</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->user->name ?? 'Unknown' }}</td>
                <td>{{ $payment->provider->name ?? 'Unknown' }}</td>
                <td>{{ $payment->service->name ?? 'Deleted Service' }}</td>
                <td>${{ number_format($payment->amount, 2) }}</td>
                <td>
                    @if($payment->status == 'success')
                    <span class="badge bg-success">Success</span>
                    @elseif($payment->status == 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                    @else
                    <span class="badge bg-danger">Failed</span>
                    @endif
                </td>
                <td>{{ $payment->transaction_id ?? '-' }}</td>
                <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted">No payments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $payments->links() }}
    </div>
</div>
@endsection
