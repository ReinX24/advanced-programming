<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">ITP17 - Project</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>

                        {{-- <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('profile.index') }}">Profile</a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('students.index') }}">Students</a>
                        </li> --}}

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('users.index') }}">Manage Users</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-pencil-fill"></i>
                                Students
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('students.index') }}">Student List</a></li>
                                <li>
                                    {{-- <hr class="dropdown-divider"> --}}
                                </li>
                                <li><a class="dropdown-item" href="{{ route('students.create') }}">Add New Student</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-file-person-fill"></i>
                                Appointments
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('appointments.index') }}">Manage
                                        Appointments</a></li>
                                <li>
                                    {{-- <hr class="dropdown-divider"> --}}
                                </li>
                                <li><a class="dropdown-item" href="{{ route('appointments.create') }}">Add New
                                        Appointment</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>

                {{-- If the user is not logged in --}}
                @if (!Auth::check())
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                    </div>
                    {{-- If the user is logged in --}}
                @elseif (Auth::check())
                    <div class="d-flex gap-2 align-items-center">
                        <div>
                            <img src="{{ Auth::user()->display_photo }}" alt="Profile Photo" class="img-thumbnail"
                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            <a href="{{ route('profile.index') }}"
                                class="fw-bold link-underline link-underline-opacity-0">
                                {{ Auth::user()->name }}
                            </a>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </nav>
</header>
