@extends('layouts.provcust')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">💰 My Service Payments</h2>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Customer</th>
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
                    <td colspan="7" class="text-center text-muted">No payments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $payments->links() }}
    </div>
</div>
@endsection
