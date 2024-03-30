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
  
</head>
<body>
   
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
<div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
    <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg" id="navbarVertical">
        <div class="container-fluid">
            <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
                <img class="image_logo" style="height: 100px;margin-left:50px" src="{{ url('images/image.jpeg') }}" alt="Image Description">
            </a>
           
            <div class="collapse navbar-collapse" id="sidebarCollapse">
                <ul class="navbar-nav">
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                        @if(Auth::user()->role->name == "Admin")
                        <li><a class="nav-link" href="{{ route('users.index') }}"><i class="bi bi-person"></i> Manage Users</a></li>
                        <li><a class="nav-link" href="{{ route('roles.index') }}"><i class="bi bi-shield-fill"></i> Manage Role</a></li>
                        <li><a class="nav-link" href="{{ route('departments.index') }}"><i class="bi bi-building"></i> Department</a></li>
                            
                        @endif
                        <li><a class="nav-link" href="{{ route('leaves.index') }}"><i class="bi bi-calendar-plus"></i> Request Leave</a></li>
                        <li><a class="nav-link" href="{{ route('missions.index') }}"><i class="bi bi-calendar-plus"></i>Mission Request</a></li>
                
                            <li class="ms-3 nav-item dropdown">
                                 
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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

                                <a id="navbarDropdown"  href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
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
                <div class="row g-6 mb-6">
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Users</span>
                                        <span class="h3 font-bold mb-0">$750.90</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Request Leaves</span>
                                        <span class="h3 font-bold mb-0">215</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                            <i class="bi bi-calendar-plus"></i>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Mission Request</span>
                                        <span class="h3 font-bold mb-0">1.400</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                            <i class="bi bi-calendar-plus"></i>
                                        </div>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Departments</span>
                                        <span class="h3 font-bold mb-0">95%</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white text-lg rounded-circle">
                                            <i class="bi bi bi-building"></i>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
            </div>
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
    {{-- {{ $users->links() }} --}}
</div>

<style>
    /* Webpixels CSS */
/* Utility and component-centric Design System based on Bootstrap for fast, responsive UI development */
/* URL: https://github.com/webpixels/css */

@import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");

</style>