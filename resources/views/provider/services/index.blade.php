@extends('layouts.provcust')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">My Services</h2>
        <a href="{{ route('provider.services.create') }}" class="btn btn-success shadow-sm">
            + Add New Service
        </a>
    </div>

    {{-- ✅ Success Message --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- ✅ Services Table --}}
    <div class="card shadow border-0">
        <div class="card-body p-0">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $index => $service)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold text-start">{{ $service->name }}</td>
                        <td>{{ $service->category->name ?? 'N/A' }}</td>
                        <td class="text-success fw-bold">${{ number_format($service->price, 2) }}</td>
                        <td class="text-muted text-start" style="max-width: 250px;">
                            {{ Str::limit($service->description, 50, '...') }}
                        </td>
                        <td>
                            @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="Service Image"
                                class="rounded shadow-sm" width="70" height="70" style="object-fit: cover;">
                            @else
                            <span class="text-secondary">No Image</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('provider.services.show', $service->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('provider.services.edit', $service->id) }}"
                                class="btn btn-sm btn-warning text-white">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('provider.services.destroy', $service->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-exclamation-circle"></i> No services found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
