<x-adminlayout>
            <!-- Main Content -->
            <div class="flex-1 p-8">
                <div class="overflow-hidden bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold mb-6">Announcement</h2>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('announcements.store') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <textarea
                                name="message_anounce"
                                id="message_anounce"
                                rows="6"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('message_anounce') border-red-500 @enderror"
                                placeholder="Type your announcement here..."
                                required
                            >{{ old('message_anounce') }}</textarea>
                            @error('message_anounce')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('user-manage') }}"
                               class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Send Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
</x-adminlayout>
