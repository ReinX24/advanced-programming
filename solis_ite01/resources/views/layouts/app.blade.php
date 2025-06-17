<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ITP17 Project - {{ $page_title }}</title>
    {{-- @vite('resources/css/app.css') --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    @yield('css')
</head>

<body class="container mx-auto mt-10 mb-10 max-w-lg">
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">ITP17 - Project</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse flex" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if (Auth::check())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('profile.index') }}">Profile</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('students.index') }}">Students</a>
                            </li>

                            {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/">Home</a></li>
                                <li><a class="dropdown-item" href="/profile">Profile</a></li>
                                <li><a class="dropdown-item" href="/students">Students</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li> --}}
                        @endif
                    </ul>

                    {{-- If the user is not logged in --}}
                    @if (!Auth::check())
                        <div class="flex gap-2">
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                        </div>
                        {{-- If the user is logged in --}}
                    @elseif (Auth::check())
                        <div>
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

    <h2 class="text-4xl font-bold my-2 text-primary">@yield('title')</h2>

    <div>
        @yield('content')
    </div>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
    {{-- @vite('resources/js/app.js') --}}
</body>

</html>
