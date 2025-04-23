<x-userlayout>
            <!-- Main Content -->


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

                                    <!-- Current Password -->
                                    <div>
                                        <label class="block text-gray-700">Enter Current Password:</label>
                                        <input type="password" name="current_password" placeholder="Enter your current password" class="w-full p-2 mt-1 border rounded-md">
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
            const currentPasswordInput = document.querySelector('input[name="current_password"]');
            const changePasswordInput = document.querySelector('input[name="change_password"]');

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


</x-userlayout>