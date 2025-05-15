<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Dashboard' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-detail.css') }}">

    @livewireStyles

    <!-- Add this just before the closing </head> tag -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="logo-container">
                <h1>My Dashboard</h1>
            </div>

            <div class="user-info">
                <span>Welcome, {{ auth()->user()->name ?? 'User' }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="sidebar">
                <nav>
                    <ul class="nav-items">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}"><span>📊</span> Overview</a>
                        </li>

                        <!-- Page Management -->
                        <li class="nav-item {{ request()->routeIs('pages.*') ? 'active' : '' }}">
                            <a href="{{ route('pages.index') }}"><span>📄</span> Pages</a>
                        </li>

                        <!-- Section Management -->
                        <li class="nav-item {{ request()->routeIs('sections.*') ? 'active' : '' }}">
                            <a href="{{ route('sections.index') }}"><span>📑</span> Sections</a>
                        </li>

                        <!-- Projects Management -->
                        <li class="nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                            <a href="{{ route('projects.index') }}"><span>💼</span> Projects</a>
                        </li>


                    </ul>
                </nav>
            </div>

            <main class="main-content">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts

    <!-- Stack for page-specific scripts -->
    @stack('scripts')
</body>
</html>
