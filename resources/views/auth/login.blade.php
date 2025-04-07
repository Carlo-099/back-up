<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        <!-- Login Form -->
        <div class="flex items-center justify-center mt-20">
            <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-lg">
                <div>
                    <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                        Welcome Back, Ninja!
                    </h2>
                    <p class="mt-2 text-sm text-center text-gray-600">
                        Ready to conquer your tasks?
                    </p>
                </div>
                <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="-space-y-px rounded-md shadow-sm">
                        <div>
                            <label for="email" class="sr-only">Email address</label>
                            <input id="email" name="email" type="email" required
                                class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Email address">
                        </div>
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" required
                                class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Password">
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="text-sm text-red-500">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div>
                        <button type="submit"
                            class="relative flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md group hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-5 h-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Sign in
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('show.register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Register here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
