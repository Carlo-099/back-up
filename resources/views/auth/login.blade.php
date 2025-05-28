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
    <!-- Three.js dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
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
            justify-content: space-between;
            padding: 90px clamp(1rem, 5vw, 10%) 0;
            gap: clamp(2rem, 5vw, 4rem);
        }
        .left-content {
            flex: 1;
            max-width: 600px;
            position: relative;
        }
        .left-title {
            font-size: clamp(2rem, 8vw, 4rem);
            font-weight: bold;
            color: #00eaff;
            margin-bottom: 1rem;
            text-shadow: 0 0 8px #00eaff, 0 0 16px #1a6cff;
            line-height: 1.2;
        }
        .left-subtitle {
            font-size: clamp(1rem, 3vw, 1.5rem);
            color: #cbefff;
            margin-bottom: 2rem;
        }
        .register-card {
            width: 100%;
            max-width: 430px;
            padding: clamp(1.5rem, 4vw, 2.5rem);
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
        .register-btn {
            width: 100%;
            padding: clamp(0.75rem, 2vw, 1rem) 1.5rem;
            font-size: clamp(0.875rem, 3vw, 1.1rem);
            border-radius: 9999px;
            margin-top: 1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            background: linear-gradient(90deg, #00eaff 0%, #1a6cff 100%);
            color: #fff;
            border: none;
            font-weight: 600;
            box-shadow: 0 0 16px #00eaff99;
            transition: all 0.3s ease;
        }
        .register-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 0 32px #00eaffcc;
            background: linear-gradient(90deg, #1a6cff 0%, #00eaff 100%);
        }
        .register-card input[type="email"],
        .register-card input[type="password"] {
            width: 100%;
            padding: clamp(0.75rem, 2vw, 1rem);
            font-size: 16px;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(0, 234, 255, 0.2);
            color: #fff;
            transition: all 0.3s ease;
        }
        .register-card input:focus {
            border: 1.5px solid #00eaff;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 3px rgba(0, 234, 255, 0.15);
            outline: none;
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
        @media (max-width: 1024px) {
            .main-content {
                flex-direction: column;
                padding: 90px clamp(1rem, 3vw, 5%) 0;
                text-align: center;
                gap: 2rem;
            }
            .left-content {
                padding-right: 0;
                margin-bottom: 1rem;
            }
            .model-container {
                max-width: 500px;
                margin: 1rem auto;
            }
        }
        @media (max-width: 640px) {
            .main-content {
                padding-top: 80px;
            }
            .register-card {
                margin: 0.5rem;
                padding: 1.5rem;
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
            .model-container {
                height: 250px;
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
            .model-container {
                height: 200px;
            }
        }
        /* Fix for iOS input zoom */
        @supports (-webkit-touch-callout: none) {
            input[type="email"],
            input[type="password"] {
                font-size: 16px !important;
            }
        }
        /* Improve touch targets on mobile */
        @media (hover: none) and (pointer: coarse) {
            .register-btn {
                min-height: 44px;
            }
            input[type="email"],
            input[type="password"] {
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
            .model-container {
                height: 180px;
            }
        }
        /* Mobile navigation styles */
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
        .model-container {
            width: 100%;
            height: clamp(300px, 50vw, 400px);
            margin: 2rem 0;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            background: rgba(30, 41, 59, 0.85);
        }
        #model-viewer {
            width: 100%;
            height: 100%;
            border: none;
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

         <!-- 3d animation-->
        <div class="left-content" data-aos="fade-right" data-aos-duration="1000">
            <h1 class="left-title">Smart To Do List</h1>

            <div class="model-container" data-aos="fade-up" data-aos-duration="1000">
                <div id="model-viewer"></div>
            </div>

            <p style="font-size: 13px; color: #cbefff; margin-top: 0.5rem;">
              By <a href="https://ambientcg.com/view?id=3DApple002" target="_blank" style="color: #00eaff; font-weight: bold;">Carlo</a>
            </p>
        </div>

        <div class="register-card tilt-card" data-aos="zoom-in" data-aos-duration="1000">
            <div>
                <h2 class="register-title">Welcome Back, Ninja!</h2>
                <p class="register-subtitle">Ready to conquer your tasks?</p>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" required placeholder="Email address" value="{{ old('email') }}">
                </div>
                <div class="mb-4">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required placeholder="Password">
                </div>
                @if ($errors->any())
                    <div class="mb-2 text-sm text-red-500">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <button type="submit" class="register-btn">Sign in</button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('show.register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Register here
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

            // Three.js initialization and model loading
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            const container = document.getElementById('model-viewer');

            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setClearColor(0x000000, 0);
            container.appendChild(renderer.domElement);

            // Lighting
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
            scene.add(ambientLight);

            const directionalLight = new THREE.DirectionalLight(0x00eaff, 1);
            directionalLight.position.set(5, 5, 5);
            scene.add(directionalLight);

            // Controls
            const controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;
            controls.dampingFactor = 0.05;
            controls.autoRotate = true;
            controls.autoRotateSpeed = 1.0;

            // Camera position
            camera.position.z = 5;

            // Load model
            const loader = new THREE.GLTFLoader();
            loader.load(
                '/3d-assets/PILLOW.glb',
                function (gltf) {
                    const model = gltf.scene;
                    // Center and scale the model
                    const box = new THREE.Box3().setFromObject(model);
                    const center = box.getCenter(new THREE.Vector3());
                    const size = box.getSize(new THREE.Vector3());
                    const maxDim = Math.max(size.x, size.y, size.z);
                    const scale = 2 / maxDim;
                    model.scale.multiplyScalar(scale);
                    model.position.sub(center.multiplyScalar(scale));
                    scene.add(model);
                },
                function (xhr) {
                    console.log((xhr.loaded / xhr.total * 100) + '% loaded');
                },
                function (error) {
                    console.error('An error happened loading the model:', error);
                }
            );

            // Animation loop
            function animate() {
                requestAnimationFrame(animate);
                controls.update();
                renderer.render(scene, camera);
            }
            animate();

            // Handle window resize
            window.addEventListener('resize', function() {
                const width = container.clientWidth;
                const height = container.clientHeight;
                camera.aspect = width / height;
                camera.updateProjectionMatrix();
                renderer.setSize(width, height);
            });
        });
    </script>
</body>
</html>
