<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-custom {
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar p-3">
            <h4 class="text-white mb-4">{{ ucfirst(Auth::user()->role) }} Menu</h4>
            @if(Auth::user()->role === 'provider')
            <a href="{{ route('provider.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            @elseif(Auth::user()->role === 'customer')
            <a href="{{ route('customer.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            @endif

            @if(Auth::user()->role === 'provider')
            <a href="{{ route('provider.services.index') }}">My Services</a>
            <a href="{{ route('provider.bookings.index') }}">My Bookings</a>
            @elseif(Auth::user()->role === 'customer')
            <a href="{{ route('customer.bookings.create') }}">Book Service</a>
            <a href="{{ route('customer.bookings.index') }}">My Bookings</a>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        {{-- Main Content --}}
        <div class="flex-fill p-4">
            <h2 class="mb-4">@yield('page-title', 'Dashboard')</h2>
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @yield('content')

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
