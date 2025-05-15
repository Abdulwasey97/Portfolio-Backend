<div class="dashboard-container">
    <header class="dashboard-header">
        <div class="logo-container">
            <h1>My Dashboard</h1>
        </div>

        <div class="user-info">
            <span>Welcome, {{ $user->name }}</span>
            <button wire:click="$dispatch('logout')" class="logout-btn">Logout</button>
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
            <div class="welcome-card">
                <h2>Welcome to your Dashboard!</h2>
                <p>This is your personal dashboard where you can manage all your activities and projects.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $pagesCount }}</div>
                    <div class="stat-label">Total Pages</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $sectionsCount }}</div>
                    <div class="stat-label">Total Sections</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $publishedPagesCount }}</div>
                    <div class="stat-label">Published Pages</div>
                </div>
                <div class="stat-card">
                    <a href="{{ route('pages.create') }}" class="no-underline">
                        <div class="stat-number">+</div>
                        <div class="stat-label">Add New Page</div>
                    </a>
                </div>
            </div>


        </main>
    </div>
</div>
