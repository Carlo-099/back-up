<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart to do list</title>

    @vite('resources/css/app.css')
    <!-- FullCalendar CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        <!-- Top Navigation Bar -->
        <nav class="bg-white shadow-md">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="/" class="flex items-center">
                                <img src="/images/logo.png" alt="Logo" class="w-8 h-8 mr-2">
                                <span class="text-xl font-bold text-gray-800">Smart to do list</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <span class="text-gray-700">Hi, {{ Auth::user()->name }}</span>
                            <!-- Notification Button -->
                            <button class="relative p-2 text-gray-600 rounded-full hover:bg-gray-100">
                                <i class="fas fa-bell"></i>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button class="btn">Logout</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex">
            <!-- Sidebar -->
            <div class="w-64 min-h-screen bg-white shadow-md">
                <div class="p-4">
                    <!-- User Profile Section -->
                    @auth
                        <div class="flex flex-col items-center mb-6">
                            <div class="w-24 h-24 mb-3 overflow-hidden rounded-full">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0D9488&color=fff"
                                     alt="Profile"
                                     class="object-cover w-full h-full">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</h3>

                        </div>
                    @endauth

                    <h2 class="mb-4 text-lg font-semibold text-gray-800">Menu</h2>
                    <nav class="space-y-2">
                        @auth
                            <a href="{{ route('content') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-calendar-alt"></i> Calendar
                            </a>
                            <a href="{{ route('status') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-chart-line"></i> Status
                            </a>
                            <a href="{{ route('category') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-tags"></i> Category
                            </a>
                            <a href="{{ route('feedback') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-comments"></i> Feedback
                            </a>
                            <a href="{{ route('productivity-insight') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-chart-bar"></i> Productivity Insight
                            </a>

                            <hr class="my-4 border-gray-200">

                            <a href={{ route('setting') }} class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-cog"></i> Settings
                            </a>
                        @else
                            <a href="{{ route('show.login') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-sign-in-alt"></i> Login
                            </a>
                            <a href="{{ route('show.register') }}" class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                <i class="mr-2 fas fa-user-plus"></i> Register
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>

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
    </script>
</body>
</html>
