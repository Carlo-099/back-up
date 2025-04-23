<x-userlayout>

            <!-- Main Content -->

                    <!-- Title Bar with Status Buttons -->
                    <div class="border-b border-gray-200">
                        <div class="px-6 py-4">
                            <h2 class="text-xl font-semibold text-gray-800">Task Status</h2>
                        </div>
                        <div class="flex px-6 py-3 space-x-4">
                            <button onclick="filterTasks('pending')" class="px-4 py-2 text-sm font-medium text-yellow-700 border border-yellow-300 rounded-md bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 status-btn active" data-status="pending">
                                <i class="mr-2 fas fa-clock"></i> Pending
                            </button>
                            <button onclick="filterTasks('in-progress')" class="px-4 py-2 text-sm font-medium text-blue-700 border border-blue-300 rounded-md bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 status-btn" data-status="in-progress">
                                <i class="mr-2 fas fa-spinner fa-spin"></i> In Progress
                            </button>
                            <button onclick="filterTasks('completed')" class="px-4 py-2 text-sm font-medium text-green-700 border border-green-300 rounded-md bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 status-btn" data-status="completed">
                                <i class="mr-2 fas fa-check-circle"></i> Complete
                            </button>
                        </div>
                    </div>

                    <!-- Content Area -->

                        <!-- Pending Tasks -->
                        <div id="pending-tasks" class="mb-8 task-section">
                            <h3 class="mb-4 text-lg font-semibold text-red-700">In Progress Tasks</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                @forelse($tasks as $task)
                                    @if($task->status == 'pending')
                                        <div class="p-4 transition-shadow border border-purple-200 rounded-lg shadow-sm bg-purple-50 hover:shadow-md">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-medium text-purple-800">{{ $task->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-full">{{ $task->category->name ?? 'Uncategorized' }}</span>
                                            </div>
                                            <p class="mb-3 text-sm text-purple-700">{{ $task->description }}</p>
                                            <div class="flex items-center justify-between text-sm text-purple-600">
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

                        <!-- In Progress Tasks -->
                        <div id="in-progress-tasks" class="hidden mb-8 task-section">
                            <h3 class="mb-4 text-lg font-semibold text-blue-700">In Progress Tasks</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                @forelse($tasks as $task)
                                    @if($task->status == 'in_progress')
                                        <div class="p-4 transition-shadow border border-indigo-200 rounded-lg shadow-sm bg-indigo-50 hover:shadow-md">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-medium text-indigo-800">{{ $task->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-full">{{ $task->category->name ?? 'Uncategorized' }}</span>
                                            </div>
                                            <p class="mb-3 text-sm text-indigo-700">{{ $task->description }}</p>
                                            <div class="flex items-center justify-between text-sm text-indigo-600">
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

                        <!-- Completed Tasks -->
                        <div id="completed-tasks" class="hidden mb-8 task-section">
                            <h3 class="mb-4 text-lg font-semibold text-green-700">Completed Tasks</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                @forelse($tasks as $task)
                                    @if($task->status == 'complete')
                                        <div class="p-4 transition-shadow border rounded-lg shadow-sm bg-emerald-50 border-emerald-200 hover:shadow-md">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-medium text-emerald-800">{{ $task->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full text-emerald-700 bg-emerald-100">{{ $task->category->name ?? 'Uncategorized' }}</span>
                                            </div>
                                            <p class="mb-3 text-sm text-emerald-700">{{ $task->description }}</p>
                                            <div class="flex items-center justify-between text-sm text-emerald-600">
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
                activeBtn.classList.add('bg-yellow-100');
            } else if (status === 'in-progress') {
                activeBtn.classList.add('bg-blue-100');
            } else if (status === 'completed') {
                activeBtn.classList.add('bg-green-100');
            }
        }
    </script>

</x-userlayout>
