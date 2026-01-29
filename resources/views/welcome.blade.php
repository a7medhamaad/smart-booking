<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Booking - Welcome</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            scroll-behavior: smooth;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-weight: 700;
            color: #fff !important;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-link:hover {
            color: #ffd43b !important;
            transform: scale(1.05);
        }

        /* Hero */
        .hero {
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 1%, transparent 60%);
            animation: pulse 6s infinite linear;
            pointer-events: none;
        }

        @keyframes pulse {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            z-index: 1;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 30px;
            z-index: 1;
        }

        /* Services */
        .services {
            padding: 80px 0;
            background: #fff;
        }

        .service-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .service-card img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .service-card .card-body {
            text-align: center;
            padding: 1.5rem;
        }

        .service-card .price {
            color: #28a745;
            font-weight: 600;
            margin-top: 10px;
        }

        /* CTA */
        .cta {
            background: linear-gradient(135deg, #2575fc 0%, #6a11cb 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta h2 {
            font-weight: 700;
        }

        footer {
            background: #111;
            color: #ccc;
            text-align: center;
            padding: 20px 0;
        }
    </style>
</head>

<body>

    <!-- 🌐 Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Smart Booking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon text-white">☰</span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                    @if(auth()->user()->role == 'admin')
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    @elseif(auth()->user()->role == 'provider')
                    <li class="nav-item"><a class="nav-link" href="{{ route('provider.dashboard') }}">Dashboard</a></li>
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                    @endif
                    <li class="nav-item ms-3">
                        <form action="{{ route('logout') }}" method="POST">@csrf
                            <button type="submit" class="btn btn-warning btn-sm">Logout</button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- 💫 Hero -->
    <section class="hero text-center py-5 bg-dark text-white">
        <div class="container">
            <h1 class="mb-3">
                Welcome to <span class="text-warning">Smart Booking</span>
            </h1>
            <p class="lead mb-4">Book trusted services — quick, easy, and smart.</p>

            @auth
            @switch(auth()->user()->role)
            @case('admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-lg px-4">
                <i class="bi bi-speedometer2 me-2"></i> Go to Admin Dashboard
            </a>
            @break

            @case('provider')
            <a href="{{ route('provider.dashboard') }}" class="btn btn-warning btn-lg px-4">
                <i class="bi bi-briefcase-fill me-2"></i> Go to Provider Dashboard
            </a>
            @break

            @default
            <a href="{{ route('customer.dashboard') }}" class="btn btn-warning btn-lg px-4">
                <i class="bi bi-person-circle me-2"></i> Go to My Dashboard
            </a>
            @endswitch
            @else
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg me-2 px-4">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </a>
            <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-4">
                <i class="bi bi-person-plus-fill me-2"></i> Get Started
            </a>
            @endauth
        </div>
    </section>

    <!-- 🧰 Services -->
    <section class="services">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Popular Services</h2>
                <p class="text-muted">Explore our most booked and trusted services</p>
            </div>

            <div class="row g-4">
                @forelse($services as $service)
                <div class="col-md-4">
                    <div class="card service-card">
                        <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://via.placeholder.com/400x200?text=No+Image' }}"
                            alt="Service Image">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $service->name }}</h5>
                            <p class="text-muted">{{ Str::limit($service->description, 80) }}</p>
                            <p class="price">${{ number_format($service->price, 2) }}</p>

                            @auth
                            <a href="{{ route('customer.bookings.create') }}" class="btn btn-primary w-100">Book Now</a>

                            @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Login to Book</a>
                            @endauth
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted">
                    <p>No services available right now.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 🚀 CTA -->
    <section class="cta">
        <div class="container">
            <h2 class="fw-bold mb-3">Ready to get started?</h2>
            <p class="mb-4">Join Smart Booking today and make your life simpler.</p>

            @guest
            <a href="{{ route('register') }}" class="btn btn-warning btn-lg me-2">Sign Up</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Login</a>
            @else
            <a href="{{ route('home') }}" class="btn btn-light btn-lg">Go to Dashboard</a>
            @endguest
        </div>
    </section>

    <!-- ⚙️ Footer -->
    <footer>
        <p>© {{ date('Y') }} Smart Booking. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
