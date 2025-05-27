<x-userlayout>
            <!-- Main Content -->


                            <h2 class="mb-6 text-xl font-semibold theme-text">Settings</h2>

                            @if(session('success'))
                                <div class="p-4 mb-4 bg-green-100 rounded-md theme-text">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="p-4 mb-4 bg-red-100 rounded-md theme-text">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="p-4 mb-4 bg-red-100 rounded-md theme-text">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data" id="settings-form" class="theme-text">
                                @csrf
                                <div class="space-y-4">
                                    <!-- Change Email -->
                                    <div>
                                        <label class="block theme-text">Change Email:</label>
                                        <input type="email" name="change_email" placeholder="Enter new email" class="w-full p-2 mt-1 bg-transparent border rounded-md theme-text" value="{{ $settings->change_email ?? '' }}">
                                    </div>

                                    <!-- Update Age and Gender -->
                                    <div class="flex gap-4">
                                        <div class="w-1/2">
                                            <label class="block theme-text">Update Age:</label>
                                            <input type="number" name="age" min="13" class="w-full p-2 mt-1 bg-transparent border rounded-md theme-text" value="{{ Auth::user()->age ?? '' }}">
                                        </div>
                                        <div class="w-1/2">
                                            <label class="block theme-text">Change Gender:</label>
                                            <select name="gender" class="w-full p-2 mt-1 bg-transparent border rounded-md theme-text">
                                                <option value="" disabled {{ !Auth::user()->gender ? 'selected' : '' }}>Select Gender</option>
                                                <option value="male" {{ (Auth::user()->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ (Auth::user()->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Update Educational Level -->
                                    <div class="mt-4">
                                        <label class="block theme-text">Update Educational Level:</label>
                                        <select name="educational_level" class="w-full p-2 mt-1 bg-transparent border rounded-md theme-text">
                                            <option value="" disabled {{ !Auth::user()->educational_level ? 'selected' : '' }}>Select Educational Level</option>
                                            <option value="elementary" {{ (Auth::user()->educational_level ?? '') == 'elementary' ? 'selected' : '' }}>Elementary</option>
                                            <option value="high school" {{ (Auth::user()->educational_level ?? '') == 'high school' ? 'selected' : '' }}>High School</option>
                                            <option value="senior high" {{ (Auth::user()->educational_level ?? '') == 'senior high' ? 'selected' : '' }}>Senior High</option>
                                            <option value="college" {{ (Auth::user()->educational_level ?? '') == 'college' ? 'selected' : '' }}>College</option>
                                        </select>
                                    </div>

                                    <!-- Current Password -->
                                    <div>
                                        <label class="block theme-text">Enter Current Password:</label>
                                        <input type="password" name="current_password" placeholder="Enter your current password" class="w-full p-2 mt-1 bg-transparent border rounded-md theme-text">
                                    </div>

                                    <!-- Change Password -->
                                    <div>
                                        <label class="block theme-text">Change Password:</label>
                                        <input type="password" name="change_password" placeholder="Enter new password" class="w-full p-2 mt-1 bg-transparent border rounded-md theme-text">
                                    </div>

                                    <!-- Change Profile Picture -->
                                    <div>
                                        <label class="block theme-text">Change Profile Picture:</label>
                                        <input type="file" name="profile_picture" class="w-full p-2 mt-1 bg-transparent border rounded-md theme-text">
                                    </div>

                                    <!-- Dark / Light Mode -->
                                    <div>
                                        <label class="block theme-text">Theme:</label>
                                        <select name="theme" class="w-full p-2 mt-1 bg-transparent border rounded-md theme-text">
                                            <option value="light" {{ ($settings->theme ?? '') == 'light' ? 'selected' : '' }}>Light Mode</option>
                                            <option value="dark" {{ ($settings->theme ?? '') == 'dark' ? 'selected' : '' }}>Dark Mode</option>
                                        </select>
                                    </div>

                                    <!-- Notifications --....
                                    <div>
                                        <label class="block theme-text">Notifications:</label>
                                        <select name="notification" class="w-full p-2 mt-1 bg-transparent border rounded-md theme-text">
                                            <option value="1" {{ ($settings->notification === true) ? 'selected' : '' }}>Turn On</option>
                                            <option value="0" {{ ($settings->notification === false) ? 'selected' : '' }}>Turn Off</option>
                                        </select>
                                    </div> -->

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

    <style>
        /* Theme-specific styles */
        [data-theme="light"] .theme-text {
            color: #1a1a1a; /* Dark text for light mode */
        }

        [data-theme="dark"] .theme-text {
            color: #e5e5e5; /* Light text for dark mode */
        }

        /* Input and select specific styles */
        [data-theme="light"] input::placeholder,
        [data-theme="light"] select::placeholder {
            color: #666666;
        }

        [data-theme="dark"] input::placeholder,
        [data-theme="dark"] select::placeholder {
            color: #a0a0a0;
        }

        /* Ensure inputs and selects maintain their text color */
        [data-theme="light"] input,
        [data-theme="light"] select {
            color: #1a1a1a;
        }

        [data-theme="dark"] input,
        [data-theme="dark"] select {
            color: #e5e5e5;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('settings-form');
            const currentPasswordInput = document.querySelector('input[name="current_password"]');
            const changePasswordInput = document.querySelector('input[name="change_password"]');
            const themeSelect = document.querySelector('select[name="theme"]');
            const userId = {{ Auth::id() }}; // Get current user's ID
            const userThemeKey = `userTheme_${userId}`; // Create user-specific key

            // Initially disable the change password field
            if (changePasswordInput) {
                changePasswordInput.disabled = true;
                changePasswordInput.placeholder = "Enter current password first";
            }

            // Add event listener to current password field
            if (currentPasswordInput) {
                currentPasswordInput.addEventListener('input', function() {
                    // Enable the change password field when current password is entered
                    if (changePasswordInput) {
                        changePasswordInput.disabled = false;
                        changePasswordInput.placeholder = "Enter new password";
                    }
                });
            }

            // Add event listener to theme select
            if (themeSelect) {
                themeSelect.addEventListener('change', function() {
                    const selectedTheme = this.value;
                    document.documentElement.setAttribute('data-theme', selectedTheme);

                    // Update all theme-text elements
                    document.querySelectorAll('.theme-text').forEach(element => {
                        element.style.color = selectedTheme === 'light' ? '#1a1a1a' : '#e5e5e5';
                    });

                    // Save theme preference to localStorage for immediate effect
                    localStorage.setItem(userThemeKey, selectedTheme);
                });
            }

            // Check for theme in localStorage on page load
            const savedTheme = localStorage.getItem(userThemeKey);
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
                if (themeSelect) {
                    themeSelect.value = savedTheme;
                    // Update text colors based on saved theme
                    document.querySelectorAll('.theme-text').forEach(element => {
                        element.style.color = savedTheme === 'light' ? '#1a1a1a' : '#e5e5e5';
                    });
                }
            }

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

            // Update restore button handler
            const restoreButton = document.querySelector('button[type="reset"]');
            if (restoreButton) {
                restoreButton.addEventListener('click', function(e) {
                    console.log('Restore button clicked');

                    // Reset theme to the server-side default
                    const serverTheme = document.documentElement.getAttribute('data-theme');
                    if (serverTheme) {
                        document.documentElement.setAttribute('data-theme', serverTheme);
                        localStorage.setItem(userThemeKey, serverTheme);
                        if (themeSelect) {
                            themeSelect.value = serverTheme;
                        }
                    }
                });
            }
        });
    </script>


</x-userlayout>
