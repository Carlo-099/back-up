<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart to do list</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-100 overflow-y-auto">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation Bar -->
        <header>
            <nav>
                <h1>
                    <a href="/" class="flex items-center">
                        <img src="/images/logo.png" alt="Logo" class="w-8 h-8 mr-2">
                        Smart to do list
                    </a>
                </h1>

                <a href="/" class="btn">Home</a>
                <a href="{{ route('show.login') }}" class="btn">Login</a>
                <a href="{{ route('show.register') }}" class="btn">Register</a>
            </nav>
        </header>

        <!-- Register Form -->
        <div class="flex items-center justify-center mt-20">
            <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-lg max-h-screen overflow-y-auto">
                <div>
                    <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                        Join the Ninja Clan!
                    </h2>
                    <p class="mt-2 text-sm text-center text-gray-600">
                        Start your journey to task mastery
                    </p>
                </div>
                <form id="registerForm" class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div id="step1">
                        <div class="-space-y-px rounded-md shadow-sm">
                            <div>
                                <label for="name" class="sr-only">Full Name</label>
                                <input id="name" name="name" type="text" required
                                    class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="Full Name">
                            </div>
                            <div class="flex gap-2 mt-2">
                                <div class="w-1/2">
                                    <label for="age" class="sr-only">Age</label>
                                    <input id="age" name="age" type="number" min="13" required
                                        class="block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Age">
                                </div>
                                <div class="w-1/2">
                                    <label for="gender" class="sr-only">Gender</label>
                                    <select id="gender" name="gender" required
                                        class="block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2">
                                <label for="email" class="sr-only">Email address</label>
                                <input id="email" name="email" type="email" required
                                    class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="Email address">
                            </div>
                            <div>
                                <label for="password" class="sr-only">Password</label>
                                <input id="password" name="password" type="password" required
                                    class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="Password">
                            </div>
                            <div>
                                <label for="password_confirmation" class="sr-only">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="Confirm Password">
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="text-sm text-red-500">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div>
                            <button type="button" id="nextStepBtn"
                                class="relative flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md group hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="step2" style="display:none;">
                        <h2 class="text-lg font-bold text-center mb-4">Educational Level</h2>
                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <button type="button" class="edu-btn bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-2 rounded" data-value="elementary">Elementary</button>
                            <button type="button" class="edu-btn bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-2 rounded" data-value="high school">High School</button>
                            <button type="button" class="edu-btn bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-2 rounded" data-value="senior high">Senior High</button>
                            <button type="button" class="edu-btn bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-2 rounded" data-value="college">College</button>
                        </div>
                        <input type="hidden" name="educational_level" id="educational_level" required>
                        <div>
                            <button type="submit"
                                class="relative flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md group hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Account
                            </button>
                        </div>
                    </div>
                </form>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Already a ninja?
                        <a href="{{ route('show.login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
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
