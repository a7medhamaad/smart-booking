@extends('layouts.provcust')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Service Details</h2>

    <div class="card">
        <div class="card-body">
            <h4>Name: {{ $service->name }}</h4>
            <p>Category: {{ $service->category->name ?? 'N/A' }}</p>
            @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" width="150">
            @endif
        </div>
    </div>

    <a href="{{ route('provider.services.index') }}" class="btn btn-secondary mt-3">Back to Services</a>
</div>
@endsection
