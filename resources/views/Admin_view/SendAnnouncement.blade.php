<x-adminlayout>
    <!-- Main Content -->
    <div class="min-h-screen p-4 bg-gradient-to-br from-gray-900 to-gray-800">
        <!-- Header (left-aligned, outside cards) -->
        <div class="max-w-5xl pt-16 mx-auto mb-8">
            <h2 class="text-3xl font-bold text-white">Send Announcement</h2>
            <div>
                <span class="mt-2 text-lg font-medium text-blue-300">Share important updates with your team members</span>
            </div>
        </div>
        <!-- Form and List Section -->
        <div class="flex flex-col items-stretch justify-center max-w-5xl gap-12 mx-auto lg:flex-row">
            <!-- Form Section (narrower) -->
            <div class="w-full lg:w-2/5 flex-[2] max-w-xl lg:mb-0">
                <div class="flex flex-col h-full p-6 overflow-hidden border shadow-2xl bg-white/10 backdrop-blur-lg rounded-2xl border-white/20">
                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('announcement.store') }}" method="POST">
                        @csrf
                        <!-- Announcement Textarea -->
                        <div>
                            <label for="announcement" class="block mb-1.5 text-sm font-medium text-gray-200">Announcement Content</label>
                            <textarea
                                id="announcement"
                                name="announcement"
                                rows="5"
                                class="w-full p-3 text-white placeholder-gray-400 transition-all duration-200 border rounded-lg resize-none bg-white/5 border-white/10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Type your announcement here..."
                                required></textarea>
                            <p class="mt-1 text-xs text-gray-400">Maximum 500 characters</p>
                            @error('announcement')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Buttons -->
                        <div class="flex justify-end pt-3 space-x-3 border-t border-white/10">
                            <button type="reset"
                                class="px-4 py-2 text-sm font-medium text-gray-200 transition-all duration-200 rounded-lg bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/30">
                                Clear Form
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white transition-all duration-200 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                Send Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- List Section (wider) -->
            <div class="flex-1 w-full max-w-3xl lg:w-1/2">
                <div class="flex flex-col h-full p-6 overflow-hidden border shadow-2xl bg-white/10 backdrop-blur-lg rounded-2xl border-white/20">
                    <!-- Header Section -->
                    <div class="mb-6">
                        <h2 class="inline-block px-2 py-1 text-2xl font-bold text-white">Recent Active Users</h2>
                    </div>
                    <!-- User Activity List -->
                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="text-sm font-medium text-gray-300 border-b border-white/10">
                                <tr>
                                    <th class="px-4 py-3">Profile</th>
                                    <th class="px-4 py-3">Last Active</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($activeUsers as $user)
                                <tr class="text-gray-200 hover:bg-white/5">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <a href="{{ route('user.show', $user->id) }}" class="flex items-center hover:opacity-80">
                                                @php
                                                    $reference = $user->reference;
                                                    $settings = $reference ? $reference->settings : null;
                                                    $profilePicture = "https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&background=0D9488&color=fff";
                                                    if ($settings && $settings->profile_picture) {
                                                        if (strpos($settings->profile_picture, 'uploads/profile_pictures/') === 0) {
                                                            $profilePicture = asset($settings->profile_picture);
                                                        } else {
                                                            $profilePicture = asset('uploads/profile_pictures/' . $settings->profile_picture);
                                                        }
                                                    }
                                                @endphp
                                                <img src="{{ $profilePicture }}" alt="Profile" class="object-cover w-8 h-8 rounded-full">
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-adminlayout>
