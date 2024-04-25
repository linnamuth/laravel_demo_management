<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
<div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
    <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg"
        id="navbarVertical">
        <div class="container-fluid">
            <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
                <img class="image_logo" style="height: 100px;margin-left:50px" src="{{ url('images/image.jpeg') }}"
                    alt="Image Description">
            </a>

            <div class="collapse navbar-collapse" id="sidebarCollapse">
                <ul class="navbar-nav">
                    @guest
                        <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @else
                    @if (Auth::user()->role_id == 1)

                    <li><a class="nav-link" href="{{ route('dashboards.index') }}"><i class="bi bi-bar-chart"></i> Dashboard</a></li>
                    <li><a class="nav-link" href="{{ route('workflows.index') }}"><i class="bi bi-gear"></i> Workflows</a></li>
                    <li><a class="nav-link" href="{{ route('users.index') }}"><i class="bi bi-person"></i> Users</a></li>
                    <li><a class="nav-link" href="{{ route('roles.index') }}"><i class="bi bi-shield-fill"></i> Manage Role</a></li>
                    <li><a class="nav-link" href="{{ route('departments.index') }}"><i class="bi bi-building"></i> Departments</a></li>
                    <li><a class="nav-link" href="{{ route('leaves.index') }}"><i class="bi bi-calendar-plus"></i> Request Leave</a></li>
                    <li><a class="nav-link" href="{{ route('missions.index') }}"><i class="bi bi-calendar-plus"></i> Mission Request</a></li>
                @else
                    <li><a class="nav-link" href="{{ route('leaves.index') }}"><i class="bi bi-calendar-plus"></i> Request Leave</a></li>
                    <li><a class="nav-link" href="{{ route('missions.index') }}"><i class="bi bi-calendar-plus"></i> Mission Request</a></li>

                @endif
                        <li class="ms-3 nav-item dropdown">

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest

                </ul>

            </div>
        </div>
    </nav>
    <div class="h-screen flex-grow-1 overflow-y-lg-auto">
        <header class="bg-surface-primary border-bottom pt-6">
            <div class="container-fluid">
                <div class="mb-npx">
                    <div class="row align-items-center">
                        <div class="d-flex justify-content-between">
                            <h2>Management System</h2>
                            <h1 class="h2 mb-0 ls-tight"></h1>
                            <div class="d-flex">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-person"></i> {{ Auth::user()->name }} <span
                                            class="caret"></span>
                                    </button>


                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            {{ __('Profile') }}
                                        </a>

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <ul class="nav nav-tabs mt-4 overflow-x border-0">

                    </ul>
                </div>
            </div>
        </header>
        <main class="py-6 bg-surface-secondary">
            <div class="container-fluid">

                <div id="app">
                    <main class="py-4">
                        <div class="container">
                            @yield('content')
                        </div>
                    </main>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        navLinks.forEach(function(navLink) {
            if (window.location.href === navLink.href) {
                navLink.classList.add('active');
            }

            navLink.addEventListener('click', function(event) {
                navLinks.forEach(link => link.classList.remove('active'));
                navLink.classList.add('active');
            });
        });
    });
</script>
