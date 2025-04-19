<!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>MDM</title>
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container">
              <a class="navbar-brand" href="{{ route('home') }}">MDM</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav">
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('brands.index') }}">Brands</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('items.index') }}">Items</a>
                      </li>
                  </ul>
                  <ul class="navbar-nav ms-auto">
                      @auth
                          <li class="nav-item">
                              <span class="nav-link">{{ Auth::user()->name }} @if (Auth::user()->is_admin) (Admin) @endif</span>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('logout') }}"
                                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                  Logout
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                          </li>
                      @else
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('login') }}">Login</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('register') }}">Register</a>
                          </li>
                      @endauth
                  </ul>
              </div>
          </div>
      </nav>

      <div class="container mt-4">
          @if (session('status'))
              <div class="alert alert-success">{{ session('status') }}</div>
          @endif
          @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          @yield('content')
      </div>
  </body>
  </html>
