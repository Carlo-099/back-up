@php
use App\Models\Task;
@endphp

<x-adminlayout>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Main Content -->
    <div class="min-h-screen p-6 bg-gradient-to-br from-gray-900 to-gray-800 font-inter">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">User Management Dashboard</h1>
                    <p class="text-gray-400">Overview of regular users and their activities</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="p-4 bg-white/10 backdrop-blur-lg rounded-xl">
                        <div class="text-sm text-gray-400">Current Date</div>
                        <div class="text-xl font-semibold text-white" id="currentDate">--</div>
                    </div>
                    <div class="p-4 bg-white/10 backdrop-blur-lg rounded-xl">
                        <div class="text-sm text-gray-400">Weather</div>
                        <div class="flex items-center space-x-2">
                            <i class="text-2xl text-yellow-400 fas fa-sun" id="weatherIcon"></i>
                            <div>
                                <div class="text-xl font-semibold text-white" id="temperature">--°C</div>
                                <div class="text-sm text-gray-400" id="weatherDesc">--</div>
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
                <div class="h-32">
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
                <div class="h-32">
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
                <div class="h-32">
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
                <div class="h-64">
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
                <div class="h-64">
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
                <div class="h-[300px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.1);">
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
                <div class="h-[300px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.1);">
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

    <!-- Dashboard Scripts -->
    <script>
        // Initialize charts with futuristic theme
        Chart.defaults.color = '#9CA3AF';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';

        // Initial data from PHP variables
        const initialData = {
            gender: @json($genderDistribution),
            age: @json($ageDistribution),
            education: @json($educationDistribution),
            taskStats: @json($taskStatsData)
        };

        console.log('Initial Task Stats:', initialData.taskStats);

        const charts = {
            gender: new Chart(document.getElementById('genderChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        data: [initialData.gender.male || 0, initialData.gender.female || 0],
                        backgroundColor: ['#3B82F6', '#EC4899'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#9CA3AF'
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
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
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
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
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
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#9CA3AF'
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
                        borderColor: '#22d47b', // Neon green
                        backgroundColor: ctx => {
                            const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                            gradient.addColorStop(0, 'rgba(34, 212, 123, 0.15)');
                            gradient.addColorStop(1, 'rgba(34, 212, 123, 0)');
                            return gradient;
                        },
                        tension: 0.45,
                        fill: true,
                        pointBackgroundColor: '#22d47b',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        borderWidth: 4,
                        pointHoverBackgroundColor: '#22d47b',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3,
                        shadowOffsetX: 0,
                        shadowOffsetY: 4,
                        shadowBlur: 16,
                        shadowColor: 'rgba(34, 212, 123, 0.7)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#22d47b',
                            borderWidth: 1,
                            padding: 14,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y} active users`;
                                }
                            }
                        },
                        // Custom plugin for endpoint badge
                        endpointBadge: {
                            enabled: true
                        }
                    },
                    layout: {
                        padding: { left: 0, right: 0, top: 20, bottom: 0 }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: false },
                            ticks: {
                                color: '#b0b0b0',
                                font: { size: 13, family: 'Inter, sans-serif' },
                                padding: 10
                            },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#b0b0b0',
                                font: { size: 13, family: 'Inter, sans-serif' },
                                padding: 10
                            },
                            border: { display: false }
                        }
                    },
                    interaction: { intersect: false, mode: 'index' },
                    elements: {
                        line: {
                            borderWidth: 4,
                            borderColor: '#22d47b',
                            fill: true
                        },
                        point: {
                            radius: 6,
                            backgroundColor: '#22d47b',
                            borderColor: '#fff',
                            borderWidth: 3
                        }
                    },
                    animation: {
                        duration: 900,
                        easing: 'easeOutQuart'
                    }
                },
                plugins: [{
                    // Custom plugin for endpoint badge
                    id: 'endpointBadge',
                    afterDatasetsDraw(chart, args, options) {
                        if (!options.enabled) return;
                        const { ctx, data, chartArea } = chart;
                        const dataset = chart.getDatasetMeta(0);
                        if (!dataset || !dataset.data.length) return;
                        const lastPoint = dataset.data[dataset.data.length - 1];
                        const value = data.datasets[0].data[data.datasets[0].data.length - 1];
                        ctx.save();
                        ctx.font = 'bold 12px Inter, sans-serif';
                        ctx.textAlign = 'left';
                        ctx.textBaseline = 'middle';
                        ctx.fillStyle = '#22d47b';
                        ctx.strokeStyle = '#222';
                        ctx.lineWidth = 2;
                        // Draw rounded badge
                        const badgeText = 'JUN'; // You can make this dynamic if needed
                        const badgeWidth = ctx.measureText(badgeText).width + 18;
                        const badgeHeight = 24;
                        const badgeX = lastPoint.x + 12;
                        const badgeY = lastPoint.y - badgeHeight / 2;
                        ctx.beginPath();
                        ctx.moveTo(badgeX + 8, badgeY);
                        ctx.lineTo(badgeX + badgeWidth - 8, badgeY);
                        ctx.quadraticCurveTo(badgeX + badgeWidth, badgeY, badgeX + badgeWidth, badgeY + 8);
                        ctx.lineTo(badgeX + badgeWidth, badgeY + badgeHeight - 8);
                        ctx.quadraticCurveTo(badgeX + badgeWidth, badgeY + badgeHeight, badgeX + badgeWidth - 8, badgeY + badgeHeight);
                        ctx.lineTo(badgeX + 8, badgeY + badgeHeight);
                        ctx.quadraticCurveTo(badgeX, badgeY + badgeHeight, badgeX, badgeY + badgeHeight - 8);
                        ctx.lineTo(badgeX, badgeY + 8);
                        ctx.quadraticCurveTo(badgeX, badgeY, badgeX + 8, badgeY);
                        ctx.closePath();
                        ctx.fill();
                        ctx.stroke();
                        ctx.fillStyle = '#fff';
                        ctx.fillText(badgeText, badgeX + 9, badgeY + badgeHeight / 2);
                        ctx.restore();
                    }
                }, {
                    // Glow effect for line
                    id: 'glowLine',
                    beforeDraw(chart) {
                        const ctx = chart.ctx;
                        ctx.save();
                        ctx.shadowColor = '#22d47b';
                        ctx.shadowBlur = 16;
                    },
                    afterDraw(chart) {
                        chart.ctx.restore();
                    }
                }]
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
    </script>

    <style>
        /* Font Family */
        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.1);
        }

        /* Chrome, Edge, and Safari */
        *::-webkit-scrollbar {
            width: 8px;
        }

        *::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        *::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        *::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
    </style>
</x-adminlayout>

