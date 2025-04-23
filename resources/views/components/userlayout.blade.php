<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart to do list</title>

    @vite('resources/css/app.css')
    <!-- FullCalendar CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        <!-- Top Navigation Bar -->
        <nav class="bg-white shadow-md">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="/" class="flex items-center">
                                <img src="/images/logo.png" alt="Logo" class="w-8 h-8 mr-2">
                                <span class="text-xl font-bold text-gray-800">Smart to do list</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <span class="text-gray-700">Hi, {{ Auth::user()->name }}</span>
                            <!-- Notification Button -->
                            <button class="relative p-2 text-gray-600 rounded-full hover:bg-gray-100">
                                <i class="fas fa-bell"></i>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
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
                    <!-- User Profile Section -->
                    @auth
                        <div class="flex flex-col items-center mb-6">
                            <div class="w-24 h-24 mb-3 overflow-hidden rounded-full">
                                @php
                                    $user = Auth::user();
                                    $reference = $user->reference;
                                    $settings = $reference ? $reference->settings : null;

                                    $profilePicture = "https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&background=0D9488&color=fff";

                                    if ($settings && $settings->profile_picture) {
                                        // Check if the path already includes the directory
                                        if (strpos($settings->profile_picture, 'uploads/profile_pictures/') === 0) {
                                            $profilePicture = asset($settings->profile_picture);
                                        } else {
                                            $profilePicture = asset('uploads/profile_pictures/' . $settings->profile_picture);
                                        }
                                    }
                                @endphp
                                <img src="{{ $profilePicture }}"
                                     alt="Profile"
                                     class="object-cover w-full h-full">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</h3>
                        </div>
                    @endauth

                    <h2 class="mb-4 text-lg font-semibold text-gray-800">Menu</h2>
                    <nav class="space-y-2">
                        @auth
                            <a href="{{ route('content') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-calendar-alt"></i> Calendar
                            </a>
                            <a href="{{ route('status') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-chart-line"></i> Status
                            </a>
                            <a href="{{ route('category') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-tags"></i> Category
                            </a>
                            <a href="{{ route('feedback') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-comments"></i> Feedback
                            </a>
                            <a href="{{ route('productivity-insight') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-chart-bar"></i> Productivity Insight
                            </a>

                            <hr class="my-4 border-gray-200">

                            <a href={{ route('setting') }} class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-cog"></i> Settings
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

            <div class="flex-1 p-8">
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <div id="calendar"></div>

                    <main class="container"  >
                        {{ $slot }}
                    </main>

                </div>

                </div>
            </div>
            </body>

            </html>
