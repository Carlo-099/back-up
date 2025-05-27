<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Theme Variables */
        :root[data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --border-color: #dee2e6;
            --accent-color: #0d6efd;
            --hover-color: #e9ecef;
            --notification-bg: #ffffff;
            --notification-hover: #f8f9fa;
            --notification-border: #e9ecef;
            --notification-unread: #e3f2fd;
            --notification-badge: #dc3545;
            --text-color: #212529;
            --feedback-bg: #e6faf0;
            --feedback-border: #b6e7d8;
            --feedback-heading: #14532d;
            --feedback-title: #166534;
            --feedback-text: #14532d;
            --feedback-label: #166534;
            --feedback-accent: #16a34a;
            --feedback-success-bg: #d1fae5;
            --feedback-success-text: #166534;
            --feedback-error-bg: #fee2e2;
            --feedback-error-text: #b91c1c;
            --feedback-input-bg: #fff;
            --feedback-input-border: #b6e7d8;
            --feedback-input-text: #14532d;
            --feedback-btn-bg: #16a34a;
            --feedback-btn-text: #fff;
            --feedback-btn-border: #16a34a;
            --feedback-btn-alt-bg: #d1fae5;
            --feedback-btn-alt-text: #166534;
            --feedback-btn-alt-border: #b6e7d8;
            --feedback-admin-bg: #d1fae5;
            --feedback-admin-label: #166534;
            --feedback-admin-text: #14532d;
        }

        :root[data-theme="dark"] {
            --bg-primary: #1a1f2e;
            --bg-secondary: #2a2f3e;
            --text-primary: #e9ecef;
            --text-secondary: #adb5bd;
            --border-color: #495057;
            --accent-color: #4dabf7;
            --hover-color: #343a40;
            --notification-bg: #2a2f3e;
            --notification-hover: #343a40;
            --notification-border: #495057;
            --notification-unread: #1a237e;
            --notification-badge: #dc3545;
            --text-color: #e9ecef;
            --feedback-bg: #23293a;
            --feedback-border: #38405a;
            --feedback-heading: #a5b4fc;
            --feedback-title: #c7d2fe;
            --feedback-text: #e0e7ef;
            --feedback-label: #a5b4fc;
            --feedback-accent: #60a5fa;
            --feedback-success-bg: #23293a;
            --feedback-success-text: #a7f3d0;
            --feedback-error-bg: #3b2231;
            --feedback-error-text: #fca5a5;
            --feedback-input-bg: #1e2533;
            --feedback-input-border: #38405a;
            --feedback-input-text: #e0e7ef;
            --feedback-btn-bg: #6366f1;
            --feedback-btn-text: #fff;
            --feedback-btn-border: #6366f1;
            --feedback-btn-alt-bg: #23293a;
            --feedback-btn-alt-text: #a5b4fc;
            --feedback-btn-alt-border: #38405a;
            --feedback-admin-bg: #23293a;
            --feedback-admin-label: #a5b4fc;
            --feedback-admin-text: #e0e7ef;
        }

        /* Theme Transition */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Original Navbar Styles */
        .navbar {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: #1a2b36 !important;
            font-weight: 600;
        }

        .nav-link {
            color: #3a4a56 !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #2ecc71 !important;
        }

        .nav-link.active {
            color: #2ecc71 !important;
            font-weight: 600;
        }

        .navbar-toggler {
            border-color: #e5e7eb;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            border-color: #2ecc71;
        }

        /* Dark Mode Toggle Button */
        #theme-toggle {
            padding: 0.5rem;
            cursor: pointer;
            color: #3a4a56;
        }

        #theme-toggle:hover {
            color: #2ecc71;
        }

        #theme-toggle i {
            font-size: 1.1rem;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
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

        /* Facebook-style Notification Styles */
        .notification-dropdown {
            width: 360px;
            max-height: 480px;
            overflow-y: auto;
            padding: 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.1);
            border: none;
            margin-top: 8px;
            background: var(--bg-primary);
        }

        .notification-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--bg-primary);
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .notification-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .notification-actions {
            display: flex;
            gap: 8px;
        }

        .notification-actions button {
            color: var(--accent-color);
            padding: 4px 8px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .notification-actions button:hover {
            background-color: var(--hover-color);
        }

        .notification-item {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            cursor: pointer;
            position: relative;
        }

        .notification-item:hover {
            background-color: var(--hover-color);
        }

        .notification-item.unread::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background-color: var(--accent-color);
        }

        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e4e6eb;
            color: #1877f2;
            flex-shrink: 0;
            font-size: 1.1rem;
        }

        .notification-content {
            flex-grow: 1;
            min-width: 0;
        }

        .notification-text {
            margin: 0;
            color: var(--text-primary);
            font-size: 0.9375rem;
            line-height: 1.3333;
            font-weight: 400;
        }

        .notification-time {
            font-size: 0.8125rem;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background-color: #e41e3f;
            color: white;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            font-weight: 600;
        }

        .notification-footer {
            padding: 12px;
            text-align: center;
            border-top: 1px solid var(--border-color);
            background-color: var(--bg-primary);
        }

        .notification-footer a {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 600;
        }

        .notification-footer a:hover {
            text-decoration: underline;
        }

        .notification-empty {
            padding: 32px 16px;
            text-align: center;
            color: var(--text-secondary);
        }

        .notification-empty i {
            font-size: 2rem;
            margin-bottom: 8px;
            opacity: 0.5;
        }

        /* Custom Scrollbar */
        .notification-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .notification-dropdown::-webkit-scrollbar-track {
            background: transparent;
        }

        .notification-dropdown::-webkit-scrollbar-thumb {
            background: #bcc0c4;
            border-radius: 3px;
        }

        .notification-dropdown::-webkit-scrollbar-thumb:hover {
            background: #8b8d90;
        }

        /* Navbar Notification Icon */
        .nav-link .fa-bell {
            font-size: 1.25rem;
            color: var(--text-primary);
        }

        .nav-link:hover .fa-bell {
            color: var(--accent-color);
        }

        /* Notification Types */
        .notification-icon.task {
            background-color: #e7f3ff;
            color: #1877f2;
        }

        .notification-icon.comment {
            background-color: #e4e6eb;
            color: #1877f2;
        }

        .notification-icon.deadline {
            background-color: #fff4e5;
            color: #f7b928;
        }

        .notification-icon.mention {
            background-color: #e7f3ff;
            color: #1877f2;
        }
    </style>
    @yield('styles')
