@extends('layouts.provcust')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📅 My Service Bookings</h2>

    @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($bookings->isEmpty())
    <div class="alert alert-info text-center">
        No bookings found.
    </div>
    @else
    <table class="table table-bordered table-striped align-middle shadow-sm">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Service</th>
                <th>Booking Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach($bookings as $index => $booking)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $booking->user->name ?? 'Unknown' }}</td>
                <td>{{ $booking->service->name ?? 'Deleted Service' }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</td>
                <td>
                    @if($booking->status == 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($booking->status == 'confirmed')
                    <span class="badge bg-success">Confirmed</span>
                    @elseif($booking->status == 'cancelled')
                    <span class="badge bg-danger">Cancelled</span>
                    @else
                    <span class="badge bg-secondary">Completed</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('provider.bookings.show', $booking->id) }}" class="btn btn-sm btn-info">
                        View
                    </a>

                    @if($booking->status != 'cancelled' && $booking->status != 'completed')
                    <form action="{{ route('provider.bookings.destroy', $booking->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Cancel</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
