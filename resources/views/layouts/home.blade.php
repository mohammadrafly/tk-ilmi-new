<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('img/logo-tk.png')}}" rel="icon" type="image/x-icon" >
    <title>{{ env('APP_NAME') }} | {{ $title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;600;700&family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/home/bootstrap/bootstrap.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/home/css/style.css') }}" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-warning position-fixed w-100">
        <div class="container">
            <a class="navbar-brand" href="#">
              <img src="{{ asset('assets/home/img/logo.png') }}" alt="TK Ilmi" width="110">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-3">
                  <a class="nav-link active" aria-current="page" href="#hero">Beranda</a>
                </li>
                <li class="nav-item mx-3">
                  <a class="nav-link" href="#profile">Profile Sekolah</a>
                </li>
                <li class="nav-item mx-3">
                  <a class="nav-link" href="#pendidikan">Jenjang Pendidikan</a>
                </li>
              </ul>
              @if (Auth::check())
                <div>
                    <a href="{{ route('dashboard.index') }}"><button class="button-primary">Dashboard</button></a>
                </div>
              @else
                <div>
                    <a href="{{ route('login') }}"><button class="button-primary">Login</button></a>
                </div>
                <div>
                    <a href="{{ route('register') }}"><button class="button-primary">Register</button></a>
                </div>
              @endif

            </div>
        </div>
    </nav>

    @yield('content')

    <footer id="footer">
        <div class="footer-top">
          <div class="container">
            <div class="row">
                @include('home.partials.footer')
            </div>
          </div>
        </div>
    </footer>
    <script src="{{asset('assets/home/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/home/js/main.js')}}"></script>
</body>
</html>
