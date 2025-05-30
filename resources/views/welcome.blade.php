<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        }
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
            padding-top: 80px;
        }
        .section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 1rem 0 1rem;
        }
        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 2.5rem 0 2rem 0;
            text-align: center;
        }
        .hero {
            position: relative;
            width: 100%;
            min-height: 420px;
            background: url('/images/hero.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(30, 34, 44, 0.7);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
            max-width: 700px;
            margin: 0 auto;
            padding: 3rem 0 3rem 0;
        }
        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: 1px;
        }
        .hero-desc {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #e0e7ef;
        }
        .hero-btn {
            background: #00eaff;
            color: #23272f;
            border: none;
            border-radius: 9999px;
            padding: 0.75rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .hero-btn:hover {
            background: #009ec3;
            color: #fff;
        }
        .about-section {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 2.5rem;
            margin-top: 2.5rem;
        }
        .about-img {
            width: 320px;
            height: 220px;
            object-fit: cover;
            border-radius: 1rem;
            box-shadow: 0 4px 24px #0004;
        }
        .about-content {
            flex: 1;
        }
        .about-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .about-desc {
            color: #cbd5e1;
            margin-bottom: 1.2rem;
        }
        .about-mission {
            color: #00eaff;
            font-weight: 600;
        }
        .services-section {
            margin-top: 3.5rem;
        }
        .services-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 2.5rem 0 2rem 0;
            text-align: center;
        }
        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }
        .service-card {
            min-width: 0;
            background: #23272f;
            border-radius: 1rem;
            box-shadow: 0 2px 16px #0003;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            margin-bottom: 0;
        }
        .service-bg {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }
        .service-title {
            padding: 1rem;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .projects-section {
            margin-top: 3.5rem;
        }
        .projects-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 2.5rem 0 2rem 0;
            text-align: center;
        }
        .projects-img {
            width: 100%;
            max-width: 900px;
            height: 260px;
            object-fit: cover;
            border-radius: 1rem;
            box-shadow: 0 4px 24px #0004;
            display: block;
            margin: 0 auto 2rem auto;
        }
        .projects-cards-row {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
            margin-top: 0;
        }
        .project-card {
            background: #23272f;
            border-radius: 1rem;
            box-shadow: 0 2px 16px #0003;
            width: 260px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            margin-bottom: 0;
        }
        .project-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }
        .project-card-content {
            padding: 1rem;
        }
        .project-card-title {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        .project-card-desc {
            color: #cbd5e1;
            font-size: 0.95rem;
        }
        @media (max-width: 1100px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 900px) {
            .section {
                padding: 2rem 0.5rem 0 0.5rem;
            }
            .services-grid {
                grid-template-columns: 1fr;
            }
            .projects-img {
                height: 180px;
            }
            .projects-cards-row {
                flex-direction: column;
                align-items: center;
                gap: 2rem;
            }
            .project-card {
                width: 95vw;
                max-width: 340px;
            }
            .about-section {
                flex-direction: column;
                gap: 1.5rem;
                align-items: center;
            }
            .about-img {
                width: 100%;
                height: 180px;
                max-width: 400px;
            }
            .about-content {
                width: 100%;
            }
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
            .hero-content {
                padding: 2rem 0.5rem 2rem 0.5rem;
            }
            .hero-title {
                font-size: 1.1rem;
            }
            .hero-desc {
                font-size: 0.95rem;
            }
            .hero-btn {
                font-size: 1rem;
                padding: 0.5rem 1.2rem;
            }
            .section-title, .services-title, .projects-title {
                font-size: 1.1rem;
                margin: 2rem 0 1.2rem 0;
            }
            .services-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            .service-card {
                width: 100%;
                max-width: 100vw;
                margin: 0 auto 1.5rem auto;
            }
            .service-bg {
                height: 110px;
            }
            .projects-img {
                height: 110px;
                margin-bottom: 1.5rem;
            }
            .projects-cards-row {
                flex-direction: column;
                align-items: center;
                gap: 1.5rem;
                margin-left: 0;
                margin-right: 0;
                padding-left: 0;
                padding-right: 0;
            }
            .project-card {
                width: 100vw;
                max-width: 98vw;
                min-width: 0;
                margin: 0 auto 1.5rem auto;
            }
            .project-card img {
                height: 100px;
            }
            .section {
                padding: 1.2rem 0.2rem 0 0.2rem;
            }
        }
        @media (max-width: 400px) {
            .hero-title {
                font-size: 0.95rem;
            }
            .hero-desc {
                font-size: 0.8rem;
            }
            .project-card {
                width: 100vw;
                max-width: 100vw;
            }
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
                <a href="#about" class="navbar-link" data-aos="fade-down" data-aos-delay="600">About Us</a>
                <a href="#services" class="navbar-link" data-aos="fade-down" data-aos-delay="700">Services</a>
                <a href="#projects" class="navbar-link" data-aos="fade-down" data-aos-delay="800">Projects</a>
            </div>
        </div>
    </nav>
    <div class="main-content">


        <!-- Hero Section -->
        <section class="hero" data-aos="fade-up" data-aos-duration="1200">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <div class="hero-title" data-aos="fade-up" data-aos-delay="200">SMART TO DO LIST</div>
                <div class="hero-desc" data-aos="fade-up" data-aos-delay="400">"Stay on track. Get things done smarter."</div>
                <button class="hero-btn" data-aos="zoom-in" data-aos-delay="600">View Projects</button>
            </div>
        </section>



        <!-- About Section -->
        <section class="section about-section" id="about" data-aos="fade-left" data-aos-duration="1000">
            <img src="\images\about.jpg" class="about-img" alt="About Us" data-aos="flip-left" data-aos-delay="200">
            <div class="about-content">
                <div class="about-title" data-aos="fade-right" data-aos-delay="300">About Us</div>
                <div class="about-desc" data-aos="fade-up" data-aos-delay="400">Smart To Do List is a productivity platform built to help individuals and teams stay focused, organized, and in control of their daily tasks. We believe that managing your time and goals shouldn't feel overwhelming — that's why we created a smart, easy-to-use tool that adapts to your workflow. Whether you're planning your day, tracking progress, or setting long-term goals, our system keeps you one step ahead.</div>
                <div class="about-mission" data-aos="fade-right" data-aos-delay="500">Our Mission</div>
                <div class="about-desc" data-aos="fade-up" data-aos-delay="600">Our mission is to simplify productivity by combining smart technology with intuitive design. We aim to empower users to manage tasks efficiently, reduce stress, and achieve more — both personally and professionally. By providing tools that are smart, responsive, and user-friendly, we help turn to-do lists into done lists.

                </div>
            </div>
        </section>



        <!-- Services Section -->
        <section class="section services-section" id="services" data-aos="fade-up" data-aos-duration="1000">
            <div class="services-title" data-aos="zoom-in" data-aos-delay="100">What You Can Organize</div>
            <div class="services-grid">
                <div class="service-card tilt-card" data-aos="flip-left" data-aos-delay="100">
                    <img src="\images\list.jpg" class="service-bg" alt="Listing Activities">
                    <div class="service-title">Listing Activities</div>
                </div>
                <div class="service-card tilt-card" data-aos="flip-right" data-aos-delay="200">
                    <img src="\images\home.jpg"" class="service-bg" alt="Home Tasks">
                    <div class="service-title">Home Tasks</div>
                </div>
                <div class="service-card tilt-card" data-aos="flip-up" data-aos-delay="300">
                    <img src="\images\school.jpg" class="service-bg" alt="School & Study">
                    <div class="service-title">School & Study</div>
                </div>
                <div class="service-card tilt-card" data-aos="flip-down" data-aos-delay="400">
                    <img src="\images\outdoors.jpg"class="service-bg" alt="Outdoor & Errands">
                    <div class="service-title">Outdoor & Errands</div>
                </div>
            </div>
        </section>
        <!-- Projects Section -->
        <section class="section projects-section" id="projects" style="padding-bottom: 4rem;" data-aos="fade-up" data-aos-duration="1000">
            <div class="projects-title" data-aos="fade-up" data-aos-delay="100">Your Productivity Projects</div>
            <img src="\images\project.jpg" class="projects-img tilt-card" alt="Productivity Overview" data-aos="zoom-in" data-aos-delay="200">
            <div class="projects-cards-row">
                <div class="project-card tilt-card" data-aos="fade-up" data-aos-delay="100">
                    <img src="\images\list.jpg">
                    <div class="project-card-content">
                        <div class="project-card-title">Daily Task List</div>
                        <div class="project-card-desc">Organize your daily activities and never miss a task again.</div>
                    </div>
                </div>
                <div class="project-card tilt-card" data-aos="fade-up" data-aos-delay="200">
                    <img src="\images\home.jpg">
                    <div class="project-card-content">
                        <div class="project-card-title">Home Chores</div>
                        <div class="project-card-desc">Keep track of your home cleaning, cooking, and maintenance tasks.</div>
                    </div>
                </div>
                <div class="project-card tilt-card" data-aos="fade-up" data-aos-delay="300">
                    <img src="\images\school.jpg">
                    <div class="project-card-content">
                        <div class="project-card-title">Study Planner</div>
                        <div class="project-card-desc">Manage your school assignments, exams, and study sessions.</div>
                    </div>
                </div>
                <div class="project-card tilt-card" data-aos="fade-up" data-aos-delay="400">
                    <img src="\images\outdoors.jpg">
                    <div class="project-card-content">
                        <div class="project-card-title">Errands & Outdoors</div>
                        <div class="project-card-desc">Plan your shopping, appointments, and outdoor activities.</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- AOS Animate On Scroll JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });
        // VanillaTilt 3D effect for cards
        VanillaTilt.init(document.querySelectorAll('.tilt-card'), {
            max: 15,
            speed: 400,
            glare: true,
            'max-glare': 0.18,
            scale: 1.04,
        });
        document.addEventListener('DOMContentLoaded', function() {
            var hamburger = document.getElementById('navbar-hamburger');
            var links = document.getElementById('navbar-links');
            if (hamburger && links) {
                hamburger.addEventListener('click', function() {
                    links.classList.toggle('open');
                });
                // Optional: Hide menu when a link is clicked
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
