@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>Service Details</h1>

    <div class="card mb-3">
        <div class="card-header">{{ $service->name }}</div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $service->description ?? 'No description' }}</p>
            <p><strong>Price:</strong> ${{ $service->price }}</p>
            <p><strong>Category:</strong> {{ $service->category->name ?? 'No Category' }}</p>
            <p><strong>Provider:</strong> {{ $service->provider->name ?? 'N/A' }}</p>
            @if($service->image)
            <p><strong>Image:</strong></p>
            <img src="{{ asset('storage/'.$service->image) }}" width="150">
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
