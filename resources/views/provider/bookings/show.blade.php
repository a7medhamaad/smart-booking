@extends('layouts.provcust')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Booking Details</h2>

    <div class="card shadow-sm p-4">
        <div class="mb-3">
            <label class="form-label fw-bold">Service Name:</label>
            <p>{{ $booking->service->name ?? 'Deleted Service' }}</p>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Customer:</label>
            <p>{{ $booking->user->name ?? 'Unknown User' }}</p>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Booking Date:</label>
            <p>{{ $booking->booking_date->format('Y-m-d') }}</p>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Status:</label>
            @php
            $badge = match($booking->status) {
            'pending' => 'warning',
            'confirmed' => 'primary',
            'cancelled' => 'danger',
            'completed' => 'success',
            default => 'secondary',
            };
            @endphp
            <span class="badge bg-{{ $badge }}">{{ ucfirst($booking->status) }}</span>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Created At:</label>
            <p>{{ $booking->created_at->diffForHumans() }}</p>
        </div>

        <div class="text-center">
            <a href="{{ route('provider.bookings.edit', $booking->id) }}" class="btn btn-warning px-4">Edit</a>
            <a href="{{ route('provider.bookings.index') }}" class="btn btn-secondary px-4">Back</a>
        </div>
    </div>
</div>
@endsection
