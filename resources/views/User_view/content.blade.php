<x-userlayout>
            <!-- Main Content -->
            <div class="flex-1 p-8">
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

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
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="flex items-start justify-between">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Add New Task</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeAddTaskModal()">
                            <span class="sr-only">Close</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
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
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category" id="category" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <option value="home">Home</option>
                                <option value="school">School</option>
                                <option value="outdoors">Outdoors</option>
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

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- FullCalendar JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>

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
                                className: getStatusClass(task.status),
                                textColor: getStatusTextColor(task.status),
                                backgroundColor: getStatusBackgroundColor(task.status)
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
                        'width': '100%'
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

        function getStatusClass(status) {
            switch(status) {
                case 'pending':
                    return 'bg-purple-100 text-purple-700';
                case 'in_progress':
                    return 'bg-blue-100 text-blue-700';
                case 'complete':
                    return 'bg-green-100 text-green-700';
                default:
                    return '';
            }
        }

        function getStatusTextColor(status) {
            switch(status) {
                case 'pending':
                    return '#6B46C1'; // Purple text
                case 'in_progress':
                    return '#2563EB'; // Blue text
                case 'complete':
                    return '#059669'; // Green text
                default:
                    return '#000000';
            }
        }

        function getStatusBackgroundColor(status) {
            switch(status) {
                case 'pending':
                    return '#F3E8FF'; // Light purple background
                case 'in_progress':
                    return '#DBEAFE'; // Light blue background
                case 'complete':
                    return '#D1FAE5'; // Light green background
                default:
                    return '#FFFFFF';
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

            // Set the category_type field to match the selected category
            const category = document.getElementById('category').value;
            document.getElementById('category_type').value = category;

            // Show the modal
            document.getElementById('addTaskModal').classList.remove('hidden');
        }

        function closeAddTaskModal() {
            document.getElementById('addTaskModal').classList.add('hidden');
            document.getElementById('addTaskForm').reset();

            // Reset the category_type field
            document.getElementById('category_type').value = '';
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

            // Set the category_type based on the selected category
            const category = document.getElementById('category').value;
            formData.set('category_type', category);

            // Log the form data for debugging
            console.log('Form data:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

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
                    // Refresh the calendar to show the new task
                    $('#calendar').fullCalendar('refetchEvents');
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

        // Update category_type when category changes
        document.getElementById('category').addEventListener('change', function() {
            document.getElementById('category_type').value = this.value;
        });
    </script>
</x-userlayout>

