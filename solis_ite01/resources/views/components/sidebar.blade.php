<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary d-lg-block vertical-sidebar">
        <div class="container-fluid flex-column align-items-start">
            <a class="navbar-brand" href="/">ITP17 - Project</a>
            <span class="mb-3 fw-bold">{{ Auth::user()->name }}</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column w-100" id="navbarSupportedContent">
                <ul class="navbar-nav flex-column me-auto mb-2 mb-lg-0 w-100">
                    @if (Auth::check())
                        <li class="nav-item w-100">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>

                        <li class="nav-item w-100">
                            <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('profile.index') }}">Profile</a>
                        </li>

                        <li class="nav-item w-100">
                            <a class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('students.index') }}">Students</a>
                        </li>
                    @endif
                </ul>

                {{-- If the user is not logged in --}}
                @if (!Auth::check())
                    <div class="d-flex flex-column gap-2 mt-auto w-100">
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary w-100">Register</a>
                    </div>
                    {{-- If the user is logged in --}}
                @elseif (Auth::check())
                    <div class="mt-auto w-100">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">Logout</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <style>
        .vertical-sidebar {
            min-height: 100vh;
            /* Make the sidebar take full height */
            position: fixed;
            /* Fix the sidebar position */
            top: 0;
            left: 0;
            width: 250px;
            /* Adjust sidebar width as needed */
            padding: 1rem;
            box-shadow: 2px 0 5px rgba(0, 0, 0, .1);
            /* Optional: add a subtle shadow */
        }

        /* Adjust content margin to prevent overlap with sidebar */
        body {
            /* padding-left: 250px; */
            /* Should match the sidebar width */
        }
    </style>
</header>
