<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <title>{{ config('app.name','MyApp') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="es-bg">

  <div class="d-flex">
    {{-- Sidebar --}}
    <nav class="navbar fixed-top es-bg-navbar">
        <div class="container-fluid">
            <a class="navbar-brand es-text" href="/menus"><img class="img-light" src="{{ asset('images/logo.png') }}" alt="MyApp Logo" height="40" style="padding-bottom: inherit">
                {{ config('app.name','MyApp') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title border-bottom" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                @auth
                {{-- <li class="nav-item">
                    <span class="nav-link">Hi, {{ Auth::user()->name }}</span>
                </li> --}}
                <li class="nav-item mb-3">
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="nav-link btn btn-link" style="padding:0;">
                        Logout
                    </button>
                    </form>
                </li>
                    <a class="nav-link" aria-current="page" href="/stock">Stock</a>
                <li class="nav-item">

                </li>
                @endauth
                {{-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                    </a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                </ul>
                <form class="d-flex mt-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                <button class="btn btn-outline-success" type="submit">Search</button>
                </form> --}}
            </div>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <div class="flex-grow-1">
      {{-- Top navbar with toggle button --}}
      <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
          <button class="btn btn-outline-primary" 
                  type="button" 
                  data-bs-toggle="collapse" 
                  data-bs-target="#sidebar" 
                  aria-controls="sidebar" 
                  aria-expanded="true" 
                  aria-label="Toggle sidebar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <span class="navbar-brand mb-0 h1">{{ config('app.name','MyApp') }}</span>
        </div>
      </nav>

      {{-- Main content area --}}
      <main class="p-4">
        @yield('content')
      </main>
    </div>
  </div>
</body>
</html>
