<x-userlayout>
            <!-- Main Content -->

    <!-- Task Details Modal -->
    <div id="taskDetailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="flex items-start justify-between">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modalTaskTitle"></h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeTaskDetailsModal()">
                            <span class="sr-only">Close</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="mt-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <p class="mt-1 text-sm text-gray-900" id="modalTaskDescription"></p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <p class="mt-1 text-sm text-gray-900" id="modalTaskCategory"></p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Due Date</label>
                            <p class="mt-1 text-sm text-gray-900" id="modalTaskDueDate"></p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <p class="mt-1">
                                <span id="modalTaskStatus" class="px-2 py-1 text-xs font-medium rounded-full"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div id="addTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75 backdrop-blur-sm"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-content">
                <div class="px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-start justify-between">
                        <h3 class="text-xl font-semibold leading-6 modal-title">Add New Task</h3>
                        <button type="button" class="modal-close-btn" onclick="closeAddTaskModal()">
                            <span class="sr-only">Close</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form id="addTaskForm" method="POST" action="{{ route('tasks.store') }}" class="mt-6">
                        @csrf
                        <input type="hidden" name="category_type" id="category_type">
                        <div class="mb-5">
                            <label for="title" class="block text-sm font-medium modal-label">Title</label>
                            <input type="text" name="title" id="title" required
                                class="block w-full mt-1 modal-input"
                                placeholder="Enter task title">
                        </div>
                        <div class="mb-5">
                            <label for="description" class="block text-sm font-medium modal-label">Description</label>
                            <textarea name="description" id="description" rows="3" required
                                class="block w-full mt-1 modal-input"
                                placeholder="Enter task description"></textarea>
                        </div>
                        <div class="mb-5">
                            <label for="status" class="block text-sm font-medium modal-label">Status</label>
                            <select name="status" id="status" required class="block w-full mt-1 modal-input">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="category" class="block text-sm font-medium modal-label">Category</label>
                            <select name="category" id="category" required class="block w-full mt-1 modal-input">
                                <option value="home">Home</option>
                                <option value="school">School</option>
                                <option value="outdoors">Outdoors</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="due_date" class="block text-sm font-medium modal-label">Due Date</label>
                            <input type="date" name="due_date" id="due_date" required
                                class="block w-full mt-1 modal-input">
                        </div>
                        <div class="mt-6 sm:mt-8">
                            <button type="submit" class="modal-submit-btn">
                                Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- FullCalendar JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>

    <!-- FullCalendar CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />

    <style>
        /* Custom Calendar Styling */
        #calendar {
            background: var(--card-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
        }

        /* Calendar Header */
        .fc-header-toolbar {
            margin-bottom: 2rem !important;
        }

        .fc-button {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            border: none !important;
            border-radius: 0.75rem !important;
            padding: 0.5rem 1.25rem !important;
            text-transform: capitalize !important;
            font-weight: 500 !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s ease !important;
        }

        .fc-button:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }

        .fc-button-primary:not(:disabled).fc-button-active,
        .fc-button-primary:not(:disabled):active {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color)) !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1) !important;
        }

        /* Calendar Grid */
        .fc-view {
            border-radius: 1rem !important;
            overflow: hidden !important;
            background: var(--card-bg) !important;
            border: 2px solid var(--primary-color) !important;
            box-shadow: 0 0 20px rgba(var(--primary-color-rgb), 0.1) !important;
        }

        .fc-day-grid {
            border-radius: 1rem !important;
        }

        /* Calendar Grid Lines */
        .fc-row {
            border: none !important;
            position: relative !important;
        }

        .fc-row::after {
            content: '' !important;
            position: absolute !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            height: 1px !important;
            background: linear-gradient(90deg,
                transparent 0%,
                var(--primary-color) 20%,
                var(--primary-color) 80%,
                transparent 100%
            ) !important;
            opacity: 0.3 !important;
        }

        .fc-row:last-child::after {
            display: none !important;
        }

        .fc-day {
            border: none !important;
            position: relative !important;
            padding: 0.5rem !important;
            transition: all 0.3s ease !important;
        }

        .fc-day::after {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            bottom: 0 !important;
            right: 0 !important;
            width: 1px !important;
            background: linear-gradient(180deg,
                transparent 0%,
                var(--primary-color) 20%,
                var(--primary-color) 80%,
                transparent 100%
            ) !important;
            opacity: 0.3 !important;
        }

        .fc-day:last-child::after {
            display: none !important;
        }

        /* Add RGB variable for primary color */
        :root {
            --primary-color-rgb: 159, 179, 223; /* RGB values for #9FB3DF */
        }

        [data-theme="dark"] {
            --primary-color-rgb: 34, 40, 49; /* RGB values for #222831 */
        }

        /* Calendar Cells */
        .fc-day:hover {
            background: var(--hover-bg) !important;
            transform: scale(1.02) !important;
            z-index: 1 !important;
            box-shadow: 0 0 15px rgba(var(--primary-color-rgb), 0.2) !important;
        }

        /* Today's Date */
        .fc-today {
            background: linear-gradient(135deg, var(--hover-bg), var(--card-bg)) !important;
            box-shadow: inset 0 0 0 2px var(--primary-color),
                       0 0 20px rgba(var(--primary-color-rgb), 0.2) !important;
        }

        /* Event Styling */
        .fc-event {
            border-radius: 0.75rem !important;
            border: none !important;
            padding: 0.25rem 0.5rem !important;
            margin: 0.25rem 0 !important;
            box-shadow: 0 2px 4px rgba(var(--primary-color-rgb), 0.15) !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .fc-event::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 2px !important;
            background: linear-gradient(90deg,
                var(--primary-color),
                var(--secondary-color)
            ) !important;
            opacity: 0.5 !important;
        }

        .fc-event:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 8px rgba(var(--primary-color-rgb), 0.25) !important;
        }

        /* Calendar Title */
        .fc-toolbar h2 {
            font-size: 1.5rem !important;
            font-weight: 600 !important;
            color: var(--text-color) !important;
            text-transform: capitalize !important;
        }

        /* Modal Theme Styles */
        .modal-content {
            background: var(--card-bg) !important;
            border: 2px solid var(--primary-color) !important;
            box-shadow: 0 0 30px rgba(var(--primary-color-rgb), 0.2) !important;
        }

        .modal-title {
            color: var(--text-color) !important;
            font-weight: 600 !important;
        }

        .modal-label {
            color: var(--text-color) !important;
            font-weight: 500 !important;
            margin-bottom: 0.5rem !important;
        }

        .modal-input {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-color) !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            width: 100% !important;
            transition: all 0.3s ease !important;
            font-size: 0.95rem !important;
        }

        .modal-input:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(var(--primary-color-rgb), 0.1) !important;
            outline: none !important;
        }

        .modal-input::placeholder {
            color: var(--text-secondary) !important;
            opacity: 0.7 !important;
        }

        .modal-close-btn {
            color: var(--text-secondary) !important;
            padding: 0.5rem !important;
            border-radius: 0.5rem !important;
            transition: all 0.3s ease !important;
        }

        .modal-close-btn:hover {
            color: var(--text-color) !important;
            background: var(--hover-bg) !important;
            transform: rotate(90deg) !important;
        }

        .modal-submit-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            color: white !important;
            border: none !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem 1.5rem !important;
            width: 100% !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(var(--primary-color-rgb), 0.2) !important;
        }

        .modal-submit-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(var(--primary-color-rgb), 0.3) !important;
        }

        .modal-submit-btn:active {
            transform: translateY(0) !important;
            box-shadow: 0 2px 8px rgba(var(--primary-color-rgb), 0.2) !important;
        }

        /* Dark mode specific adjustments */
        [data-theme="dark"] .modal-input {
            background: rgba(255, 255, 255, 0.05) !important;
        }

        [data-theme="dark"] .modal-input::placeholder {
            color: var(--text-secondary) !important;
            opacity: 0.5 !important;
        }

        [data-theme="dark"] .modal-content {
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3) !important;
        }

        /* Light mode specific adjustments */
        [data-theme="light"] .modal-input {
            background: rgba(255, 255, 255, 0.9) !important;
        }

        [data-theme="light"] .modal-input::placeholder {
            color: var(--text-secondary) !important;
            opacity: 0.6 !important;
        }

        [data-theme="light"] .modal-content {
            box-shadow: 0 0 30px rgba(var(--primary-color-rgb), 0.15) !important;
        }

        /* Toast Notification Styles */
        .toast-notification {
            position: fixed;
            top: 1rem;
            right: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            color: white;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateX(120%);
            transition: transform 0.3s ease-in-out;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 300px;
            backdrop-filter: blur(8px);
        }

        .toast-notification.show {
            transform: translateX(0);
        }

        .toast-notification i {
            font-size: 1.25rem;
        }

        .toast-notification.success {
            background: linear-gradient(135deg, #10B981, #059669);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .toast-notification.error {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes slideIn {
            from {
                transform: translateX(120%);
            }
            to {
                transform: translateX(0);
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(120%);
            }
        }
    </style>

    <!-- Add Toast Notification Element -->
    <div id="toastNotification" class="toast-notification" style="display: none;">
        <i class="fas fa-check-circle"></i>
        <span></span>
    </div>

    <!-- Update Task Modal -->
    <div id="updateTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75 backdrop-blur-sm"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-content">
                <div class="px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-start justify-between">
                        <h3 class="text-xl font-semibold leading-6 modal-title">Update Task</h3>
                        <button type="button" class="modal-close-btn" onclick="closeUpdateTaskModal()">
                            <span class="sr-only">Close</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form id="updateTaskForm" method="POST" class="mt-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="update_task_id" name="task_id">
                        <div class="mb-5">
                            <label for="update_title" class="block text-sm font-medium modal-label">Title</label>
                            <input type="text" name="title" id="update_title" required class="block w-full mt-1 modal-input">
                        </div>
                        <div class="mb-5">
                            <label for="update_description" class="block text-sm font-medium modal-label">Description</label>
                            <textarea name="description" id="update_description" rows="3" required class="block w-full mt-1 modal-input"></textarea>
                        </div>
                        <div class="mb-5">
                            <label for="update_status" class="block text-sm font-medium modal-label">Status</label>
                            <select name="status" id="update_status" required class="block w-full mt-1 modal-input">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="complete">Complete</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="update_due_date" class="block text-sm font-medium modal-label">Due Date</label>
                            <input type="date" name="due_date" id="update_due_date" required class="block w-full mt-1 modal-input">
                        </div>
                        <div class="mt-6 sm:mt-8">
                            <button type="submit" class="modal-submit-btn">
                                Update Task
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
                <div class="absolute inset-0 bg-gray-500 opacity-75 backdrop-blur-sm"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-content">
                <div class="px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-2 bg-red-100 rounded-full">
                                <i class="text-xl text-red-600 fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold leading-6 modal-title">Delete Task</h3>
                                <p class="mt-2 text-sm modal-label">Are you sure you want to delete this task? This action cannot be undone.</p>
                            </div>
                        </div>
                        <button type="button" class="modal-close-btn" onclick="closeDeleteTaskModal()">
                            <span class="sr-only">Close</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="mt-6 sm:mt-8">
                        <div class="flex space-x-4">
                            <button type="button" id="confirmDeleteBtn" class="flex-1 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Delete Task
                            </button>
                            <button type="button" onclick="closeDeleteTaskModal()" class="flex-1 px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                defaultView: 'month',
                editable: true,
                selectable: true,
                selectHelper: true,
                events: function(start, end, timezone, callback) {
                    // Fetch tasks from the backend
                    $.ajax({
                        url: '{{ route("tasks.index") }}',
                        type: 'GET',
                        success: function(response) {
                            const events = response.tasks.map(task => ({
                                id: task.task_id,
                                title: task.title,
                                start: task.due_date,
                                description: task.description,
                                category: task.category_type,
                                status: task.status,
                                backgroundColor: getCategoryBackgroundColor(task.category_type),
                                textColor: getCategoryTextColor(task.category_type),
                                borderColor: getCategoryBorderColor(task.category_type)
                            }));
                            callback(events);
                        },
                        error: function(error) {
                            console.error('Error fetching tasks:', error);
                            callback([]);
                        }
                    });
                },
                eventClick: function(event) {
                    showTaskDetails(event);
                },
                eventRender: function(event, element) {
                    // Add custom styling to the event title
                    element.find('.fc-title').css({
                        'background-color': event.backgroundColor,
                        'color': event.textColor,
                        'padding': '2px 6px',
                        'border-radius': '4px',
                        'display': 'inline-block',
                        'width': '100%',
                        'border': `1px solid ${event.borderColor}`
                    });
                },
                dayClick: function(date, jsEvent, view) {
                    // Handle double-click on a day
                    if (jsEvent.detail === 2) {
                        openAddTaskModal(date);
                    }
                }
            });
        });

        function getCategoryBackgroundColor(category) {
            switch(category) {
                case 'home':
                    return '#FFFBDE'; // Home category background
                case 'school':
                    return '#90D1CA'; // School category background
                case 'outdoors':
                    return '#096B68'; // Outdoors category background
                default:
                    return '#FFFFFF';
            }
        }

        function getCategoryTextColor(category) {
            switch(category) {
                case 'home':
                    return '#7C6F2A'; // Home category text
                case 'school':
                    return '#1B3A36'; // School category text
                case 'outdoors':
                    return '#FFFFFF'; // Outdoors category text
                default:
                    return '#000000';
            }
        }

        function getCategoryBorderColor(category) {
            switch(category) {
                case 'home':
                    return '#F5EFC0'; // Home category border
                case 'school':
                    return '#6EC1B6'; // School category border
                case 'outdoors':
                    return '#04403E'; // Outdoors category border
                default:
                    return '#CCCCCC';
            }
        }

        function showTaskDetails(event) {
            document.getElementById('modalTaskTitle').textContent = event.title;
            document.getElementById('modalTaskDescription').textContent = event.description;
            document.getElementById('modalTaskCategory').textContent = event.category;
            document.getElementById('modalTaskDueDate').textContent = moment(event.start).format('MMMM D, YYYY');

            const statusElement = document.getElementById('modalTaskStatus');
            statusElement.textContent = event.status;
            statusElement.className = `px-2 py-1 text-xs font-medium rounded-full ${getStatusClass(event.status)}`;

            // Add category-specific styling to the modal
            const modalContent = document.querySelector('.modal-content');
            modalContent.style.backgroundColor = getCategoryBackgroundColor(event.category);
            modalContent.style.borderColor = getCategoryBorderColor(event.category);
            modalContent.style.color = getCategoryTextColor(event.category);

            document.getElementById('taskDetailsModal').classList.remove('hidden');
        }

        function closeTaskDetailsModal() {
            document.getElementById('taskDetailsModal').classList.add('hidden');
        }

        function openAddTaskModal(date) {
            // Format the date as YYYY-MM-DD for the input field
            const formattedDate = moment(date).format('YYYY-MM-DD');

            // Set the due date in the form
            document.getElementById('due_date').value = formattedDate;

            // Show the modal
            document.getElementById('addTaskModal').classList.remove('hidden');

            // Add form submission handler if not already added
            const form = document.getElementById('addTaskForm');
            if (!form.hasAttribute('data-handler-attached')) {
                form.setAttribute('data-handler-attached', 'true');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get the selected category
                    const category = document.getElementById('category').value;
                    document.getElementById('category_type').value = category;

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
                            // Show success toast notification instead of alert
                            showToast('Task created successfully! 🎉');

                            // Close the modal and reset the form
                            closeAddTaskModal();

                            // Refresh the calendar to show the new task
                            $('#calendar').fullCalendar('refetchEvents');
                        } else {
                            showToast('Error: ' + (data.message || 'Unknown error occurred'), 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Error creating task. Please try again.', 'error');
                    });
                });
            }
        }

        function closeAddTaskModal() {
            document.getElementById('addTaskModal').classList.add('hidden');
            document.getElementById('addTaskForm').reset();
            document.getElementById('category_type').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('addTaskModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddTaskModal();
            }
        });

        // Update the showToast function to handle different types of notifications
        function showToast(message = 'Task created successfully!', type = 'success') {
            let toast = document.getElementById('toastNotification');
            // If toast doesn't exist, create it
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toastNotification';
                toast.className = 'toast-notification';
                toast.innerHTML = '<i class="fas"></i><span></span>';
                document.body.appendChild(toast);
            }

            // Update icon and styling based on type
            const icon = toast.querySelector('i');
            if (type === 'success') {
                icon.className = 'fas fa-check-circle';
                toast.style.background = 'linear-gradient(135deg, #10B981, #059669)'; // Emerald green gradient
            } else {
                icon.className = 'fas fa-exclamation-circle';
                toast.style.background = 'linear-gradient(135deg, #dc2626, #b91c1c)';
            }

            let toastMessage = toast.querySelector('span');
            if (!toastMessage) {
                toastMessage = document.createElement('span');
                toast.appendChild(toastMessage);
            }
            toastMessage.textContent = message;

            // Clear any existing timeout
            if (toast.timeoutId) {
                clearTimeout(toast.timeoutId);
            }

            toast.style.display = 'flex';
            toast.classList.add('show');

            toast.timeoutId = setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.style.display = 'none';
                }, 300);
            }, 3000);
        }

        // Improved update task form submission handler
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
            .then(async response => {
                let data;
                try {
                    data = await response.json();
                } catch (e) {
                    throw new Error('Invalid server response');
                }
                if (!response.ok || !data.success) {
                    throw new Error(data && data.message ? data.message : 'Error updating task. Please try again.');
                }
                showToast('Task updated successfully!');
                $('#calendar').fullCalendar('refetchEvents');
                closeUpdateTaskModal();
            })
            .catch(error => {
                showToast(error.message || 'Error updating task. Please try again.');
            });
        });

        // Improved delete task handler
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            const deleteBtn = this;
            deleteBtn.disabled = true;

            fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                let data;
                try {
                    data = await response.json();
                } catch (e) {
                    throw new Error('Invalid server response');
                }
                if (!response.ok || !data.success) {
                    throw new Error(data && data.message ? data.message : 'Error deleting task. Please try again.');
                }
                showToast('Task deleted successfully!');
                $('#calendar').fullCalendar('refetchEvents');
                closeDeleteTaskModal();
            })
            .catch(error => {
                showToast(error.message || 'Error deleting task. Please try again.');
            })
            .finally(() => {
                deleteBtn.disabled = false;
            });
        });

        // Update the modal close functions to ensure proper cleanup
        function closeUpdateTaskModal() {
            const modal = document.getElementById('updateTaskModal');
            if (modal) {
                modal.classList.add('hidden');
                document.getElementById('updateTaskForm').reset();
            }
        }

        function closeDeleteTaskModal() {
            const modal = document.getElementById('deleteTaskModal');
            if (modal) {
                modal.classList.add('hidden');
                const deleteBtn = document.getElementById('confirmDeleteBtn');
                if (deleteBtn) {
                    deleteBtn.disabled = false;
                }
            }
        }

        // Add styles for the toast notification
        const style = document.createElement('style');
        style.textContent = `
            .toast-notification {
                position: fixed;
                top: 1rem;
                right: 1rem;
                padding: 1rem 1.5rem;
                border-radius: 0.75rem;
                color: white;
                font-weight: 500;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                transform: translateX(120%);
                transition: transform 0.3s ease-in-out;
                z-index: 9999;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                min-width: 300px;
                backdrop-filter: blur(8px);
            }

            .toast-notification.show {
                transform: translateX(0);
            }

            .toast-notification i {
                font-size: 1.25rem;
            }

            .toast-notification.success {
                background: linear-gradient(135deg, #10B981, #059669);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .toast-notification.error {
                background: linear-gradient(135deg, #dc2626, #b91c1c);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
        `;
        document.head.appendChild(style);
    </script>
</x-userlayout>

