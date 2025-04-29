<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ Auth::check() && Auth::user()->reference && Auth::user()->reference->settings ? Auth::user()->reference->settings->theme : 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart to do lists</title>

    @vite('resources/css/app.css')
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}">
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

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar {
            background-color: var(--topnavbar-bg) !important;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand, .nav-link {
            color: var(--text-primary) !important;
        }

        .sidebar {
            background-color: var(--sidenavbar-bg);
            border-right: 1px solid var(--border-color);
        }

        .menu-item {
            color: var(--text-primary);
            transition: background-color 0.2s;
        }

        .menu-item:hover {
            background-color: var(--hover-color);
        }

        .card {
            background-color: var(--bg-primary);
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
                            <button class="relative p-2 rounded-full" style="color: var(--text-primary);">
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
            <div class="w-64 min-h-screen shadow-md sidebar">
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
                            <a href="{{ route('user-manage') }}" class="block px-4 py-2 rounded-md menu-item hover:bg-gray-100">
                                <i class="mr-2 fas fa-users-cog"></i> Manage User
                            </a>
                            <a href="{{ route('send-announcement') }}" class="block px-4 py-2 rounded-md menu-item hover:bg-gray-100">
                                <i class="mr-2 fas fa-bullhorn"></i> User Announcement
                            </a>
                            <a href="{{ route('read-feedback') }}" class="block px-4 py-2 rounded-md menu-item hover:bg-gray-100">
                                <i class="mr-2 fas fa-comments"></i> Read Feedbacks
                            </a>

                            <hr class="my-4" style="border-color: var(--border-color);">

                            <a href={{ route('AdminSetting') }} class="block px-4 py-2 rounded-md menu-item hover:bg-gray-100">
                                <i class="mr-2 fas fa-cog"></i> Settings
                            </a>
                        @else
                            <a href="{{ route('show.login') }}" class="block px-4 py-2 rounded-md menu-item hover:bg-gray-100">
                                <i class="mr-2 fas fa-sign-in-alt"></i> Login
                            </a>
                            <a href="{{ route('show.register') }}" class="block px-4 py-2 rounded-md menu-item hover:bg-gray-100">
                                <i class="mr-2 fas fa-user-plus"></i> Register
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>

            <div class="flex-1 p-8">
                <div class="p-6 rounded-lg shadow-lg" style="background-color: var(--bg-primary);">
            <main class="container">
                {{ $slot }}
            </main>

            </div>
            </div>

        </div>
     </div>
    </body>
</html>
