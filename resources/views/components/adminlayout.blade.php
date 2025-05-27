<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ Auth::check() && Auth::user()->is_admin && Auth::user()->reference && Auth::user()->reference->settings ? Auth::user()->reference->settings->theme : 'dark' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart to do list - Admin</title>
    @vite('resources/css/app.css')
    <!-- AOS Animate On Scroll CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Theme Variables */
        :root[data-theme="dark"] {
            --primary-color: #00eaff;
            --secondary-color: #1a6cff;
            --bg-color: #23272f;
            --card-bg: rgba(30, 41, 59, 0.85);
            --text-color: #f3f4f6;
            --text-secondary: #cbefff;
            --border-color: rgba(255, 255, 255, 0.1);
            --hover-bg: rgba(255, 255, 255, 0.1);
            --shadow-color: rgba(0, 0, 0, 0.2);
            --gradient-start: #00eaff;
            --gradient-end: #1a6cff;
        }

        :root[data-theme="light"] {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --bg-color: #f0f7f4;
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-color: #2c3e50;
            --text-secondary: #34495e;
            --border-color: rgba(46, 204, 113, 0.2);
            --hover-bg: rgba(46, 204, 113, 0.1);
            --shadow-color: rgba(46, 204, 113, 0.15);
            --gradient-start: #2ecc71;
            --gradient-end: #27ae60;
        }

        body {
            background: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            transition: background-color 0.3s, color 0.3s;
        }

        .floating-svg {
            position: absolute;
            z-index: 0;
            opacity: 0.15;
            pointer-events: none;
            transition: transform 1s cubic-bezier(.23,1.01,.32,1);
        }

        [data-theme="dark"] .floating-svg-1 { fill: var(--primary-color); }
        [data-theme="dark"] .floating-svg-2 { fill: var(--secondary-color); }
        [data-theme="dark"] .floating-svg-3 { fill: #fff; }

        [data-theme="light"] .floating-svg-1 { fill: #2ecc71; }
        [data-theme="light"] .floating-svg-2 { fill: #27ae60; }
        [data-theme="light"] .floating-svg-3 { fill: #34495e; }

        .floating-svg-1 { top: 10%; left: 5%; width: 80px; animation: float1 8s ease-in-out infinite alternate; }
        .floating-svg-2 { top: 60%; left: 80%; width: 60px; animation: float2 10s ease-in-out infinite alternate; }
        .floating-svg-3 { top: 40%; left: 50%; width: 100px; animation: float3 12s ease-in-out infinite alternate; }

        @keyframes float1 { 0% { transform: translateY(0) rotate(0deg);} 100% { transform: translateY(-40px) rotate(20deg);} }
        @keyframes float2 { 0% { transform: translateY(0) scale(1);} 100% { transform: translateY(30px) scale(1.1);} }
        @keyframes float3 { 0% { transform: translateY(0) rotate(0deg);} 100% { transform: translateY(-20px) rotate(-15deg);} }

        .navbar {
            width: 100%;
            background: var(--card-bg);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            height: 72px;
            box-shadow: 0 2px 8px #0002;
        }

        .navbar-content {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            position: relative;
        }

        .navbar-logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--text-color);
            letter-spacing: 2px;
            padding-left: 1rem;
        }

        .navbar-logo span {
            color: var(--primary-color);
        }

        .navbar-links {
            display: flex;
            gap: 2rem;
            transition: max-height 0.3s, opacity 0.3s;
            align-items: center;
            padding-right: 1rem;
        }

        .navbar-welcome {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .navbar-welcome-text {
            color: var(--text-color);
            font-weight: 500;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-welcome-text i {
            color: var(--primary-color);
            font-size: 1.3rem;
        }

        .navbar-logout-form {
            margin: 0;
            display: flex;
            align-items: center;
        }

        .navbar-logout-btn {
            background: transparent;
            color: var(--text-color);
            border: 2px solid var(--primary-color);
            border-radius: 9999px;
            padding: 0.6rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-logout-btn:hover {
            background: var(--primary-color);
            color: var(--bg-color);
            transform: translateY(-2px);
            box-shadow: 0 0 16px var(--shadow-color);
        }

        .navbar-logout-btn i {
            font-size: 1.1rem;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
            padding-top: 72px;
        }

        .sidebar {
            width: 280px;
            background: var(--card-bg);
            backdrop-filter: blur(8px);
            border-right: 1px solid var(--border-color);
            padding: 2rem 1rem;
            position: fixed;
            height: calc(100vh - 72px);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 0 1rem 1.5rem 1rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 1rem;
            border: 3px solid var(--primary-color);
            box-shadow: 0 0 20px var(--shadow-color);
            transition: transform 0.3s ease;
        }

        .profile-picture:hover {
            transform: scale(1.05);
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.25rem;
        }

        .profile-role {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .sidebar-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .sidebar-subtitle {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .menu-item {
            color: var(--text-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            margin-bottom: 0.5rem;
            border: 1px solid transparent;
        }

        .menu-item:hover {
            background: var(--hover-bg);
            border-color: var(--border-color);
        }

        .menu-item.active {
            background: linear-gradient(90deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            color: white;
            border: none;
        }

        .menu-item i {
            width: 24px;
            text-align: center;
            margin-right: 0.75rem;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .content-card {
            background: var(--card-bg);
            backdrop-filter: blur(8px);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 8px 32px var(--shadow-color);
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }

        .btn {
            background: linear-gradient(90deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            color: white;
            border: none;
            border-radius: 9999px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 12px var(--shadow-color);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--shadow-color);
        }

        .input-field {
            background: var(--card-bg);
            color: var(--text-color);
            border: 1.5px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            width: 100%;
            font-size: 1rem;
            outline: none;
            transition: border 0.2s;
        }

        .input-field:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px var(--shadow-color);
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 240px;
            }
            .main-content {
                margin-left: 240px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .navbar-hamburger {
                display: flex;
            }
        }

        /* Theme Transition */
        * {
            transition: background-color 0.3s, color 0.3s, border-color 0.3s, box-shadow 0.3s;
        }

        .navbar-hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            cursor: pointer;
            padding: 0;
            background: transparent;
            border: none;
            z-index: 1000;
        }

        .navbar-hamburger span {
            display: block;
            width: 100%;
            height: 3px;
            background: var(--text-color);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .navbar-hamburger.active span:nth-child(1) {
            transform: translateY(9px) rotate(45deg);
        }

        .navbar-hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .navbar-hamburger.active span:nth-child(3) {
            transform: translateY(-9px) rotate(-45deg);
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
            padding-top: 72px;
        }

        @media (max-width: 768px) {
            .navbar-hamburger {
                display: flex;
            }

            .navbar-links {
                position: fixed;
                top: 72px;
                left: 0;
                right: 0;
                background: var(--card-bg);
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
                transform: translateY(-100%);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px var(--shadow-color);
            }

            .navbar-links.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }

            .navbar-welcome {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                width: 100%;
            }

            .navbar-welcome-text {
                width: 100%;
                padding: 0.5rem 0;
            }

            .navbar-logout-form {
                width: 100%;
            }

            .navbar-logout-btn {
                width: 100%;
                justify-content: center;
            }

            .admin-container {
                flex-direction: column;
            }

            .sidebar {
                position: fixed;
                left: -280px;
                top: 72px;
                bottom: 0;
                width: 280px;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .sidebar.open {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .content-card {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .navbar-logo {
                font-size: 1.25rem;
            }

            .content-card {
                padding: 0.75rem;
            }

            .profile-picture {
                width: 80px;
                height: 80px;
            }

            .profile-name {
                font-size: 1rem;
            }

            .profile-role {
                font-size: 0.75rem;
            }

            .menu-item {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }

        /* Responsive Typography */
        @media (max-width: 768px) {
            html {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            html {
                font-size: 12px;
            }
        }

        /* Responsive Tables */
        @media (max-width: 768px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table {
                min-width: 600px;
            }
        }

        /* Responsive Forms */
        @media (max-width: 768px) {
            .form-group {
                margin-bottom: 1rem;
            }

            .input-field {
                font-size: 16px; /* Prevents zoom on iOS */
            }

            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        /* Responsive Images */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Responsive Grid System */
        .grid {
            display: grid;
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .grid-cols-2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 768px) {
            .grid-cols-3 {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .grid-cols-4 {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
    <script>
        // Theme handling for admin only
        document.addEventListener('DOMContentLoaded', function() {
            // Check for admin theme in localStorage
            const savedAdminTheme = localStorage.getItem('adminTheme');
            if (savedAdminTheme) {
                document.documentElement.setAttribute('data-theme', savedAdminTheme);
            }

            // Listen for theme changes from admin settings
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'data-theme') {
                        const newTheme = document.documentElement.getAttribute('data-theme');
                        localStorage.setItem('adminTheme', newTheme); // Use admin-specific key
                    }
                });
            });

            observer.observe(document.documentElement, { attributes: true });
        });
    </script>
</head>
<body>
    <!-- Floating SVG Decorative Elements -->
    <svg class="floating-svg floating-svg-1" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="#00eaff"/></svg>
    <svg class="floating-svg floating-svg-2" viewBox="0 0 100 100"><rect x="20" y="20" width="60" height="60" rx="20" fill="#1a6cff"/></svg>
    <svg class="floating-svg floating-svg-3" viewBox="0 0 100 100"><polygon points="50,10 90,90 10,90" fill="#fff"/></svg>

    <!-- Navbar -->
    <nav class="navbar" data-aos="fade-down" data-aos-duration="900">
        <div class="navbar-content">
            <div class="navbar-logo" data-aos="fade-right" data-aos-delay="200">
                Smart<span style="color: var(--primary-color);"> . </span>To Do List
            </div>
            <div id="navbar-hamburger" class="navbar-hamburger" style="display: none;">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div id="navbar-links" class="navbar-links">
                @auth
                    <div class="navbar-welcome" data-aos="fade-down" data-aos-delay="300">
                        <div class="navbar-welcome-text">
                            <i class="fas fa-user-circle"></i>
                            Welcome, {{ Auth::user()->name }}
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="navbar-logout-form" data-aos="fade-down" data-aos-delay="400">
                            @csrf
                            <button type="submit" class="navbar-logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar" data-aos="fade-right" data-aos-duration="1000">
            <div class="sidebar-header">
                <h2 class="sidebar-title">Admin Panel</h2>
                @auth
                    <div class="profile-section">
                        <div class="profile-picture">
                            @php
                                $user = Auth::user();
                                $reference = $user->reference;
                                $settings = $reference ? $reference->settings : null;

                                $profilePicture = "https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&background=0D9488&color=fff";

                                if ($settings && $settings->profile_picture) {
                                    if (strpos($settings->profile_picture, 'uploads/profile_pictures/') === 0) {
                                        $profilePicture = asset($settings->profile_picture);
                                    } else {
                                        $profilePicture = asset('uploads/profile_pictures/' . $settings->profile_picture);
                                    }
                                }
                            @endphp
                            <img src="{{ $profilePicture }}" alt="Profile Picture" class="profile-img">
                        </div>
                        <div class="profile-name">{{ Auth::user()->name }}</div>
                        <div class="profile-role">Administrator</div>
                    </div>
                @endauth
            </div>

            <nav class="space-y-2">
                @auth
                    <a href="{{ route('user-manage') }}" class="menu-item {{ request()->routeIs('user-manage') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i> Manage Users
                    </a>
                    <a href="{{ route('send-announcement') }}" class="menu-item {{ request()->routeIs('send-announcement') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i> Announcements
                    </a>
                    <a href="{{ route('read-feedback') }}" class="menu-item {{ request()->routeIs('read-feedback') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i> Feedbacks
                    </a>

                    <hr class="my-4" style="border-color: var(--border-color);">

                    <a href="{{ route('AdminSetting') }}" class="menu-item {{ request()->routeIs('AdminSetting') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                @endauth
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            {{ $slot }}
        </main>
    </div>

    <!-- AOS Animate On Scroll JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('navbar-hamburger');
            const navbarLinks = document.getElementById('navbar-links');
            const sidebar = document.querySelector('.sidebar');

            if (hamburger) {
                hamburger.addEventListener('click', function() {
                    this.classList.toggle('active');
                    navbarLinks.classList.toggle('active');
                    if (sidebar) {
                        sidebar.classList.toggle('open');
                    }
                });
            }

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.navbar-hamburger') &&
                    !event.target.closest('.navbar-links') &&
                    !event.target.closest('.sidebar')) {
                    if (hamburger) hamburger.classList.remove('active');
                    if (navbarLinks) navbarLinks.classList.remove('active');
                    if (sidebar) sidebar.classList.remove('open');
                }
            });

            // Handle sidebar toggle on mobile
            if (sidebar) {
                const menuItems = sidebar.querySelectorAll('.menu-item');
                menuItems.forEach(item => {
                    item.addEventListener('click', () => {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.remove('open');
                            if (hamburger) hamburger.classList.remove('active');
                            if (navbarLinks) navbarLinks.classList.remove('active');
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>
