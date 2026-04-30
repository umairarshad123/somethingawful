<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="@yield('description', 'Digirisers — full-service digital marketing agency. SEO, PPC, web design, content, social, AI, ecommerce and more.')" />
  <meta name="theme-color" content="#0b1020" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  @hasSection('robots')
    <meta name="robots" content="@yield('robots')" />
  @endif
  <title>@yield('title', 'Digirisers — Digital Marketing That Rises Above')</title>

  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Instrument+Serif&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

  @stack('styles')
</head>
<body>

  @yield('content')

  @stack('scripts')
</body>
</html>
