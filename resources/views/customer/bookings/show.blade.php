@extends('layouts.provcust')

@section('content')
<div class="container mt-4">
    <h2>Booking Details</h2>

    <div class="card p-3">
        <p><strong>Service:</strong> {{ $booking->service->name }}</p>
        <p><strong>Provider:</strong> {{ $booking->service->provider->name }}</p>
        <p><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
    </div>

    <a href="{{ route('customer.bookings.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
