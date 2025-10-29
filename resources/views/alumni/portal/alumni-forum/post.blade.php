<x-app-layout :title="'Alumni Post'" :navType="'alumni'">
    <x-slot name="header">
        <h2 class="font-extrabold text-4xl text-gray-800 leading-tight">
            {{ __('Alumni Forum') }}
        </h2>
        <p class="text-sm text-gray-600 mb-6">
            Join discussions, share ideas, and stay connected with fellow PLP alumni through the forum.
        </p>
    </x-slot>

    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-1">
            <a class="block text-center text-white bg-plp-green h-full shadow rounded p-2" href="{{ route('post') }}">
                Alumni Post
            </a>
        </div>
        <div class="col-span-1">
            <a class="block text-center bg-neutral-300 h-full shadow rounded p-2" href="{{ route('find.alumni') }}">
                Find Alumni
            </a>
        </div>
    </div>

    <div class="mt-4">
        <x-filter title="Post Filters">
            <form id="filterForm" method="GET" action="{{ route('post') }}" class="contents">
                <div class="relative w-full col-span-3 flex items-center">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </div>

                    <input id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off"
                        placeholder="Search post by title or author..."
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base">
                </div>

                <div class="col-span-2">
                    <x-select-input name="category" :options="\App\Models\ForumCategory::orderBy('category_name')
                        ->pluck('category_name', 'category_name')
                        ->prepend('All Categories', '')
                        ->toArray()" :selected="request('category')" />
                </div>

                <div class="col-span-2">
                    <x-select-input class="col-span-2" name="date_range" :options="[
                        '' => 'Select Date Range',
                        'today' => 'Today',
                        'this_week' => 'This Week',
                        'this_month' => 'This Month',
                        'last_month' => 'Last Month',
                        'this_year' => 'This Year',
                    ]" :selected="request('date_range')" />
                </div>
            </form>
        </x-filter>
    </div>

    <div id="postContainer" class="bg-white shadow rounded-lg mt-4 p-6">
        <div class="flex gap-4 items-center">
            <h1 class="font-extrabold text-xl">Alumni Posts</h1>
            <x-primary-button class="text-sm font-light" href="{{ route('add.post') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 me-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-plus-icon lucide-plus">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                Add Post
            </x-primary-button>
        </div>

        <div id="postList">
            @forelse ($forums as $forum)
                <a href="{{ route('view.post', $forum->forum_id) }}" class="block">
                    <div class="bg-gray-100 shadow rounded-lg p-6 my-6 border border-gray-300">
                        <div class="flex items-center gap-4 mb-2">
                            <img src="{{ $forum->user->image_path ? asset('storage/' . $forum->user->image_path) : asset('images/default-profile.png') }}"
                                alt="profile" class="w-16 h-16 rounded-full">
                            <div>
                                <h1 class="font-bold text-lg">
                                    {{ $forum->user->first_name }} {{ $forum->user->last_name }}
                                </h1>
                                <p class="text-sm text-gray-500">
                                    {{ $forum->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="font-bold">{{ $forum->topic_title }}</p>
                            <p class="text-sm text-gray-500 line-clamp-3">
                                {{ Str::limit($forum->content, 150) }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="col-span-1 mt-1">
                                <span
                                    class="bg-green-100 border border-plp-green text-plp-green px-6 py-1 rounded-full text-sm">
                                    {{ $forum->category->category_name ?? 'Uncategorized' }}
                                </span>
                            </div>

                            <div class="col-span-1 flex justify-end items-end gap-2 mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-message-circle-more-icon lucide-message-circle-more">
                                    <path
                                        d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719" />
                                    <path d="M8 12h.01" />
                                    <path d="M12 12h.01" />
                                    <path d="M16 12h.01" />
                                </svg>
                                <p class="text-sm">{{ $forum->comments->count() }} comments</p>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-6 text-gray-500">
                    No alumni posts available yet.
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const form = document.getElementById('filterForm');
            const postList = document.getElementById('postList');
            // Select the Filter button whether it's outside the form (has form="filterForm") or inside the form.
            const filterButton = document.querySelector(`button[form="${form.id}"]`) || form.querySelector(
                'button[type="submit"]');
            let timeout = null;

            // Fetch posts via AJAX and replace #postList
            function fetchResults() {
                const formData = new FormData(form);
                const query = new URLSearchParams(formData).toString();

                fetch(form.action + '?' + query, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const newDoc = parser.parseFromString(html, 'text/html');
                        const newPostsElement = newDoc.getElementById('postList');
                        if (newPostsElement) {
                            postList.innerHTML = newPostsElement.innerHTML;
                        } else {
                            // fallback: replace entire postContainer if postList not found
                            const newContainer = newDoc.getElementById('postContainer');
                            if (newContainer) postList.parentElement.innerHTML = newContainer.innerHTML;
                        }
                    })
                    .catch(err => console.error('Fetch error:', err));
            }

            // 1) Live search typing
            if (searchInput) {
                // prevent Enter inside search from submitting whole page
                searchInput.addEventListener('keydown', e => {
                    if (e.key === 'Enter') e.preventDefault();
                });

                searchInput.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(fetchResults, 300);
                });
            }

            // 2) Filter button — must be clicked to apply category/date filters
            if (filterButton) {
                filterButton.addEventListener('click', function(e) {
                    e.preventDefault(); // prevent a full page form submit
                    fetchResults();
                });
            } else {
                console.warn('Filter button not found for form:', form.id);
            }

            // 3) Stop selects from auto-submitting / auto-filtering on change
            const categorySelect = form.querySelector('select[name="category"]');
            const dateRangeSelect = form.querySelector('select[name="date_range"]');
            if (categorySelect) categorySelect.addEventListener('change', e => e.stopPropagation());
            if (dateRangeSelect) dateRangeSelect.addEventListener('change', e => e.stopPropagation());
        });
    </script>
</x-app-layout>
