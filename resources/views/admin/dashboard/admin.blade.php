@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Admin Dashboard</h2>

    {{-- ==== إحصائيات ==== --}}
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.services.index') }}" class="text-decoration-none">
                <div class="card bg-primary text-white p-3 shadow-sm hover-scale">
                    <h4>Services</h4>
                    <h2>{{ $servicesCount }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                <div class="card bg-success text-white p-3 shadow-sm hover-scale">
                    <h4>Categories</h4>
                    <h2>{{ $categoriesCount }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.bookings.index') }}" class="text-decoration-none">
                <div class="card bg-warning text-white p-3 shadow-sm hover-scale">
                    <h4>Bookings</h4>
                    <h2>{{ $bookingsCount }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.payments.index') }}" class="text-decoration-none">
                <div class="card bg-danger text-white p-3 shadow-sm hover-scale">
                    <h4>Payments</h4>
                    <h2>{{ $paymentsCount }}</h2>
                </div>
            </a>
        </div>
    </div>

    {{-- ==== آخر الخدمات والتصنيفات ==== --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <h5>Recent Services</h5>
            <ul class="list-group">
                @foreach ($recentServices as $service)
                <li class="list-group-item">{{ $service->name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-6">
            <h5>Recent Categories</h5>
            <ul class="list-group">
                @foreach ($recentCategories as $category)
                <li class="list-group-item">{{ $category->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>


    {{-- ==== جدول الادمن ==== --}}
    <div class="mt-5">
        <h4 class="text-primary">Latest Admins</h4>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $admin)
                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this provider?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No providers found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ==== جدول المزودين ==== --}}
    <div class="mt-5">
        <h4 class="text-primary">Latest Providers</h4>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($providers as $provider)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $provider->name }}</td>
                    <td>{{ $provider->email }}</td>
                    <td>{{ $provider->created_at->format('Y-m-d') }}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $provider->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this provider?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No providers found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ==== جدول العملاء ==== --}}
    <div class="mt-5">
        <h4 class="text-success">Latest Customers</h4>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $customer->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this customer?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No customers found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="mt-5">
        <h5 class="mb-3">Quick Access</h5>
        <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('admin.services.create') }}" class="btn btn-outline-primary">
                ➕ Add New Service
            </a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-success">
                ➕ Add New Category
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-warning">
                📅 Manage Bookings
            </a>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-danger">
                💳 Manage Payments
            </a>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                ⚙️ Admin Profile
            </a>
        </div>
    </div>
</div>
@endsection
