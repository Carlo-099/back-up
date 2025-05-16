<x-adminlayout>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root[data-theme="dark"] {
            --bg-gradient-from: #181f2a;
            --bg-gradient-to: #23272f;
            --card-bg: rgba(255,255,255,0.08);
            --card-border: rgba(255,255,255,0.18);
            --text-primary: #F3F4F6;
            --text-secondary: #a0aec0;
            --text-muted: #7b8794;
            --accent: #3b82f6;
            --btn-bg: linear-gradient(to right, #3b82f6, #2563eb);
            --btn-hover-bg: linear-gradient(to right, #2563eb, #1e40af);
            --input-bg: #23272f;
            --input-border: #374151;
            --input-placeholder: #7b8794;
        }
        :root[data-theme="light"] {
            --bg-gradient-from: #eafaf1;
            --bg-gradient-to: #d4f5e9;
            --card-bg: rgba(255,255,255,0.97);
            --card-border: #2ecc71;
            --text-primary: #1a2b36;
            --text-secondary: #3a4a56;
            --text-muted: #6b7a89;
            --accent: #2ecc71;
            --btn-bg: linear-gradient(to right, #2ecc71, #27ae60);
            --btn-hover-bg: linear-gradient(to right, #27ae60, #219150);
            --input-bg: #f7fafc;
            --input-border: #b5e0c7;
            --input-placeholder: #6b7a89;
        }
        body, .min-h-screen {
            background: linear-gradient(to bottom right, var(--bg-gradient-from), var(--bg-gradient-to)) !important;
        }
        .card {
            background: var(--card-bg);
            border: 2px solid var(--card-border);
            border-radius: 1rem;
            box-shadow: 0 4px 24px 0 rgba(46, 204, 113, 0.08);
        }
        .card-header {
            color: var(--text-primary);
            font-weight: 700;
        }
        .card-subtitle {
            color: var(--accent);
            font-weight: 500;
        }
        .form-label {
            color: var(--text-primary);
            font-weight: 600;
        }
        .form-input, textarea {
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            color: var(--text-primary);
            border-radius: 0.5rem;
            font-size: 1rem;
        }
        .form-input::placeholder, textarea::placeholder {
            color: var(--input-placeholder);
        }
        .form-helper {
            color: var(--text-muted);
        }
        .btn-primary {
            background: var(--btn-bg);
            color: #fff;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background: var(--btn-hover-bg);
        }
        .btn-secondary {
            background: var(--card-bg);
            color: var(--text-primary);
            border: 1.5px solid var(--input-border);
            font-weight: 600;
            border-radius: 0.5rem;
        }
        .feedback-card {
            background: var(--card-bg);
            border: 2px solid var(--card-border);
            border-radius: 1rem;
            box-shadow: 0 4px 24px 0 rgba(46, 204, 113, 0.08);
        }
        .feedback-card h3, .feedback-card h4, .feedback-card p, .feedback-card span, .feedback-card label {
            color: var(--text-primary) !important;
        }
        .feedback-card .text-muted {
            color: var(--text-muted) !important;
        }
        .feedback-card .text-secondary {
            color: var(--text-secondary) !important;
        }
        .feedback-card .btn-primary, .feedback-card .btn-secondary {
            font-size: 1rem;
        }
        .feedback-card .admin-response {
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            color: var(--text-secondary);
            border-radius: 0.5rem;
        }
        /* Custom black scrollbar for Feedback Cards Container only */
        .feedback-scroll-container::-webkit-scrollbar {
            width: 10px;
            background: #111;
        }
        .feedback-scroll-container::-webkit-scrollbar-thumb {
            background: #000;
            border-radius: 8px;
        }
        .feedback-scroll-container::-webkit-scrollbar-track {
            background: #222;
        }
        /* Firefox */
        .feedback-scroll-container {
            scrollbar-width: thin;
            scrollbar-color: #000 #222;
        }
    </style>

    <!-- Main Content -->
    <div class="min-h-screen p-6 font-inter">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold card-header">User Feedback</h1>
                    <p class="card-subtitle">View and manage user feedback</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Feedback Cards Container -->
        <div class="flex flex-col items-center gap-4 max-h-[calc(100vh-200px)] overflow-y-auto pr-2 feedback-scroll-container">
            @forelse($feedbacks as $feedback)
                <div class="w-full max-w-3xl p-3 feedback-card">
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
                                     class="object-cover w-10 h-10 rounded-full">
                                <div class="absolute bottom-0 right-0 w-2 h-2 bg-green-500 border-2 border-gray-800 rounded-full"></div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium">{{ $user->name }}</h3>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-sm font-medium rounded-full" style="background: var(--accent); color: #fff; opacity: 0.85;">
                            {{ $feedback->admin_response ? 'Replied' : 'New' }}
                        </span>
                    </div>

                    <!-- Feedback Content -->
                    <div class="mb-3">
                        <h4 class="mb-1 text-xl font-medium">{{ $feedback->title }}</h4>
                        <p class="text-base text-muted line-clamp-2">{{ $feedback->message }}</p>
                    </div>

                    <!-- Action Section -->
                    <div class="flex items-center justify-between pt-3 border-t" style="border-color: var(--card-border)">
                        <div class="flex items-center space-x-3">
                            <span class="text-base text-muted">Posted {{ $feedback->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if(!$feedback->admin_response)
                                <button onclick="toggleReplyForm({{ $feedback->feedback_id }})"
                                        class="px-3 py-1.5 btn-primary">
                                    Reply
                                </button>
                            @else
                                <button onclick="toggleReplyForm({{ $feedback->feedback_id }})"
                                        class="px-3 py-1.5 btn-secondary">
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
                                <label for="admin_response{{ $feedback->feedback_id }}" class="block mb-1 text-base font-medium">Your Response</label>
                                <textarea id="admin_response{{ $feedback->feedback_id }}"
                                          name="admin_response"
                                          rows="3"
                                          class="w-full px-3 py-2 form-input"
                                          placeholder="Type your response here...">{{ $feedback->admin_response }}</textarea>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button"
                                        onclick="toggleReplyForm({{ $feedback->feedback_id }})"
                                        class="px-3 py-1.5 btn-secondary">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-3 py-1.5 btn-primary">
                                    Send Response
                                </button>
                            </div>
                        </form>
                    </div>

                    @if($feedback->admin_response)
                        <div class="p-3 mt-3 admin-response">
                            <p class="text-base font-medium">Admin Response:</p>
                            <p class="mt-1 text-base">{{ $feedback->admin_response }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-3 text-center rounded-lg bg-white/10">
                    <p class="text-xs text-muted">No feedback available</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($feedbacks->hasPages())
            <div class="flex items-center justify-between mt-6">
                <div class="text-sm text-muted">
                    Showing {{ $feedbacks->firstItem() }} to {{ $feedbacks->lastItem() }} of {{ $feedbacks->total() }} results
                </div>
                <div class="flex items-center space-x-2">
                    @if($feedbacks->onFirstPage())
                        <button disabled class="px-3 py-1.5 text-xs font-medium btn-secondary cursor-not-allowed">
                            Previous
                        </button>
                    @else
                        <a href="{{ $feedbacks->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-medium btn-primary">
                            Previous
                        </a>
                    @endif

                    @if($feedbacks->hasMorePages())
                        <a href="{{ $feedbacks->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-medium btn-primary">
                            Next
                        </a>
                    @else
                        <button disabled class="px-3 py-1.5 text-xs font-medium btn-secondary cursor-not-allowed">
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
</x-adminlayout>
