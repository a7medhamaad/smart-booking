@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Payment Details</h2>

    <div class="card mt-3">
        <div class="card-body">
            <h5><strong>Booking ID:</strong> {{ $payment->booking->id ?? '—' }}</h5>
            <p><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
            <p><strong>Status:</strong>
                <span class="badge
                    @if($payment->status == 'pending') bg-warning
                    @elseif($payment->status == 'paid') bg-success
                    @else bg-danger @endif">
                    {{ ucfirst($payment->status) }}
                </span>
            </p>
            <p><strong>Method:</strong> {{ $payment->method ?? 'N/A' }}</p>
            <p><strong>Created At:</strong> {{ $payment->created_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary mt-3">Back</a>
    <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-info mt-3">Edit</a>
</div>
@endsection
