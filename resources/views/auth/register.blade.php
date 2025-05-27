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
            max-width: 1200px;
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
        }
        .navbar-links {
            display: flex;
            gap: 2rem;
            transition: max-height 0.3s, opacity 0.3s;
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
            padding: 2.5rem 2rem 2rem 2rem;
            background: rgba(30, 41, 59, 0.85);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8px);
            z-index: 1;
            margin: 2rem 0;
        }
        .register-title {
            font-size: 2rem;
            font-weight: bold;
            color: #00eaff;
            text-align: center;
            margin-bottom: 0.5rem;
            text-shadow: 0 0 8px #00eaff, 0 0 16px #1a6cff;
        }
        .register-subtitle {
            color: #cbefff;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .register-btn, .edu-btn {
            background: linear-gradient(90deg, #00eaff 0%, #1a6cff 100%);
            color: #fff;
            border: none;
            border-radius: 9999px;
            padding: 0.75rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            box-shadow: 0 0 16px #00eaff99;
            transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
            width: 100%;
            margin-top: 1rem;
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
            background: rgba(255,255,255,0.08);
            color: #fff;
            border: 1.5px solid #00eaff44;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            width: 100%;
            font-size: 1rem;
            outline: none;
            transition: border 0.2s;
        }
        .register-card input:focus,
        .register-card select:focus {
            border: 1.5px solid #00eaff;
        }
        .register-card label {
            color: #cbefff;
            font-size: 0.95rem;
            margin-bottom: 0.2rem;
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
        @media (max-width: 600px) {
            .navbar-content {
                flex-direction: column;
                gap: 0.5rem;
                padding: 0.5rem 0.5rem 0.5rem 0.5rem;
                align-items: center;
            }
            .navbar-logo {
                margin-bottom: 0.5rem;
                width: 100%;
                text-align: center;
            }
            .navbar-hamburger {
                display: flex;
                position: absolute;
                top: 10px;
                right: 10px;
            }
            .navbar-links {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
                width: 100%;
                background: #23272f;
                position: absolute;
                top: 50px;
                left: 0;
                right: 0;
                max-height: 0;
                overflow: hidden;
                opacity: 0;
                pointer-events: none;
                box-shadow: 0 8px 32px 0 #0006;
                border-radius: 0 0 1rem 1rem;
            }
            .navbar-links.open {
                max-height: 400px;
                opacity: 1;
                pointer-events: auto;
                padding-bottom: 1rem;
            }
            .navbar-link {
                font-size: 1rem;
                padding: 0.5rem 1.2rem;
                width: 100%;
                text-align: center;
            }
            .main-content {
                padding-top: 90px;
            }
            .register-card {
                padding: 1.5rem 0.5rem 1.5rem 0.5rem;
                max-width: 98vw;
            }
        }
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: var(--bg-color);
        }
        .auth-card {
            width: 100%;
            max-width: 400px;
            background: rgba(30, 41, 59, 0.7);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 8px 32px rgba(0, 234, 255, 0.1);
            border: 1px solid rgba(0, 234, 255, 0.1);
            backdrop-filter: blur(12px);
            position: relative;
            overflow: hidden;
        }
        .auth-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 234, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            pointer-events: none;
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }
        .auth-title {
            font-size: 2rem;
            font-weight: bold;
            color: #00eaff;
            text-align: center;
            margin-bottom: 0.5rem;
            text-shadow: 0 0 20px rgba(0, 234, 255, 0.5);
            letter-spacing: 2px;
            position: relative;
        }
        .auth-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg,
                transparent 0%,
                #00eaff 50%,
                transparent 100%);
            border-radius: 3px;
        }
        .auth-subtitle {
            color: rgba(203, 239, 255, 0.8);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        .form-group::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg,
                transparent 0%,
                rgba(0, 234, 255, 0.2) 50%,
                transparent 100%);
        }
        .form-label {
            color: #cbefff;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
            display: block;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 0 0 10px rgba(0, 234, 255, 0.3);
        }
        .form-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(0, 234, 255, 0.2);
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            color: #f3f4f6;
            font-size: 1rem;
            width: 100%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            backdrop-filter: blur(4px);
            letter-spacing: 0.5px;
        }
        .form-input:hover {
            border-color: rgba(0, 234, 255, 0.4);
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 234, 255, 0.1);
        }
        .form-input:focus {
            border-color: #00eaff;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 3px rgba(0, 234, 255, 0.15),
                       0 0 20px rgba(0, 234, 255, 0.1);
            outline: none;
            transform: translateY(-2px);
        }
        .form-input::placeholder {
            color: rgba(203, 239, 255, 0.4);
            font-style: italic;
        }
        .form-input.input-error {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.05);
            animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        }
        @keyframes shake {
            10%, 90% { transform: translateX(-1px); }
            20%, 80% { transform: translateX(2px); }
            30%, 50%, 70% { transform: translateX(-4px); }
            40%, 60% { transform: translateX(4px); }
        }
        .form-input.input-error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15),
                       0 0 20px rgba(239, 68, 68, 0.1);
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.75rem;
            display: block;
            text-shadow: 0 0 10px rgba(239, 68, 68, 0.3);
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .auth-button {
            background: linear-gradient(90deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 1rem;
        }
        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--shadow-color);
        }
        .auth-links {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        .auth-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .auth-link:hover {
            color: var(--secondary-color);
        }
        .password-requirements {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
        .password-requirements ul {
            list-style: none;
            padding-left: 0;
            margin-top: 0.25rem;
        }
        .password-requirements li {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-bottom: 0.25rem;
        }
        .password-requirements li i {
            font-size: 0.625rem;
        }
        .requirement-met {
            color: var(--primary-color);
        }
        .requirement-unmet {
            color: var(--text-secondary);
        }
        @media (max-width: 480px) {
            .auth-container {
                padding: 1rem;
            }
            .auth-card {
                padding: 1.5rem;
            }
            .auth-logo {
                width: 60px;
                height: 60px;
            }
            .auth-title {
                font-size: 1.25rem;
            }
            .auth-subtitle {
                font-size: 0.75rem;
            }
            .form-input {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            .auth-button {
                padding: 0.625rem;
                font-size: 0.875rem;
            }
        }
        /* Error Messages */
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }
        .input-error {
            border-color: #ef4444 !important;
        }
        .input-error:focus {
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
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
        <div class="auth-container">
            <div class="auth-card" data-aos="fade-up" data-aos-duration="1000">
                <div class="auth-header">
                    <h1 class="auth-title">Create Account</h1>
                    <p class="auth-subtitle">Join us to start managing your tasks</p>
                </div>
                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-input @error('name') input-error @enderror"
                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-input @error('email') input-error @enderror"
                            value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password"
                            class="form-input @error('password') input-error @enderror"
                            required autocomplete="new-password">
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <div class="password-requirements">
                            <p>Password must contain:</p>
                            <ul>
                                <li class="requirement-unmet" id="length">
                                    <i class="fas fa-circle"></i> At least 8 characters
                                </li>
                                <li class="requirement-unmet" id="uppercase">
                                    <i class="fas fa-circle"></i> One uppercase letter
                                </li>
                                <li class="requirement-unmet" id="lowercase">
                                    <i class="fas fa-circle"></i> One lowercase letter
                                </li>
                                <li class="requirement-unmet" id="number">
                                    <i class="fas fa-circle"></i> One number
                                </li>
                                <li class="requirement-unmet" id="special">
                                    <i class="fas fa-circle"></i> One special character
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-input" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="auth-button">
                        Create Account
                    </button>
                    <div class="auth-links">
                        <p>
                            Already have an account?
                            <a href="{{ route('show.login') }}" class="auth-link">Sign in</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- AOS Animate On Scroll JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            disable: 'mobile'
        });
        // Password validation
        const password = document.getElementById('password');
        const requirements = {
            length: document.getElementById('length'),
            uppercase: document.getElementById('uppercase'),
            lowercase: document.getElementById('lowercase'),
            number: document.getElementById('number'),
            special: document.getElementById('special')
        };
        password.addEventListener('input', function() {
            const value = this.value;

            // Check length
            if (value.length >= 8) {
                requirements.length.classList.remove('requirement-unmet');
                requirements.length.classList.add('requirement-met');
            } else {
                requirements.length.classList.remove('requirement-met');
                requirements.length.classList.add('requirement-unmet');
            }
            // Check uppercase
            if (/[A-Z]/.test(value)) {
                requirements.uppercase.classList.remove('requirement-unmet');
                requirements.uppercase.classList.add('requirement-met');
            } else {
                requirements.uppercase.classList.remove('requirement-met');
                requirements.uppercase.classList.add('requirement-unmet');
            }
            // Check lowercase
            if (/[a-z]/.test(value)) {
                requirements.lowercase.classList.remove('requirement-unmet');
                requirements.lowercase.classList.add('requirement-met');
            } else {
                requirements.lowercase.classList.remove('requirement-met');
                requirements.lowercase.classList.add('requirement-unmet');
            }
            // Check number
            if (/[0-9]/.test(value)) {
                requirements.number.classList.remove('requirement-unmet');
                requirements.number.classList.add('requirement-met');
            } else {
                requirements.number.classList.remove('requirement-met');
                requirements.number.classList.add('requirement-unmet');
            }
            // Check special character
            if (/[!@#$%^&*]/.test(value)) {
                requirements.special.classList.remove('requirement-unmet');
                requirements.special.classList.add('requirement-met');
            } else {
                requirements.special.classList.remove('requirement-met');
                requirements.special.classList.add('requirement-unmet');
            }
        });
    </script>
    <script>
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
</body>
</html>
