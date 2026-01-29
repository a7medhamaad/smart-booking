@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">🛠️ All Services</h1>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Add New Service
    </a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Provider</th>
                <th>Status</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $service->name }}</td>
                <td>${{ number_format($service->price, 2) }}</td>
                <td>{{ $service->category->name ?? 'No Category' }}</td>
                <td>{{ $service->provider->name ?? 'N/A' }}</td>
                <td>
                    @if($service->is_approved)
                    <span class="badge bg-success">Approved</span>
                    @else
                    <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>
                <td>
                    @if($service->image)
                    <img src="{{ asset('storage/'.$service->image) }}" width="60" class="rounded shadow-sm">
                    @else
                    <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>
                    {{-- View --}}
                    <a href="{{ route('admin.services.show', $service->id) }}" class="btn btn-info btn-sm mb-1">
                        <i class="bi bi-eye"></i> View
                    </a>

                    {{-- Edit --}}
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-warning btn-sm mb-1">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    {{-- Approve (if pending) --}}
                    @if(!$service->is_approved)
                    <form action="{{ route('admin.services.approve', $service->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm mb-1">
                            <i class="bi bi-check-circle"></i> Approve
                        </button>
                    </form>
                    @endif

                    {{-- Delete --}}
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm mb-1"
                            onclick="return confirm('Are you sure you want to delete this service?')">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
