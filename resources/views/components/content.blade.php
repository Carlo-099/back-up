@props(['title' => 'Smart to do list'])

<div class="min-h-screen bg-gray-100">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-md">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex items-center flex-shrink-0">
                        <a href="/" class="flex items-center">
                            <img src="/images/logo.png" alt="Logo" class="w-8 h-8 mr-2">
                            <span class="text-xl font-bold text-gray-800">{{ $title }}</span>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="/" class="btn">Home</a>
                        @guest
                            <a href="{{ route('show.login') }}" class="btn">Login</a>
                            <a href="{{ route('show.register') }}" class="btn">Register</a>
                        @endguest
                        @auth
                            <a href="{{ route('ninjas.index') }}" class="btn">Tasks</a>
                            <a href="{{ route('ninjas.create') }}" class="btn">Create Task</a>
                        @endauth
                    </div>
                </div>

                <!-- Right side -->
                <div class="flex items-center">
                    @auth
                        <span class="pr-4 text-gray-700">Hi, {{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button class="btn">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 min-h-screen bg-white shadow-md">
            <div class="p-4">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">Menu</h2>
                <nav class="space-y-2">
                    <a href="/" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                        <i class="mr-2 fas fa-home"></i> Home
                    </a>
                    @auth
                        <a href="{{ route('ninjas.index') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                            <i class="mr-2 fas fa-tasks"></i> My Tasks
                        </a>
                        <a href="{{ route('ninjas.create') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                            <i class="mr-2 fas fa-plus"></i> Create Task
                        </a>
                    @else
                        <a href="{{ route('show.login') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                            <i class="mr-2 fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="{{ route('show.register') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                            <i class="mr-2 fas fa-user-plus"></i> Register
                        </a>
                    @endauth
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            {{ $slot }}
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
