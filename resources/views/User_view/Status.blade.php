<x-userlayout>

            <!-- Main Content -->

                    <!-- Title Bar with Status Buttons -->
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 dark:bg-gray-800">
                            <h2 class="text-xl font-semibold" style="color: var(--text-color);">Task Status</h2>
                        </div>
                        <div class="flex px-6 py-3 space-x-4">
                            <button onclick="filterTasks('pending')" class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 status-btn active" data-status="pending">
                                <i class="mr-2 fas fa-clock"></i> Pending
                            </button>
                            <button onclick="filterTasks('in-progress')" class="px-4 py-2 text-sm font-medium border rounded-md text-sky-700 border-sky-300 bg-sky-50 hover:bg-sky-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 status-btn" data-status="in-progress">
                                <i class="mr-2 fas fa-spinner fa-spin"></i> In Progress
                            </button>
                            <button onclick="filterTasks('completed')" class="px-4 py-2 text-sm font-medium border rounded-md text-emerald-700 border-emerald-300 bg-emerald-50 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 status-btn" data-status="completed">
                                <i class="mr-2 fas fa-check-circle"></i> Complete
                            </button>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-6" style="width: 100%;">
                        <!-- Pending Tasks -->
                        <div id="pending-tasks" class="mb-8 task-section">
                            <div class="p-6 rounded-lg bg-gray-50" style="width: 100%;">
                                <h3 class="mb-4 text-lg font-semibold text-gray-700">Pending Tasks</h3>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    @forelse($tasks as $task)
                                        @if($task->status == 'pending')
                                            <div class="p-4 transition-shadow bg-gray-500 border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                                <div class="flex items-center justify-between mb-3">
                                                    <h4 class="font-medium text-gray-200">{{ $task->title }}</h4>
                                                    <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full">
                                                        @if($task->category)
                                                            {{ ucfirst($task->category->category_type) }}
                                                        @else
                                                            <span class="text-red-500" title="Task has no category assigned">Missing Category</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <p class="mb-3 text-sm text-gray-300">{{ $task->description }}</p>
                                                <div class="flex items-center justify-between text-sm text-gray-200">
                                                    <span>Due: {{ $task->due_date->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="col-span-3 p-4 text-center text-gray-500">
                                            No pending tasks found.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- In Progress Tasks -->
                        <div id="in-progress-tasks" class="hidden mb-8 task-section">
                            <div class="p-6 rounded-lg bg-sky-50" style="width: 100%;">
                                <h3 class="mb-4 text-lg font-semibold text-sky-700">In Progress Tasks</h3>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    @forelse($tasks as $task)
                                        @if($task->status == 'in_progress')
                                            <div class="p-4 transition-shadow border rounded-lg shadow-sm border-sky-200 bg-sky-500 hover:shadow-md">
                                                <div class="flex items-center justify-between mb-3">
                                                    <h4 class="font-medium text-sky-100">{{ $task->title }}</h4>
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full text-sky-700 bg-sky-100">
                                                        @if($task->category)
                                                            {{ ucfirst($task->category->category_type) }}
                                                        @else
                                                            <span class="text-red-500" title="Task has no category assigned">Missing Category</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <p class="mb-3 text-sm text-sky-300">{{ $task->description }}</p>
                                                <div class="flex items-center justify-between text-sm text-sky-200">
                                                    <span>Due: {{ $task->due_date->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="col-span-3 p-4 text-center text-gray-500">
                                            No in-progress tasks found.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Completed Tasks -->
                        <div id="completed-tasks" class="hidden mb-8 task-section">
                            <div class="p-6 rounded-lg bg-emerald-50" style="width: 100%;">
                                <h3 class="mb-4 text-lg font-semibold text-emerald-700">Completed Tasks</h3>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    @forelse($tasks as $task)
                                        @if($task->status == 'complete')
                                            <div class="p-4 transition-shadow border rounded-lg shadow-sm border-emerald-200 bg-emerald-500 hover:shadow-md">
                                                <div class="flex items-center justify-between mb-3">
                                                    <h4 class="font-medium text-emerald-100">{{ $task->title }}</h4>
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full text-emerald-700 bg-emerald-100">
                                                        @if($task->category)
                                                            {{ ucfirst($task->category->category_type) }}
                                                        @else
                                                            <span class="text-red-500" title="Task has no category assigned">Missing Category</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <p class="mb-3 text-sm text-emerald-300">{{ $task->description }}</p>
                                                <div class="flex items-center justify-between text-sm text-emerald-200">
                                                    <span>Completed: {{ $task->updated_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="col-span-3 p-4 text-center text-gray-500">
                                            No completed tasks found.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>



    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script>
        function filterTasks(status) {
            // Hide all task sections
            document.querySelectorAll('.task-section').forEach(section => {
                section.classList.add('hidden');
            });

            // Show selected task section
            document.getElementById(`${status}-tasks`).classList.remove('hidden');

            // Update button styles - remove active class from all buttons
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to the clicked button
            const activeBtn = event.currentTarget;
            activeBtn.classList.add('active');

            // Apply specific styling based on status
            if (status === 'pending') {
                activeBtn.classList.add('bg-gray-100');
            } else if (status === 'in-progress') {
                activeBtn.classList.add('bg-sky-100');
            } else if (status === 'completed') {
                activeBtn.classList.add('bg-emerald-100');
            }
        }
    </script>

</x-userlayout>
