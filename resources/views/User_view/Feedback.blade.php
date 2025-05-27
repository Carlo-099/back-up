@php
use Carbon\Carbon;
@endphp

<x-userlayout>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Theme Variables */
        :root[data-theme="dark"] {
            --bg-gradient-from: #1d386d;
            --bg-gradient-to: #1a1e24;
            --card-bg:s
            --card-hover-bg: rgba(255, 255, 255, 0.15);
            --card-border: rgba(255, 255, 255, 0.2);
            --text-primary: #F3F4F6;
            --text-secondary: #e5e7eb;
            --text-muted: #a0aec0;
            --accent-primary: #3b82f6;
            --accent-secondary: #2563eb;
            --accent-success: #22d47b;
            --accent-warning: #eab308;
            --accent-error: #ef4444;
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(255, 255, 255, 0.2);
            --input-focus-ring: rgba(59, 130, 246, 0.5);
            --btn-primary-bg: #3b82f6;
            --btn-primary-hover: #2563eb;
            --btn-secondary-bg: rgba(59, 130, 246, 0.1);
            --btn-secondary-hover: rgba(59, 130, 246, 0.2);
            --success-bg: rgba(34, 212, 123, 0.1);
            --success-text: #22d47b;
            --error-bg: rgba(239, 68, 68, 0.1);
            --error-text: #ef4444;
        }

        :root[data-theme="light"] {
            --bg-gradient-from: #eafaf1;
            --bg-gradient-to: #d4f5e9;
            --card-bg: rgba(255, 255, 255, 0.95);
            --card-hover-bg: rgba(255, 255, 255, 0.98);
            --card-border: rgba(46, 204, 113, 0.2);
            --text-primary: #1a2b36;
            --text-secondary: #3a4a56;
            --text-muted: #6b7a89;
            --accent-primary: #2ecc71;
            --accent-secondary: #27ae60;
            --accent-success: #27ae60;
            --accent-warning: #f1c40f;
            --accent-error: #e74c3c;
            --input-bg: #ffffff;
            --input-border: rgba(46, 204, 113, 0.2);
            --input-focus-ring: rgba(46, 204, 113, 0.5);
            --btn-primary-bg: #2ecc71;
            --btn-primary-hover: #27ae60;
            --btn-secondary-bg: rgba(46, 204, 113, 0.1);
            --btn-secondary-hover: rgba(46, 204, 113, 0.2);
            --success-bg: rgba(46, 204, 113, 0.1);
            --success-text: #27ae60;
            --error-bg: rgba(231, 76, 60, 0.1);
            --error-text: #e74c3c;
        }

        /* Base Styles */
        .feedback-container {
            background: linear-gradient(to bottom right, var(--bg-gradient-from), var(--bg-gradient-to));
            min-height: 100vh;
            color: var(--text-primary);
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Card Styles */
        .feedback-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        .feedback-card:hover {
            background: var(--card-hover-bg);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Form Styles */
        .form-label {
            color: var(--text-primary);
            font-weight: 500;
        }

        .form-input {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 2px var(--input-focus-ring);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        /* Button Styles */
        .btn-primary {
            background: var(--btn-primary-bg);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--btn-primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--btn-secondary-bg);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: var(--btn-secondary-hover);
            transform: translateY(-1px);
        }

        /* Alert Styles */
        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
            border: 1px solid var(--success-text);
        }

        .alert-error {
            background: var(--error-bg);
            color: var(--error-text);
            border: 1px solid var(--error-text);
        }

        /* Previous Feedback Styles */
        .feedback-item {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            transition: all 0.3s ease;
        }

        .feedback-item:hover {
            background: var(--card-hover-bg);
            transform: translateY(-2px);
        }

        .feedback-date {
            color: var(--text-secondary);
        }

        .feedback-message {
            color: var(--text-primary);
        }

        .admin-response {
            background: var(--btn-secondary-bg);
            border: 1px solid var(--card-border);
        }

        .admin-response-label {
            color: var(--accent-primary);
            font-weight: 500;
        }

        .admin-response-text {
            color: var(--text-primary);
        }
    </style>

    <!-- Main Content -->
    <div class="flex-1 p-8 feedback-container">
        <div class="max-w-4xl mx-auto">
            <!-- Title Bar -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold">Feedback</h2>
                <p class="mt-2 text-sm text-secondary">Share your thoughts and suggestions with us</p>
            </div>

            <!-- Content Area -->
            <div class="rounded-lg shadow-sm feedback-card">
                <!-- Feedback Form -->
                <div class="p-6">
                    <h3 class="mb-4 text-lg font-semibold">Send Feedback</h3>

                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm rounded-lg alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="p-4 mb-4 text-sm rounded-lg alert-error">
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
                            <label for="title" class="block mb-2 text-sm form-label">Title</label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   class="form-input w-full px-4 py-2 rounded-md @error('title') border-error @enderror"
                                   placeholder="Enter feedback title"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Input -->
                        <div>
                            <label for="message" class="block mb-2 text-sm form-label">Description</label>
                            <textarea id="message"
                                      name="message"
                                      rows="4"
                                      class="form-input w-full px-4 py-2 rounded-md @error('message') border-error @enderror"
                                      placeholder="Enter your feedback description"
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex space-x-4">
                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium rounded-md btn-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-primary">
                                <i class="mr-2 fas fa-paper-plane"></i> Send Feedback
                            </button>
                            <button type="reset"
                                    class="px-4 py-2 text-sm font-medium rounded-md btn-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-primary">
                                <i class="mr-2 fas fa-redo"></i> Clear Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Previous Feedback Section -->
            @if(isset($previousFeedback) && count($previousFeedback) > 0)
                <div class="mt-8">
                    <h3 class="mb-4 text-lg font-semibold">Your Previous Feedback</h3>
                    <div class="space-y-4">
                        @foreach($previousFeedback as $feedback)
                            <div class="p-4 rounded-lg shadow-sm feedback-item">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-medium">{{ $feedback->title }}</h4>
                                    <span class="text-sm feedback-date">{{ $feedback->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="mt-2 feedback-message">{{ $feedback->message }}</p>
                                @if($feedback->admin_response)
                                    <div class="p-3 mt-3 rounded-md admin-response">
                                        <p class="text-sm font-medium admin-response-label">Admin Response:</p>
                                        <p class="mt-1 text-sm admin-response-text">{{ $feedback->admin_response }}</p>
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
