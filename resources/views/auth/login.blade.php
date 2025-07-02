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
<body class="align-items-center justify-content-center vh-100 bg-light">
  <section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card login-bg text-white" style="border-radius: 1rem;">
          <div class="card-body px-5 pb-5 text-center">

            <div class="mb-md-5 mt-md-4">
            <img class="img-light-logo" src="{{ asset('images/logo.png') }}" alt="MyApp Logo" height="150" >
              <h2 class="mb-5 text-uppercase" style="font-weight: 700;font-size: 20px;">{{ config('app.name','MyApp') }}</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror"   id="email" name="email" placeholder="name@example.com" autocomplete="email">
                <label for="floatingInput">Email address</label>
                 @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                </div>
                <div class="form-floating">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" autocomplete="current-password">
                <label for="floatingPassword">Password</label>
                @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                </div>

                <button class="btn btn-outline-light btn-lg px-5 mt-5" type="submit">Login</button>
            </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
