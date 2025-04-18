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
                    <!-- Title Bar with Status Buttons -->
                    <div class="border-b border-gray-200">
                        <div class="px-6 py-4">
                            <h2 class="text-xl font-semibold text-gray-800">Task Status</h2>
                        </div>
                        <div class="flex px-6 py-3 space-x-4">
                            <button onclick="filterTasks('pending')" class="px-4 py-2 text-sm font-medium text-yellow-700 border border-yellow-300 rounded-md bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 status-btn active" data-status="pending">
                                <i class="mr-2 fas fa-clock"></i> Pending
                            </button>
                            <button onclick="filterTasks('in-progress')" class="px-4 py-2 text-sm font-medium text-blue-700 border border-blue-300 rounded-md bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 status-btn" data-status="in-progress">
                                <i class="mr-2 fas fa-spinner fa-spin"></i> In Progress
                            </button>
                            <button onclick="filterTasks('completed')" class="px-4 py-2 text-sm font-medium text-green-700 border border-green-300 rounded-md bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 status-btn" data-status="completed">
                                <i class="mr-2 fas fa-check-circle"></i> Complete
                            </button>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-6 bg-yellow-50">
                        <!-- Pending Tasks -->
                        <div id="pending-tasks" class="mb-8 task-section">
                            <h3 class="mb-4 text-lg font-semibold text-yellow-700">Pending Tasks</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                @forelse($tasks as $task)
                                    @if($task->status == 'pending')
                                        <div class="p-4 transition-shadow border border-purple-200 rounded-lg shadow-sm bg-purple-50 hover:shadow-md">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-medium text-purple-800">{{ $task->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-full">{{ $task->category->name ?? 'Uncategorized' }}</span>
                                            </div>
                                            <p class="mb-3 text-sm text-purple-700">{{ $task->description }}</p>
                                            <div class="flex items-center justify-between text-sm text-purple-600">
                                                <span>Due: {{ $task->due_date->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="col-span-3 p-4 text-center text-gray-500">
                                        No pending tasks found.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- In Progress Tasks -->
                        <div id="in-progress-tasks" class="hidden mb-8 task-section">
                            <h3 class="mb-4 text-lg font-semibold text-blue-700">In Progress Tasks</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                @forelse($tasks as $task)
                                    @if($task->status == 'in_progress')
                                        <div class="p-4 transition-shadow border border-indigo-200 rounded-lg shadow-sm bg-indigo-50 hover:shadow-md">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-medium text-indigo-800">{{ $task->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-full">{{ $task->category->name ?? 'Uncategorized' }}</span>
                                            </div>
                                            <p class="mb-3 text-sm text-indigo-700">{{ $task->description }}</p>
                                            <div class="flex items-center justify-between text-sm text-indigo-600">
                                                <span>Due: {{ $task->due_date->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="col-span-3 p-4 text-center text-gray-500">
                                        No in-progress tasks found.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Completed Tasks -->
                        <div id="completed-tasks" class="hidden mb-8 task-section">
                            <h3 class="mb-4 text-lg font-semibold text-green-700">Completed Tasks</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                @forelse($tasks as $task)
                                    @if($task->status == 'complete')
                                        <div class="p-4 transition-shadow border rounded-lg shadow-sm bg-emerald-50 border-emerald-200 hover:shadow-md">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-medium text-emerald-800">{{ $task->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full text-emerald-700 bg-emerald-100">{{ $task->category->name ?? 'Uncategorized' }}</span>
                                            </div>
                                            <p class="mb-3 text-sm text-emerald-700">{{ $task->description }}</p>
                                            <div class="flex items-center justify-between text-sm text-emerald-600">
                                                <span>Completed: {{ $task->updated_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="col-span-3 p-4 text-center text-gray-500">
                                        No completed tasks found.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script>
        function filterTasks(status) {
            // Hide all task sections
            document.querySelectorAll('.task-section').forEach(section => {
                section.classList.add('hidden');
            });

            // Show selected task section
            document.getElementById(`${status}-tasks`).classList.remove('hidden');

            // Update button styles
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.classList.remove('bg-yellow-50', 'border-yellow-300', 'bg-blue-50', 'border-blue-300', 'bg-green-50', 'border-green-300');
            });

            // Update content area background color
            const contentArea = document.querySelector('.p-6');
            contentArea.classList.remove('bg-yellow-50', 'bg-blue-50', 'bg-green-50');

            // Add appropriate color classes based on status
            const activeBtn = event.currentTarget;
            if (status === 'pending') {
                activeBtn.classList.add('bg-yellow-50', 'border-yellow-300');
                contentArea.classList.add('bg-yellow-50');
            } else if (status === 'in-progress') {
                activeBtn.classList.add('bg-blue-50', 'border-blue-300');
                contentArea.classList.add('bg-blue-50');
            } else if (status === 'completed') {
                activeBtn.classList.add('bg-green-50', 'border-green-300');
                contentArea.classList.add('bg-green-50');
            }
        }
    </script>
</body>
</html>
