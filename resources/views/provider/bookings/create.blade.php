@extends('layouts.provcust')

@section('content')
<h2 class="mb-4">Add New Booking</h2>

<form action="{{ route('provider.bookings.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="service_id" class="form-label">Service</label>
        <select name="service_id" id="service_id" class="form-control">
            @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>
        @error('service_id')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="booking_date" class="form-label">Booking Date</label>
        <input type="date" name="booking_date" id="booking_date" class="form-control" value="{{ old('booking_date') }}">
        @error('booking_date')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-control">
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="cancelled">Cancelled</option>
            <option value="completed">Completed</option>
        </select>
        @error('status')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <button type="submit" class="btn btn-success">Create Booking</button>
    <a href="{{ route('provider.bookings.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
