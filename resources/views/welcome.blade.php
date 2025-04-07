<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart to do list</title>

  @vite('resources/css/app.css')
</head>
<body>
  <div class="min-h-screen bg-gray-100">
    <!-- Navigation Bar -->
    <header>
      <nav>
        <h1>
          <a href="/" class="flex items-center">
            <img src="/images/logo.png" alt="Logo" class="w-8 h-8 mr-2">
            Smart to do list
          </a>
        </h1>

        <a href="/" class="btn">Home</a>
        <a href="{{ route('show.login') }}" class="btn">Login</a>
        <a href="{{ route('show.register') }}" class="btn">Register</a>
      </nav>
    </header>

    <div class="justify-center mt-20 text-center">
      <h1 class="mb-6 text-5xl font-extrabold text-gray-800">Welcome to Smart to do list</h1>
      <p class="mb-12 text-3xl font-bold tracking-wide text-blue-600">MAKE THINGS ORGANIZED</p>
      <p class="mb-6 text-xl text-gray-600">Click the button below to view your tasks.</p>

      <a href="/ninjas" class="inline-block px-8 py-3 mt-6 text-lg btn">
        View Tasks!
      </a>
    </>
  </div>
</body>
</html>
