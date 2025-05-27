<x-userlayout>

            <!-- Main Content -->
                    <!-- Title Bar with Category Buttons -->
                    <div class="border-b border-gray-200">
                        <div class="px-6 py-4">
                            <h2 class="text-xl font-semibold" style="color: var(--text-color);">Task Categories</h2>
                        </div>
                        <div class="flex px-6 py-3 space-x-4">
                            <button onclick="filterCategories('home')" class="px-4 py-2 text-sm font-medium rounded-md category-btn active" data-category="home" style="background-color: #FFFBDE; color: #7C6F2A; border: 2px solid #F5EFC0; transition: background 0.2s, color 0.2s;">
                                <i class="mr-2 fas fa-home"></i> Home Activity
                            </button>
                            <button onclick="filterCategories('school')" class="px-4 py-2 text-sm font-medium rounded-md category-btn" data-category="school" style="background-color: #90D1CA; color: #1B3A36; border: 2px solid #6EC1B6; transition: background 0.2s, color 0.2s;">
                                <i class="mr-2 fas fa-graduation-cap"></i> School Activity
                            </button>
                            <button onclick="filterCategories('outdoors')" class="px-4 py-2 text-sm font-medium rounded-md category-btn" data-category="outdoors" style="background-color: #096B68; color: #fff; border: 2px solid #04403E; transition: background 0.2s, color 0.2s;">
                                <i class="mr-2 fas fa-tree"></i> Outdoors Activity
                            </button>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-6" style="width: 100%;">
                        <!-- Home Activities -->
                        <div id="home-tasks" class="mb-8 category-section">
                            <div class="p-6 rounded-lg" style="width: 100%; background-color: #f7f5eb;">
                                <h3 class="mb-4 text-lg font-semibold" style="color: #7C6F2A;">Home Activities</h3>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <!-- Add Task Button -->
                                    <div class="flex items-center justify-center p-4 transition-shadow border rounded-lg shadow-sm cursor-pointer hover:shadow-md" style="background-color: #FFFBDE; color: #7C6F2A; border-color: #F5EFC0;" onclick="openAddTaskModal('home')">
                                        <div class="flex flex-col items-center">
                                            <i class="text-4xl fas fa-plus-circle" style="color: #7C6F2A;"></i>
                                            <span class="mt-2 text-sm">Add New Task</span>
                                        </div>
                                    </div>
                                    @foreach($tasks as $task)
                                        @if($task->category && $task->category->category_type === 'home')
                                            <div class="p-4 transition-shadow border rounded-lg shadow-sm hover:shadow-md" style="background-color: #FFFBDE; color: #3B3B3B; border-color: #F5EFC0;" data-task-id="{{ $task->task_id }}">
                                                <div class="flex items-center justify-between mb-3">
                                                    <h4 class="font-medium">{{ $task->title }}</h4>
                                                    <span class="px-2 py-1 text-xs font-medium" style="background-color: #F5EFC0; color: #7C6F2A; border-radius: 9999px;">{{ $task->status }}</span>
                                                </div>
                                                <p class="mb-3 text-sm">{{ $task->description }}</p>
                                                <div class="flex items-center justify-between text-sm">
                                                    <span>Due: {{ $task->due_date->format('Y-m-d') }}</span>
                                                    <div class="flex space-x-2">
                                                        <button onclick="openUpdateTaskModal('{{ $task->task_id }}', '{{ $task->title }}', '{{ $task->description }}', '{{ $task->status }}', '{{ $task->due_date->format('Y-m-d') }}', '{{ $task->category->category_type }}')" style="color: #3B3B3B;">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button onclick="openDeleteTaskModal('{{ $task->task_id }}', '{{ $task->title }}')" style="color: #B91C1C;">
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

                        <!-- School Activities -->
                        <div id="school-tasks" class="hidden mb-8 category-section">
                            <div class="p-6 rounded-lg" style="width: 100%; background-color: #aae4dfcc;">
                                <h3 class="mb-4 text-lg font-semibold" style="color: #1B3A36;">School Activities</h3>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <!-- Add Task Button -->
                                    <div class="flex items-center justify-center p-4 transition-shadow border rounded-lg shadow-sm cursor-pointer hover:shadow-md" style="background-color: #90D1CA; color: #1B3A36; border-color: #6EC1B6;" onclick="openAddTaskModal('school')">
                                        <div class="flex flex-col items-center">
                                            <i class="text-4xl fas fa-plus-circle" style="color: #1B3A36;"></i>
                                            <span class="mt-2 text-sm">Add New Task</span>
                                        </div>
                                    </div>
                                    @foreach($tasks as $task)
                                        @if($task->category && $task->category->category_type === 'school')
                                            <div class="p-4 transition-shadow border rounded-lg shadow-sm hover:shadow-md" style="background-color: #90D1CA; color: #1B3A36; border-color: #6EC1B6;" data-task-id="{{ $task->task_id }}">
                                                <div class="flex items-center justify-between mb-3">
                                                    <h4 class="font-medium">{{ $task->title }}</h4>
                                                    <span class="px-2 py-1 text-xs font-medium" style="background-color: #6EC1B6; color: #1B3A36; border-radius: 9999px;">{{ $task->status }}</span>
                                                </div>
                                                <p class="mb-3 text-sm">{{ $task->description }}</p>
                                                <div class="flex items-center justify-between text-sm">
                                                    <span>Due: {{ $task->due_date->format('Y-m-d') }}</span>
                                                    <div class="flex space-x-2">
                                                        <button onclick="openUpdateTaskModal('{{ $task->task_id }}', '{{ $task->title }}', '{{ $task->description }}', '{{ $task->status }}', '{{ $task->due_date->format('Y-m-d') }}', '{{ $task->category->category_type }}')" style="color: #1B3A36;">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button onclick="openDeleteTaskModal('{{ $task->task_id }}', '{{ $task->title }}')" style="color: #B91C1C;">
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

                        <!-- Outdoors Activities -->
                        <div id="outdoors-tasks" class="hidden mb-8 category-section">
                            <div class="p-6 rounded-lg" style="width: 100%; background-color: #6bb5b3;">
                                <h3 class="mb-4 text-lg font-semibold" style="color: #fff;">Outdoors Activities</h3>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <!-- Add Task Button -->
                                    <div class="flex items-center justify-center p-4 transition-shadow border rounded-lg shadow-sm cursor-pointer hover:shadow-md" style="background-color: #096B68; color: #fff; border-color: #04403E;" onclick="openAddTaskModal('outdoors')">
                                        <div class="flex flex-col items-center">
                                            <i class="text-4xl fas fa-plus-circle" style="color: #fff;"></i>
                                            <span class="mt-2 text-sm">Add New Task</span>
                                        </div>
                                    </div>
                                    @foreach($tasks as $task)
                                        @if($task->category && $task->category->category_type === 'outdoors')
                                            <div class="p-4 transition-shadow border rounded-lg shadow-sm hover:shadow-md" style="background-color: #096B68; color: #fff; border-color: #04403E;" data-task-id="{{ $task->task_id }}">
                                                <div class="flex items-center justify-between mb-3">
                                                    <h4 class="font-medium">{{ $task->title }}</h4>
                                                    <span class="px-2 py-1 text-xs font-medium" style="background-color: #0B837F; color: #fff; border-radius: 9999px;">{{ $task->status }}</span>
                                                </div>
                                                <p class="mb-3 text-sm">{{ $task->description }}</p>
                                                <div class="flex items-center justify-between text-sm">
                                                    <span>Due: {{ $task->due_date->format('Y-m-d') }}</span>
                                                    <div class="flex space-x-2">
                                                        <button onclick="openUpdateTaskModal('{{ $task->task_id }}', '{{ $task->title }}', '{{ $task->description }}', '{{ $task->status }}', '{{ $task->due_date->format('Y-m-d') }}', '{{ $task->category->category_type }}')" style="color: #fff;">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button onclick="openDeleteTaskModal('{{ $task->task_id }}', '{{ $task->title }}')" style="color: #F87171;">
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
                    </div>







    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Add Task Modal -->
    <div id="addTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-75 dark:bg-opacity-75"></div>
            </div>
            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="relative inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-[#1a1f2e] rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                <!-- X Close Button -->
                <button type="button" onclick="closeAddTaskModal()" aria-label="Close" class="absolute text-2xl text-gray-400 top-4 right-4 hover:text-gray-700 dark:hover:text-white focus:outline-none">
                    &times;
                </button>
                <div class="px-4 pt-5 pb-4 sm:p-6">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left">
                        <h3 class="mb-6 text-xl font-semibold leading-6 text-gray-800 dark:text-white">Add New Task</h3>
                        <form id="addTaskForm" method="POST" action="{{ route('tasks.store') }}">
                            @csrf
                            <input type="hidden" name="category_type" id="category_type">
                            <div class="mb-5">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                <input type="text" name="title" id="title" required
                                    class="w-full px-3 py-2 bg-gray-100 dark:bg-[#2a2f3e] border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                            </div>
                            <div class="mb-5">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" id="description" rows="3" required
                                    class="w-full px-3 py-2 bg-gray-100 dark:bg-[#2a2f3e] border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"></textarea>
                            </div>
                            <div class="mb-5">
                                <label for="status" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status" required
                                    class="w-full px-3 py-2 bg-gray-100 dark:bg-[#2a2f3e] border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="complete">Complete</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="due_date" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Due Date</label>
                                <input type="date" name="due_date" id="due_date" required
                                    class="w-full px-3 py-2 bg-gray-100 dark:bg-[#2a2f3e] border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                            </div>
                            <div class="mt-6">
                                <button id="createTaskBtn" type="submit"
                                    class="w-full px-4 py-2 text-sm font-semibold text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-[#1a1f2e] transition duration-200">
                                    Create Task
                                </button>
                            </div>
                        </form>
                    </div>
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

            // Change Create Task button color based on category
            const btn = document.getElementById('createTaskBtn');
            btn.classList.remove('bg-purple-600', 'hover:bg-purple-700', 'focus:ring-purple-500',
                'bg-red-600', 'hover:bg-red-700', 'focus:ring-red-500',
                'bg-orange-500', 'hover:bg-orange-600', 'focus:ring-orange-500',
                'bg-amber-800', 'hover:bg-amber-900', 'focus:ring-amber-800');
            if (category === 'home') {
                btn.classList.add('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-500');
            } else if (category === 'school') {
                btn.classList.add('bg-orange-500', 'hover:bg-orange-600', 'focus:ring-orange-500');
            } else if (category === 'outdoors') {
                btn.classList.add('bg-amber-800', 'hover:bg-amber-900', 'focus:ring-amber-800');
            } else {
                btn.classList.add('bg-purple-600', 'hover:bg-purple-700', 'focus:ring-purple-500');
            }
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
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('Task created successfully!');

                    // Add the new task to the UI
                    const task = data.task;
                    const taskBox = createTaskBox(task);
                    const categorySection = document.getElementById(`${task.category_type}-tasks`);
                    if (categorySection) {
                        const taskGrid = categorySection.querySelector('.grid');
                        if (taskGrid) {
                            // Insert the new task box after the "Add Task" button
                            const addTaskButton = taskGrid.querySelector('.cursor-pointer');
                            if (addTaskButton) {
                                taskGrid.insertBefore(taskBox, addTaskButton.nextSibling);
                            } else {
                                taskGrid.appendChild(taskBox);
                            }
                        }
                    }

                    // Close the modal and reset the form
                    closeAddTaskModal();

                    // Optionally refresh the page to ensure everything is in sync
                    window.location.reload();
                } else {
                    alert('Error creating task: ' + (data.message || 'Unknown error occurred'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating task. Please try again.');
            });
        });

        function createTaskBox(task) {
            let bgClass = '';
            if (task.category_type === 'home') {
                bgClass = 'bg-red-50 border-red-300 text-red-700';
            } else if (task.category_type === 'school') {
                bgClass = 'bg-orange-50 border-orange-300 text-orange-700';
            } else if (task.category_type === 'outdoors') {
                bgClass = 'bg-amber-50 border-amber-300 text-amber-800';
            }
            const div = document.createElement('div');
            div.className = `p-4 transition-shadow border rounded-lg shadow-sm hover:shadow-md ${bgClass}`;
            div.setAttribute('data-task-id', task.id);
            div.innerHTML = `
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-medium">${task.title}</h4>
                    <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-white rounded-full">${task.status}</span>
                </div>
                <p class="mb-3 text-sm">${task.description}</p>
                <div class="flex items-center justify-between text-sm">
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

            // Update button styles - remove active class from all buttons
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to the clicked button
            const activeBtn = event.currentTarget;
            activeBtn.classList.add('active');

            // Apply specific styling based on category
            if (category === 'home') {
                activeBtn.classList.add('bg-red-100');
            } else if (category === 'school') {
                activeBtn.classList.add('bg-orange-100');
            } else if (category === 'outdoors') {
                activeBtn.classList.add('bg-amber-100');
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
                    const statusClass = data.task.status === 'pending' ? 'text-gray-700 bg-gray-100' :
                                      data.task.status === 'in_progress' ? 'text-orange-700 bg-orange-100' :
                                      'text-amber-800 bg-amber-100';

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
