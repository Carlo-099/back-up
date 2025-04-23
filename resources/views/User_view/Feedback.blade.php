<x-userlayout>
            <!-- Main Content -->
            <div class="flex-1 p-8">
                <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                    <!-- Title Bar -->
                    <div class="border-b border-gray-200">
                        <div class="px-6 py-4">
                            <h2 class="text-xl font-semibold text-gray-800">Feedback</h2>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-6">
                        <!-- Feedback Form -->
                        <div class="mb-8">
                            <h3 class="mb-4 text-lg font-semibold text-gray-700">Send Feedback</h3>
                            <form class="space-y-4">
                                <!-- Title Input -->
                                <div>
                                    <label for="feedback-title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" id="feedback-title" name="title"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter feedback title">
                                </div>

                                <!-- Description Input -->
                                <div>
                                    <label for="feedback-description" class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="feedback-description" name="description" rows="4"
                                              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Enter your feedback description"></textarea>
                                </div>

                                <!-- Buttons -->
                                <div class="flex space-x-4">
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="mr-2 fas fa-paper-plane"></i> Send Feedback
                                    </button>
                                    <button type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="mr-2 fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Previous Feedback Section -->
                        <div>
                            <h3 class="mb-4 text-lg font-semibold text-gray-700">Previous Feedback</h3>
                            <div class="space-y-4">
                                <!-- Feedback Item 1 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-medium text-gray-800">UI Improvements Needed</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-gray-500 bg-gray-100 rounded-full">Sent: May 15, 2024</span>
                                    </div>
                                    <p class="text-sm text-gray-600">The navigation menu could be more intuitive and the color scheme needs adjustment for better contrast.</p>
                                    <div class="flex justify-end mt-3 space-x-2">
                                        <button class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Feedback Item 2 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-medium text-gray-800">Bug Report</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-gray-500 bg-gray-100 rounded-full">Sent: May 10, 2024</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Found an issue with the task completion status not updating correctly when marking tasks as done.</p>
                                    <div class="flex justify-end mt-3 space-x-2">
                                        <button class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Feedback Item 3 -->
                                <div class="p-4 transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-medium text-gray-800">Feature Request</h4>
                                        <span class="px-2 py-1 text-xs font-medium text-gray-500 bg-gray-100 rounded-full">Sent: May 5, 2024</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Would be great to have a dark mode option and the ability to export tasks to PDF.</p>
                                    <div class="flex justify-end mt-3 space-x-2">
                                        <button class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</x-userlayout>
