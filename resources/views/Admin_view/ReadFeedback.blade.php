<x-adminlayout>
    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="mx-auto max-w-7xl">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">User Feedback</h1>
                <p class="mt-2 text-sm text-gray-600">View and manage user feedback</p>
            </div>

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Feedback Cards Container -->
            <div class="grid gap-6">
                @forelse($feedbacks as $feedback)
                    <div class="transition-shadow duration-200 bg-white border border-gray-100 shadow-sm rounded-xl hover:shadow-md">
                        <div class="p-6">
                            <!-- User Info Section -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full">
                                        @php
                                            $user = $feedback->user;
                                            $reference = $user->reference;
                                            $settings = $reference ? $reference->settings : null;

                                            $profilePicture = "https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&background=0D9488&color=fff";

                                            if ($settings && $settings->profile_picture) {
                                                if (strpos($settings->profile_picture, 'uploads/profile_pictures/') === 0) {
                                                    $profilePicture = asset($settings->profile_picture);
                                                } else {
                                                    $profilePicture = asset('uploads/profile_pictures/' . $settings->profile_picture);
                                                }
                                            }
                                        @endphp
                                        <img src="{{ $profilePicture }}"
                                             alt="{{ $user->name }}"
                                             class="object-cover w-full h-full rounded-full">
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-sm font-medium {{ $feedback->admin_response ? 'text-green-600 bg-green-50' : 'text-indigo-600 bg-indigo-50' }} rounded-full">
                                    {{ $feedback->admin_response ? 'Replied' : 'New' }}
                                </span>
                            </div>

                            <!-- Feedback Content -->
                            <div class="mb-4">
                                <h4 class="mb-2 text-lg font-medium text-gray-900">{{ $feedback->title }}</h4>
                                <p class="leading-relaxed text-gray-700">{{ $feedback->message }}</p>
                            </div>

                            <!-- Action Section -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm text-gray-500">Posted {{ $feedback->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @if(!$feedback->admin_response)
                                        <button onclick="toggleReplyForm({{ $feedback->feedback_id }})"
                                                class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Reply
                                        </button>
                                    @else
                                        <button onclick="toggleReplyForm({{ $feedback->feedback_id }})"
                                                class="px-4 py-2 text-sm font-medium text-indigo-600 transition-colors duration-200 rounded-lg bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Edit Reply
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Reply Form (Hidden by default) -->
                            <div id="replyForm{{ $feedback->feedback_id }}" class="hidden mt-4">
                                <form action="{{ route('feedback.reply', $feedback->feedback_id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="admin_response{{ $feedback->feedback_id }}" class="block mb-2 text-sm font-medium text-gray-700">Your Response</label>
                                        <textarea id="admin_response{{ $feedback->feedback_id }}"
                                                  name="admin_response"
                                                  rows="3"
                                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                  placeholder="Type your response here...">{{ $feedback->admin_response }}</textarea>
                                    </div>
                                    <div class="flex justify-end space-x-3">
                                        <button type="button"
                                                onclick="toggleReplyForm({{ $feedback->feedback_id }})"
                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Send Response
                                        </button>
                                    </div>
                                </form>
                            </div>

                            @if($feedback->admin_response)
                                <div class="p-3 mt-4 rounded-md bg-gray-50">
                                    <p class="text-sm font-medium text-gray-700">Admin Response:</p>
                                    <p class="mt-1 text-sm text-gray-600">{{ $feedback->admin_response }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center bg-white rounded-lg shadow-sm">
                        <p class="text-gray-500">No feedback available</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($feedbacks->hasPages())
                <div class="flex items-center justify-between mt-8">
                    <div class="text-sm text-gray-500">
                        Showing {{ $feedbacks->firstItem() }} to {{ $feedbacks->lastItem() }} of {{ $feedbacks->total() }} results
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($feedbacks->onFirstPage())
                            <button disabled class="px-3 py-1 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-md cursor-not-allowed">
                                Previous
                            </button>
                        @else
                            <a href="{{ $feedbacks->previousPageUrl() }}" class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Previous
                            </a>
                        @endif

                        @if($feedbacks->hasMorePages())
                            <a href="{{ $feedbacks->nextPageUrl() }}" class="px-3 py-1 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Next
                            </a>
                        @else
                            <button disabled class="px-3 py-1 text-sm font-medium text-gray-400 bg-indigo-600 border border-transparent rounded-md cursor-not-allowed">
                                Next
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript for Reply Form Toggle -->
    <script>
        function toggleReplyForm(feedbackId) {
            const form = document.getElementById('replyForm' + feedbackId);
            form.classList.toggle('hidden');
        }
    </script>
</x-adminlayout>
