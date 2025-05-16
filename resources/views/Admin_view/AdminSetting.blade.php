<x-adminlayout>

            <!-- Main Content -->

                    <div class="flex-1 p-8">
                        <div class="p-6 rounded-lg shadow-lg" style="background-color: var(--bg-primary);">
                            <h2 class="mb-6 text-xl font-semibold" style="color: var(--text-primary);">Admin Settings</h2>

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

                            <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data" id="admin-settings-form">
                                @csrf
                                <div class="space-y-4">
                                    <!-- Change Email -->
                                    <div>
                                        <label class="block" style="color: var(--text-primary);">Change Email:</label>
                                        <input type="email" name="change_email" placeholder="Enter new email" class="w-full p-2 mt-1 border rounded-md" value="{{ $settings->change_email ?? '' }}">
                                    </div>

                                    <!-- Change Password -->
                                    <div>
                                        <label class="block" style="color: var(--text-primary);">Change Password:</label>
                                        <input type="password" name="change_password" placeholder="Enter new password" class="w-full p-2 mt-1 border rounded-md">
                                    </div>

                                    <!-- Change Profile Picture -->
                                    <div>
                                        <label class="block" style="color: var(--text-primary);">Change Profile Picture:</label>
                                        <input type="file" name="profile_picture" class="w-full p-2 mt-1 border rounded-md">
                                    </div>

                                    <!-- Dark / Light Mode -->
                                    <div>
                                        <label class="block" style="color: var(--text-primary);">Theme:</label>
                                        <select name="theme" class="w-full p-2 mt-1 border rounded-md">
                                            <option value="light" {{ ($settings->theme ?? '') == 'light' ? 'selected' : '' }}>Light Mode</option>
                                            <option value="dark" {{ ($settings->theme ?? '') == 'dark' ? 'selected' : '' }}>Dark Mode</option>
                                        </select>
                                    </div>

                                    <!-- Notifications -->
                                    <div>
                                        <label class="block" style="color: var(--text-primary);">Notifications:</label>
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
            const form = document.getElementById('admin-settings-form');
            const themeSelect = document.querySelector('select[name="theme"]');

            // Add event listener to theme select
            if (themeSelect) {
                themeSelect.addEventListener('change', function() {
                    const selectedTheme = this.value;
                    document.documentElement.setAttribute('data-theme', selectedTheme);

                    // Save theme preference to localStorage for immediate effect
                    localStorage.setItem('theme', selectedTheme);
                });
            }

            // Check for theme in localStorage on page load
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
                if (themeSelect) {
                    themeSelect.value = savedTheme;
                }
            }

            if (form) {
                console.log('Admin settings form found:', form);

                // Log the form action
                console.log('Form action:', form.getAttribute('action'));

                form.addEventListener('submit', function(e) {
                    console.log('Admin settings form submitted');

                    // Log form data
                    const formData = new FormData(form);
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }
                });
            } else {
                console.error('Admin settings form not found');
            }

            // Add click event to the update button
            const updateButton = document.querySelector('button[type="submit"]');
            if (updateButton) {
                updateButton.addEventListener('click', function(e) {
                    console.log('Admin update button clicked');
                });
            }

            // Add click event to the restore button
            const restoreButton = document.querySelector('button[type="reset"]');
            if (restoreButton) {
                restoreButton.addEventListener('click', function(e) {
                    console.log('Admin restore button clicked');

                    // Reset theme to the server-side default
                    const serverTheme = document.documentElement.getAttribute('data-theme');
                    if (serverTheme) {
                        document.documentElement.setAttribute('data-theme', serverTheme);
                        localStorage.setItem('theme', serverTheme);
                        if (themeSelect) {
                            themeSelect.value = serverTheme;
                        }
                    }
                });
            }
        });
    </script>

    <style>
    /* Make disabled select text readable in dark mode */
    html[data-theme="dark"] select:disabled,
    html[data-theme="dark"] option:disabled {
        color: #b0b0b0 !important;
        background-color: #222 !important;
    }
    </style>

</x-adminlayout>
