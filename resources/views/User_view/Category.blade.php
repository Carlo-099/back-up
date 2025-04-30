<x-userlayout>

            <!-- Main Content -->
                    <!-- Title Bar with Category Buttons -->
                    <div class="border-b border-gray-200"  >
                        <div class="px-6 py-4">
                            <h2 class="text-xl font-semibold text-gray-800">Task Categories</h2>
                        </div>
                        <div class="flex px-6 py-3 space-x-4">
                            <button onclick="filterCategories('home')" class="px-4 py-2 text-sm font-medium text-purple-700 border border-purple-300 rounded-md bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 category-btn active" data-category="home">
                                <i class="mr-2 fas fa-home"></i> Home Activity
                            </button>
                            <button onclick="filterCategories('school')" class="px-4 py-2 text-sm font-medium text-indigo-700 border border-indigo-300 rounded-md bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 category-btn" data-category="school">
                                <i class="mr-2 fas fa-graduation-cap"></i> School Activity
                            </button>
                            <button onclick="filterCategories('outdoors')" class="px-4 py-2 text-sm font-medium border rounded-md text-emerald-700 border-emerald-300 bg-emerald-50 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 category-btn" data-category="outdoors">
                                <i class="mr-2 fas fa-tree"></i> Outdoors Activity
                            </button>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-6 bg-purple-50" style=" width: 100%;">
                        <!-- Home Activities -->
                        <div id="home-tasks" class="mb-8 category-section">
                            <h3 class="mb-4 text-lg font-semibold text-purple-700">Home Activities</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <!-- Add Task Button -->
                                <div class="flex items-center justify-center p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md" onclick="openAddTaskModal('home')">
                                    <div class="flex flex-col items-center">
                                        <i class="text-4xl text-purple-600 fas fa-plus-circle"></i>
                                        <span class="mt-2 text-sm text-gray-600">Add New Task</span>
                                    </div>
                                </div>
                                @foreach($tasks as $task)
                                    @if($task->category && $task->category->category_type === 'home')
                                        <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md" data-task-id="{{ $task->task_id }}">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-medium text-gray-800">{{ $task->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium {{ $task->status === 'pending' ? 'text-purple-700 bg-purple-100' : ($task->status === 'in_progress' ? 'text-blue-700 bg-blue-100' : 'text-green-700 bg-green-100') }} rounded-full">{{ $task->status }}</span>
                                            </div>
                                            <p class="mb-3 text-sm text-gray-600">{{ $task->description }}</p>
                                            <div class="flex items-center justify-between text-sm text-gray-500">
                                                <span>Due: {{ $task->due_date->format('Y-m-d') }}</span>
                                                <div class="flex space-x-2">
                                                    <button onclick="openUpdateTaskModal('{{ $task->task_id }}', '{{ $task->title }}', '{{ $task->description }}', '{{ $task->status }}', '{{ $task->due_date->format('Y-m-d') }}', '{{ $task->category->category_type }}')" class="text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button onclick="openDeleteTaskModal('{{ $task->task_id }}', '{{ $task->title }}')" class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- School Activities -->
                        <div id="school-tasks" class="hidden mb-8 category-section">
                            <h3 class="mb-4 text-lg font-semibold text-indigo-700">School Activities</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <!-- Add Task Button -->
                                <div class="flex items-center justify-center p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md" onclick="openAddTaskModal('school')">
                                    <div class="flex flex-col items-center">
                                        <i class="text-4xl text-indigo-600 fas fa-plus-circle"></i>
                                        <span class="mt-2 text-sm text-gray-600">Add New Task</span>
                                    </div>
                                </div>
                                @foreach($tasks as $task)
                                    @if($task->category && $task->category->category_type === 'school')
                                        <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md" data-task-id="{{ $task->task_id }}">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-medium text-gray-800">{{ $task->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium {{ $task->status === 'pending' ? 'text-purple-700 bg-purple-100' : ($task->status === 'in_progress' ? 'text-blue-700 bg-blue-100' : 'text-green-700 bg-green-100') }} rounded-full">{{ $task->status }}</span>
                                            </div>
                                            <p class="mb-3 text-sm text-gray-600">{{ $task->description }}</p>
                                            <div class="flex items-center justify-between text-sm text-gray-500">
                                                <span>Due: {{ $task->due_date->format('Y-m-d') }}</span>
                                                <div class="flex space-x-2">
                                                    <button onclick="openUpdateTaskModal('{{ $task->task_id }}', '{{ $task->title }}', '{{ $task->description }}', '{{ $task->status }}', '{{ $task->due_date->format('Y-m-d') }}', '{{ $task->category->category_type }}')" class="text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button onclick="openDeleteTaskModal('{{ $task->task_id }}', '{{ $task->title }}')" class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Outdoors Activities -->
                        <div id="outdoors-tasks" class="hidden mb-8 category-section">
                            <h3 class="mb-4 text-lg font-semibold text-emerald-700">Outdoors Activities</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <!-- Add Task Button -->
                                <div class="flex items-center justify-center p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md" onclick="openAddTaskModal('outdoors')">
                                    <div class="flex flex-col items-center">
                                        <i class="text-4xl text-emerald-600 fas fa-plus-circle"></i>
                                        <span class="mt-2 text-sm text-gray-600">Add New Task</span>
                                    </div>
                                </div>
                                @foreach($tasks as $task)
                                    @if($task->category && $task->category->category_type === 'outdoors')
                                        <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md" data-task-id="{{ $task->task_id }}">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-medium text-gray-800">{{ $task->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium {{ $task->status === 'pending' ? 'text-purple-700 bg-purple-100' : ($task->status === 'in_progress' ? 'text-blue-700 bg-blue-100' : 'text-green-700 bg-green-100') }} rounded-full">{{ $task->status }}</span>
                                            </div>
                                            <p class="mb-3 text-sm text-gray-600">{{ $task->description }}</p>
                                            <div class="flex items-center justify-between text-sm text-gray-500">
                                                <span>Due: {{ $task->due_date->format('Y-m-d') }}</span>
                                                <div class="flex space-x-2">
                                                    <button onclick="openUpdateTaskModal('{{ $task->task_id }}', '{{ $task->title }}', '{{ $task->description }}', '{{ $task->status }}', '{{ $task->due_date->format('Y-m-d') }}', '{{ $task->category->category_type }}')" class="text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button onclick="openDeleteTaskModal('{{ $task->task_id }}', '{{ $task->title }}')" class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>







    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Add Task Modal -->
    <div id="addTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">Add New Task</h3>
                    <form id="addTaskForm" method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <input type="hidden" name="category_type" id="category_type">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="complete">Complete</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                            <input type="date" name="due_date" id="due_date" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>
                        <div class="mt-5 sm:mt-6">
                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:text-sm">
                                Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Task Modal -->
    <div id="deleteTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <i class="text-xl text-red-600 fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Delete Task</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to delete the task "<span id="deleteTaskTitle" class="font-medium"></span>"? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmDeleteBtn" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" onclick="closeDeleteTaskModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Task Modal -->
    <div id="updateTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">Update Task</h3>
                    <form id="updateTaskForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="update_task_id" name="task_id">
                        <div class="mb-4">
                            <label for="update_title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="update_title" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="update_description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="update_description" rows="3" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="update_status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="update_status" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="complete">Complete</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="update_due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                            <input type="date" name="due_date" id="update_due_date" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>
                        <div class="mt-5 sm:mt-6">
                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:text-sm">
                                Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentCategory = 'home';

        function openAddTaskModal(category) {
            currentCategory = category;
            document.getElementById('category_type').value = category;
            document.getElementById('addTaskModal').classList.remove('hidden');
        }

        function closeAddTaskModal() {
            document.getElementById('addTaskModal').classList.add('hidden');
            document.getElementById('addTaskForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('addTaskModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddTaskModal();
            }
        });

        // Handle form submission
        document.getElementById('addTaskForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Add the new task to the UI
                    const task = data.task;
                    const taskBox = createTaskBox(task);
                    const categorySection = document.getElementById(`${task.category_type}-tasks`);
                    const taskGrid = categorySection.querySelector('.grid');

                    // Insert the new task box after the "Add Task" button
                    const addTaskButton = taskGrid.querySelector('.cursor-pointer');
                    taskGrid.insertBefore(taskBox, addTaskButton.nextSibling);

                    closeAddTaskModal();
                } else {
                    alert('Error creating task: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating task. Please try again.');
            });
        });

        function createTaskBox(task) {
            const div = document.createElement('div');
            div.className = 'p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md';
            div.setAttribute('data-task-id', task.id);

            const statusClass = task.status === 'pending' ? 'text-purple-700 bg-purple-100' :
                              task.status === 'in_progress' ? 'text-blue-700 bg-blue-100' :
                              'text-green-700 bg-green-100';

            div.innerHTML = `
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-medium text-gray-800">${task.title}</h4>
                    <span class="px-2 py-1 text-xs font-medium ${statusClass} rounded-full">${task.status}</span>
                </div>
                <p class="mb-3 text-sm text-gray-600">${task.description}</p>
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Due: ${task.due_date}</span>
                    <div class="flex space-x-2">
                        <button onclick="openUpdateTaskModal('${task.id}', '${task.title}', '${task.description}', '${task.status}', '${task.due_date}', '${task.category_type}')" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="openDeleteTaskModal('${task.id}', '${task.title}')" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            `;

            return div;
        }

        function filterCategories(category) {
            // Hide all category sections
            document.querySelectorAll('.category-section').forEach(section => {
                section.classList.add('hidden');
            });

            // Show selected category section
            document.getElementById(`${category}-tasks`).classList.remove('hidden');

            // Update button styles
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('bg-purple-50', 'border-purple-300', 'bg-indigo-50', 'border-indigo-300', 'bg-emerald-50', 'border-emerald-300');
            });

            // Update content area background color
            const contentArea = document.querySelector('.p-6');
            contentArea.classList.remove('bg-purple-50', 'bg-indigo-50', 'bg-emerald-50');

            // Add appropriate color classes based on category
            const activeBtn = event.currentTarget;
            if (category === 'home') {
                activeBtn.classList.add('bg-purple-50', 'border-purple-300');
                contentArea.classList.add('bg-purple-50');
            } else if (category === 'school') {
                activeBtn.classList.add('bg-indigo-50', 'border-indigo-300');
                contentArea.classList.add('bg-indigo-50');
            } else if (category === 'outdoors') {
                activeBtn.classList.add('bg-emerald-50', 'border-emerald-300');
                contentArea.classList.add('bg-emerald-50');
            }
        }

        function openDeleteTaskModal(taskId, taskTitle) {
            document.getElementById('deleteTaskTitle').textContent = taskTitle;
            document.getElementById('confirmDeleteBtn').setAttribute('data-task-id', taskId);
            document.getElementById('deleteTaskModal').classList.remove('hidden');
        }

        function closeDeleteTaskModal() {
            document.getElementById('deleteTaskModal').classList.add('hidden');
        }

        function openUpdateTaskModal(taskId, title, description, status, dueDate, categoryType) {
            document.getElementById('update_task_id').value = taskId;
            document.getElementById('update_title').value = title;
            document.getElementById('update_description').value = description;
            document.getElementById('update_status').value = status;
            document.getElementById('update_due_date').value = dueDate;

            // Set the form action
            document.getElementById('updateTaskForm').action = `/tasks/${taskId}`;

            document.getElementById('updateTaskModal').classList.remove('hidden');
        }

        function closeUpdateTaskModal() {
            document.getElementById('updateTaskModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.getElementById('deleteTaskModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteTaskModal();
            }
        });

        document.getElementById('updateTaskModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUpdateTaskModal();
            }
        });

        // Handle delete task
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');

            fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Remove the task from the UI
                    const taskElement = document.querySelector(`[data-task-id="${taskId}"]`).closest('.p-4');
                    taskElement.remove();
                    closeDeleteTaskModal();
                } else {
                    alert('Error deleting task: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting task. Please try again.');
            });
        });

        // Handle update task form submission
        document.getElementById('updateTaskForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const taskId = document.getElementById('update_task_id').value;

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update the task in the UI
                    const taskElement = document.querySelector(`[data-task-id="${taskId}"]`).closest('.p-4');
                    const taskTitle = taskElement.querySelector('h4');
                    const taskDescription = taskElement.querySelector('p');
                    const taskStatus = taskElement.querySelector('span');
                    const taskDueDate = taskElement.querySelector('.text-gray-500 span');

                    taskTitle.textContent = data.task.title;
                    taskDescription.textContent = data.task.description;
                    taskStatus.textContent = data.task.status;
                    taskDueDate.textContent = 'Due: ' + data.task.due_date;

                    // Update status class
                    const statusClass = data.task.status === 'pending' ? 'text-purple-700 bg-purple-100' :
                                      data.task.status === 'in_progress' ? 'text-blue-700 bg-blue-100' :
                                      'text-green-700 bg-green-100';

                    taskStatus.className = `px-2 py-1 text-xs font-medium ${statusClass} rounded-full`;

                    closeUpdateTaskModal();
                } else {
                    alert('Error updating task: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating task. Please try again.');
            });
        });
    </script>

</x-userlayout>
