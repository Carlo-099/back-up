<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart to do list</title>

  @vite('resources/css/app.css')
</head>
<body>
  @if (session('success'))
    <div id="flash" class="p-4 font-bold text-center text-green-500 bg-green-50">
      {{ session('success') }}
    </div>
  @endif

  <header>
    <nav>
      <h1>
        <a href="/" class="flex items-center">
          <img src="/images/logo.png" alt="Logo" class="w-8 h-8 mr-2">
          Smart to do list
        </a>
      </h1>

      <a href="/" class="btn">Home</a>

    @guest
      <a href="{{ route('show.login') }}" class="btn">Login</a>
      <a href="{{ route('show.register') }}" class="btn">Register</a>
    @endguest

    @auth
      <span class="pr-2 border-r-2">
        Hi There, {{ Auth::user()->name }}
      </span>
      <a href="{{ route('ninjas.create') }}">Create New Ninja</a>
      <form action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf
        <button class="btn">logout</button>
      </form>
    @endauth

    </nav>
  </header>

  <main class="container">
    {{ $slot }}
  </main>

</body>
</html>
