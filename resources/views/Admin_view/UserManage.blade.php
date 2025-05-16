@php
use App\Models\Task;
@endphp

<x-adminlayout>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Theme Variables */
        :root[data-theme="dark"] {
            --bg-gradient-from: #23272f;
            --bg-gradient-to: #1a1e24;
            --card-bg: rgba(255, 255, 255, 0.1);
            --card-hover-bg: rgba(255, 255, 255, 0.2);
            --card-border: rgba(255, 255, 255, 0.2);
            --card-shadow: none;
            --text-primary: #F3F4F6;
            --text-secondary: #e5e7eb;
            --text-muted: #a0aec0;
            --accent-blue: #3b82f6;
            --accent-purple: #8b5cf6;
            --accent-green: #22d47b;
            --accent-pink: #ec4899;
            --accent-yellow: #eab308;
            --chart-gradient-start: rgba(59, 130, 246, 0.2);
            --chart-gradient-end: rgba(139, 92, 246, 0.2);
            --modal-bg: linear-gradient(to bottom right, #1f2937, #111827);
            --modal-border: #374151;
            --input-bg: #374151;
            --input-border: #4b5563;
            --input-focus-ring: #3b82f6;
            --scrollbar-track: rgba(255, 255, 255, 0.1);
            --scrollbar-thumb: rgba(255, 255, 255, 0.2);
            --scrollbar-thumb-hover: rgba(255, 255, 255, 0.3);
            --chart-text: #F3F4F6;
        }

        :root[data-theme="light"] {
            --bg-gradient-from: #f0f7f4;
            --bg-gradient-to: #e2e8f0;
            --card-bg: rgba(255, 255, 255, 0.95);
            --card-hover-bg: rgba(255, 255, 255, 0.98);
            --card-border: #2ecc71;
            --card-shadow: 0 4px 24px 0 rgba(46, 204, 113, 0.10), 0 1.5px 6px 0 rgba(46, 204, 113, 0.08);
            --text-primary: #1a2b36;
            --text-secondary: #3a4a56;
            --text-muted: #6b7a89;
            --accent-blue: #2ecc71;
            --accent-purple: #27ae60;
            --accent-green: #2ecc71;
            --accent-pink: #27ae60;
            --accent-yellow: #f1c40f;
            --chart-gradient-start: rgba(46, 204, 113, 0.2);
            --chart-gradient-end: rgba(39, 174, 96, 0.2);
            --modal-bg: linear-gradient(to bottom right, #ffffff, #f7fafc);
            --modal-border: #e2e8f0;
            --input-bg: #ffffff;
            --input-border: #e2e8f0;
            --input-focus-ring: #2ecc71;
            --scrollbar-track: rgba(46, 204, 113, 0.1);
            --scrollbar-thumb: rgba(46, 204, 113, 0.2);
            --scrollbar-thumb-hover: rgba(46, 204, 113, 0.3);
            --chart-text: #1a2b36;
        }

        /* Base Styles */
        .dashboard-container {
            min-height: 100vh;
            padding: 1.5rem;
            background: linear-gradient(to bottom right, var(--bg-gradient-from), var(--bg-gradient-to));
            font-family: 'Inter', sans-serif;
        }

        /* Card Styles */
        .dashboard-card, .p-6, .p-5, .col-span-2, .p-4, .p-3 {
            background: var(--card-bg) !important;
            border: 2px solid var(--card-border) !important;
            border-radius: 0.75rem !important;
            box-shadow: var(--card-shadow, none) !important;
            transition: all 0.3s ease;
        }
        .dashboard-card:hover, .p-6:hover, .p-5:hover, .col-span-2:hover, .p-4:hover, .p-3:hover {
            background: var(--card-hover-bg) !important;
            box-shadow: 0 0 16px 2px rgba(46,204,113,0.18) !important;
        }

        /* Text Styles - Stronger contrast for light mode */
        .text-primary { color: var(--text-primary) !important; font-weight: 600; }
        .text-secondary { color: var(--text-secondary) !important; font-weight: 500; }
        .text-muted { color: var(--text-muted) !important; font-weight: 500; }
        h1, h2, h3, h4, h5, h6 { color: var(--text-primary) !important; font-weight: 700; }

        /* Chart Styles - Remove border and shadow from graph containers */
        .chart-container, .h-32, .h-64, .h-\[300px\] {
            background: var(--card-bg) !important;
            border: none !important;
            box-shadow: none !important;
            border-radius: 0.75rem !important;
            padding: 1.25rem !important;
        }
        .chart-container:hover, .h-32:hover, .h-64:hover, .h-\[300px\]:hover {
            box-shadow: none !important;
        }

        /* For dark mode, keep original look for cards only */
        :root[data-theme="dark"] .dashboard-card,
        :root[data-theme="dark"] .p-6,
        :root[data-theme="dark"] .p-5,
        :root[data-theme="dark"] .col-span-2,
        :root[data-theme="dark"] .p-4,
        :root[data-theme="dark"] .p-3 {
            border: 1px solid var(--card-border) !important;
            box-shadow: none !important;
        }

        /* Table Styles */
        .dashboard-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .dashboard-table th {
            color: var(--text-secondary);
            font-weight: 500;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--card-border);
        }

        .dashboard-table td {
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--card-border);
        }

        .dashboard-table tr:hover {
            background: var(--card-hover-bg);
        }

        /* Modal Styles */
        .modal-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: var(--modal-bg);
            border: 1px solid var(--modal-border);
            border-radius: 0.75rem;
        }

        .modal-input {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            border-radius: 0.375rem;
        }

        .modal-input:focus {
            border-color: var(--input-focus-ring);
            box-shadow: 0 0 0 2px var(--input-focus-ring);
        }

        /* Scrollbar Styles */
        * {
            scrollbar-width: thin;
            scrollbar-color: var(--scrollbar-thumb) var(--scrollbar-track);
        }

        *::-webkit-scrollbar {
            width: 8px;
        }

        *::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
            border-radius: 4px;
        }

        *::-webkit-scrollbar-thumb {
            background-color: var(--scrollbar-thumb);
            border-radius: 4px;
            border: 2px solid var(--scrollbar-track);
        }

        *::-webkit-scrollbar-thumb:hover {
            background-color: var(--scrollbar-thumb-hover);
        }

        /* Theme Transition */
        * {
            transition: background-color 0.3s, color 0.3s, border-color 0.3s, box-shadow 0.3s;
        }

        /* Add specific styles for chart text */
        .chart-text {
            color: var(--text-primary);
            font-weight: 500;
        }
        .chart-label {
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Chart and box text overrides for both modes */
        [data-theme="dark"] .chart-label,
        [data-theme="dark"] .chart-text,
        [data-theme="dark"] .text-primary,
        [data-theme="dark"] .text-secondary,
        [data-theme="dark"] .text-muted,
        [data-theme="dark"] h1,
        [data-theme="dark"] h2,
        [data-theme="dark"] h3,
        [data-theme="dark"] h4,
        [data-theme="dark"] h5,
        [data-theme="dark"] h6 {
            color: var(--chart-text) !important;
        }
        [data-theme="dark"] .dashboard-card *,
        [data-theme="dark"] .chart-container *,
        [data-theme="dark"] .p-6 *,
        [data-theme="dark"] .p-5 *,
        [data-theme="dark"] .col-span-2 *,
        [data-theme="dark"] .p-4 *,
        [data-theme="dark"] .p-3 * {
            color: var(--chart-text) !important;
        }
        [data-theme="light"] .chart-label,
        [data-theme="light"] .chart-text,
        [data-theme="light"] .text-primary,
        [data-theme="light"] .text-secondary,
        [data-theme="light"] .text-muted,
        [data-theme="light"] h1,
        [data-theme="light"] h2,
        [data-theme="light"] h3,
        [data-theme="light"] h4,
        [data-theme="light"] h5,
        [data-theme="light"] h6 {
            color: var(--chart-text) !important;
        }
        [data-theme="light"] .dashboard-card *,
        [data-theme="light"] .chart-container *,
        [data-theme="light"] .p-6 *,
        [data-theme="light"] .p-5 *,
        [data-theme="light"] .col-span-2 *,
        [data-theme="light"] .p-4 *,
        [data-theme="light"] .p-3 * {
            color: var(--chart-text) !important;
        }
    </style>

    <!-- Main Content -->
    <div class="dashboard-container">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-primary">User Management Dashboard</h1>
                    <p class="text-secondary">Overview of regular users and their activities</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="p-4 dashboard-card">
                        <div class="text-sm text-secondary">Current Date</div>
                        <div class="text-xl font-semibold text-primary" id="currentDate">--</div>
                    </div>
                    <div class="p-4 dashboard-card">
                        <div class="text-sm text-secondary">Weather</div>
                        <div class="flex items-center space-x-2">
                            <i class="text-2xl text-yellow-400 fas fa-sun" id="weatherIcon"></i>
                            <div>
                                <div class="text-xl font-semibold text-primary" id="temperature">--°C</div>
                                <div class="text-sm text-secondary" id="weatherDesc">--</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Summary Cards -->
        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Regular Users -->
            <div class="p-6 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <div class="flex items-center justify-between h-full">
                    <div class="flex-1">
                        <div class="flex items-center mb-4 space-x-3">
                            <div class="p-2 rounded-lg bg-gradient-to-br from-blue-500/20 to-purple-500/20">
                                <i class="text-2xl text-blue-400 fas fa-users"></i>
                            </div>
                            <span class="text-xl font-semibold text-gray-300">Users</span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-baseline space-x-3">
                                <span class="text-5xl font-bold text-white" id="totalUsers">{{ $totalUsers }}</span>
                                <div class="flex items-center px-3 py-1.5 text-base text-blue-400 bg-blue-500/20 rounded-full">
                                    <i class="mr-2 fas fa-user-plus"></i>
                                    <span id="newUsers">{{ $newUsersThisMonth }}</span> new
                                </div>
                            </div>
                            <div class="flex items-center text-base text-gray-400">
                                <div class="flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-lg">
                                    <i class="mr-2 fas fa-chart-line"></i>
                                    <span id="userGrowth">{{ round(($newUsersThisMonth / max($totalUsers - $newUsersThisMonth, 1)) * 100) }}</span>% growth
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <div class="p-4 rounded-lg bg-gradient-to-br from-blue-500/20 to-purple-500/20">
                            <i class="text-4xl text-blue-400 fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gender Distribution -->
            <div class="p-5 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-400">Gender Distribution</span>
                    <div class="p-2 rounded-lg bg-pink-500/20">
                        <i class="text-lg text-pink-400 fas fa-venus-mars"></i>
                    </div>
                </div>
                <div class="h-40">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <!-- Age Distribution -->
            <div class="p-5 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-400">Age Groups</span>
                    <div class="p-2 rounded-lg bg-green-500/20">
                        <i class="text-lg text-green-400 fas fa-chart-bar"></i>
                    </div>
                </div>
                <div class="h-40">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>

            <!-- Educational Level -->
            <div class="p-5 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-400">Education Level</span>
                    <div class="p-2 rounded-lg bg-purple-500/20">
                        <i class="text-lg text-purple-400 fas fa-graduation-cap"></i>
                    </div>
                </div>
                <div class="h-40">
                    <canvas id="educationChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Middle Section -->
        <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
            <!-- Task Completion Stats -->
            <div class="p-5 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <div class="flex items-center justify-between mb-4">
                    <span class="font-semibold text-white">Task Completion Statistics</span>
                    <div class="p-2 rounded-lg bg-yellow-500/20">
                        <i class="text-lg text-yellow-400 fas fa-tasks"></i>
                    </div>
                </div>
                <div class="h-[332px]">
                    <canvas id="taskStatsChart"></canvas>
                </div>
            </div>

            <!-- User Activity -->
            <div class="p-5 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <div class="flex items-center justify-between mb-4">
                    <span class="font-semibold text-white">User Activity (Last 7 Days)</span>
                    <div class="p-2 rounded-lg bg-blue-500/20">
                        <i class="text-lg text-blue-400 fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="h-[332px]">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Recent Active Users -->
            <div class="p-5 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-semibold text-white">Recently Active Users</span>
                    <div class="p-2 rounded-lg bg-green-500/20">
                        <i class="text-lg text-green-400 fas fa-user-clock"></i>
                    </div>
                </div>
                <div class="h-[390px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.1);">
                    <div class="space-y-2">
                        @forelse($users->where('last_login_at', '>=', now()->subDays(30))->sortByDesc('last_login_at') as $user)
                            <div class="flex items-center p-3 transition-colors rounded-lg bg-white/5 hover:bg-white/10">
                                <div class="relative">
                                    @if($user->reference && $user->reference->settings && $user->reference->settings->profile_picture)
                                        <img src="{{ asset($user->reference->settings->profile_picture) }}"
                                             alt="{{ $user->name }}"
                                             class="object-cover w-8 h-8 mr-3 rounded-full">
                                    @else
                                        <div class="flex items-center justify-center w-8 h-8 mr-3 text-white rounded-full bg-blue-500/20">
                                            <i class="text-sm fas fa-user"></i>
                                        </div>
                                    @endif
                                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-gray-800"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-white truncate">{{ $user->name }}</h3>
                                        <span class="px-2 py-0.5 ml-2 text-xs font-medium text-gray-400 bg-gray-500/20 rounded-full whitespace-nowrap">
                                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center mt-0.5 text-xs text-gray-400">
                                        <span class="flex items-center">
                                            <i class="mr-1 fas fa-envelope"></i>
                                            {{ $user->email }}
                                        </span>
                                        <span class="mx-2">•</span>
                                        <span class="flex items-center">
                                            <i class="mr-1 fas fa-user-graduate"></i>
                                            {{ ucfirst($user->educational_level) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-3 text-center text-gray-400 rounded-lg bg-white/5">
                                No active users found
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Task Completions -->
            <div class="p-5 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-semibold text-white">Recent Task Completions</span>
                    <div class="p-2 rounded-lg bg-purple-500/20">
                        <i class="text-lg text-purple-400 fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="h-[390px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.1);">
                    <div class="space-y-2">
                        @forelse($recentTasks as $task)
                            <div class="flex items-center p-3 transition-colors rounded-lg bg-white/5 hover:bg-white/10">
                                <div class="flex items-center justify-center w-8 h-8 mr-3 text-green-400 rounded-full bg-green-500/20">
                                    <i class="text-sm fas fa-check"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-white truncate">{{ $task['title'] }}</h3>
                                        <span class="px-2 py-0.5 ml-2 text-xs font-medium text-blue-400 bg-blue-500/20 rounded-full whitespace-nowrap">
                                            {{ ucfirst($task['category']) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center mt-0.5 text-xs text-gray-400">
                                        <span class="flex items-center">
                                            <i class="mr-1 fas fa-user"></i>
                                            {{ $task['user_name'] }}
                                        </span>
                                        <span class="mx-2">•</span>
                                        <span class="flex items-center">
                                            <i class="mr-1 fas fa-clock"></i>
                                            {{ $task['completed_at'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-3 text-center text-gray-400 rounded-lg bg-white/5">
                                No completed tasks found
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- User List -->
        <div class="col-span-2 p-6 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-white">User List</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 border-b border-gray-700">
                            <th class="pb-3">Name</th>
                            <th class="pb-3">Email</th>
                            <th class="pb-3">Age</th>
                            <th class="pb-3">Gender</th>
                            <th class="pb-3">Education</th>
                            <th class="pb-3">Last Login</th>
                            <th class="pb-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="text-gray-300 border-b border-gray-700">
                            <td class="py-3">{{ $user->name }}</td>
                            <td class="py-3">{{ $user->email }}</td>
                            <td class="py-3">{{ $user->age }}</td>
                            <td class="py-3">{{ ucfirst($user->gender) }}</td>
                            <td class="py-3">{{ ucfirst($user->educational_level) }}</td>
                            <td class="py-3">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</td>
                            <td class="py-3">
                                <button onclick="showUserModal({{ $user->id }})" class="p-2 text-blue-400 hover:text-blue-300">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- User Information Modal -->
        <div id="userModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
                </div>
                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform rounded-lg shadow-xl bg-gradient-to-br from-gray-800 to-gray-900 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <!-- Modal Header -->
                    <div class="px-6 pt-6 pb-4 border-b border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-white" id="modalTitle">User Information</h3>
                            <button onclick="closeUserModal()" class="text-gray-400 hover:text-white">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-6 py-4">
                        <div class="flex items-center mb-6 space-x-4">
                            <div class="relative">
                                <img id="userProfilePicture" src="" alt="Profile Picture" class="w-20 h-20 border-4 border-blue-500 rounded-full">
                                <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-2 border-gray-800 rounded-full"></div>
                            </div>
                            <div>
                                <h4 id="userNameDisplay" class="text-lg font-semibold text-white"></h4>
                                <p id="userEmailDisplay" class="text-sm text-gray-400"></p>
                            </div>
                        </div>

                        <form id="userForm" class="space-y-4">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400">Name</label>
                                    <input type="text" id="userName" name="name" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400">Email</label>
                                    <input type="email" id="userEmail" name="email" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400">Age</label>
                                    <input type="number" id="userAge" name="age" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400">Gender</label>
                                    <select id="userGender" name="gender" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400">Educational Level</label>
                                    <select id="userEducation" name="educational_level" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="elementary">Elementary</option>
                                        <option value="high school">High School</option>
                                        <option value="senior high">Senior High</option>
                                        <option value="college">College</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400">Last Login</label>
                                    <p id="userLastLogin" class="mt-1 text-sm text-gray-300"></p>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-4 bg-gray-800/50 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="updateUser()" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <i class="mr-2 fas fa-save"></i> Update
                        </button>
                        <button type="button" onclick="deleteUser()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            <i class="mr-2 fas fa-trash"></i> Delete
                        </button>
                        <button type="button" onclick="closeUserModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:w-auto sm:text-sm">
                            <i class="mr-2 fas fa-times"></i> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart.js DataLabels Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- Dashboard Scripts -->
    <script>
        // Initialize charts with futuristic theme
        Chart.defaults.color = '#E2E8F0';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.15)';
        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.font.weight = '500';

        // Initial data from PHP variables
        const initialData = {
            gender: @json($genderDistribution),
            age: @json($ageDistribution),
            education: @json($educationDistribution),
            taskStats: @json($taskStatsData)
        };

        console.log('Initial Task Stats:', initialData.taskStats);

        // Chart.js color settings for both modes
        function getChartTextColor() {
            const theme = document.documentElement.getAttribute('data-theme');
            return theme === 'light' ? '#1a2b36' : '#F3F4F6';
        }

        // Helper to get datalabel color based on theme
        function getDataLabelColor() {
            const theme = document.documentElement.getAttribute('data-theme');
            return theme === 'light' ? '#1a2b36' : '#F3F4F6';
        }

        // Add datalabels plugin to all charts
        Chart.register(window.ChartDataLabels);

        // Update chart options for better readability
        const commonChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: getChartTextColor(),
                        font: {
                            weight: '600',
                            size: 13
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.98)',
                    titleColor: getChartTextColor(),
                    bodyColor: getChartTextColor(),
                    borderColor: '#2ecc71',
                    borderWidth: 1,
                    padding: 12,
                    titleFont: {
                        weight: '700',
                        size: 13
                    },
                    bodyFont: {
                        weight: '600',
                        size: 12
                    }
                },
                datalabels: {
                    color: getDataLabelColor(),
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    anchor: 'end',
                    align: 'top',
                    clamp: true,
                    display: true
                }
            }
        };

        // Update chart options for better readability
        function updateAllChartTextColors() {
            const color = getChartTextColor();
            const datalabelColor = getDataLabelColor();
            Object.values(charts).forEach(chart => {
                if (chart.options.scales) {
                    if (chart.options.scales.x) {
                        chart.options.scales.x.ticks.color = color;
                        chart.options.scales.x.grid.color = color + '33';
                    }
                    if (chart.options.scales.y) {
                        chart.options.scales.y.ticks.color = color;
                        chart.options.scales.y.grid.color = color + '33';
                    }
                }
                if (chart.options.plugins) {
                    if (chart.options.plugins.legend && chart.options.plugins.legend.labels) {
                        chart.options.plugins.legend.labels.color = color;
                    }
                    if (chart.options.plugins.tooltip) {
                        chart.options.plugins.tooltip.titleColor = color;
                        chart.options.plugins.tooltip.bodyColor = color;
                        chart.options.plugins.tooltip.backgroundColor = (document.documentElement.getAttribute('data-theme') === 'dark') ? '#23272f' : '#fff';
                    }
                    if (chart.options.plugins.datalabels) {
                        chart.options.plugins.datalabels.color = datalabelColor;
                    }
                }
                chart.update();
            });
        }

        // Listen for theme changes and update chart text colors
        const observer = new MutationObserver(updateAllChartTextColors);
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
        window.addEventListener('DOMContentLoaded', updateAllChartTextColors);

        // Update individual chart configurations
        const charts = {
            gender: new Chart(document.getElementById('genderChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        data: [initialData.gender.male || 0, initialData.gender.female || 0],
                        backgroundColor: ['#3B82F6', '#EC4899'],
                        borderWidth: 2,
                        borderColor: 'rgba(255, 255, 255, 0.1)'
                    }]
                },
                options: {
                    ...commonChartOptions,
                    plugins: {
                        ...commonChartOptions.plugins,
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: getChartTextColor(),
                                font: {
                                    weight: '500',
                                    size: 12
                                },
                                padding: 20
                            }
                        }
                    },
                    cutout: '70%'
                }
            }),
            age: new Chart(document.getElementById('ageChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['18-24', '25-34', '35-44', '45-54', '55+'],
                    datasets: [{
                        label: 'Users',
                        data: Object.values(initialData.age),
                        backgroundColor: '#10B981',
                        borderRadius: 6,
                        borderWidth: 2,
                        borderColor: 'rgba(255, 255, 255, 0.1)'
                    }]
                },
                options: {
                    ...commonChartOptions,
                    plugins: {
                        ...commonChartOptions.plugins,
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: getChartTextColor(),
                                drawBorder: false,
                                lineWidth: 1
                            },
                            ticks: {
                                color: getChartTextColor(),
                                font: {
                                    weight: '500',
                                    size: 11
                                },
                                padding: 10
                            }
                        },
                        x: {
                            grid: {
                                color: getChartTextColor(),
                                drawBorder: false,
                                lineWidth: 1
                            },
                            ticks: {
                                color: getChartTextColor(),
                                font: {
                                    weight: '500',
                                    size: 11
                                },
                                padding: 10
                            }
                        }
                    }
                }
            }),
            education: new Chart(document.getElementById('educationChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Elementary', 'High School', 'Senior High', 'College'],
                    datasets: [{
                        label: 'Users',
                        data: Object.values(initialData.education),
                        backgroundColor: '#6366F1',
                        borderRadius: 6,
                        borderWidth: 2,
                        borderColor: 'rgba(255, 255, 255, 0.1)'
                    }]
                },
                options: {
                    ...commonChartOptions,
                    plugins: {
                        ...commonChartOptions.plugins,
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: getChartTextColor(),
                                drawBorder: false,
                                lineWidth: 1
                            },
                            ticks: {
                                color: getChartTextColor(),
                                font: {
                                    weight: '500',
                                    size: 11
                                },
                                padding: 10
                            }
                        },
                        x: {
                            grid: {
                                color: getChartTextColor(),
                                drawBorder: false,
                                lineWidth: 1
                            },
                            ticks: {
                                color: getChartTextColor(),
                                font: {
                                    weight: '500',
                                    size: 11
                                },
                                padding: 10
                            }
                        }
                    }
                }
            }),
            taskStats: new Chart(document.getElementById('taskStatsChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Completed', 'In Progress', 'Pending'],
                    datasets: [{
                        data: [
                            initialData.taskStats.complete || 0,
                            initialData.taskStats.in_progress || 0,
                            initialData.taskStats.pending || 0
                        ],
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                        borderWidth: 2,
                        borderColor: 'rgba(255, 255, 255, 0.1)'
                    }]
                },
                options: {
                    ...commonChartOptions,
                    plugins: {
                        ...commonChartOptions.plugins,
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: getChartTextColor(),
                                font: {
                                    weight: '500',
                                    size: 12
                                },
                                padding: 20
                            }
                        }
                    }
                }
            }),
            activity: new Chart(document.getElementById('activityChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Active Users',
                        data: [],
                        borderColor: '#22d47b',
                        backgroundColor: ctx => {
                            const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                            gradient.addColorStop(0, 'rgba(34, 212, 123, 0.15)');
                            gradient.addColorStop(1, 'rgba(34, 212, 123, 0)');
                            return gradient;
                        },
                        tension: 0.45,
                        fill: true,
                        borderWidth: 3,
                        pointBackgroundColor: '#22d47b',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    ...commonChartOptions,
                    plugins: {
                        ...commonChartOptions.plugins,
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: getChartTextColor(),
                                drawBorder: false,
                                lineWidth: 1
                            },
                            ticks: {
                                color: getChartTextColor(),
                                font: {
                                    weight: '500',
                                    size: 11
                                },
                                padding: 10
                            }
                        },
                        x: {
                            grid: {
                                color: getChartTextColor(),
                                drawBorder: false,
                                lineWidth: 1
                            },
                            ticks: {
                                color: getChartTextColor(),
                                font: {
                                    weight: '500',
                                    size: 11
                                },
                                padding: 10
                            }
                        }
                    }
                }
            })
        };

        // Function to update dashboard data
        async function updateDashboard() {
            try {
                const response = await fetch('/api/dashboard-stats');
                const data = await response.json();

                // Update summary numbers
                document.getElementById('totalUsers').textContent = data.totalUsers;
                document.getElementById('newUsers').textContent = data.newUsers;

                // Calculate user growth
                const lastMonthUsers = data.lastMonthUsers || 0;
                const growth = lastMonthUsers > 0 ? ((data.totalUsers - lastMonthUsers) / lastMonthUsers * 100).toFixed(1) : 0;
                document.getElementById('userGrowth').textContent = growth;

                // Update charts
                charts.gender.data.datasets[0].data = data.gender;
                charts.age.data.datasets[0].data = data.age;
                charts.education.data.datasets[0].data = data.education;
                charts.taskStats.data.datasets[0].data = [
                    data.taskStats.complete || 0,
                    data.taskStats.in_progress || 0,
                    data.taskStats.pending || 0
                ];

                // Update activity chart with animation
                const activityData = data.activity;
                if (activityData && activityData.labels && activityData.data) {
                    // Add a subtle animation when updating the data
                    charts.activity.data.labels = activityData.labels;
                    charts.activity.data.datasets[0].data = activityData.data;

                    // Calculate trend
                    const values = activityData.data;
                    const trend = values[values.length - 1] > values[0] ? 'up' : 'down';
                    const change = Math.abs(((values[values.length - 1] - values[0]) / values[0]) * 100).toFixed(1);

                    // Update the chart with animation
                    charts.activity.update('active');
                }

                // Update all other charts
                Object.entries(charts).forEach(([key, chart]) => {
                    if (key !== 'activity') {
                        chart.update();
                    }
                });

            } catch (error) {
                console.error('Error updating dashboard:', error);
            }
        }

        // Function to update date and weather
        async function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);

            try {
                const response = await fetch('https://api.openweathermap.org/data/2.5/weather?q=Manila&units=metric&appid=d4d01f5e0e7c2c0d5f9c2c6f3d3e3f3f');
                const data = await response.json();

                document.getElementById('temperature').textContent = `${Math.round(data.main.temp)}°C`;
                document.getElementById('weatherDesc').textContent = data.weather[0].description;

                // Update weather icon
                const weatherIcon = document.getElementById('weatherIcon');
                const iconCode = data.weather[0].icon;
                weatherIcon.className = `text-2xl text-yellow-400 fas fa-${getWeatherIcon(iconCode)}`;
            } catch (error) {
                console.error('Error fetching weather:', error);
                // Set default values if weather API fails
                document.getElementById('temperature').textContent = '--°C';
                document.getElementById('weatherDesc').textContent = 'Weather data unavailable';
                document.getElementById('weatherIcon').className = 'text-2xl text-yellow-400 fas fa-sun';
            }
        }

        // Helper function to map weather codes to Font Awesome icons
        function getWeatherIcon(code) {
            const iconMap = {
                '01d': 'sun',
                '01n': 'moon',
                '02d': 'cloud-sun',
                '02n': 'cloud-moon',
                '03d': 'cloud',
                '03n': 'cloud',
                '04d': 'cloud',
                '04n': 'cloud',
                '09d': 'cloud-showers-heavy',
                '09n': 'cloud-showers-heavy',
                '10d': 'cloud-sun-rain',
                '10n': 'cloud-moon-rain',
                '11d': 'bolt',
                '11n': 'bolt',
                '13d': 'snowflake',
                '13n': 'snowflake',
                '50d': 'smog',
                '50n': 'smog'
            };
            return iconMap[code] || 'cloud';
        }

        // Initial updates
        updateDashboard();
        updateDateTime();

        // Update dashboard every 5 minutes
        setInterval(updateDashboard, 5 * 60 * 1000);
        // Update date and weather every 30 minutes
        setInterval(updateDateTime, 30 * 60 * 1000);

        let currentUserId = null;

        function showUserModal(userId) {
            currentUserId = userId;
            fetch(`/user/${userId}`)
                .then(response => response.json())
                .then(user => {
                    document.getElementById('userName').value = user.name;
                    document.getElementById('userEmail').value = user.email;
                    document.getElementById('userAge').value = user.age;
                    document.getElementById('userGender').value = user.gender;
                    document.getElementById('userEducation').value = user.educational_level;
                    document.getElementById('userLastLogin').textContent = user.last_login_at ? new Date(user.last_login_at).toLocaleString() : 'Never';

                    // Update display name and email
                    document.getElementById('userNameDisplay').textContent = user.name;
                    document.getElementById('userEmailDisplay').textContent = user.email;

                    // Set profile picture if available
                    const profilePicture = user.reference?.settings?.profile_picture;
                    document.getElementById('userProfilePicture').src = profilePicture ? `/${profilePicture}` : '/default-profile.png';

                    document.getElementById('userModal').classList.remove('hidden');
                });
        }

        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
            currentUserId = null;
        }

        function updateUser() {
            const formData = new FormData(document.getElementById('userForm'));
            const data = Object.fromEntries(formData.entries());

            fetch(`/user/${currentUserId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                alert('User updated successfully');
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating user: ' + error.message);
            });
        }

        function deleteUser() {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch(`/user/${currentUserId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('User deleted successfully');
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting user: ' + error.message);
                });
            }
        }

        // Update chart colors based on theme
        function getChartColors() {
            const theme = document.documentElement.getAttribute('data-theme');
            return {
                blue: theme === 'dark' ? '#3b82f6' : '#2ecc71',
                purple: theme === 'dark' ? '#8b5cf6' : '#27ae60',
                green: theme === 'dark' ? '#22d47b' : '#2ecc71',
                pink: theme === 'dark' ? '#ec4899' : '#27ae60',
                yellow: theme === 'dark' ? '#eab308' : '#f1c40f',
                gradientStart: theme === 'dark' ? 'rgba(59, 130, 246, 0.2)' : 'rgba(46, 204, 113, 0.2)',
                gradientEnd: theme === 'dark' ? 'rgba(139, 92, 246, 0.2)' : 'rgba(39, 174, 96, 0.2)'
            };
        }

        // Update your existing chart configurations to use the theme colors
        // ... rest of your existing JavaScript code ...
    </script>
</x-adminlayout>

