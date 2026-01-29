@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Booking Details</h2>

    <ul class="list-group">
        <li class="list-group-item"><strong>ID:</strong> {{ $booking->id }}</li>
        <li class="list-group-item"><strong>Service:</strong> {{ $booking->service->name ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>User:</strong> {{ $booking->user->name ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Date:</strong> {{ $booking->booking_date }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($booking->status) }}</li>
    </ul>

    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