</head>
<body>
    @yield('content')
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">TDL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tasks') }}">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('feedback') }}">Feedback</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <!-- Dark Mode Toggle -->
                    <li class="nav-item">
                        <button id="theme-toggle" class="bg-transparent border-0 nav-link" aria-label="Toggle dark mode">
                            <i class="fas fa-moon dark:hidden"></i>
                            <i class="hidden fas fa-sun dark:block"></i>
                        </button>
                    </li>
                    <!-- Notification Dropdown -->
                    <li class="nav-item dropdown" id="notificationContainer" style="display: none;">
                        <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </a>
                        <div class="dropdown-menu notification-dropdown">
                            <div class="notification-header">
                                <h6 class="notification-title">Notifications</h6>
                                <div class="notification-actions">
                                    <button class="btn btn-sm btn-link text-decoration-none" title="Mark all as read">
                                        <i class="fas fa-check-double"></i>
                                    </button>
                                    <button class="btn btn-sm btn-link text-decoration-none" title="Clear all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="notification-body">
                                <!-- Unread Notification -->
                                <div class="notification-item unread">
                                    <div class="notification-icon task">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text">New task assigned: Complete project documentation</p>
                                        <span class="notification-time">2 minutes ago</span>
                                    </div>
                                </div>

                                <!-- Read Notification -->
                                <div class="notification-item">
                                    <div class="notification-icon comment">
                                        <i class="fas fa-comment"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text">New comment on your task: "Great progress!"</p>
                                        <span class="notification-time">1 hour ago</span>
                                    </div>
                                </div>

                                <!-- Another Notification -->
                                <div class="notification-item">
                                    <div class="notification-icon deadline">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text">Upcoming deadline: Project review in 2 days</p>
                                        <span class="notification-time">3 hours ago</span>
                                    </div>
                                </div>
                            </div>

                            <div class="notification-footer">
                                <a href="#">See all notifications</a>
                            </div>
                        </div>
                    </li>
                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <div class="dropdown-item d-flex justify-content-between align-items-center">
                                    <span>Notifications</span>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notificationToggle" checked>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="margin-top: 70px;">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const html = document.documentElement;
            const notificationToggle = document.getElementById('notificationToggle');
            const notificationContainer = document.getElementById('notificationContainer');

            // Check for saved notification preference
            const notificationsEnabled = localStorage.getItem('notificationsEnabled') !== 'false';
            notificationToggle.checked = notificationsEnabled;
            notificationContainer.style.display = notificationsEnabled ? 'block' : 'none';

            // Handle notification toggle
            notificationToggle.addEventListener('change', function() {
                const enabled = this.checked;
                localStorage.setItem('notificationsEnabled', enabled);
                notificationContainer.style.display = enabled ? 'block' : 'none';
            });

            // Check for saved theme preference or use system preference
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
                html.setAttribute('data-theme', 'dark');
            } else {
                html.setAttribute('data-theme', 'light');
            }

            // Toggle theme
            themeToggle.addEventListener('click', function() {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';

                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            });

            // Example: Mark notification as read when clicked
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function() {
                    this.classList.remove('unread');
                    // Add your AJAX call here to mark as read
                });
            });

            // Example: Mark all as read
            document.querySelector('.notification-actions .fa-check-double').parentElement.addEventListener('click', function() {
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                });
                // Add your AJAX call here to mark all as read
            });

            // Example: Clear all notifications
            document.querySelector('.notification-actions .fa-trash').parentElement.addEventListener('click', function() {
                if (confirm('Are you sure you want to clear all notifications?')) {
                    document.querySelector('.notification-body').innerHTML = `
                        <div class="notification-empty">
                            <i class="fas fa-bell-slash"></i>
                            <p>No notifications</p>
                        </div>
                    `;
                    // Add your AJAX call here to clear all notifications
                }
            });
        });
    </script>
</body>
</html>
