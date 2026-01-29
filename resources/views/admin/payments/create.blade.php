@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Add New Payment</h2>

    <form action="{{ route('admin.payments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Booking</label>
            <select name="booking_id" class="form-control" required>
                <option value="">Select Booking</option>
                @foreach ($bookings as $booking)
                    <option value="{{ $booking->id }}">{{ $booking->service->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="number" name="amount" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="failed">Failed</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <input type="text" name="method" class="form-control" placeholder="Cash / Card / ...">
        </div>

        <button type="submit" class="btn btn-success">Save Payment</button>
    </form>
</div>
@endsection
