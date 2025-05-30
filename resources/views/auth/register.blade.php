<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart to do list</title>
    @vite('resources/css/app.css')
    <!-- AOS Animate On Scroll CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- VanillaTilt.js for 3D tilt -->
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.1/dist/vanilla-tilt.min.js"></script>
    <style>
        body {
            background: #23272f;
            color: #f3f4f6;
            font-family: 'Segoe UI', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .floating-svg {
            position: absolute;
            z-index: 0;
            opacity: 0.25;
            pointer-events: none;
            transition: transform 1s cubic-bezier(.23,1.01,.32,1);
        }
        .floating-svg-1 { top: 10%; left: 5%; width: 80px; animation: float1 8s ease-in-out infinite alternate; }
        .floating-svg-2 { top: 60%; left: 80%; width: 60px; animation: float2 10s ease-in-out infinite alternate; }
        .floating-svg-3 { top: 40%; left: 50%; width: 100px; animation: float3 12s ease-in-out infinite alternate; }
        @keyframes float1 { 0% { transform: translateY(0) rotate(0deg);} 100% { transform: translateY(-40px) rotate(20deg);} }
        @keyframes float2 { 0% { transform: translateY(0) scale(1);} 100% { transform: translateY(30px) scale(1.1);} }
        @keyframes float3 { 0% { transform: translateY(0) rotate(0deg);} 100% { transform: translateY(-20px) rotate(-15deg);} }
        .navbar {
            width: 100%;
            background: #23272f;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            height: 64px;
            box-shadow: 0 2px 8px #0002;
        }
        .navbar-content {
            width: 100%;
            max-width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: relative;
        }
        .navbar-logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
            letter-spacing: 2px;
            margin-right: auto;
        }
        .navbar-links {
            display: flex;
            gap: 2rem;
            transition: max-height 0.3s, opacity 0.3s;
            margin-left: auto;
        }
        .navbar-hamburger {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            cursor: pointer;
            z-index: 200;
        }
        .navbar-hamburger span {
            display: block;
            width: 28px;
            height: 4px;
            margin: 4px 0;
            background: #00eaff;
            border-radius: 2px;
            transition: 0.3s;
        }
        .navbar-link {
            color: #f3f4f6;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: color 0.2s;
        }
        .navbar-link:hover {
            color: #00eaff;
        }
        .main-content {
            padding-top: 90px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            width: 100%;
            max-width: 430px;
            padding: 2rem;
            background: rgba(30, 41, 59, 0.85);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8px);
            z-index: 1;
            margin: 1rem;
            transition: all 0.3s ease;
        }
        .register-title {
            font-size: clamp(1.5rem, 5vw, 2rem);
            font-weight: bold;
            color: #00eaff;
            text-align: center;
            margin-bottom: 0.5rem;
            text-shadow: 0 0 8px #00eaff, 0 0 16px #1a6cff;
        }
        .register-subtitle {
            font-size: clamp(0.875rem, 3vw, 1rem);
            color: #cbefff;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .register-btn, .edu-btn {
            width: 100%;
            padding: clamp(0.75rem, 2vw, 1rem) 1.5rem;
            font-size: clamp(0.875rem, 3vw, 1.1rem);
            border-radius: 9999px;
            margin-top: 1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .register-btn:hover, .edu-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 0 32px #00eaffcc;
            background: linear-gradient(90deg, #1a6cff 0%, #00eaff 100%);
        }
        .register-card input[type="email"],
        .register-card input[type="password"],
        .register-card input[type="text"],
        .register-card input[type="number"],
        .register-card select {
            width: 100%;
            padding: clamp(0.75rem, 2vw, 1rem);
            font-size: 16px; /* Prevents zoom on iOS */
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(0, 234, 255, 0.2);
            color: #fff;
            transition: all 0.3s ease;
        }
        .register-card input:focus,
        .register-card select:focus {
            border: 1.5px solid #00eaff;
        }
        .register-card label {
            display: block;
            margin-bottom: 0.5rem;
            color: #cbefff;
            font-size: clamp(0.875rem, 2.5vw, 0.95rem);
        }
        .register-card .text-red-500 {
            color: #ff6b6b;
        }
        .register-card .text-gray-600 {
            color: #cbefff;
        }
        .register-card .text-indigo-600 {
            color: #00eaff;
        }
        .register-card .text-indigo-600:hover {
            color: #1a6cff;
        }
        .flex.gap-2 {
            gap: clamp(0.5rem, 2vw, 1rem);
        }
        .w-1/2 {
            width: 100%;
        }
        @media (min-width: 640px) {
            .w-1/2 {
                width: 48%;
            }
        }
        @media (max-width: 640px) {
            .register-card {
                margin: 0.5rem;
                padding: 1.5rem;
                border-radius: 1rem;
            }
            .main-content {
                padding: 1rem;
                padding-top: 80px;
            }
            .flex.gap-2 {
                flex-direction: column;
            }
            .grid {
                gap: 0.75rem;
            }
            .edu-btn {
                padding: 0.875rem 1rem;
            }
            .navbar-content {
                padding: 0.5rem 1rem;
            }
            .navbar-logo {
                font-size: clamp(1.25rem, 4vw, 1.5rem);
            }
            .navbar-link {
                padding: 0.75rem 1rem;
            }
        }
        @media (max-width: 768px) {
            .navbar-hamburger {
                display: flex;
            }
            .navbar-links {
                position: absolute;
                top: 64px;
                left: 0;
                right: 0;
                background: #23272f;
                flex-direction: column;
                align-items: center;
                padding: 0;
                max-height: 0;
                overflow: hidden;
                opacity: 0;
                transition: all 0.3s ease;
            }
            .navbar-links.open {
                max-height: 300px;
                opacity: 1;
                padding: 1rem 0;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .navbar-link {
                width: 100%;
                text-align: center;
                padding: 0.75rem 1rem;
            }
        }
        @media (max-width: 480px) {
            body {
                font-size: 14px;
            }
            .register-card {
                margin: 0.25rem;
                padding: 1.25rem;
            }
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            select {
                padding: 0.75rem;
                margin-bottom: 0.75rem;
            }
            .register-btn, .edu-btn {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            .navbar {
                height: 56px;
            }
            .navbar-hamburger {
                width: 32px;
                height: 32px;
            }
            .navbar-hamburger span {
                width: 24px;
                height: 3px;
            }
            .navbar-links {
                top: 56px;
            }
        }
        /* Fix for iOS input zoom */
        @@supports (-webkit-touch-callout: none) {
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            select {
                font-size: 16px !important;
            }
        }
        /* Improve touch targets on mobile */
        @media (hover: none) and (pointer: coarse) {
            .register-btn, .edu-btn {
                min-height: 44px;
            }
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            select {
                min-height: 44px;
            }
            .navbar-link {
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
        /* Improve form layout on very small screens */
        @media (max-width: 360px) {
            .register-card {
                padding: 1rem;
            }
            .register-title {
                font-size: 1.25rem;
            }
            .register-subtitle {
                font-size: 0.875rem;
            }
            .mb-4 {
                margin-bottom: 0.75rem;
            }
            .grid {
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Floating SVG Decorative Elements -->
    <svg class="floating-svg floating-svg-1" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="#00eaff"/></svg>
    <svg class="floating-svg floating-svg-2" viewBox="0 0 100 100"><rect x="20" y="20" width="60" height="60" rx="20" fill="#1a6cff"/></svg>
    <svg class="floating-svg floating-svg-3" viewBox="0 0 100 100"><polygon points="50,10 90,90 10,90" fill="#fff"/></svg>
    <!-- Navbar -->
    <nav class="navbar" data-aos="fade-down" data-aos-duration="900">
        <div class="navbar-content">
            <div class="navbar-logo" data-aos="fade-right" data-aos-delay="200">Smart<span style="color:#00eaff;"> . </span>To Do List</div>
            <div id="navbar-hamburger" class="navbar-hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div id="navbar-links" class="navbar-links">
                <a href="/" class="navbar-link" data-aos="fade-down" data-aos-delay="300">Home</a>
                <a href="{{ route('show.login') }}" class="navbar-link" data-aos="fade-down" data-aos-delay="400">Login</a>
                <a href="{{ route('show.register') }}" class="navbar-link" data-aos="fade-down" data-aos-delay="500">Register</a>
            </div>
        </div>
    </nav>
    <div class="main-content">
        <div class="register-card tilt-card" data-aos="zoom-in" data-aos-duration="1000">
            <div>
                <h2 class="register-title">Join the Ninja Clan!</h2>
                <p class="register-subtitle">Start your journey to task mastery</p>
            </div>
            <form id="registerForm" class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div id="step1">
                    <div class="mb-4">
                        <label for="name">Full Name</label>
                        <input id="name" name="name" type="text" required placeholder="Full Name">
                    </div>
                    <div class="flex gap-2 mb-4">
                        <div class="w-1/2">
                            <label for="age">Age</label>
                            <input id="age" name="age" type="number" min="13" required placeholder="Age">
                        </div>
                        <div class="w-1/2">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="email">Email address</label>
                        <input id="email" name="email" type="email" required placeholder="Email address" value="{{ old('email') }}">
                    </div>
                    <div class="mb-4">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" required placeholder="Password">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Confirm Password">
                    </div>
                    @if ($errors->any())
                        <div class="mb-2 text-sm text-red-500">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <button type="button" id="nextStepBtn" class="register-btn">Next</button>
                </div>
                <div id="step2" style="display:none;">
                    <h2 class="mb-4 text-lg font-bold text-center">Educational Level</h2>
                    <div class="grid grid-cols-1 gap-4 mb-6">
                        <button type="button" class="edu-btn" data-value="elementary">Elementary</button>
                        <button type="button" class="edu-btn" data-value="high school">High School</button>
                        <button type="button" class="edu-btn" data-value="senior high">Senior High</button>
                        <button type="button" class="edu-btn" data-value="college">College</button>
                    </div>
                    <input type="hidden" name="educational_level" id="educational_level" required>
                    <div>
                        <button type="submit" class="register-btn">Create Account</button>
                    </div>
                </div>
            </form>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Already a ninja?
                    <a href="{{ route('show.login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>
    </div>
    <!-- AOS Animate On Scroll JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });
        // VanillaTilt 3D effect for card
        VanillaTilt.init(document.querySelectorAll('.tilt-card'), {
            max: 15,
            speed: 400,
            glare: true,
            'max-glare': 0.18,
            scale: 1.04,
        });
        // Hamburger menu for mobile
        document.addEventListener('DOMContentLoaded', function() {
            var hamburger = document.getElementById('navbar-hamburger');
            var links = document.getElementById('navbar-links');
            if (hamburger && links) {
                hamburger.addEventListener('click', function() {
                    links.classList.toggle('open');
                });
                links.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', function() {
                        links.classList.remove('open');
                    });
                });
            }
        });
    </script>
    <script>
        document.getElementById('nextStepBtn').onclick = function() {
            // Validate age
            var age = document.getElementById('age').value;
            if (parseInt(age) < 13) {
                alert('You must be at least 13 years old to register.');
                return;
            }
            // Validate gender
            var gender = document.getElementById('gender').value;
            if (!gender) {
                alert('Please select your gender.');
                return;
            }
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
        };
        document.querySelectorAll('.edu-btn').forEach(function(btn) {
            btn.onclick = function() {
                document.getElementById('educational_level').value = this.getAttribute('data-value');
                // Highlight selected
                document.querySelectorAll('.edu-btn').forEach(b => b.classList.remove('bg-blue-300'));
                this.classList.add('bg-blue-300');
            };
        });
        // Prevent submit if no educational level selected
        document.getElementById('registerForm').onsubmit = function() {
            if (!document.getElementById('educational_level').value) {
                alert('Please select your educational level.');
                return false;
            }
        };
    </script>
</body>
</html>
