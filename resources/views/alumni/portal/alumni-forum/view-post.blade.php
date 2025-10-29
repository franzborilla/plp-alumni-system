<x-app-layout :title="'View Post'" :navType="'alumni'">
    <a href="{{ route('post') }}" class="flex py-6 items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 24" fill="none"
            stroke="#212121" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8L2 12L6 16" />
            <path d="M2 12H22" />
        </svg>
        <h1>Back to Alumni-Forum</h1>
    </a>

    {{-- ✅ Success Message --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ Validation Errors --}}
    @if ($errors->any())
        <div id="error-box" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>There were some problems with your input:</strong>
            <ul class="list-disc ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-3 gap-3">
        <div class="col-span-2">
            <x-white-card class="p-6">
                <!-- Profile & Category -->
                <div class="grid grid-cols-3 items-center mb-6">
                    <div class="col-span-2 flex items-center gap-4">
                        <img src="{{ $post->user->image_path ? asset('storage/' . $post->user->image_path) : asset('images/default-profile.png') }}"
                            alt="" class="w-20 h-20 rounded-full object-cover">
                        <div>
                            <h2 class="font-bold text-xl">{{ $post->user->full_name }}</h2>
                            <p class="text-sm text-gray-600">
                                {{ $post->user->education->course->course_name ?? 'No Course Info' }}</p>
                            <p class="text-xs text-gray-500">
                                Batch {{ $post->user->education->year_graduated ?? 'N/A' }} </p>
                        </div>
                    </div>
                    <div class="col-span-1 flex justify-end">
                        <span
                            class="bg-green-100 border border-plp-green text-plp-green px-8 py-1 rounded-full text-xs flex items-center">
                            {{ $post->category->name ?? 'General' }}
                        </span>
                    </div>
                </div>

                <!-- Post Title -->
                <h1 class="font-bold text-2xl md:text-3xl">
                    {{ $post->topic_title }}
                </h1>

                <!-- Post Content -->
                <div class="text-md text-gray-700 whitespace-pre-line">
                    {{ $post->content }}
                </div>
            </x-white-card>
        </div>

        <div class="col-span-1">
            <x-white-card class="h-full p-6">
                <h1 class="text-xl font-bold flex gap-2 items-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-messages-square-icon lucide-messages-square">
                        <path
                            d="M16 10a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 14.286V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" />
                        <path
                            d="M20 9a2 2 0 0 1 2 2v10.286a.71.71 0 0 1-1.212.502l-2.202-2.202A2 2 0 0 0 17.172 19H10a2 2 0 0 1-2-2v-1" />
                    </svg>
                    Comment ({{ $post->comments_count }})
                </h1>
                <form action="{{ route('post.comment', $post->forum_id) }}" method="POST">
                    @csrf
                    <textarea name="content" rows="4"
                        class="w-full p-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Share your thoughts or ask a question..."></textarea>

                    <div class="flex justify-end my-2 mb-4">
                        <x-primary-button class="gap-3" type="submit">
                            Post Comment
                        </x-primary-button>
                    </div>
                </form>

                <div class="space-y-4">
                    @foreach ($post->comments as $comment)
                        <div class="flex gap-3">
                            <img src="{{ $post->user->image_path ? asset('storage/' . $post->user->image_path) : asset('images/default-profile.png') }}"
                                alt="" class="w-10 h-10 rounded-full object-cover">
                            <div class="w-full">
                                <div class="bg-gray-100 p-3 rounded shadow">
                                    <p class="text-base font-semibold">{{ $comment->user->full_name }}</p>
                                    <p class="text-sm text-gray-700">{{ $comment->comment }}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->format('m/d/Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-white-card>
        </div>
    </div>
</x-app-layout>
