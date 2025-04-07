<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart to do list</title>

    @vite('resources/css/app.css')
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
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0D9488&color=fff"
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

            <!-- Main Content -->
            <div class="flex-1 p-8">
                <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                    <!-- Title Bar -->
                    <div class="border-b border-gray-200">
                        <div class="px-6 py-4">
                            <h2 class="text-xl font-semibold text-gray-800">Feedback</h2>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-6">
                        <!-- Feedback Form -->
                        <div class="mb-8">
                            <h3 class="mb-4 text-lg font-semibold text-gray-700">Send Feedback</h3>
                            <form class="space-y-4">
                                <!-- Title Input -->
                                <div>
                                    <label for="feedback-title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" id="feedback-title" name="title"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter feedback title">
                                </div>

                                <!-- Description Input -->
                                <div>
                                    <label for="feedback-description" class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="feedback-description" name="description" rows="4"
                                              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Enter your feedback description"></textarea>
                                </div>

                                <!-- Buttons -->
                                <div class="flex space-x-4">
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="mr-2 fas fa-paper-plane"></i> Send Feedback
                                    </button>
                                    <button type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="mr-2 fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Previous Feedback Section -->
                        <div>
                            <h3 class="mb-4 text-lg font-semibold text-gray-700">Previous Feedback</h3>
                            <div class="space-y-4">
                                <!-- Feedback Item 1 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-medium text-gray-800">UI Improvements Needed</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-gray-500 bg-gray-100 rounded-full">Sent: May 15, 2024</span>
                                    </div>
                                    <p class="text-sm text-gray-600">The navigation menu could be more intuitive and the color scheme needs adjustment for better contrast.</p>
                                    <div class="flex justify-end mt-3 space-x-2">
                                        <button class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Feedback Item 2 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-medium text-gray-800">Bug Report</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-gray-500 bg-gray-100 rounded-full">Sent: May 10, 2024</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Found an issue with the task completion status not updating correctly when marking tasks as done.</p>
                                    <div class="flex justify-end mt-3 space-x-2">
                                        <button class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Feedback Item 3 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-medium text-gray-800">Feature Request</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-gray-500 bg-gray-100 rounded-full">Sent: May 5, 2024</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Would be great to have a dark mode option and the ability to export tasks to PDF.</p>
                                    <div class="flex justify-end mt-3 space-x-2">
                                        <button class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
