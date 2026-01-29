@extends('layouts.provcust')

@section('content')
<div class="container mt-4">
    <h2>Book New Service</h2>

    <form action="{{ route('customer.bookings.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="service_id" class="form-label">Select Service</label>
            <select name="service_id" id="service_id" class="form-control">
                <option value="">-- Select Service --</option>
                @foreach($services as $service)
                <option value="{{ $service->id }}" {{ old('service_id')==$service->id ? 'selected' : '' }}>
                    {{ $service->name }} - {{ $service->provider->name }}
                </option>
                @endforeach
            </select>
            @error('service_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="booking_date" class="form-label">Booking Date</label>
            <input type="date" name="booking_date" id="booking_date" class="form-control"
                value="{{ old('booking_date') }}">
            @error('booking_date')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success">Create Booking</button>
        <a href="{{ route('customer.bookings.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
