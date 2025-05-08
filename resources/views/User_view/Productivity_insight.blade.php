@php
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
@endphp

<x-userlayout>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Main Content -->
    <div class="w-full min-h-screen p-0 m-0 bg-gradient-to-br from-gray-900 to-gray-800 font-inter">
        <div class="px-6 pt-6 mb-6">
            <h1 class="text-3xl font-bold text-white">Productivity Insight</h1>
            <p class="text-gray-400">Personal productivity overview and statistics</p>
        </div>
        <div class="grid grid-cols-1 gap-6 px-6 mb-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Task Statistics Card -->
            <div class="p-6 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <h3 class="mb-4 text-xl font-semibold text-white">Task Overview</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Total Tasks</span>
                        <span class="font-bold text-white">{{ $totalTasks }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Completed</span>
                        <span class="font-bold text-green-400">{{ $completedTasks }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">In Progress</span>
                        <span class="font-bold text-yellow-400">{{ $inProgressTasks }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Pending</span>
                        <span class="font-bold text-red-400">{{ $pendingTasks }}</span>
                    </div>
                </div>
            </div>

            <!-- Category Distribution Card -->
            <div class="p-6 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <h3 class="mb-4 text-xl font-semibold text-white">Category Distribution</h3>
                <canvas id="categoryPieChart" class="w-full h-64"></canvas>
            </div>

            <!-- Recent Activity Card -->
            <div class="p-6 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <h3 class="mb-4 text-xl font-semibold text-white">Recent Activity</h3>
                <div class="h-64 pr-2 space-y-4 overflow-y-auto" style="scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) rgba(255,255,255,0.1);">
                    @foreach($recentTasks as $task)
                    <div class="pb-2 border-b border-white/10">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-white">{{ $task->title }}</span>
                            <span class="text-sm text-gray-400">{{ $task->updated_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-sm text-gray-400">{{ $task->status }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Task Progress and Insights Row -->
        <div class="grid grid-cols-1 gap-6 px-6 mt-8 md:grid-cols-2">
            <!-- Task Progress Chart -->
            <div class="flex flex-col justify-between p-6 transition-all duration-300 border h-72 bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <h3 class="mb-4 text-xl font-semibold text-white">Task Progress</h3>
                <canvas id="taskProgressChart" class="w-full h-48"></canvas>
            </div>
            <!-- Insights Card -->
            <div class="flex flex-col justify-between p-6 transition-all duration-300 border h-72 bg-white/10 backdrop-blur-lg rounded-xl border-white/20 hover:bg-white/20">
                <h3 class="mb-4 text-xl font-semibold text-white">AI Insights</h3>
                <div class="space-y-4 overflow-y-auto" style="scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) rgba(255,255,255,0.1);">
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
                        <div class="p-3 rounded-lg bg-white/5">
                            <h4 class="mb-2 text-sm font-medium text-white">Yesterday's Summary</h4>
                            <p class="text-sm text-gray-300">
                                Completed <span class="font-medium text-white">{{ $insights['daily_summary']['completed_yesterday'] }}</span> tasks
                                with an average completion time of
                                <span class="font-medium text-white">{{ $insights['daily_summary']['avg_completion_time'] }}</span> hours.
                            </p>
                        </div>

                        <!-- Productivity Time -->
                        <div class="p-3 rounded-lg bg-white/5">
                            <h4 class="mb-2 text-sm font-medium text-white">Productivity Pattern</h4>
                            <p class="text-sm text-gray-300">
                                Your most productive hour is
                                <span class="font-medium text-white">
                                    {{ \Carbon\Carbon::createFromFormat('H', $insights['daily_summary']['most_productive_hour'])->format('g A') }}
                                </span>
                            </p>
                        </div>

                        <!-- Category Distribution -->
                        <div class="p-3 rounded-lg bg-white/5">
                            <h4 class="mb-2 text-sm font-medium text-white">Category Focus</h4>
                            @foreach($insights['category_insights'] as $category)
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-300">{{ $category['name'] }}</span>
                                    <span class="text-sm font-medium text-white">{{ $category['percentage'] }}%</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- AI Suggestions -->
                        <div class="p-3 rounded-lg bg-white/5">
                            <h4 class="mb-2 text-sm font-medium text-white">AI Suggestions</h4>
                            <ul class="space-y-2">
                                @foreach($insights['suggestions'] as $suggestion)
                                    <li class="text-sm text-gray-300">
                                        <span class="text-yellow-400">•</span> {{ $suggestion }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="flex items-center justify-center h-full">
                            <p class="text-gray-400">Today's insights will be available at 7 AM</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upcoming Tasks -->
        <div class="p-6 mt-8">
            <h3 class="mb-4 text-xl font-semibold text-white">Upcoming Tasks</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-white/10">
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">Task</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">Category</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">Due Date</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-white/5 divide-white/10">
                        @foreach($upcomingTasks as $task)
                        <tr>
                            <td class="px-6 py-4 text-white whitespace-nowrap">{{ $task->title }}</td>
                            <td class="px-6 py-4 text-gray-300 whitespace-nowrap">{{ $task->category->category_type }}</td>
                            <td class="px-6 py-4 text-gray-300 whitespace-nowrap">{{ $task->due_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($task->status === 'complete') bg-green-500/20 text-green-400
                                    @elseif($task->status === 'in_progress') bg-yellow-500/20 text-yellow-400
                                    @else bg-red-500/20 text-red-400 @endif">
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
        const ctx = document.getElementById('taskProgressChart').getContext('2d');
        // Create gradient for the line fill
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(33, 150, 243, 0.3)');
        gradient.addColorStop(1, 'rgba(33, 150, 243, 0)');

        const chart = new Chart(ctx, {
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
                    legend: { display: false }
                },
                scales: {
                    x: {
                        display: true,
                        grid: { display: false },
                        ticks: {
                            color: 'white',
                            font: { family: 'Inter', size: 14 }
                        }
                    },
                    y: { display: false }
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

        // Category Distribution Pie Chart
        const pieCtx = document.getElementById('categoryPieChart').getContext('2d');
        new Chart(pieCtx, {
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
                            color: 'white',
                            font: { family: 'Inter' }
                        }
                    }
                }
            }
        });
    </script>
</x-userlayout>
