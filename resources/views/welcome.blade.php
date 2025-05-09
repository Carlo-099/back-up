<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Smart to do list</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <noscript><link rel="stylesheet" href="{{ asset('assets/css/noscript.css') }}" /></noscript>
    @vite('resources/css/app.css')
    <style>
        .gradient-text {
            background: linear-gradient(45deg, #fff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .feature-card {
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .banner-text-main {
            color: #fff;
            font-weight: 800;
            letter-spacing: 2px;
        }
        .banner-text-sub {
            color: #e0e7ff;
            font-size: 1.5rem;
            font-weight: 500;
        }
        .banner-text-desc {
            color: #f3f4f6;
            font-size: 1.1rem;
        }
        .special.button.large, .special {
            background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
            color: #fff !important;
            border: none;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }
        .feature-card h3, .feature-card p {
            color: #f3f4f6;
        }
        .major.gradient-text {
            color: #fff;
            background: none;
            -webkit-text-fill-color: #fff;
        }
        .testimonials blockquote {
            color: #fff;
            border-left: 4px solid #60a5fa;
            background: rgba(96, 165, 250, 0.08);
        }
    </style>
</head>
<body class="is-preload">
    <!-- Page Wrapper -->
    <div id="page-wrapper">
        <!-- Header -->
        <header id="header" class="alt glass-effect">
            <h1>
                <a href="/" class="flex items-center">
                    <img src="/images/logo.png" alt="Logo" class="w-8 h-8 mr-2">
                    <span class="gradient-text">Smart to do list</span>
                </a>
            </h1>
            <nav>
                <a href="#menu">Menu</a>
            </nav>
        </header>

        <!-- Menu -->
        <nav id="menu">
            <div class="inner glass-effect">
                <h2>Menu</h2>
                <ul class="links">
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('show.login') }}">Login</a></li>
                    <li><a href="{{ route('show.register') }}">Register</a></li>
                </ul>
                <a href="#" class="close">Close</a>
            </div>
        </nav>

        <!-- Banner -->
        <section id="banner">
            <div class="inner">
                <div class="logo">
                    <span class="icon fa-gem"></span>
                </div>
                <h2 class="gradient-text banner-text-main">WELCOME TO SMART TO DO LIST</h2>
                <p class="banner-text-sub">MAKE THINGS ORGANIZED</p>
                <p class="banner-text-desc">Click the button below to view your tasks.</p>
                <a href="/ninjas" class="special button large">VIEW TASKS!</a>
            </div>
        </section>

        <!-- Wrapper -->
        <section id="wrapper">
            <!-- One -->
            <section id="one" class="wrapper spotlight style1">
                <div class="inner">
                    <div class="content">
                        <h2 class="major gradient-text">Organize Your Life</h2>
                        <p>Smart to do list helps you manage your tasks efficiently and stay organized. With our intuitive interface and powerful features, you'll never miss a deadline again.</p>
                        <a href="/ninjas" class="special">Get Started</a>
                    </div>
                </div>
            </section>

            <!-- Features -->
            <section id="features" class="wrapper alt style2">
                <div class="inner">
                    <h2 class="major gradient-text">Why Choose Us?</h2>
                    <div class="features">
                        <article class="feature-card">
                            <span class="icon solid fa-tasks"></span>
                            <h3 class="major">Smart Task Management</h3>
                            <p>Organize your tasks with our intuitive interface and never miss a deadline again.</p>
                        </article>
                        <article class="feature-card">
                            <span class="icon solid fa-bell"></span>
                            <h3 class="major">Smart Reminders</h3>
                            <p>Get timely notifications and reminders to keep you on track with your tasks.</p>
                        </article>
                        <article class="feature-card">
                            <span class="icon solid fa-chart-line"></span>
                            <h3 class="major">Progress Tracking</h3>
                            <p>Monitor your productivity and track your progress with detailed analytics.</p>
                        </article>
                        <article class="feature-card">
                            <span class="icon solid fa-sync"></span>
                            <h3 class="major">Real-time Sync</h3>
                            <p>Access your tasks from anywhere with our cloud-based synchronization.</p>
                        </article>
                    </div>
                </div>
            </section>

            <!-- Testimonials -->
            <section id="testimonials" class="wrapper spotlight style3">
                <div class="inner">
                    <div class="content">
                        <h2 class="major gradient-text">What Our Users Say</h2>
                        <div class="testimonials">
                            <blockquote class="glass-effect">
                                "This app has completely transformed how I manage my daily tasks. It's intuitive and powerful!"
                            </blockquote>
                            <blockquote class="glass-effect">
                                "The best task management app I've ever used. Simple yet feature-rich!"
                            </blockquote>
                        </div>
                    </div>
                </div>
            </section>
        </section>

        <!-- Footer -->
        <section id="footer">
            <div class="inner glass-effect">
                <h2 class="major gradient-text">Get Started Today</h2>
                <p>Join thousands of users who have transformed their productivity with Smart to do list. Sign up now and experience the difference.</p>
                <ul class="actions">
                    <li><a href="{{ route('show.register') }}" class="button large">Sign Up Now</a></li>
                </ul>
                <ul class="copyright">
                    <li>&copy; Smart to do list. All rights reserved.</li>
                </ul>
            </div>
        </section>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollex.min.js') }}"></script>
    <script src="{{ asset('assets/js/browser.min.js') }}"></script>
    <script src="{{ asset('assets/js/breakpoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/util.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
