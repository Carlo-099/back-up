<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ Auth::check() && Auth::user()->reference && Auth::user()->reference->settings ? Auth::user()->reference->settings->theme : 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart to do list</title>

    @vite('resources/css/app.css')
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}">
    <!-- FullCalendar CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <style>
        :root[data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #48A6A7;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --border-color: #dee2e6;
            --accent-color: #0d6efd;
            --hover-color: #e9ecef;

            /* Light Theme (my second option) */
            --topnavbar-bg: #9FB3DF;
            --sidenavbar-bg: #9EC6F3;
            --menubutton-bg:#BDDDE4;
            --menubuttonhover-bg: #ffffff;
        }

        :root[data-theme="dark"] {
            --bg-primary: #212529;
            --bg-secondary: #343a40;
            --text-primary: #f8f9fa;
            --text-secondary: #adb5bd;
            --border-color: #495057;
            --accent-color: #0d6efd;
            --hover-color: #495057;

            /* Dark Theme (my second option) */
            --topnavbar-bg: #2C3E50;
            --sidenavbar-bg: #34495E;
            --menubutton-bg: #3498DB;
            --menubuttonhover-bg: #2980B9;
        }

        /* Menu button styles */
        .menu-button {
            display: block;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
            color: var(--text-primary);
            background-color: var(--menubutton-bg);
            margin-bottom: 0.5rem;
        }

        .menu-button:hover {
            background-color: var(--menubuttonhover-bg);
        }

        /* Theme-specific styles */
        [data-theme="light"] .menu-button {
            background-color: var(--menubutton-bg);
        }

        [data-theme="light"] .menu-button:hover {
            background-color: var(--menubuttonhover-bg);
        }

        [data-theme="dark"] .menu-button {
            background-color: var(--menubutton-bg);
        }

        [data-theme="dark"] .menu-button:hover {
            background-color: var(--menubuttonhover-bg);
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar {
            background-color: var(--bg-secondary) !important;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand, .nav-link {
            color: var(--text-primary) !important;
        }

        .card {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .card-header {
            background-color: var(--bg-secondary);
            border-bottom-color: var(--border-color);
        }

        .table {
            color: var(--text-primary);
        }

        .table thead th {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .table td {
            border-color: var(--border-color);
        }

        .form-control {
            background-color: var(--bg-primary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .form-control:focus {
            background-color: var(--bg-primary);
            border-color: var(--accent-color);
            color: var(--text-primary);
        }

        .btn-outline-secondary {
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .btn-outline-secondary:hover {
            background-color: var(--hover-color);
            color: var(--text-primary);
        }

        .modal-content {
            background-color: var(--bg-primary);
            border-color: var(--border-color);
        }

        .modal-header {
            border-bottom-color: var(--border-color);
        }

        .modal-footer {
            border-top-color: var(--border-color);
        }

        .dropdown-menu {
            background-color: var(--bg-primary);
            border-color: var(--border-color);
        }

        .dropdown-item {
            color: var(--text-primary);
        }

        .dropdown-item:hover {
            background-color: var(--hover-color);
            color: var(--text-primary);
        }

        .alert {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
    </style>
     <script>
        // Function to apply theme to menu buttons
        function applyThemeToMenuButtons() {
            const theme = document.documentElement.getAttribute('data-theme');
            const menuButtons = document.querySelectorAll('.menu-button');

            menuButtons.forEach(button => {
                if (theme === 'dark') {
                    button.style.setProperty('background-color', 'var(--menubutton-bg)', 'important');
                    button.style.setProperty('color', 'var(--text-primary)', 'important');

                    // Add hover effect
                    button.onmouseover = function() {
                        this.style.setProperty('background-color', 'var(--menubuttonhover-bg)', 'important');
                    };
                    button.onmouseout = function() {
                        this.style.setProperty('background-color', 'var(--menubutton-bg)', 'important');
                    };
                } else {
                    button.style.setProperty('background-color', 'var(--menubutton-bg)', 'important');
                    button.style.setProperty('color', 'var(--text-primary)', 'important');

                    // Add hover effect
                    button.onmouseover = function() {
                        this.style.setProperty('background-color', 'var(--menubuttonhover-bg)', 'important');
                    };
                    button.onmouseout = function() {
                        this.style.setProperty('background-color', 'var(--menubutton-bg)', 'important');
                    };
                }
            });
        }

        // Function to apply theme from localStorage or server-side setting
        function applyTheme() {
            // First check if there's a theme in localStorage
            const savedTheme = localStorage.getItem('theme');

            if (savedTheme) {
                // Apply the theme from localStorage
                document.documentElement.setAttribute('data-theme', savedTheme);
            } else {
                // If no theme in localStorage, use the server-side theme
                const serverTheme = document.documentElement.getAttribute('data-theme');
                if (serverTheme) {
                    // Save the server-side theme to localStorage for consistency
                    localStorage.setItem('theme', serverTheme);
                }
            }

            // Apply theme to menu buttons
            applyThemeToMenuButtons();
        }

        // Function to hide deleted notifications
        function hideDeletedNotifications() {
            // Get deleted task IDs from localStorage
            const deletedTaskIds = JSON.parse(localStorage.getItem('deletedTaskIds') || '[]');

            // Hide notifications for deleted tasks
            deletedTaskIds.forEach(taskId => {
                const notificationItem = document.querySelector(.notification-item[data-task-id="${taskId}"]);
                if (notificationItem) {
                    notificationItem.style.display = 'none';
                }
            });


        }


        // Run on page load
        document.addEventListener('DOMContentLoaded', applyTheme);

        // Run when theme changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'data-theme') {
                    // Theme changed, no additional action needed
                }
            });
        });

        observer.observe(document.documentElement, { attributes: true });
    </script>
</head>
<body>
    <div class="min-h-screen" style="background-color: var(--bg-primary);">
        <!-- Top Navigation Bar -->
        <nav class="shadow-md" style="background-color: var(--topnavbar-bg);">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">

                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="/" class="flex items-center">
                                <img src="/images/logo.png" alt="Logo" class="w-8 h-8 mr-2">
                                <span class="text-xl font-bold" style="color: var(--text-primary);">Smart to do list</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <span style="color: var(--text-primary);">Hi, {{ Auth::user()->name }}</span>

                          <!-- Notification Button -->
                            <div class="relative">
                                <button id="notificationButton" class="relative p-2 rounded-full" style="color: var(--text-primary);">
                                    <i class="fas fa-bell"></i>
                                    @php
                                        $hasUnreadNotifications = \App\Models\Notification::where('user_id', Auth::id())
                                            ->where('status', 'unread')
                                            ->exists();
                                    @endphp
                                    @if ($hasUnreadNotifications)
                                        <span id="notificationDot" class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                    @endif
                                </button>

                                <!-- Notification Dropdown -->
                                <div id="notificationDropdown" class="absolute right-0 z-50 hidden w-64 mt-2 overflow-hidden bg-white rounded-lg shadow-lg" style="background-color: var(--bg-primary); border: 1px solid var(--border-color);">
                                    <div class="p-4">
                                        <h3 class="text-sm font-semibold" style="color: var(--text-primary);">Tasks Due Today</h3>
                                    </div>
                                    <ul class="divide-y divide-gray-200" style="border-color: var(--border-color);">
                                        @php
                                            $tasks = \App\Models\Task::with('category')
                                                ->where('user_id', Auth::id())
                                                ->whereDate('due_date', now()->toDateString())
                                                ->get();
                                        @endphp

                                        @forelse ($tasks as $task)
                                            <li id="task-{{ $task->task_id }}" class="flex items-center justify-between p-4">
                                                <div>
                                                    <h4 class="text-sm font-medium" style="color: var(--text-primary);">{{ $task->title }}</h4>
                                                    <p class="text-xs" style="color: var(--text-secondary);">Status: {{ $task->status }}</p>
                                                    <p class="text-xs" style="color: var(--text-secondary);">Category: {{ $task->category->category_type }}</p>
                                                    <p class="text-xs" style="color: var(--text-secondary);">Due: {{ $task->due_date->format('d M Y') }}</p>
                                                </div>

                                                <!-- Mark as Read Button -->
                                                <button class="text-xs font-semibold text-blue-500 mark-as-read-btn hover:underline" data-task-id="{{ $task->task_id }}">
                                                    Mark as Read
                                                </button>

                                            </li>
                                        @empty
                                            <li class="p-4 text-sm" style="color: var(--text-secondary);">No tasks due today.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div> <!-- Missing closing tag added here -->

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
            <div class="w-64 min-h-screen shadow-md" style="background-color: var(--sidenavbar-bg);">
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
                            <h3 class="text-lg font-semibold" style="color: var(--text-primary);">{{ Auth::user()->name }}</h3>
                        </div>
                    @endauth

                    <h2 class="mb-4 text-lg font-semibold" style="color: var(--text-primary);">Menu</h2>
                    <nav class="space-y-2">
                        @auth
                            <a href="{{ route('content') }}" class="menu-button">
                                <i class="mr-2 fas fa-calendar-alt"></i> Calendar
                            </a>
                            <a href="{{ route('status') }}" class="menu-button">
                                <i class="mr-2 fas fa-chart-line"></i> Status
                            </a>
                            <a href="{{ route('category') }}" class="menu-button">
                                <i class="mr-2 fas fa-tags"></i> Category
                            </a>
                            <a href="{{ route('feedback') }}" class="menu-button">
                                <i class="mr-2 fas fa-comments"></i> Feedback
                            </a>
                            <a href="{{ route('productivity-insight') }}" class="menu-button">
                                <i class="mr-2 fas fa-chart-bar"></i> Productivity Insight
                            </a>

                            <hr class="my-4" style="border-color: var(--border-color);">

                            <a href={{ route('setting') }} class="menu-button">
                                <i class="mr-2 fas fa-cog"></i> Settings
                            </a>
                        @else
                            <a href="{{ route('show.login') }}" class="menu-button">
                                <i class="mr-2 fas fa-sign-in-alt"></i> Login
                            </a>
                            <a href="{{ route('show.register') }}" class="menu-button">
                                <i class="mr-2 fas fa-user-plus"></i> Register
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>

            <div class="flex-1 p-8">
                <div class="p-6 rounded-lg shadow-lg" style="background-color: var(--bg-primary);">
                    <div id="calendar"></div>

                    <main class="container">
                        {{ $slot }}
                    </main>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const notificationButton = document.getElementById('notificationButton');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationDot = document.getElementById('notificationDot');
    const markAsReadButtons = document.querySelectorAll('.mark-as-read-btn');

    // Toggle dropdown and hide red dot
    notificationButton.addEventListener('click', function () {
        if (notificationDropdown) {
            notificationDropdown.classList.toggle('hidden');
        }
        if (notificationDot) {
            notificationDot.style.display = 'none'; // Hide the red dot
        }
    });

    // Mark task as read
    markAsReadButtons.forEach(button => {
        button.addEventListener('click', function () {
            const taskId = button.dataset.taskId;

            // Send AJAX request to mark the task as read
            fetch(`/notifications/mark-as-read/${taskId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mark the task as read in the UI
                        const taskElement = document.getElementById(`task-${taskId}`);
                        if (taskElement) {
                            taskElement.classList.add('task-read');
                        }
                        button.disabled = true;
                        button.textContent = 'Read';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
     </script>






</body>
</html>
