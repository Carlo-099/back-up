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
        :root {
            --primary-glow: conic-gradient(from 180deg at 50% 50%, #00eaff 0deg, #1a6cff 55deg, #00eaff 120deg, #1a6cff 160deg, transparent 360deg);
            --secondary-glow: radial-gradient(rgba(0, 234, 255, 0.1), rgba(26, 108, 255, 0.1));
            --card-bg: rgba(17, 25, 40, 0.75);
            --border-color: rgba(0, 234, 255, 0.2);
            --text-color: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --gradient-start: #00eaff;
            --gradient-end: #1a6cff;
            --shadow-color: rgba(0, 234, 255, 0.15);
        }

        body {
            background: #0a0f1c;
            background-image:
                radial-gradient(circle at 100% 0%, rgba(0, 234, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 0% 100%, rgba(26, 108, 255, 0.08) 0%, transparent 50%);
            color: var(--text-color);
            font-family: 'Segoe UI', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 50% 50%, var(--primary-glow)),
                radial-gradient(circle at 50% 50%, var(--secondary-glow));
            filter: blur(100px);
            opacity: 0.15;
            z-index: -1;
            pointer-events: none;
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
            padding: 90px 10% 0 10%;
        }
        .left-content {
            flex: 1;
            padding-right: 2rem;
            max-width: 600px;
            position: relative;
        }
        .left-title {
            font-size: 4rem;
            font-weight: bold;
            color: #00eaff;
            margin-bottom: 1rem;
            text-shadow: 0 0 8px #00eaff, 0 0 16px #1a6cff;
            line-height: 1.2;
        }
        .left-subtitle {
            font-size: 1.5rem;
            color: #cbefff;
            margin-bottom: 2rem;
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
        @media (max-width: 1024px) {
            .main-content {
                flex-direction: column;
                padding: 90px 5% 0 5%;
                text-align: center;
            }
            .left-content {
                padding-right: 0;
                margin-bottom: 2rem;
            }
            .left-title {
                font-size: 3rem;
            }
            .register-card {
                margin: 0 auto;
            }
        }
        .model-container {
            width: 100%;
            height: 300px;
            margin: 2rem 0;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            background: rgba(30, 41, 59, 0.85);
        }
        #model-viewer {
            width: 100%;
            height: 100%;
            border: none;
        }
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
        }
        .auth-card {
            width: 100%;
            max-width: 800px;
            height: 450px;
            background: var(--card-bg);
            border-radius: 10px;
            padding: 1.25rem;
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(0, 234, 255, 0.1),
                inset 0 0 32px rgba(0, 234, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            transform-style: preserve-3d;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .auth-card:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow:
                0 12px 40px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(0, 234, 255, 0.2),
                inset 0 0 48px rgba(0, 234, 255, 0.08);
        }
        .auth-header {
            text-align: center;
            margin-bottom: 0.75rem;
            position: relative;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .auth-title {
            font-size: 2.35rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.15rem;
            letter-spacing: 0.5px;
        }
        .auth-subtitle {
            color: var(--text-secondary);
            font-size: 0.85rem;
            letter-spacing: 0.3px;
        }
        .auth-form {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0.75rem;
            align-items: start;
            overflow: visible;
        }
        .form-group {
            grid-column: 1 / -1;
            margin-bottom: 0.5rem;
            position: relative;
        }
        .form-label {
            color: var(--text-secondary);
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            display: block;
            letter-spacing: 0.5px;
        }
        .form-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 5px;
            padding: 0.6rem 0.85rem;
            color: var(--text-color);
            font-size: 0.9rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(4px);
        }
        .form-input:focus {
            outline: none;
            border-color: var(--gradient-start);
            box-shadow:
                0 0 0 2px rgba(0, 234, 255, 0.1),
                0 0 20px rgba(0, 234, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
        }
        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }
        .auth-actions {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0.75rem;
            align-items: center;
            margin-top: 0.35rem;
            justify-items: end;
        }
        .remember-me {
            grid-column: 1;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .remember-me input[type="checkbox"] {
            width: 1.1rem;
            height: 1.1rem;
            border-radius: 6px;
            border: 1.5px solid var(--border-color);
            background: rgba(255, 255, 255, 0.03);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            appearance: none;
        }
        .remember-me input[type="checkbox"]:checked {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-color: transparent;
        }
        .remember-me input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 0.8rem;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .remember-me label {
            color: var(--text-secondary);
            font-size: 0.85rem;
            cursor: pointer;
            user-select: none;
        }
        .auth-button {
            grid-column: 2 / -1;
            margin: 0;
            width: 100%;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.6rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
            max-width: 200px;
            margin-left: auto;
        }
        .auth-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }
        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow:
                0 8px 20px rgba(0, 234, 255, 0.2),
                0 0 0 1px rgba(0, 234, 255, 0.1);
        }
        .auth-button:hover::before {
            left: 100%;
        }
        .auth-links {
            grid-column: 1 / -1;
            margin-top: 0.5rem;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }
        .auth-link {
            color: var(--gradient-start);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.2rem 0;
            white-space: nowrap;
        }
        .auth-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        .auth-link:hover {
            color: var(--gradient-end);
        }
        .auth-link:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }
        .error-message {
            color: #ff4d4d;
            font-size: 0.8rem;
            margin-top: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .error-message::before {
            content: '⚠';
            font-size: 1rem;
        }
        .input-error {
            border-color: #ff4d4d !important;
            animation: shake 0.5s ease-in-out;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        @media (max-width: 768px) {
            .auth-card {
                max-width: 650px;
                padding: 1rem;
            }

            .auth-form {
                grid-template-columns: 1fr 1fr;
                gap: 0.5rem;
            }

            .auth-actions {
                grid-template-columns: 1fr 1fr;
                gap: 0.5rem;
            }

            .auth-button {
                max-width: 180px;
            }
        }
        @media (max-width: 640px) {
            .auth-card {
                height: auto;
                min-height: 450px;
                padding: 1rem;
                max-width: 100%;
            }

            .auth-form {
                grid-template-columns: 1fr;
                gap: 0.35rem;
            }

            .auth-actions {
                grid-template-columns: 1fr;
                gap: 0.35rem;
                justify-items: stretch;
            }

            .auth-links {
                flex-direction: column;
                gap: 0.35rem;
            }

            .auth-button {
                max-width: 100%;
                margin-left: 0;
            }
        }
        .auth-form::-webkit-scrollbar {
            width: 6px;
        }
        .auth-form::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 3px;
        }
        .auth-form::-webkit-scrollbar-thumb {
            background: rgba(0, 234, 255, 0.2);
            border-radius: 3px;
        }
        .auth-form::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 234, 255, 0.3);
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

        <div class="auth-container">
            <div class="auth-card" data-aos="fade-up" data-aos-duration="1000">
                <div class="auth-header">

                    <h1 class="auth-title">Welcome Back</h1>
                    <p class="auth-subtitle">Sign in to your account to continue</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-input @error('email') input-error @enderror"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password"
                            class="form-input @error('password') input-error @enderror"
                            required autocomplete="current-password">
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember me</label>
                    </div>


                    <button type="submit" class="auth-button">
                        Sign In
                    </button>

                    <div class="auth-links">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link">
                                Forgot your password?
                            </a>
                        @endif
                        <p class="mt-2">
                            Don't have an account?
                            <a href="{{ route('show.register') }}" class="auth-link">Sign up</a>
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
