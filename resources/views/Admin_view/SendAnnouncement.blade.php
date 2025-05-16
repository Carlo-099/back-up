<x-adminlayout>
    <style>
        :root[data-theme="dark"] {
            --bg-gradient-from: #181f2a;
            --bg-gradient-to: #23272f;
            --card-bg: rgba(255,255,255,0.08);
            --card-border: rgba(255,255,255,0.18);
            --text-primary: #F3F4F6;
            --text-secondary: #a0aec0;
            --text-muted: #7b8794;
            --accent: #3b82f6;
            --btn-bg: linear-gradient(to right, #3b82f6, #2563eb);
            --btn-hover-bg: linear-gradient(to right, #2563eb, #1e40af);
            --input-bg: #23272f;
            --input-border: #374151;
            --input-placeholder: #7b8794;
        }
        :root[data-theme="light"] {
            --bg-gradient-from: #eafaf1;
            --bg-gradient-to: #d4f5e9;
            --card-bg: rgba(255,255,255,0.97);
            --card-border: #2ecc71;
            --text-primary: #1a2b36;
            --text-secondary: #3a4a56;
            --text-muted: #6b7a89;
            --accent: #2ecc71;
            --btn-bg: linear-gradient(to right, #2ecc71, #27ae60);
            --btn-hover-bg: linear-gradient(to right, #27ae60, #219150);
            --input-bg: #f7fafc;
            --input-border: #b5e0c7;
            --input-placeholder: #6b7a89;
        }
        body, .min-h-screen {
            background: linear-gradient(to bottom right, var(--bg-gradient-from), var(--bg-gradient-to)) !important;
        }
        .card {
            background: var(--card-bg);
            border: 2px solid var(--card-border);
            border-radius: 1rem;
            box-shadow: 0 4px 24px 0 rgba(46, 204, 113, 0.08);
        }
        .card-header {
            color: var(--text-primary);
            font-weight: 700;
        }
        .card-subtitle {
            color: var(--accent);
            font-weight: 500;
        }
        .form-label {
            color: var(--text-primary);
            font-weight: 600;
        }
        .form-input, textarea {
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            color: var(--text-primary);
            border-radius: 0.5rem;
            font-size: 1rem;
        }
        .form-input::placeholder, textarea::placeholder {
            color: var(--input-placeholder);
        }
        .form-helper {
            color: var(--text-muted);
        }
        .btn-primary {
            background: var(--btn-bg);
            color: #fff;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background: var(--btn-hover-bg);
        }
        .btn-secondary {
            background: var(--card-bg);
            color: var(--text-primary);
            border: 1.5px solid var(--input-border);
            font-weight: 600;
            border-radius: 0.5rem;
        }
        .table th, .table td {
            color: var(--text-primary);
        }
        .table th {
            font-weight: 700;
        }
        .table thead {
            border-bottom: 1.5px solid var(--card-border);
        }
        .table tbody tr {
            transition: background 0.2s;
        }
        .table tbody tr:hover {
            background: var(--input-bg);
        }
    </style>
    <div class="min-h-screen p-4">
        <!-- Header (left-aligned, outside cards) -->
        <div class="max-w-5xl pt-16 mx-auto mb-8">
            <h2 class="text-3xl font-bold card-header">Send Announcement</h2>
            <div>
                <span class="mt-2 text-lg font-medium card-subtitle">Share important updates with your team members</span>
            </div>
        </div>
        <!-- Form and List Section -->
        <div class="flex flex-col items-stretch justify-center max-w-5xl gap-12 mx-auto lg:flex-row">
            <!-- Form Section (narrower) -->
            <div class="flex-1 lg:mb-0">
                <div class="flex flex-col h-full p-6 overflow-hidden card">
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
                            <label for="announcement" class="block mb-1.5 text-sm form-label">Announcement Content</label>
                            <div class="flex flex-col items-center">
                                <textarea
                                    id="announcement"
                                    name="announcement"
                                    rows="5"
                                    class="w-[600px] max-w-full p-5 text-lg resize-none form-input mx-auto"
                                    placeholder="Type your announcement here..."
                                    required></textarea>
                                <p class="mt-1 text-xs form-helper w-[600px] max-w-full mx-auto">Maximum 500 characters</p>
                            </div>
                            @error('announcement')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Buttons -->
                        <div class="flex justify-center pt-3 space-x-3 border-t w-[600px] max-w-full mx-auto" style="border-color: var(--card-border)">
                            <button type="reset"
                                class="px-4 py-2 text-sm btn-secondary">
                                Clear Form
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm btn-primary">
                                Send Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- List Section (wider) -->
            <div class="w-full max-w-sm lg:w-1/3">
                <div class="flex flex-col h-full p-6 overflow-hidden card">
                    <!-- Header Section -->
                    <div class="mb-6">
                        <h2 class="inline-block px-2 py-1 text-2xl font-bold card-header">Recent Active Users</h2>
                    </div>
                    <!-- User Activity List -->
                    <div class="flex-1 overflow-x-auto">
                        <table class="table w-full text-left">
                            <thead class="text-sm font-medium">
                                <tr>
                                    <th class="px-4 py-3">Profile</th>
                                    <th class="px-4 py-3">Last Active</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y" style="border-color: var(--card-border)">
                                @foreach($activeUsers as $user)
                                <tr>
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
