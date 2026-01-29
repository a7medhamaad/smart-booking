@extends('layouts.provcust')

@section('page-title', 'Provider Dashboard')

@section('content')
<div class="row text-center">
    <div class="col-md-6 mb-3">
        <a href="{{ route('provider.services.index') }}" class="text-decoration-none">
            <div class="card card-custom bg-primary text-white p-3">
                <h4>My Services</h4>
                <h2>{{ $services->count() }}</h2>
            </div>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <a href="{{ route('provider.bookings.index') }}" class="text-decoration-none">
            <div class="card card-custom bg-success text-white p-3">
                <h4>My Bookings</h4>
                <h2>{{ $bookings->count() }}</h2>
            </div>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <a href="{{ route('provider.payments.index') }}" class="text-decoration-none">
            <div class="card card-custom bg-success text-white p-3">
                <h4>My Payments</h4>
                <h2>{{ $payments->count() }}</h2>
            </div>
        </a>
    </div>

</div>


{{-- جدول الخدمات --}}
<h4 class="mt-4">My Services</h4>
<table class="table table-striped table-bordered mt-2">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Category</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($services as $index => $service)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $service->name }}</td>
            <td>{{ $service->category->name ?? 'N/A' }}</td>
            <td>{{ $service->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- جدول الحجوزات --}}
<h4 class="mt-4">My Bookings</h4>
<table class="table table-striped table-bordered mt-2">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Service</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Booked At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $index => $booking)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $booking->service->name ?? 'N/A' }}</td>
            <td>{{ $booking->user->name ?? 'N/A' }}</td>
            <td>{{ ucfirst($booking->status) }}</td>
            <td>{{ $booking->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
