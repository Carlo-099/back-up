<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart to do list</title>

    @vite('resources/css/app.css')
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        <!-- Top Navigation Bar -->
        <nav class="bg-white shadow-md">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="/" class="flex items-center">
                                <img src="/images/logo.png" alt="Logo" class="w-8 h-8 mr-2">
                                <span class="text-xl font-bold text-gray-800">Smart to do list</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <span class="text-gray-700">Hi, {{ Auth::user()->name }}</span>
                            <!-- Notification Button -->
                            <button class="relative p-2 text-gray-600 rounded-full hover:bg-gray-100">
                                <i class="fas fa-bell"></i>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button class="btn">Logout</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex">
            <!-- Sidebar -->
            <div class="w-64 min-h-screen bg-white shadow-md">
                <div class="p-4">
                    <!-- User Profile Section -->
                    @auth
                        <div class="flex flex-col items-center mb-6">
                            <div class="w-24 h-24 mb-3 overflow-hidden rounded-full">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0D9488&color=fff"
                                     alt="Profile"
                                     class="object-cover w-full h-full">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</h3>
                        </div>
                    @endauth

                    <h2 class="mb-4 text-lg font-semibold text-gray-800">Menu</h2>
                    <nav class="space-y-2">
                        @auth
                            <a href="{{ route('content') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-calendar-alt"></i> Calendar
                            </a>
                            <a href="{{ route('status') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-chart-line"></i> Status
                            </a>
                            <a href="{{ route('category') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-tags"></i> Category
                            </a>
                            <a href="{{ route('feedback') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-comments"></i> Feedback
                            </a>
                            <a href="{{ route('productivity-insight') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-chart-bar"></i> Productivity Insight
                            </a>

                            <hr class="my-4 border-gray-200">

                            <a href={{ route('setting') }} class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-cog"></i> Settings
                            </a>
                        @else
                            <a href="{{ route('show.login') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-sign-in-alt"></i> Login
                            </a>
                            <a href="{{ route('show.register') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-user-plus"></i> Register
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 p-8">
                <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                    <!-- Title Bar with Category Buttons -->
                    <div class="border-b border-gray-200">
                        <div class="px-6 py-4">
                            <h2 class="text-xl font-semibold text-gray-800">Task Categories</h2>
                        </div>
                        <div class="flex px-6 py-3 space-x-4">
                            <button onclick="filterCategories('home')" class="px-4 py-2 text-sm font-medium text-purple-700 border border-purple-300 rounded-md bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 category-btn active" data-category="home">
                                <i class="mr-2 fas fa-home"></i> Home Activity
                            </button>
                            <button onclick="filterCategories('school')" class="px-4 py-2 text-sm font-medium text-indigo-700 border border-indigo-300 rounded-md bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 category-btn" data-category="school">
                                <i class="mr-2 fas fa-graduation-cap"></i> School Activity
                            </button>
                            <button onclick="filterCategories('outdoors')" class="px-4 py-2 text-sm font-medium border rounded-md text-emerald-700 border-emerald-300 bg-emerald-50 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 category-btn" data-category="outdoors">
                                <i class="mr-2 fas fa-tree"></i> Outdoors Activity
                            </button>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-6 bg-purple-50">
                        <!-- Home Activities -->
                        <div id="home-tasks" class="mb-8 category-section">
                            <h3 class="mb-4 text-lg font-semibold text-purple-700">Home Activities</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <!-- Task Box 1 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-gray-800">Clean Room</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-full">High Priority</span>
                                    </div>
                                    <p class="mb-3 text-sm text-gray-600">Clean and organize bedroom, including laundry and vacuuming.</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Due: Today</span>
                                        <button class="text-purple-600 hover:text-purple-700">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Task Box 2 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-gray-800">Grocery Shopping</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-full">Medium Priority</span>
                                    </div>
                                    <p class="mb-3 text-sm text-gray-600">Buy groceries for the week, including fresh produce and household items.</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Due: Tomorrow</span>
                                        <button class="text-purple-600 hover:text-purple-700">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Task Box 3 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-gray-800">Meal Prep</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-full">Low Priority</span>
                                    </div>
                                    <p class="mb-3 text-sm text-gray-600">Prepare meals for the week and organize the freezer.</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Due: This Weekend</span>
                                        <button class="text-purple-600 hover:text-purple-700">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- School Activities -->
                        <div id="school-tasks" class="hidden mb-8 category-section">
                            <h3 class="mb-4 text-lg font-semibold text-indigo-700">School Activities</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <!-- Task Box 1 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-gray-800">Research Paper</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-full">High Priority</span>
                                    </div>
                                    <p class="mb-3 text-sm text-gray-600">Complete research paper on environmental science topic.</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Due: Next Week</span>
                                        <button class="text-indigo-600 hover:text-indigo-700">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Task Box 2 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-gray-800">Group Project</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-full">Medium Priority</span>
                                    </div>
                                    <p class="mb-3 text-sm text-gray-600">Prepare presentation for group project on history.</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Due: Friday</span>
                                        <button class="text-indigo-600 hover:text-indigo-700">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Task Box 3 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-gray-800">Study Session</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-full">Low Priority</span>
                                    </div>
                                    <p class="mb-3 text-sm text-gray-600">Review notes for upcoming math exam.</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Due: Thursday</span>
                                        <button class="text-indigo-600 hover:text-indigo-700">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Outdoors Activities -->
                        <div id="outdoors-tasks" class="hidden mb-8 category-section">
                            <h3 class="mb-4 text-lg font-semibold text-emerald-700">Outdoors Activities</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <!-- Task Box 1 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-gray-800">Garden Maintenance</h4>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full text-emerald-700 bg-emerald-100">High Priority</span>
                                    </div>
                                    <p class="mb-3 text-sm text-gray-600">Water plants, trim bushes, and clean garden area.</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Due: Today</span>
                                        <button class="text-emerald-600 hover:text-emerald-700">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Task Box 2 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-gray-800">Bike Ride</h4>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full text-emerald-700 bg-emerald-100">Medium Priority</span>
                                    </div>
                                    <p class="mb-3 text-sm text-gray-600">Go for a 30-minute bike ride in the park.</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Due: Tomorrow</span>
                                        <button class="text-emerald-600 hover:text-emerald-700">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Task Box 3 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-gray-800">Picnic Planning</h4>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full text-emerald-700 bg-emerald-100">Low Priority</span>
                                    </div>
                                    <p class="mb-3 text-sm text-gray-600">Plan and prepare for weekend picnic with friends.</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Due: This Weekend</span>
                                        <button class="text-emerald-600 hover:text-emerald-700">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script>
        function filterCategories(category) {
            // Hide all category sections
            document.querySelectorAll('.category-section').forEach(section => {
                section.classList.add('hidden');
            });

            // Show selected category section
            document.getElementById(`${category}-tasks`).classList.remove('hidden');

            // Update button styles
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('bg-purple-50', 'border-purple-300', 'bg-indigo-50', 'border-indigo-300', 'bg-emerald-50', 'border-emerald-300');
            });

            // Update content area background color
            const contentArea = document.querySelector('.p-6');
            contentArea.classList.remove('bg-purple-50', 'bg-indigo-50', 'bg-emerald-50');

            // Add appropriate color classes based on category
            const activeBtn = event.currentTarget;
            if (category === 'home') {
                activeBtn.classList.add('bg-purple-50', 'border-purple-300');
                contentArea.classList.add('bg-purple-50');
            } else if (category === 'school') {
                activeBtn.classList.add('bg-indigo-50', 'border-indigo-300');
                contentArea.classList.add('bg-indigo-50');
            } else if (category === 'outdoors') {
                activeBtn.classList.add('bg-emerald-50', 'border-emerald-300');
                contentArea.classList.add('bg-emerald-50');
            }
        }
    </script>
</body>
</html>
