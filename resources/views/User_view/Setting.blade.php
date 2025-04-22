<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart to do lists</title>

    @vite('resources/css/app.css')
</head>

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
                        <div class="p-6 bg-white rounded-lg shadow-lg">
                            <h2 class="mb-6 text-xl font-semibold text-gray-800">Settings</h2>

                            @if(session('success'))
                                <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-md">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-md">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data" id="settings-form">
                                @csrf
                                <div class="space-y-4">
                                    <!-- Change Email -->
                                    <div>
                                        <label class="block text-gray-700">Change Email:</label>
                                        <input type="email" name="change_email" placeholder="Enter new email" class="w-full p-2 mt-1 border rounded-md" value="{{ $settings->change_email ?? '' }}">
                                    </div>

                                    <!-- Change Password -->
                                    <div>
                                        <label class="block text-gray-700">Change Password:</label>
                                        <input type="password" name="change_password" placeholder="Enter new password" class="w-full p-2 mt-1 border rounded-md">
                                    </div>

                                    <!-- Change Profile Picture -->
                                    <div>
                                        <label class="block text-gray-700">Change Profile Picture:</label>
                                        <input type="file" name="profile_picture" class="w-full p-2 mt-1 border rounded-md">
                                    </div>

                                    <!-- Dark / Light Mode -->
                                    <div>
                                        <label class="block text-gray-700">Theme:</label>
                                        <select name="theme" class="w-full p-2 mt-1 border rounded-md">
                                            <option value="light" {{ ($settings->theme ?? '') == 'light' ? 'selected' : '' }}>Light Mode</option>
                                            <option value="dark" {{ ($settings->theme ?? '') == 'dark' ? 'selected' : '' }}>Dark Mode</option>
                                        </select>
                                    </div>

                                    <!-- Notifications -->
                                    <div>
                                        <label class="block text-gray-700">Notifications:</label>
                                        <select name="notification" class="w-full p-2 mt-1 border rounded-md">
                                            <option value="1" {{ ($settings->notification ?? false) ? 'selected' : '' }}>Turn On</option>
                                            <option value="0" {{ ($settings->notification ?? false) ? '' : 'selected' }}>Turn Off</option>
                                        </select>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="flex space-x-4">
                                        <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md">Update</button>
                                        <button type="reset" class="px-4 py-2 font-semibold text-white bg-gray-500 rounded-md">Restore</button>
                                    </div>
                                </div>
                            </form>
                        </div>




            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- FullCalendar JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('settings-form');

            if (form) {
                console.log('Form found:', form);

                // Log the form action
                console.log('Form action:', form.getAttribute('action'));

                form.addEventListener('submit', function(e) {
                    console.log('Form submitted');

                    // Log form data
                    const formData = new FormData(form);
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }

                    // Uncomment the line below to prevent form submission for debugging
                    // e.preventDefault();
                });
            } else {
                console.error('Form not found');
            }

            // Add click event to the update button
            const updateButton = document.querySelector('button[type="submit"]');
            if (updateButton) {
                updateButton.addEventListener('click', function(e) {
                    console.log('Update button clicked');
                });
            }

            // Add click event to the restore button
            const restoreButton = document.querySelector('button[type="reset"]');
            if (restoreButton) {
                restoreButton.addEventListener('click', function(e) {
                    console.log('Restore button clicked');
                });
            }
        });
    </script>

</body>

</html>
