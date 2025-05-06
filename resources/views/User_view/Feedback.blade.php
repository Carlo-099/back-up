<x-userlayout>
    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="max-w-4xl mx-auto">
            <!-- Title Bar -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Feedback</h2>
                <p class="mt-2 text-sm text-gray-600">Share your thoughts and suggestions with us</p>
            </div>

            <!-- Content Area -->
            <div class="bg-white rounded-lg shadow-sm">
                <!-- Feedback Form -->
                <div class="p-6">
                    <h3 class="mb-4 text-lg font-semibold text-gray-700">Send Feedback</h3>

                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('feedback.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <!-- Title Input -->
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                                   placeholder="Enter feedback title"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Input -->
                        <div>
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                            <textarea id="message"
                                      name="message"
                                      rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('message') border-red-500 @enderror"
                                      placeholder="Enter your feedback description"
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex space-x-4">
                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="mr-2 fas fa-paper-plane"></i> Send Feedback
                            </button>
                            <button type="reset"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="mr-2 fas fa-redo"></i> Clear Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Previous Feedback Section -->
            @if(isset($previousFeedback) && count($previousFeedback) > 0)
                <div class="mt-8">
                    <h3 class="mb-4 text-lg font-semibold text-gray-700">Your Previous Feedback</h3>
                    <div class="space-y-4">
                        @foreach($previousFeedback as $feedback)
                            <div class="p-4 bg-white rounded-lg shadow-sm">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-medium text-gray-900">{{ $feedback->title }}</h4>
                                    <span class="text-sm text-gray-500">{{ $feedback->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="mt-2 text-gray-600">{{ $feedback->message }}</p>
                                @if($feedback->admin_response)
                                    <div class="p-3 mt-3 rounded-md bg-gray-50">
                                        <p class="text-sm font-medium text-gray-700">Admin Response:</p>
                                        <p class="mt-1 text-sm text-gray-600">{{ $feedback->admin_response }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</x-userlayout>
