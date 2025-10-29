<x-app-layout :title="'Events'" :navType="'alumni'">
    <!-- Header slot -->
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-calendar-icon lucide-calendar">
                <path d="M8 2v4" />
                <path d="M16 2v4" />
                <rect width="18" height="18" x="3" y="4" rx="2" />
                <path d="M3 10h18" />
            </svg>
            {{ __('Events') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">
            View upcoming events, join activities, and stay connected with the PLP community.
        </p>
    </x-slot>


    {{-- Filters --}}
    <x-filter title="Event Filters" :formId="'filterForm'" :resetRoute="route('alumni.events')">
        <form id="filterForm" method="GET" action="{{ route('alumni.events') }}" class="contents">
            <!-- Search -->
            <div class="relative w-full col-span-4 flex items-center">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off"
                    placeholder="Search event title, date or location..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base">
            </div>


            <!-- Event Type -->
            <div class="col-span-3">
                <x-select-input name="type_filter" :options="[
                    '' => 'All Event Types',
                    'Alumni Homecoming' => 'Alumni Homecoming',
                    'Job Fair' => 'Job Fair',
                    'Career Seminar' => 'Career Seminar',
                    'Reunion' => 'Reunion',
                    'Webinar' => 'Webinar',
                    'Workshop' => 'Workshop',
                    'Awarding Ceremony' => 'Awarding Ceremony',
                    'Outreach Program' => 'Outreach Program',
                    'General Assembly' => 'General Assembly',
                ]" :selected="request('type_filter')" />
            </div>
        </form>
    </x-filter>


    {{-- Event Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-10 mt-6" id="eventCardContainer">
        @forelse ($events as $event)
            <x-white-card
                class="col-span-1 flex flex-col h-full py-6 px-8 shadow-sm hover:shadow-md transition-shadow duration-200">
                <h1 class="text-lg font-bold text-gray-800">{{ $event->event_title }}</h1>
                <h4 class="text-sm font-semibold text-[#7F7F7F] mb-2">
                    {{ ucfirst(optional($event->eventType)->event_type_name ?? 'General Event') }}
                </h4>


                <x-rsvp-tag class="mt-1">{{ ucfirst($event->status ?? 'Upcoming') }}</x-rsvp-tag>


                <div class="flex flex-col text-sm mt-4 gap-3 mb-8">
                    <div class="flex gap-2 items-center">
                        <span class="text-lg">📆</span>
                        <p>{{ $event->formatted_date }}</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <span class="text-lg">🕒</span>
                        <p>{{ $event->formatted_time ?? 'TBA' }}</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <span class="text-lg">📍</span>
                        <p>{{ $event->location ?? 'Location to be announced' }}</p>
                    </div>
                </div>


                <div class="mt-auto text-right">
                    <x-primary-button href="{{ route('alumni.event.view', $event->event_id) }}">
                        View Event
                    </x-primary-button>
                </div>
            </x-white-card>
        @empty
            <div class="col-span-3 text-center text-gray-500 py-10 italic text-sm">
                No events available at the moment.
            </div>
        @endforelse
    </div>


    <!-- ✅ FIXED JS FUNCTIONALITY -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('eventCardContainer'),
                route = `{{ route('alumni.events') }}`;
            let timer;


            // 🔄 Fetch filtered cards dynamically
            const fetchCards = async () => {
                const q = new URLSearchParams(new FormData(f));
                const res = await fetch(`${route}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                box.innerHTML = new DOMParser().parseFromString(await res.text(), 'text/html')
                    .querySelector('#eventCardContainer').innerHTML;
            };


            // 🔍 Live search (with debounce)
            s.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(fetchCards, 400);
            });


            // ⛔ Prevent Enter key from reloading page
            s.addEventListener('keydown', e => e.key === 'Enter' && e.preventDefault());


            // 🟢 Trigger filter on button click
            document.querySelector(`button[form='filterForm']`)?.addEventListener('click', e => {
                e.preventDefault();
                fetchCards();
            });
        });
    </script>
</x-app-layout>
