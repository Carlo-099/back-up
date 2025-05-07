<x-adminlayout>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Main Content -->
    <div class="min-h-screen p-6 bg-gradient-to-br from-gray-900 to-gray-800 font-inter">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">User Feedback</h1>
                    <p class="text-gray-400">View and manage user feedback</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-400 bg-green-500/20 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Feedback Cards Container -->
        <div class="grid gap-3 max-h-[calc(100vh-200px)] overflow-y-auto pr-2">
            @forelse($feedbacks as $feedback)
                <div class="p-3 transition-all duration-300 border bg-white/10 backdrop-blur-lg rounded-lg border-white/20 hover:bg-white/20">
                    <!-- User Info Section -->
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
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
                                     class="w-10 h-10 rounded-full object-cover">
                                <div class="absolute bottom-0 right-0 w-2 h-2 bg-green-500 rounded-full border-2 border-gray-800"></div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-white">{{ $user->name }}</h3>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-sm font-medium {{ $feedback->admin_response ? 'text-green-400 bg-green-500/20' : 'text-blue-400 bg-blue-500/20' }} rounded-full">
                            {{ $feedback->admin_response ? 'Replied' : 'New' }}
                        </span>
                    </div>

                    <!-- Feedback Content -->
                    <div class="mb-3">
                        <h4 class="mb-1 text-xl font-medium text-white">{{ $feedback->title }}</h4>
                        <p class="text-base text-gray-400 line-clamp-2">{{ $feedback->message }}</p>
                    </div>

                    <!-- Action Section -->
                    <div class="flex items-center justify-between pt-3 border-t border-white/10">
                        <div class="flex items-center space-x-3">
                            <span class="text-base text-gray-400">Posted {{ $feedback->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if(!$feedback->admin_response)
                                <button onclick="toggleReplyForm({{ $feedback->feedback_id }})"
                                        class="px-3 py-1.5 text-base font-medium text-white transition-colors duration-200 bg-blue-500/20 rounded-lg hover:bg-blue-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Reply
                                </button>
                            @else
                                <button onclick="toggleReplyForm({{ $feedback->feedback_id }})"
                                        class="px-3 py-1.5 text-base font-medium text-blue-400 transition-colors duration-200 bg-blue-500/20 rounded-lg hover:bg-blue-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Edit Reply
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Reply Form (Hidden by default) -->
                    <div id="replyForm{{ $feedback->feedback_id }}" class="hidden mt-3">
                        <form action="{{ route('feedback.reply', $feedback->feedback_id) }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <label for="admin_response{{ $feedback->feedback_id }}" class="block mb-1 text-base font-medium text-gray-400">Your Response</label>
                                <textarea id="admin_response{{ $feedback->feedback_id }}"
                                          name="admin_response"
                                          rows="3"
                                          class="w-full px-3 py-2 text-base bg-white/5 border border-white/10 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                                          placeholder="Type your response here...">{{ $feedback->admin_response }}</textarea>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button"
                                        onclick="toggleReplyForm({{ $feedback->feedback_id }})"
                                        class="px-3 py-1.5 text-base font-medium text-gray-400 bg-white/5 rounded-lg hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-3 py-1.5 text-base font-medium text-white bg-blue-500/20 rounded-lg hover:bg-blue-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Send Response
                                </button>
                            </div>
                        </form>
                    </div>

                    @if($feedback->admin_response)
                        <div class="p-3 mt-3 rounded-lg bg-white/5">
                            <p class="text-base font-medium text-gray-400">Admin Response:</p>
                            <p class="mt-1 text-base text-gray-300 line-clamp-2">{{ $feedback->admin_response }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-3 text-center bg-white/10 rounded-lg">
                    <p class="text-xs text-gray-400">No feedback available</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($feedbacks->hasPages())
            <div class="flex items-center justify-between mt-6">
                <div class="text-sm text-gray-400">
                    Showing {{ $feedbacks->firstItem() }} to {{ $feedbacks->lastItem() }} of {{ $feedbacks->total() }} results
                </div>
                <div class="flex items-center space-x-2">
                    @if($feedbacks->onFirstPage())
                        <button disabled class="px-3 py-1.5 text-xs font-medium text-gray-500 bg-white/5 rounded-lg cursor-not-allowed">
                            Previous
                        </button>
                    @else
                        <a href="{{ $feedbacks->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-white bg-white/5 rounded-lg hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Previous
                        </a>
                    @endif

                    @if($feedbacks->hasMorePages())
                        <a href="{{ $feedbacks->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-white bg-blue-500/20 rounded-lg hover:bg-blue-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Next
                        </a>
                    @else
                        <button disabled class="px-3 py-1.5 text-xs font-medium text-gray-500 bg-blue-500/20 rounded-lg cursor-not-allowed">
                            Next
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- JavaScript for Reply Form Toggle -->
    <script>
        function toggleReplyForm(feedbackId) {
            const form = document.getElementById('replyForm' + feedbackId);
            form.classList.toggle('hidden');
        }
    </script>

    <style>
        /* Font Family */
        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.1);
        }

        /* Chrome, Edge, and Safari */
        *::-webkit-scrollbar {
            width: 8px;
        }

        *::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        *::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        *::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
    </style>
</x-adminlayout>
