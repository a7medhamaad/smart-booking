@extends('layouts.provcust')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Edit Booking</h2>

    <div class="card shadow-sm p-4">
        <form action="{{ route('provider.bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Service</label>
                <input type="text" class="form-control" value="{{ $booking->service->name ?? 'Deleted' }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Customer</label>
                <input type="text" class="form-control" value="{{ $booking->user->name ?? 'Unknown' }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Booking Date</label>
                <input type="text" class="form-control" value="{{ $booking->booking_date->format('Y-m-d') }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="text-center">
                <button class="btn btn-success px-4">Update Booking</button>
                <a href="{{ route('provider.bookings.index') }}" class="btn btn-secondary px-4">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
