<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Suggestion System</title>
    <link rel="icon" href="{{ asset('assets/images/1674638155928.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #343a40; color: white; padding: 20px; flex-shrink: 0; }
        .sidebar .nav-link { color: white; text-decoration: none; display: block; padding: 10px; border-radius: .25rem; margin-bottom: .5rem; }
        .sidebar .nav-link i { width: 20px; text-align: center; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #495057; }
        .content { flex-grow: 1; padding: 20px; background-color: #f8f9fa; }
        .navbar { background-color: #ffffff; border-bottom: 1px solid #dee2e6; padding: 10px 20px; display: flex; justify-content: flex-end; align-items: center; }
        .footer { background-color: #f8f9fa; padding: 15px; text-align: center; border-top: 1px solid #dee2e6; margin-top: auto; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 class="text-center mb-4">Admin Panel</h3>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.suggestions.*') ? 'active' : '' }}" href="{{ route('admin.suggestions.index') }}"><i class="fas fa-lightbulb me-2"></i> Kelola Suggestions</a>
            
            {{-- [BARU] Link untuk manajemen departemen --}}
            <a class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}" href="{{ route('admin.departments.index') }}"><i class="fas fa-building me-2"></i> Kelola Departemen</a>
            
            {{-- [BARU] Link untuk manajemen access code --}}
            <a class="nav-link {{ request()->routeIs('admin.access_codes.*') ? 'active' : '' }}" href="{{ route('admin.access_codes.index') }}"><i class="fas fa-key me-2"></i> Kelola Kode Akses</a>

            {{-- Form Logout --}}
            <form action="{{ route('admin.logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-danger w-100"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
            </form>
        </nav>
    </div>

    <div class="d-flex flex-column flex-grow-1">
        <nav class="navbar">
            <div class="navbar-text">Halo, <strong>{{ Auth::user()->name }}</strong></div>
        </nav>
        <main class="content flex-grow-1">
            @yield('content')
        </main>
        <footer class="footer">
            Suggestion System &copy; {{ date('Y') }}
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Font Awesome sudah di-include di CSS, JS tidak selalu perlu --}}
    @stack('scripts')
</body>
</html>