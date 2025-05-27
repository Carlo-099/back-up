<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ Auth::check() && !Auth::user()->is_admin && Auth::user()->reference && Auth::user()->reference->settings ? Auth::user()->reference->settings->theme : 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart to do list</title>

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animate On Scroll CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @vite('resources/css/app.css')
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}">
    <!-- FullCalendar CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
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
            font-family: 'Inter', sans-serif;
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
            z-index: 1000;
            height: 72px;
            box-shadow: 0 2px 8px var(--shadow-color);
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
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-left: 1rem;
        }

        .navbar-logo img {
            width: 32px;
            height: 32px;
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

        .user-container {
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
            transition: transform 0.3s ease-in-out;
            z-index: 999;
            top: 72px;
        }

        .sidebar-header {
            padding: 0 1rem 1.5rem 1rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .sidebar-title {
            display: none; /* Hide the "User Panel" text */
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
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.expanded {
            margin-left: 0;
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

        /* Notification Styles */
        .notification-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            width: 360px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px var(--shadow-color);
            z-index: 1000;
            margin-top: 0.5rem;
        }

        .notification-header {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .notification-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }

        .notification-body {
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }

        .notification-item:hover {
            background: var(--hover-bg);
        }

        .notification-item.unread {
            background: var(--hover-bg);
        }

        .notification-content {
            flex: 1;
            margin-right: 1rem;
        }

        .notification-text {
            margin: 0;
            color: var(--text-color);
        }

        .notification-time {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .notification-status {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 0.25rem;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-in-progress {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .view-button {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .view-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--primary-color);
            color: white;
            border-radius: 9999px;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .notification-empty {
            padding: 2rem;
            text-align: center;
            color: var(--text-secondary);
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
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
                padding-top: calc(72px + 1rem);
            }

            .navbar-hamburger {
                display: flex;
            }

            .navbar-links {
                position: static;
                transform: none;
                opacity: 1;
                visibility: visible;
                background: transparent;
                box-shadow: none;
                padding: 0;
                flex-direction: row;
                align-items: center;
            }

            .navbar-welcome {
                flex-direction: row;
                align-items: center;
                gap: 1rem;
            }

            .navbar-welcome-text {
                width: auto;
                padding: 0;
            }

            .navbar-logout-form {
                width: auto;
            }

            .navbar-logout-btn {
                width: auto;
            }
        }

        /* Theme Transition */
        * {
            transition: background-color 0.3s, color 0.3s, border-color 0.3s, box-shadow 0.3s;
        }

        /* Notification Button Styles */
        .notification-button {
            position: relative;
            background: transparent;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .notification-button:hover {
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .notification-button i {
            font-size: 1.25rem;
        }

        .notification-dropdown.hidden {
            display: none;
        }

        .notification-dropdown:not(.hidden) {
            display: block;
        }

        .notification-section-header {
            padding: 0.5rem 1rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--hover-bg);
        }

        .notification-section-header h6 {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* Add these modal styles */
        .task-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .task-modal-content {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px var(--shadow-color);
            max-width: 500px;
            width: 90%;
            position: relative;
        }

        .task-modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1.5rem;
        }

        .task-modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        .task-modal-button {
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .task-modal-button.yes {
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .task-modal-button.no {
            background: transparent;
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }

        .task-modal-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        /* Update notification styles for light theme */
        [data-theme="light"] .notification-dropdown {
            background: var(--card-bg);
            border-color: var(--border-color);
            box-shadow: 0 4px 12px var(--shadow-color);
        }

        [data-theme="light"] .notification-item:hover {
            background: var(--hover-bg);
        }

        [data-theme="light"] .notification-item.unread {
            background: var(--hover-bg);
        }

        [data-theme="light"] .notification-status.status-pending {
            background: #e8f5e9;
            color: #2e7d32;
        }

        [data-theme="light"] .notification-status.status-in-progress {
            background: #e3f2fd;
            color: #1565c0;
        }

        [data-theme="light"] .notification-status.status-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        [data-theme="light"] .view-button {
            background: var(--primary-color);
            color: white;
        }

        [data-theme="light"] .view-button:hover {
            background: var(--secondary-color);
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        [data-theme="light"] .notification-badge {
            background: var(--primary-color);
            color: white;
        }

        [data-theme="light"] .notification-empty {
            color: var(--text-secondary);
        }

        /* Update modal styles for light theme */
        [data-theme="light"] .task-modal-content {
            background: var(--card-bg);
            box-shadow: 0 4px 12px var(--shadow-color);
        }

        [data-theme="light"] .task-modal-title {
            color: var(--text-color);
        }

        [data-theme="light"] .task-modal-button.yes {
            background: var(--primary-color);
            color: white;
        }

        [data-theme="light"] .task-modal-button.no {
            background: transparent;
            color: var(--text-color);
            border-color: var(--border-color);
        }

        [data-theme="light"] .task-modal-button:hover {
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        /* Add these styles for the custom notification */
        .custom-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: #f0fdf4; /* Light green background */
            border-left: 4px solid #22c55e; /* Green border */
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2); /* Green shadow */
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transform: translateX(120%);
            transition: transform 0.3s ease-in-out;
        }

        .custom-notification.show {
            transform: translateX(0);
        }

        .custom-notification i {
            color: #22c55e; /* Green icon */
            font-size: 1.25rem;
        }

        .custom-notification-content {
            color: #166534; /* Dark green text */
        }

        .custom-notification-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #166534; /* Dark green title */
        }

        .custom-notification-message {
            font-size: 0.875rem;
            color: #15803d; /* Slightly lighter green for message */
        }

        /* Dark theme adjustments */
        [data-theme="dark"] .custom-notification {
            background: #064e3b; /* Dark green background for dark theme */
            border-left-color: #34d399; /* Lighter green border for dark theme */
            box-shadow: 0 4px 12px rgba(52, 211, 153, 0.2);
        }

        [data-theme="dark"] .custom-notification i {
            color: #34d399; /* Lighter green icon for dark theme */
        }

        [data-theme="dark"] .custom-notification-content,
        [data-theme="dark"] .custom-notification-title {
            color: #d1fae5; /* Light green text for dark theme */
        }

        [data-theme="dark"] .custom-notification-message {
            color: #a7f3d0; /* Lighter green message for dark theme */
        }

        /* Add styles for the New label */
        .notification-text {
            margin: 0;
            color: var(--text-color);
            display: inline-block;
        }

        .notification-item.unread {
            background: var(--hover-bg);
        }

        .notification-item.unread .notification-text {
            font-weight: 600;
        }

        /* Update the New badge styles */
        .notification-item .bg-blue-500 {
            background: var(--primary-color) !important;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        [data-theme="dark"] .notification-item.unread {
            background: rgba(255, 255, 255, 0.05);
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

        @media (max-width: 480px) {
            .navbar-logo {
                font-size: 1.25rem;
            }

            .navbar-logo img {
                width: 24px;
                height: 24px;
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

        /* Add styles for the sidebar toggle button */
        .sidebar-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px var(--shadow-color);
            z-index: 998;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px var(--shadow-color);
        }

        /* Add styles for sidebar transition */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                bottom: 80px; /* Move button up on mobile to avoid overlap with other elements */
            }
        }

        /* Update navbar styles for mobile */
        @media (max-width: 768px) {
            .navbar-content {
                padding: 0 0.5rem;
            }

            .navbar-logo {
                font-size: 1.25rem;
                padding-left: 0.5rem;
            }

            .navbar-logo img {
                width: 24px;
                height: 24px;
            }

            .navbar-links {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            /* Hide welcome text on mobile */
            .navbar-welcome {
                display: none;
            }

            .navbar-welcome-text {
                display: none;
            }

            /* Style notification button for mobile */
            .notification-button {
                padding: 0.5rem;
                font-size: 1.1rem;
            }

            .notification-badge {
                top: -2px;
                right: -2px;
                padding: 0.15rem 0.35rem;
                font-size: 0.7rem;
            }

            /* Style logout button for mobile */
            .navbar-logout-btn {
                padding: 0.5rem;
                font-size: 1rem;
                border-width: 1px;
            }

            .navbar-logout-btn i {
                margin-right: 0;
            }

            .navbar-logout-btn span {
                display: none; /* Hide "Logout" text, show only icon */
            }

            /* Adjust notification dropdown for mobile */
            .notification-dropdown {
                position: fixed;
                top: 72px;
                left: 0;
                right: 0;
                width: 100%;
                max-width: none;
                border-radius: 0;
                margin-top: 0;
                max-height: calc(100vh - 72px);
                overflow-y: auto;
            }
        }

        /* Add styles for extra small screens */
        @media (max-width: 480px) {
            .navbar-logo {
                font-size: 1.1rem;
            }

            .navbar-logo img {
                width: 20px;
                height: 20px;
            }

            .navbar-logout-btn {
                padding: 0.4rem;
            }

            .notification-button {
                padding: 0.4rem;
            }
        }

        /* Modern mobile calendar styles */
        @media (max-width: 768px) {
            /* Calendar container */
            #calendar {
                font-size: 0.9rem;
                background: var(--card-bg);
                border-radius: 1rem;
                overflow: hidden;
                box-shadow: 0 2px 8px var(--shadow-color);
            }

            /* Modern header style */
            .fc-toolbar {
                flex-direction: column;
                gap: 0.75rem;
                padding: 1rem;
                background: var(--card-bg);
                border-bottom: 1px solid var(--border-color);
                margin: 0 !important;
            }

            .fc-toolbar-title {
                font-size: 1.25rem !important;
                font-weight: 600;
                color: var(--text-color);
                text-align: center;
                margin: 0 !important;
                padding: 0.5rem 0;
            }

            /* Modern navigation buttons */
            .fc-toolbar-chunk {
                display: flex;
                justify-content: space-between;
                width: 100%;
                gap: 0.5rem;
            }

            .fc-button-group {
                display: flex;
                gap: 0.5rem;
                width: 100%;
            }

            .fc-button {
                flex: 1;
                padding: 0.75rem !important;
                font-size: 0.9rem !important;
                border-radius: 0.75rem !important;
                background: var(--card-bg) !important;
                border: 1px solid var(--border-color) !important;
                color: var(--text-color) !important;
                box-shadow: none !important;
                transition: all 0.2s ease;
            }

            .fc-button:hover {
                background: var(--hover-bg) !important;
                transform: translateY(-1px);
            }

            .fc-button-active {
                background: var(--primary-color) !important;
                border-color: var(--primary-color) !important;
                color: white !important;
            }

            /* Calendar grid */
            .fc-view-harness {
                min-height: 450px !important;
                background: var(--card-bg);
            }

            .fc-scrollgrid {
                border: none !important;
            }

            .fc-scrollgrid-section-header {
                background: var(--card-bg);
            }

            /* Day headers */
            .fc-col-header-cell {
                padding: 0.5rem 0 !important;
                background: var(--card-bg);
            }

            .fc-col-header-cell-cushion {
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--text-color);
                padding: 0.5rem !important;
                text-decoration: none !important;
            }

            /* Day cells */
            .fc-daygrid-day {
                min-height: 90px !important;
                border: 1px solid var(--border-color) !important;
                background: var(--card-bg);
            }

            .fc-daygrid-day-number {
                font-size: 0.9rem;
                font-weight: 500;
                padding: 0.5rem !important;
                color: var(--text-color);
                text-decoration: none !important;
            }

            /* Today highlight */
            .fc-day-today {
                background: var(--hover-bg) !important;
            }

            .fc-day-today .fc-daygrid-day-number {
                background: var(--primary-color);
                color: white;
                border-radius: 50%;
                width: 24px;
                height: 24px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin: 0.25rem;
            }

            /* Events */
            .fc-event {
                margin: 0.1rem 0.25rem !important;
                padding: 0.25rem 0.5rem !important;
                border-radius: 0.5rem !important;
                border: none !important;
                background: var(--primary-color) !important;
                color: white !important;
                font-size: 0.8rem !important;
                font-weight: 500;
                box-shadow: 0 2px 4px var(--shadow-color);
            }

            .fc-event-title {
                padding: 0.1rem 0 !important;
                font-weight: 500;
            }

            /* List view (for mobile) */
            .fc-list {
                border: none !important;
                background: var(--card-bg);
            }

            .fc-list-day-cushion {
                background: var(--card-bg) !important;
                padding: 0.75rem 1rem !important;
                border-bottom: 1px solid var(--border-color);
            }

            .fc-list-event {
                margin: 0.5rem 0 !important;
                padding: 0.75rem !important;
                border-radius: 0.75rem !important;
                background: var(--card-bg) !important;
                border: 1px solid var(--border-color) !important;
                transition: all 0.2s ease;
            }

            .fc-list-event:hover {
                transform: translateY(-1px);
                box-shadow: 0 2px 8px var(--shadow-color);
            }

            .fc-list-event-time {
                font-size: 0.8rem;
                color: var(--text-secondary);
                font-weight: 500;
            }

            .fc-list-event-title {
                font-size: 0.9rem;
                color: var(--text-color);
                font-weight: 600;
                margin-top: 0.25rem;
            }

            /* More link */
            .fc-daygrid-more-link {
                background: var(--hover-bg);
                color: var(--primary-color);
                font-size: 0.75rem;
                font-weight: 500;
                padding: 0.25rem 0.5rem;
                border-radius: 0.5rem;
                margin: 0.25rem;
            }

            /* View switcher */
            .fc-view-switcher {
                display: flex;
                gap: 0.5rem;
                padding: 0.5rem;
                background: var(--card-bg);
                border-bottom: 1px solid var(--border-color);
            }

            .fc-view-switcher-button {
                flex: 1;
                padding: 0.75rem;
                text-align: center;
                border-radius: 0.75rem;
                background: var(--card-bg);
                border: 1px solid var(--border-color);
                color: var(--text-color);
                font-weight: 500;
                transition: all 0.2s ease;
            }

            .fc-view-switcher-button.active {
                background: var(--primary-color);
                border-color: var(--primary-color);
                color: white;
            }
        }

        /* Extra small screen adjustments */
        @media (max-width: 480px) {
            .fc-toolbar-title {
                font-size: 1.1rem !important;
            }

            .fc-button {
                padding: 0.6rem !important;
                font-size: 0.8rem !important;
            }

            .fc-daygrid-day {
                min-height: 70px !important;
            }

            .fc-event {
                font-size: 0.75rem !important;
                padding: 0.2rem 0.4rem !important;
            }

            .fc-list-event {
                padding: 0.6rem !important;
            }

            .fc-list-event-title {
                font-size: 0.85rem;
            }
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
                const notificationItem = document.querySelector(`.notification-item[data-task-id="${taskId}"]`);
                if (notificationItem) {
                    notificationItem.style.display = 'none';
                }
            });
        }

        // Notification functionality
        document.addEventListener('DOMContentLoaded', function() {
            const notificationButton = document.getElementById('notificationButton');
            const notificationDropdown = document.getElementById('notificationDropdown');

            // Toggle notification dropdown
            if (notificationButton && notificationDropdown) {
                notificationButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!notificationButton.contains(e.target) && !notificationDropdown.contains(e.target)) {
                        notificationDropdown.classList.add('hidden');
                    }
                });

                // Handle view buttons in notifications
                const viewButtons = notificationDropdown.querySelectorAll('.view-button');
                viewButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const taskId = this.getAttribute('data-task-id');
                        const feedbackId = this.getAttribute('data-feedback-id');

                        if (taskId) {
                            showTaskModal(taskId);
                        } else if (feedbackId) {
                            showAdminResponseModal(feedbackId);
                        }
                    });
                });
            }

            // Function to show task modal
            window.showTaskModal = function(taskId) {
                const modal = document.getElementById('taskModal');
                if (modal) {
                    modal.style.display = 'flex';

                    // Set up the confirm button
                    document.getElementById('confirmTask').onclick = function() {
                        fetch(`/tasks/${taskId}/complete`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Hide the notification item
                                const notificationItem = document.querySelector(`.notification-item[data-task-id="${taskId}"]`);
                                if (notificationItem) {
                                    notificationItem.style.display = 'none';
                                }
                                // Close the modal
                                modal.style.display = 'none';
                                // Show custom notification
                                showCustomNotification();
                            } else {
                                showCustomNotification('Error', data.message || 'Failed to complete task. Please try again.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showCustomNotification('Error', 'An error occurred while completing the task. Please try again.');
                        });
                    };

                    // Mark task as viewed when opening modal
                    fetch(`/tasks/${taskId}/mark-viewed`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove unread styling and New badge
                            const notificationItem = document.querySelector(`.notification-item[data-task-id="${taskId}"]`);
                            if (notificationItem) {
                                notificationItem.classList.remove('unread', 'bg-blue-50');
                                const badge = notificationItem.querySelector('.bg-blue-500');
                                if (badge) badge.remove();
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));

                    // Set up the cancel button
                    document.getElementById('cancelTask').onclick = function() {
                        modal.style.display = 'none';
                    };
                }
            };

            // Function to show admin response modal
            window.showAdminResponseModal = function(feedbackId) {
                const modal = document.getElementById('adminResponseModal');
                const modalContent = document.getElementById('adminResponseModalContent');

                if (modal && modalContent && window.feedbackData) {
                    const feedback = window.feedbackData.find(f => f.feedback_id == feedbackId);
                    if (feedback) {
                        // First, remove the "New" badge and unread styling
                        const notificationItem = document.querySelector(`.notification-item[data-feedback-id="${feedbackId}"]`);
                        if (notificationItem) {
                            notificationItem.classList.remove('unread', 'bg-blue-50');
                            const badge = notificationItem.querySelector('.bg-blue-500');
                            if (badge) badge.remove();
                        }

                        modalContent.innerHTML = `
                            <h3 class="task-modal-title">Admin Response</h3>
                            <div class="p-4">
                                <p class="mb-2"><strong>Your Feedback:</strong> ${feedback.message}</p>
                                <p class="mb-4"><strong>Admin's Response:</strong> ${feedback.admin_response}</p>
                                <p class="text-sm text-gray-500">Last updated: ${feedback.updated_at}</p>
                            </div>
                            <div class="task-modal-buttons">
                                <button class="task-modal-button yes" onclick="this.closest('.task-modal').style.display='none'">Close</button>
                            </div>
                        `;
                        modal.style.display = 'flex';

                        // Only mark as read if it's not already read
                        if (!feedback.is_read) {
                            fetch(`/feedback/mark-as-read/${feedbackId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update the feedback data to reflect the read status
                                    feedback.is_read = true;
                                } else {
                                    console.error('Failed to mark feedback as read');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        }
                    }
                }
            };

            // Function to show announcement modal
            window.showAnnouncementModal = function(announcementId) {
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
            };

            // Close modals when clicking outside
            window.addEventListener('click', function(e) {
                const taskModal = document.getElementById('taskModal');
                const adminResponseModal = document.getElementById('adminResponseModal');

                if (e.target === taskModal) {
                    taskModal.style.display = 'none';
                }
                if (e.target === adminResponseModal) {
                    adminResponseModal.style.display = 'none';
                }
            });
        });

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

        // Theme handling for regular users only
        document.addEventListener('DOMContentLoaded', function() {
            const userId = {{ Auth::id() }}; // Get current user's ID
            const userThemeKey = `userTheme_${userId}`; // Create user-specific key

            // Check for user's theme in localStorage
            const savedUserTheme = localStorage.getItem(userThemeKey);
            if (savedUserTheme) {
                document.documentElement.setAttribute('data-theme', savedUserTheme);
            }

            // Listen for theme changes from user settings
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'data-theme') {
                        const newTheme = document.documentElement.getAttribute('data-theme');
                        localStorage.setItem(userThemeKey, newTheme); // Use user-specific key
                    }
                });
            });

            observer.observe(document.documentElement, { attributes: true });
        });

        // Add this function to show custom notification
        function showCustomNotification() {
            const notification = document.getElementById('customNotification');
            notification.classList.add('show');

            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
    </script>
</head>
<body>
    <!-- Add sidebar toggle button -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Floating SVG Decorative Elements -->
    <svg class="floating-svg floating-svg-1" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="#00eaff"/></svg>
    <svg class="floating-svg floating-svg-2" viewBox="0 0 100 100"><rect x="20" y="20" width="60" height="60" rx="20" fill="#1a6cff"/></svg>
    <svg class="floating-svg floating-svg-3" viewBox="0 0 100 100"><polygon points="50,10 90,90 10,90" fill="#fff"/></svg>

    <!-- Navbar -->
    <nav class="navbar" data-aos="fade-down" data-aos-duration="900">
        <div class="navbar-content">
            <div class="navbar-logo" data-aos="fade-right" data-aos-delay="200">
                <img src="/images/logo.png" alt="Logo">
                Smart<span>. </span>To Do List
            </div>
            <div id="navbar-hamburger" class="navbar-hamburger" style="display: none;">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div id="navbar-links" class="navbar-links">
                @auth
                    <!-- Welcome text (hidden on mobile) -->
                    <div class="navbar-welcome" data-aos="fade-down" data-aos-delay="300">
                        <div class="navbar-welcome-text">
                            <i class="fas fa-user-circle"></i>
                            Welcome, {{ Auth::user()->name }}
                        </div>
                    </div>
                    <!-- Notification Button -->
                    <div class="relative">
                        <button id="notificationButton" class="notification-button">
                            <i class="fas fa-bell"></i>
                            @php
                                $currentUser = Auth::user();
                                $userId = $currentUser ? $currentUser->id : null;
                                $hasUnreadNotifications = \App\Models\Notification::where('user_id', $userId)
                                    ->where('status', 'unread')
                                    ->exists();
                                $unreadCount = \App\Models\Notification::where('user_id', $userId)
                                    ->where('status', 'unread')
                                    ->count();
                            @endphp
                            @if ($hasUnreadNotifications)
                                <span class="notification-badge">{{ $unreadCount }}</span>
                            @endif
                        </button>
                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" class="hidden notification-dropdown">
                            <div class="notification-header">
                                <h6 class="notification-title">Notifications</h6>
                            </div>

                            <div class="notification-body">
                                @php
                                    // Debug: Print current user info
                                    $currentUser = Auth::user();
                                    $userId = $currentUser ? $currentUser->id : null;

                                    // Get tasks for current user only
                                    $tasks = \App\Models\Task::with('category')
                                        ->where('user_id', $userId)
                                        ->whereDate('due_date', now()->toDateString())
                                        ->get();

                                    // Get feedback for current user only
                                    $feedbackNotifications = \App\Models\Feedback::where('user_id', $userId)
                                        ->whereNotNull('admin_response')
                                        ->where('updated_at', '>=', now()->subDays(3)) // Only get admin responses from last 3 days
                                        ->orderBy('updated_at', 'desc')
                                        ->get();

                                    // Get announcements for current user only
                                    $announcements = \App\Models\Announcement::with('user')
                                        ->where(function($query) use ($userId) {
                                            $query->where('user_id', $userId)
                                                ->orWhere('is_public', true);
                                        })
                                        ->where('created_at', '>=', now()->subDays(3)) // Only get announcements from last 3 days
                                        ->orderBy('created_at', 'desc')
                                        ->take(5)
                                        ->get();

                                    // Debug information
                                    echo "<!-- Debug Info:
                                    User ID: " . $userId . "
                                    Tasks Count: " . $tasks->count() . "
                                    Feedback Count: " . $feedbackNotifications->count() . "
                                    Announcements Count: " . $announcements->count() . "
                                    -->";
                                @endphp

                                @if(!$userId)
                                    <div class="notification-item">
                                        <div class="notification-content">
                                            <p class="notification-text">Please log in to view notifications</p>
                                        </div>
                                    </div>
                                @else
                                    <!-- Section Headers -->
                                    @if($announcements->isNotEmpty())
                                        <div class="notification-section-header">
                                            <h6 class="mb-2 text-sm font-semibold text-gray-500">Announcements</h6>
                                        </div>
                                    @endif

                                    <!-- Announcement Notifications -->
                                    @forelse ($announcements as $announcement)
                                            <div class="notification-item {{ $announcement->isReadBy($userId) ? '' : 'unread bg-blue-50' }}" data-announcement-id="{{ $announcement->announcement_id }}">
                                            <div class="flex items-center notification-content">
                                                <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;margin-right:10px;">
                                                    <i class="text-blue-500 fas fa-bullhorn"></i>
                                                </span>
                                                <div>
                                                        <span class="font-semibold">{{ $announcement->title ?? 'Announcement' }}</span>
                                                        @if(!$announcement->isReadBy($userId))
                                                        <span class="ml-2 inline-block px-2 py-0.5 text-xs font-bold text-white bg-blue-500 rounded-full align-middle">New</span>
                                                    @endif
                                                    <br>
                                                    <span class="notification-time">{{ $announcement->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <button class="view-button" onclick="showAnnouncementModal({{ $announcement->announcement_id }})">View</button>
                                        </div>
                                    @empty
                                            <!-- No announcements -->
                                    @endforelse

                                        @if($feedbackNotifications->isNotEmpty())
                                            <div class="notification-section-header">
                                                <h6 class="mb-2 text-sm font-semibold text-gray-500">Admin Responses</h6>
                                            </div>
                                        @endif

                                    <!-- Admin Response Notifications -->
                                    @forelse ($feedbackNotifications as $feedback)
                                        <div class="notification-item {{ !$feedback->is_read ? 'unread bg-blue-50' : '' }}" data-feedback-id="{{ $feedback->feedback_id }}">
                                            <div class="flex items-center notification-content">
                                                <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;margin-right:10px;">
                                                    <i class="text-blue-500 fas fa-comment"></i>
                                                </span>
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-semibold notification-text">{{ $feedback->title ?? 'Admin Response' }}</span>
                                                        @if(!$feedback->is_read)
                                                            <span class="ml-2 inline-block px-2 py-0.5 text-xs font-bold text-white bg-blue-500 rounded-full align-middle">New</span>
                                                        @endif
                                                    </div>
                                                    <br>
                                                    <span class="notification-time">{{ $feedback->updated_at->format('d M Y H:i') }}</span>
                                                </div>
                                            </div>
                                            <button class="view-button" onclick="showAdminResponseModal({{ $feedback->feedback_id }})">View</button>
                                        </div>
                                    @empty
                                            <!-- No feedback -->
                                    @endforelse

                                        @if($tasks->isNotEmpty())
                                            <div class="notification-section-header">
                                                <h6 class="mb-2 text-sm font-semibold text-gray-500">Today's Tasks</h6>
                                            </div>
                                        @endif

                                    <!-- Task Notifications -->
                                    @forelse ($tasks as $task)
                                        <div class="notification-item {{ !$task->is_viewed ? 'unread bg-blue-50' : '' }}" data-task-id="{{ $task->task_id }}">
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
                                                    <div class="flex items-center gap-2">
                                                        <p class="notification-text">{{ $task->title }}</p>
                                                        @if(!$task->is_viewed)
                                                            <span class="ml-2 inline-block px-2 py-0.5 text-xs font-bold text-white bg-blue-500 rounded-full align-middle">New</span>
                                                        @endif
                                                    </div>
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
                                @endif
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="navbar-logout-form" data-aos="fade-down" data-aos-delay="400">
                        @csrf
                        <button type="submit" class="navbar-logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="user-container">
        <!-- Sidebar -->
        <aside class="sidebar" data-aos="fade-right" data-aos-duration="1000">
            <div class="sidebar-header">
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
                        <div class="profile-role">User</div>
                    </div>
                @endauth
            </div>

            <nav class="space-y-2">
                @auth
                    <a href="{{ route('content') }}" class="menu-item {{ request()->routeIs('content') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Calendar
                    </a>
                    <a href="{{ route('status') }}" class="menu-item {{ request()->routeIs('status') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Status
                    </a>
                    <a href="{{ route('category') }}" class="menu-item {{ request()->routeIs('category') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i> Category
                    </a>
                    <a href="{{ route('feedback') }}" class="menu-item {{ request()->routeIs('feedback') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i> Feedback
                    </a>
                    <a href="{{ route('productivity-insight') }}" class="menu-item {{ request()->routeIs('productivity-insight') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i> Productivity Insight
                    </a>

                    <hr class="my-4" style="border-color: var(--border-color);">

                    <a href="{{ route('setting') }}" class="menu-item {{ request()->routeIs('setting') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                @else
                    <a href="{{ route('show.login') }}" class="menu-item">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('show.register') }}" class="menu-item">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                @endauth
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-card">
                <div id="calendar"></div>
                {{ $slot }}
            </div>
        </main>
    </div>

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
                'is_read' => $f->is_read
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

    <!-- AOS Animate On Scroll JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });

        // Update the mobile menu toggle script
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('navbar-hamburger');
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const navbarLinks = document.getElementById('navbar-links');

            // Toggle sidebar with the floating button
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                    // Update button icon
                    const icon = this.querySelector('i');
                    if (sidebar.classList.contains('hidden')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    const isClickInsideSidebar = sidebar && sidebar.contains(event.target);
                    const isClickOnToggle = sidebarToggle && sidebarToggle.contains(event.target);

                    if (!isClickInsideSidebar && !isClickOnToggle && sidebar && sidebar.classList.contains('open')) {
                        sidebar.classList.remove('open');
                        const icon = sidebarToggle.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    if (sidebar) sidebar.classList.remove('open');
                    if (sidebarToggle) {
                        const icon = sidebarToggle.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            });
        });
    </script>

    <!-- Add this HTML for the custom notification -->
    <div id="customNotification" class="custom-notification">
        <i class="fas fa-check-circle"></i>
        <div class="custom-notification-content">
            <div class="custom-notification-title">Success!</div>
            <div class="custom-notification-message">Congratulations for completing the task!</div>
        </div>
    </div>
</body>
</html>
