<x-app-layout :title="'Add Post'" navType="'alumni'">
    <a href="{{ route('post') }}" class="flex py-6">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 24" fill="none"
            stroke="#212121" stroke-width="2.0" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-move-left-icon lucide-move-left mr-3">
            <path d="M6 8L2 12L6 16" />
            <path d="M2 12H22" />
        </svg>
        <h1>Back to Alumni Forum</h1>
    </a>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <x-white-card class="p-6">
        <h1 class="mb-4 font-bold">Write Your Post!</h1>
        <form action="{{ route('post.forum') }}" method="POST">
            @csrf
            <div>
                <x-input-label>Topic Title:</x-input-label>
                <x-text-input name="topic_title" class="mb-4"
                    placeholder="Enter the title of your topic..."></x-text-input>

                <x-input-label>Category:</x-input-label>
                <x-select-input class="mb-4" name="category_id" :options="\App\Models\ForumCategory::orderBy('category_name')
                    ->pluck('category_name', 'category_id')
                    ->prepend('-- Select Topic Category --', '')
                    ->toArray()" :selected="old('category_id')" />

                <x-input-label>Content:</x-input-label>
                <textarea name="content"
                    class="w-full h-52 p-2 border border-gray-300 rounded-md text-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 mb-4"
                    placeholder="Share your thoughts or ask question..."></textarea>

            </div>

            <div class="flex justify-end">
                <x-primary-button type="submit" class="gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                        height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save-icon lucide-save">
                        <path
                            d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                        <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                        <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                    </svg>Post
                </x-primary-button>
            </div>
        </form>
    </x-white-card>

    <div class="grid grid-cols-4 gap-4 mt-5">
        <x-white-card class="col-span-2">
            <h1 class="p-5 font-bold">Posting Guidelines</h1>
            <ul class="list-disc px-9 pb-4 text-base">
                <li>Be respectful and professional in your communication</li>
                <li>Choose the most appropriate category for your post</li>
                <li>Use clear, descriptive titles that summarize your post</li>
                <li>Search existing posts before creating duplicates</li>
                <li>Keep content relevant to the alumni community</li>
            </ul>
        </x-white-card>
        <x-white-card class="col-span-2">
            <h1 class="p-5 font-bold">Category Guide</h1>
            <ul class="list-disc px-9 pb-4 text-base">
                <li>Career - jobs, career tips, professional growth</li>
                <li>Events - meetups, networking, socials</li>
                <li>Entrepreneurship - startups, business ideas</li>
                <li>Mentorship - guidance and mentoring</li>
                <li>Support - community help and resources</li>
                <li>Networking - collaboration and connections</li>
                <li>Academic - education, research, achievements</li>
            </ul>
        </x-white-card>
    </div>
</x-app-layout>
