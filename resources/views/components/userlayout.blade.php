<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ Auth::check() && Auth::user()->reference && Auth::user()->reference->settings ? Auth::user()->reference->settings->theme : 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart to do list</title>

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}">
    <!-- FullCalendar CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <style>
        /* Apply Inter font to all elements */
        * {
            font-family: 'Inter', sans-serif;
        }

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

        /* Material Design Notification Styles */
        .notification-dropdown {
            width: 320px;
            max-height: 400px;
            overflow-y: auto;
            padding: 0;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: none;
            margin-top: 8px;
            background: var(--bg-primary);
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 1000;
        }

        .notification-header {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--bg-primary);
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .notification-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-primary);
            margin: 0;
        }

        .notification-item {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .notification-item:hover {
            background-color: var(--hover-color);
        }

        .notification-item.unread {
            background-color: rgba(var(--accent-color-rgb), 0.05);
        }

        .notification-content {
            flex-grow: 1;
            min-width: 0;
            margin-right: 12px;
        }

        .notification-text {
            margin: 0;
            color: var(--text-primary);
            font-size: 0.9rem;
            line-height: 1.4;
            font-weight: 400;
        }

        .notification-time {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        .notification-status {
            font-size: 0.8rem;
            padding: 2px 8px;
            border-radius: 12px;
            margin-top: 4px;
            display: inline-block;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-in-progress {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-overdue {
            background-color: #f8d7da;
            color: #721c24;
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background-color: #f44336;
            color: white;
            border-radius: 50%;
            min-width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .notification-empty {
            padding: 32px 16px;
            text-align: center;
            color: var(--text-secondary);
        }

        /* Custom Scrollbar */
        .notification-dropdown::-webkit-scrollbar {
            width: 4px;
        }

        .notification-dropdown::-webkit-scrollbar-track {
            background: transparent;
        }

        .notification-dropdown::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 2px;
        }

        .notification-dropdown::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }

        /* Navbar Notification Icon */
        .nav-link .fa-bell {
            font-size: 1.25rem;
            color: var(--text-primary);
            transition: transform 0.2s;
        }

        .nav-link:hover .fa-bell {
            color: var(--accent-color);
            transform: scale(1.1);
        }

        /* View Button */
        .view-button {
            padding: 6px 12px;
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            white-space: nowrap;
        }

        .view-button:hover {
            background-color: var(--accent-color-dark, #0056b3);
        }

        /* Notification Types */
        .notification-icon.task {
            background-color: #2196f3;
        }

        .notification-icon.comment {
            background-color: #4caf50;
        }

        .notification-icon.deadline {
            background-color: #ff9800;
        }

        .notification-icon.mention {
            background-color: #9c27b0;
        }

        /* Modal Styles */
        .task-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1100;
            align-items: center;
            justify-content: center;
        }

        .task-modal-content {
            background-color: var(--bg-primary);
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        .task-modal-title {
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .task-modal-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 24px;
        }

        .task-modal-button {
            padding: 8px 24px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .task-modal-button.yes {
            background-color: var(--accent-color);
            color: white;
            border: none;
        }

        .task-modal-button.yes:hover {
            background-color: var(--accent-color-dark, #0056b3);
        }

        .task-modal-button.no {
            background-color: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .task-modal-button.no:hover {
            background-color: var(--hover-color);
        }

        .notification-body {
            max-height: 20rem;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #8CB4E2 #f1f1f1;
        }
        .notification-body::-webkit-scrollbar {
            width: 6px;
        }
        .notification-body::-webkit-scrollbar-thumb {
            background: #8CB4E2;
            border-radius: 3px;
        }
        .notification-body::-webkit-scrollbar-track {
            background: #f1f1f1;
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
                                        <span class="notification-badge">3</span>
                                    @endif
                                </button>

                                <!-- Notification Dropdown -->
                                <div id="notificationDropdown" class="hidden notification-dropdown">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Notifications</h6>
                                    </div>

                                    <div class="notification-body">
                                        @php
                                            $tasks = \App\Models\Task::with('category')
                                                ->where('user_id', Auth::id())
                                                ->whereDate('due_date', now()->toDateString())
                                                ->get();
                                            $feedbackNotifications = \App\Models\Feedback::where('user_id', Auth::id())
                                                ->whereNotNull('admin_response')
                                                ->orderBy('updated_at', 'desc')
                                                ->get();

                                            // Get recent announcements
                                            $announcements = \App\Models\Announcement::with('user')
                                                ->orderBy('created_at', 'desc')
                                                ->take(5)
                                                ->get();
                                        @endphp

                                        <!-- Announcement Notifications -->
                                        @forelse ($announcements as $announcement)
                                            <div class="notification-item {{ $announcement->isReadBy(Auth::id()) ? '' : 'unread bg-blue-50' }}" data-announcement-id="{{ $announcement->announcement_id }}">
                                                <div class="flex items-center notification-content">
                                                    <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;margin-right:10px;">
                                                        <i class="text-blue-500 fas fa-bullhorn"></i>
                                                    </span>
                                                    <div>
                                                        <span class="font-semibold">Announcement</span>
                                                        @if(!$announcement->isReadBy(Auth::id()))
                                                            <span class="ml-2 inline-block px-2 py-0.5 text-xs font-bold text-white bg-blue-500 rounded-full align-middle">New</span>
                                                        @endif
                                                        <br>
                                                        <span class="notification-time">{{ $announcement->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                                <button class="view-button" onclick="showAnnouncementModal({{ $announcement->announcement_id }})">View</button>
                                            </div>
                                        @empty
                                        @endforelse

                                        <!-- Admin Response Notifications -->
                                        @forelse ($feedbackNotifications as $feedback)
                                            <div class="notification-item {{ $feedback->is_read ? '' : 'unread bg-blue-50' }}" data-feedback-id="{{ $feedback->feedback_id }}">
                                                <div class="flex items-center notification-content">
                                                    <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;margin-right:10px;">
                                                        <i class="text-blue-500 fas fa-comment"></i>
                                                    </span>
                                                    <div>
                                                        <span class="font-semibold">From Admin</span>
                                                        @if(!$feedback->is_read)
                                                            <span class="ml-2 inline-block px-2 py-0.5 text-xs font-bold text-white bg-blue-500 rounded-full align-middle">New</span>
                                                        @endif
                                                        <br>
                                                        <span class="notification-time">{{ $feedback->updated_at->format('d M Y H:i') }}</span>
                                                    </div>
                                                </div>
                                                <button class="view-button" data-feedback-id="{{ $feedback->feedback_id }}">View</button>
                                            </div>
                                        @empty
                                        @endforelse

                                        <!-- Task Notifications -->
                                        @forelse ($tasks as $task)
                                            <div class="notification-item unread" data-task-id="{{ $task->task_id }}">
                                                <div class="flex items-center notification-content">
                                                    <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;margin-right:10px;">
                                                        @if($task->category)
                                                            @if($task->category->category_type === 'home')
                                                                <i class="text-blue-500 fas fa-home"></i>
                                                            @elseif($task->category->category_type === 'school')
                                                                <i class="text-green-500 fas fa-graduation-cap"></i>
                                                            @elseif($task->category->category_type === 'outdoors')
                                                                <i class="text-yellow-500 fas fa-tree"></i>
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <div>
                                                        <p class="notification-text">{{ $task->title }}</p>
                                                        <span class="notification-time">Due: {{ $task->due_date->format('d M Y') }}</span>
                                                        <span class="notification-status status-{{ strtolower(str_replace(' ', '-', $task->status)) }}">
                                                            {{ $task->status }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <button class="view-button" data-task-id="{{ $task->task_id }}">View</button>
                                            </div>
                                        @empty
                                            @if($feedbackNotifications->isEmpty() && $announcements->isEmpty())
                                                <div class="notification-empty">
                                                    <p>No new notifications</p>
                                                </div>
                                            @endif
                                        @endforelse
                                    </div>
                                </div>
                            </div>

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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('taskModal');
        const confirmButton = document.getElementById('confirmTask');
        const cancelButton = document.getElementById('cancelTask');
        let currentTaskId = null;
        let currentFeedbackId = null;

        // Admin Response Modal
        const adminModal = document.getElementById('adminResponseModal');
        const adminModalContent = document.getElementById('adminResponseModalContent');

        // Add click event listeners to all view buttons
        document.querySelectorAll('.view-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (this.dataset.taskId) {
                    currentTaskId = this.dataset.taskId;
                    currentFeedbackId = null;
                    modal.style.display = 'flex';
                    // Mark the task as read
                    fetch(`/notifications/mark-as-read/${currentTaskId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove unread classes and badge dynamically
                            const notifItem = document.querySelector(`.notification-item[data-task-id='${currentTaskId}']`);
                            if (notifItem) {
                                notifItem.classList.remove('unread', 'bg-blue-50');
                                const badge = notifItem.querySelector('.bg-blue-500');
                                if (badge) badge.remove();
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
                } else if (this.dataset.feedbackId) {
                    currentFeedbackId = this.dataset.feedbackId;
                    currentTaskId = null;
                    // Find feedback data from a JS object (injected below)
                    const feedbackData = window.feedbackData.find(f => f.feedback_id == currentFeedbackId);
                    if (feedbackData) {
                        adminModalContent.innerHTML = `
                            <div class="flex flex-col items-stretch justify-center w-full max-w-md p-6 mx-auto bg-white rounded-lg shadow-lg">
                                <h3 class="mb-4 text-xl font-bold text-center task-modal-title">
                                    Admin Response Details
                                </h3>
                                <div class="space-y-4 text-justify">
                                    <div>
                                        <div class="text-xs font-semibold text-center text-gray-500 uppercase">Title</div>
                                        <div class="font-medium text-center text-gray-800">${feedbackData.title}</div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="flex items-start gap-2">
                                        <span class="text-green-500"><i class="fas fa-comment-alt"></i></span>
                                        <div>
                                            <div class="text-xs font-semibold text-gray-500 uppercase">Your Message</div>
                                            <div class="text-gray-700">${feedbackData.message}</div>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="flex items-start gap-2">
                                        <span class="text-indigo-500"><i class="fas fa-reply"></i></span>
                                        <div>
                                            <div class="text-xs font-semibold text-gray-500 uppercase">Admin's Response</div>
                                            <div class="text-gray-700">${feedbackData.admin_response}</div>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="flex items-start gap-2">
                                        <span class="text-gray-400"><i class="fas fa-clock"></i></span>
                                        <div>
                                            <div class="text-xs font-semibold text-gray-500 uppercase">Response received</div>
                                            <div class="text-gray-600">${feedbackData.updated_at}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-center mt-6 task-modal-buttons">
                                    <button class="px-6 py-2 font-semibold text-gray-800 bg-gray-200 rounded task-modal-button no hover:bg-gray-300" id="closeAdminModal">Close</button>
                                </div>
                            </div>
                        `;
                        adminModal.style.display = 'flex';
                        document.getElementById('closeAdminModal').onclick = function() {
                            adminModal.style.display = 'none';
                        };
                    }
                    // Mark the feedback as read
                    fetch(`/feedback/mark-as-read/${currentFeedbackId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove unread classes and badge dynamically
                            const notifItem = document.querySelector(`.notification-item[data-feedback-id='${currentFeedbackId}']`);
                            if (notifItem) {
                                notifItem.classList.remove('unread', 'bg-blue-50');
                                const badge = notifItem.querySelector('.bg-blue-500');
                                if (badge) badge.remove();
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });

        // Handle Yes button click
        confirmButton.addEventListener('click', function() {
            if (currentTaskId) {
                window.location.href = `/category?task=${currentTaskId}`;
            }
            modal.style.display = 'none';
        });

        // Handle No button click
        cancelButton.addEventListener('click', function() {
            modal.style.display = 'none';
            currentTaskId = null;
            currentFeedbackId = null;
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === adminModal) {
                adminModal.style.display = 'none';
            }
            if (e.target === modal) {
                modal.style.display = 'none';
                currentTaskId = null;
                currentFeedbackId = null;
            }
        });
    });
</script>

<!-- Add the modal HTML structure -->
<div id="taskModal" class="task-modal">
    <div class="task-modal-content">
        <h3 class="task-modal-title">Set this activity as Completed?</h3>
        <div class="task-modal-buttons">
            <button class="task-modal-button yes" id="confirmTask">Yes</button>
            <button class="task-modal-button no" id="cancelTask">No</button>
        </div>
    </div>
</div>

<!-- Admin Response Modal -->
<div id="adminResponseModal" class="task-modal">
    <div class="task-modal-content" id="adminResponseModalContent">
        <!-- Content will be injected by JS -->
    </div>
</div>

@php
    $feedbackData = $feedbackNotifications->map(function($f) {
        return [
            'feedback_id' => $f->feedback_id,
            'title' => $f->title,
            'message' => $f->message,
            'admin_response' => $f->admin_response,
            'updated_at' => $f->updated_at->format('d M Y H:i'),
        ];
    })->values()->all();
@endphp

<script>
window.feedbackData = @json($feedbackData);
</script>

<!-- Announcement Modal -->
<div id="announcementModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" onclick="closeAnnouncementModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="sm:flex sm:items-start">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <i class="text-blue-600 fas fa-bullhorn"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        Announcement
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500" id="announcementContent"></p>
                    </div>
                    <div class="mt-4 text-xs text-gray-400" id="announcementTime"></div>
                </div>
            </div>
            <div class="mt-5 sm:mt-6">
                <button type="button" onclick="closeAnnouncementModal()" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to show announcement modal
    function showAnnouncementModal(announcementId) {
        // Fetch announcement content
        fetch(`/announcement/${announcementId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('announcementContent').textContent = data.message_anounce;
                document.getElementById('announcementTime').textContent = `Posted ${new Date(data.created_at).toLocaleString()}`;
                document.getElementById('announcementModal').classList.remove('hidden');

                // Remove the "New" badge and unread styling
                const notificationItem = document.querySelector(`.notification-item[data-announcement-id="${announcementId}"]`);
                if (notificationItem) {
                    notificationItem.classList.remove('unread', 'bg-blue-50');
                    const badge = notificationItem.querySelector('.bg-blue-500');
                    if (badge) badge.remove();
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Function to close announcement modal
    function closeAnnouncementModal() {
        document.getElementById('announcementModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('announcementModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAnnouncementModal();
        }
    });
</script>

</body>
</html>
