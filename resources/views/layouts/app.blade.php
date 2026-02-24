<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ShopX - Your premium online shopping destination in Sri Lanka">
    <title>@yield('title', 'ShopX') | ShopX</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

{{-- ===== ADMIN NAVBAR (only on /admin/* routes) ===== --}}
@if(request()->is('admin*'))
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: #1a1a2e;">
    <div class="container-fluid px-4">
        {{-- Brand --}}
        <a class="navbar-brand fw-bold" href="{{ route('admin.home') }}">
            <i class="bi bi-shield-check text-warning me-1"></i>
            <span class="text-warning">ShopX</span> <span class="text-white opacity-50 small fw-normal">Admin</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNav">
            {{-- Admin Nav Links --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.home') ? 'text-warning' : 'text-white-50' }}" href="{{ route('admin.home') }}">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'text-warning' : 'text-white-50' }}" href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box-seam me-1"></i>Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'text-warning' : 'text-white-50' }}" href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-tags me-1"></i>Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'text-warning' : 'text-white-50' }}" href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-receipt me-1"></i>Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'text-warning' : 'text-white-50' }}" href="{{ route('admin.messages.index') }}">
                        <i class="bi bi-chat-left-text me-1"></i>Messages
                        @php $unreadCount = \App\Models\ContactMessage::where('status', 'unread')->count(); @endphp
                        @if($unreadCount > 0)
                            <span class="badge bg-danger rounded-pill ms-1" style="font-size: 0.6rem;">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            {{-- Admin Right Side --}}
            <ul class="navbar-nav align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link text-white-50 small" href="{{ route('home') }}" target="_blank" title="Open store in new tab">
                        <i class="bi bi-box-arrow-up-right me-1"></i>View Store
                    </a>
                </li>
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                        <div class="avatar-sm" style="background: #e5a81b; color: #000;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><span class="dropdown-item-text text-muted small">Signed in as admin</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- ===== CUSTOMER NAVBAR (hidden for admin on admin pages) ===== --}}
@else
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
            <i class="bi bi-bag-heart-fill text-warning"></i> ShopX
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shop.*') ? 'active' : '' }}" href="{{ route('shop.index') }}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>

            <form class="d-flex my-2 my-lg-0 me-lg-3" action="{{ route('shop.index') }}" method="GET" id="search-form">
                <div class="input-group input-group-sm w-100">
                    <input class="form-control rounded-start" type="search" name="q" id="search-input" placeholder="Search products..." value="{{ request('q') }}">
                    <button class="btn btn-warning btn-sm" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <ul class="navbar-nav align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link position-relative px-2" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart3 fs-5"></i>
                        @php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size:0.6rem">{{ $cartCount }}</span>
                        @endif
                    </a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 py-2" href="#" data-bs-toggle="dropdown">
                            <div class="avatar-sm" style="width: 30px; height: 30px; font-size: 0.7rem;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                            <span class="d-inline-block text-truncate" style="max-width: 120px;">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.orders') }}"><i class="bi bi-bag-check me-2"></i>My Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.wishlist') }}"><i class="bi bi-heart me-2"></i>Wishlist</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            @if(auth()->user()->is_admin)
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger fw-semibold" href="{{ route('admin.home') }}"><i class="bi bi-shield-check me-2"></i>Admin Panel</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-warning btn-sm ms-1 px-3" href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
@endif


@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-0 rounded-0 text-center py-2" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0 text-center py-2" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
@endif

<main>@yield('content')</main>

@if(request()->is('admin*'))
<footer class="py-3 border-top mt-5" style="background: #1a1a2e;">
    <div class="container text-center">
        <p class="text-muted small mb-0">&copy; {{ date('Y') }} ShopX Admin Panel. <a href="{{ route('home') }}" class="text-warning text-decoration-none" target="_blank">View Store &rarr;</a></p>
    </div>
</footer>
@else
<footer class="footer-section mt-5 py-4">
    <div class="container">
        <div class="row gy-3">
            <div class="col-md-4">
                <h5 class="fw-bold text-warning"><i class="bi bi-bag-heart-fill"></i> ShopX</h5>
                <p class="text-muted small">Your trusted online shopping destination in Sri Lanka.</p>
            </div>
            <div class="col-md-4">
                <h6 class="fw-semibold text-white">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                    <li><a href="{{ route('shop.index') }}" class="footer-link">Shop</a></li>
                    <li><a href="{{ route('cart.index') }}" class="footer-link">Cart</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="fw-semibold text-white">My Account</h6>
                <ul class="list-unstyled small">
                    @auth
                        <li><a href="{{ route('dashboard.orders') }}" class="footer-link">My Orders</a></li>
                        <li><a href="{{ route('dashboard.profile') }}" class="footer-link">Profile</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="footer-link">Login</a></li>
                        <li><a href="{{ route('register') }}" class="footer-link">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
        <hr class="border-secondary">
        <p class="text-center text-muted small mb-0">&copy; {{ date('Y') }} ShopX. All rights reserved.</p>
    </div>
</footer>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
