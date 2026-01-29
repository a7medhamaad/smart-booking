@extends('layouts.provcust')

@section('content')
<div class="container mt-4">
    <h2>My Bookings</h2>

    <a href="{{ route('customer.bookings.create') }}" class="btn btn-primary mb-3">Book New Service</a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Service</th>
                <th>Provider</th>
                <th>Booking Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->service->name }}</td>
                    <td>{{ $booking->service->provider->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                    <td>
                        <a href="{{ route('customer.bookings.show', $booking->id) }}" class="btn btn-info btn-sm">View</a>
                        <form action="{{ route('customer.bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No bookings found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
