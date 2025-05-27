@php
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
@endphp

<x-userlayout>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Theme Variables */
        :root[data-theme="dark"] {
            --bg-gradient-from: #2c426e;
            --bg-gradient-to: #1a1e24;
            --card-bg: rgba(24, 46, 105, 0.1);
            --card-hover-bg: rgba(255, 255, 255, 0.15);
            --card-border: rgba(255, 255, 255, 0.2);
            --text-primary: #F3F4F6;
            --text-secondary: #e5e7eb;
            --text-muted: #a0aec0;
            --accent-blue: #3b82f6;
            --accent-green: #22d47b;
            --accent-yellow: #eab308;
            --accent-red: #ef4444;
            --chart-gradient-start: rgba(59, 130, 246, 0.2);
            --chart-gradient-end: rgba(34, 212, 123, 0.2);
            --scrollbar-track: rgba(255, 255, 255, 0.1);
            --scrollbar-thumb: rgba(255, 255, 255, 0.2);
            --scrollbar-thumb-hover: rgba(255, 255, 255, 0.3);
        }

        :root[data-theme="light"] {
            --bg-gradient-from: #eafaf1;
            --bg-gradient-to: #d4f5e9;
            --card-bg: rgba(255, 255, 255, 0.95);
            --card-hover-bg: rgba(255, 255, 255, 0.98);
            --card-border: rgba(46, 204, 113, 0.2);
            --text-primary: #1a2b36;
            --text-secondary: #3a4a56;
            --text-muted: #090b0e;
            --accent-blue: #2ecc71;
            --accent-green: #27ae60;
            --accent-yellow: #f1c40f;
            --accent-red: #e74c3c;
            --chart-gradient-start: rgba(46, 204, 113, 0.2);
            --chart-gradient-end: rgba(39, 174, 96, 0.2);
            --scrollbar-track: rgba(46, 204, 113, 0.1);
            --scrollbar-thumb: rgba(46, 204, 113, 0.2);
            --scrollbar-thumb-hover: rgba(46, 204, 113, 0.3);
        }

        /* Base Styles */
        .w-full.min-h-screen {
            background: linear-gradient(to bottom right, var(--bg-gradient-from), var(--bg-gradient-to));
            color: var(--text-primary);
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Card Styles */
        .dashboard-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            background: var(--card-hover-bg);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Text Styles */
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary);
        }

        .text-gray-400 {
            color: var(--text-secondary) !important;
        }

        /* Chart Styles */
        .chart-container {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 0.75rem;
            padding: 1.25rem;
        }

        /* Table Styles */
        .dashboard-table th {
            color: var(--text-secondary);
            border-bottom: 1px solid var(--card-border);
        }

        .dashboard-table td {
            color: var(--text-primary);
            border-bottom: 1px solid var(--card-border);
        }

        /* Status Badge Styles */
        [data-theme="dark"] .status-badge {
            background: rgba(255, 255, 255, 0.1);
        }

        [data-theme="light"] .status-badge {
            background: rgba(46, 204, 113, 0.1);
        }

        .status-badge.complete {
            background: rgba(34, 212, 123, 0.2);
            color: var(--accent-green);
        }

        .status-badge.in-progress {
            background: rgba(234, 179, 8, 0.2);
            color: var(--accent-yellow);
        }

        .status-badge.pending {
            background: rgba(239, 68, 68, 0.2);
            color: var(--accent-red);
        }

        /* Scrollbar Styles */
        .overflow-y-auto {
            scrollbar-width: thin;
            scrollbar-color: var(--scrollbar-thumb) var(--scrollbar-track);
        }

        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: var(--scrollbar-thumb-hover);
        }

        /* Chart Customization */
        [data-theme="dark"] .chart-legend {
            color: var(--text-secondary);
        }

        [data-theme="light"] .chart-legend {
            color: var(--text-secondary);
        }

        /* Task Overview Card Specific */
        .task-overview-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .task-overview-card .stat-value {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Recent Activity Card Specific */
        .activity-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .activity-item {
            border-bottom: 1px solid var(--card-border);
            padding: 0.75rem 0;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        /* Insights Card Specific */
        .insights-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .insight-item {
            background: var(--card-hover-bg);
            border: 1px solid var(--card-border);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        /* Upcoming Tasks Table Specific */
        .upcoming-tasks-table {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 1rem;
            overflow: hidden;
        }

        .upcoming-tasks-table thead {
            background: var(--card-hover-bg);
        }

        .upcoming-tasks-table th {
            color: var(--text-secondary);
            font-weight: 600;
            padding: 1rem;
        }

        .upcoming-tasks-table td {
            color: var(--text-primary);
            padding: 1rem;
        }

        .upcoming-tasks-table tr:hover {
            background: var(--card-hover-bg);
        }
    </style>

    <!-- Main Content -->
    <div class="w-full min-h-screen p-0 m-0 font-inter">
        <div class="px-6 pt-6 mb-6">
            <h1 class="text-3xl font-bold">Productivity Insight</h1>
            <p class="text-secondary">Personal productivity overview and statistics</p>
        </div>
        <div class="grid grid-cols-1 gap-6 px-6 mb-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Task Statistics Card -->
            <div class="task-overview-card dashboard-card">
                <h3 class="mb-4 text-xl font-semibold">Task Overview</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-secondary">Total Tasks</span>
                        <span class="stat-value">{{ $totalTasks }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-secondary">Completed</span>
                        <span class="stat-value text-accent-green">{{ $completedTasks }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-secondary">In Progress</span>
                        <span class="stat-value text-accent-yellow">{{ $inProgressTasks }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-secondary">Pending</span>
                        <span class="stat-value text-accent-red">{{ $pendingTasks }}</span>
                    </div>
                </div>
            </div>

            <!-- Category Distribution Card -->
            <div class="dashboard-card chart-container">
                <h3 class="mb-4 text-xl font-semibold">Category Distribution</h3>
                <canvas id="categoryPieChart" class="w-full h-64"></canvas>
            </div>

            <!-- Recent Activity Card -->
            <div class="activity-card dashboard-card">
                <h3 class="mb-4 text-xl font-semibold">Recent Activity</h3>
                <div class="h-64 pr-2 space-y-4 overflow-y-auto">
                    @foreach($recentTasks as $task)
                    <div class="activity-item">
                        <div class="flex items-center justify-between">
                            <span class="font-medium">{{ $task->title }}</span>
                            <span class="text-sm text-secondary">{{ $task->updated_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-sm text-secondary">
                            <span class="status-badge {{ strtolower($task->status) }}">{{ $task->status }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Task Progress and Insights Row -->
        <div class="grid grid-cols-1 gap-6 px-6 mt-8 md:grid-cols-2">
            <!-- Task Progress Chart -->
            <div class="dashboard-card chart-container">
                <h3 class="mb-4 text-xl font-semibold">Task Progress</h3>
                <canvas id="taskProgressChart" class="w-full h-48"></canvas>
            </div>
            <!-- Insights Card -->
            <div class="insights-card dashboard-card">
                <h3 class="mb-4 text-xl font-semibold">AI Insights</h3>
                <div class="space-y-4 overflow-y-auto">
                    @php
                        $today = \Carbon\Carbon::today();
                        $insights = DB::table('user_insights')
                            ->where('user_id', auth()->id())
                            ->where('date', $today)
                            ->first();

                        if ($insights) {
                            $insights = json_decode($insights->insights, true);
                        }
                    @endphp

                    @if($insights)
                        <!-- Daily Summary -->
                        <div class="insight-item">
                            <h4 class="mb-2 text-sm font-medium">Yesterday's Summary</h4>
                            <p class="text-sm text-secondary">
                                Completed <span class="font-medium text-accent-green">{{ $insights['daily_summary']['completed_yesterday'] }}</span> tasks
                                with an average completion time of
                                <span class="font-medium text-accent-green">{{ $insights['daily_summary']['avg_completion_time'] }}</span> hours.
                            </p>
                        </div>

                        <!-- Productivity Time -->
                        <div class="insight-item">
                            <h4 class="mb-2 text-sm font-medium">Productivity Pattern</h4>
                            <p class="text-sm text-secondary">
                                Your most productive hour is
                                <span class="font-medium text-accent-blue">
                                    {{ \Carbon\Carbon::createFromFormat('H', $insights['daily_summary']['most_productive_hour'])->format('g A') }}
                                </span>
                            </p>
                        </div>

                        <!-- Category Distribution -->
                        <div class="insight-item">
                            <h4 class="mb-2 text-sm font-medium">Category Focus</h4>
                            @foreach($insights['category_insights'] as $category)
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-secondary">{{ $category['name'] }}</span>
                                    <span class="text-sm font-medium text-accent-green">{{ $category['percentage'] }}%</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- AI Suggestions -->
                        <div class="insight-item">
                            <h4 class="mb-2 text-sm font-medium">AI Suggestions</h4>
                            <ul class="space-y-2">
                                @foreach($insights['suggestions'] as $suggestion)
                                    <li class="text-sm text-secondary">
                                        <span class="text-accent-yellow">•</span> {{ $suggestion }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="flex items-center justify-center h-full">
                            <p class="text-secondary">Today's insights will be available at 7 AM</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upcoming Tasks -->
        <div class="p-6 mt-8">
            <h3 class="mb-4 text-xl font-semibold">Upcoming Tasks</h3>
            <div class="overflow-x-auto">
                <table class="w-full upcoming-tasks-table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Category</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingTasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td class="text-secondary">{{ $task->category->category_type }}</td>
                            <td class="text-secondary">{{ $task->due_date->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($task->status) }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js for visualizations -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Helper to get current theme label color
        function getChartLabelColor() {
            const theme = document.documentElement.getAttribute('data-theme');
            return theme === 'light' ? '#111' : 'white';
        }
        let labelColor = getChartLabelColor();

        // Wait for DOMContentLoaded to ensure canvases exist
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('taskProgressChart')?.getContext('2d');
            const pieCtx = document.getElementById('categoryPieChart')?.getContext('2d');
            if (!ctx || !pieCtx) return;

            // Create gradient for the line fill
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(33, 150, 243, 0.3)');
            gradient.addColorStop(1, 'rgba(33, 150, 243, 0)');

            // Line Chart
            window.taskProgressChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['labels']) !!},
                    datasets: [{
                        label: 'Tasks Completed',
                        data: {!! json_encode($chartData['data']) !!},
                        borderColor: '#2196f3',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#2196f3',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: labelColor,
                                font: { family: 'Inter', size: 14 }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: { display: false },
                            ticks: {
                                color: labelColor,
                                font: { family: 'Inter', size: 14 }
                            }
                        },
                        y: {
                            display: true,
                            ticks: {
                                color: labelColor,
                                font: { family: 'Inter', size: 14 }
                            }
                        }
                    },
                    elements: {
                        line: {
                            borderJoinStyle: 'round',
                            capBezierPoints: true
                        }
                    }
                },
                plugins: [{
                    // Glow effect
                    beforeDraw: chart => {
                        const ctx = chart.ctx;
                        ctx.save();
                        ctx.shadowColor = '#2196f3';
                        ctx.shadowBlur = 16;
                        ctx.globalCompositeOperation = 'destination-over';
                        ctx.restore();
                    }
                }]
            });

            // Pie Chart
            window.categoryPieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($categoryLabels) !!},
                    datasets: [{
                        data: {!! json_encode($categoryData) !!},
                        backgroundColor: [
                            '#60a5fa', // blue-400
                            '#fbbf24', // yellow-400
                            '#34d399', // green-400
                            '#f87171', // red-400
                            '#a78bfa', // purple-400
                            '#f472b6', // pink-400
                            '#38bdf8', // sky-400
                        ],
                        borderColor: 'rgba(255,255,255,0.2)',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: labelColor,
                                font: { family: 'Inter', size: 14 }
                            }
                        }
                    }
                }
            });

            // Function to update chart label/legend colors on theme change
            function updateChartColorsForTheme() {
                labelColor = getChartLabelColor();
                // Update line chart
                if (window.taskProgressChart) {
                    if (window.taskProgressChart.options.scales?.x?.ticks) window.taskProgressChart.options.scales.x.ticks.color = labelColor;
                    if (window.taskProgressChart.options.scales?.y?.ticks) window.taskProgressChart.options.scales.y.ticks.color = labelColor;
                    if (window.taskProgressChart.options.plugins?.legend?.labels) window.taskProgressChart.options.plugins.legend.labels.color = labelColor;
                    window.taskProgressChart.update();
                }
                // Update pie chart
                if (window.categoryPieChart) {
                    if (window.categoryPieChart.options.plugins?.legend?.labels) window.categoryPieChart.options.plugins.legend.labels.color = labelColor;
                    window.categoryPieChart.update();
                }
            }
            // Listen for theme changes
            const observer = new MutationObserver(updateChartColorsForTheme);
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
            // Call once on load
            updateChartColorsForTheme();
        });
    </script>
</x-userlayout>
