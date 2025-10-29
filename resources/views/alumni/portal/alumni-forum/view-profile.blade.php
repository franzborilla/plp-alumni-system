<x-app-layout :title="'View Profile'" :navType="'alumni'">
    <a href="{{ route('find.alumni') }}" class="flex py-6 items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 24" fill="none"
            stroke="#212121" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8L2 12L6 16" />
            <path d="M2 12H22" />
        </svg>
        <h1>Back to Alumni-Forum</h1>
    </a>

    {{-- Profile Header --}}
    <x-white-card class="flex flex-row items-center py-10 px-10 gap-8">
        <img src="{{ $alumni->image_path ? asset('storage/' . $alumni->image_path) : asset('images/default-profile.png') }}"
            alt="{{ $alumni->first_name }}" class="w-24 h-24 rounded-full">
        <div class="flex flex-col gap-2">
            <h2 class="font-bold text-3xl">{{ $alumni->first_name }} {{ $alumni->last_name }}</h2>
            <p class="text-base text-gray-600">
                {{ $alumni->education->course->course_name ?? 'No Course Info' }}
            </p>
            <p class="text-sm text-gray-500">
                Batch {{ $alumni->education->year_graduated ?? 'N/A' }}
            </p>
        </div>
    </x-white-card>

    <div class="grid grid-cols-[300px_1fr] gap-3 mt-4">
        {{-- Left Sidebar: Contact --}}
        <x-white-card class="w-72 h-96 p-6">
            <h1 class="mb-4 font-bold">Contact</h1>

            {{-- Email --}}
            @if ($alumni->email)
                <p class="flex gap-3 text-sm mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                        <rect x="2" y="4" width="20" height="16" rx="2" />
                    </svg>
                    {{ $alumni->email }}
                </p>
            @endif

            {{-- Mobile Number --}}
            @if ($alumni->basicDetails && $alumni->basicDetails->mobile_number)
                <p class="flex gap-3 text-sm mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                    </svg>
                    {{ $alumni->basicDetails->mobile_number }}
                </p>
            @endif

            {{-- LinkedIn --}}
            @if ($alumni->basicDetails && $alumni->basicDetails->linkedin)
                <p class="flex gap-3 text-sm mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                        <rect width="4" height="12" x="2" y="9" />
                        <circle cx="4" cy="4" r="2" />
                    </svg>
                    <a href="{{ $alumni->basicDetails->linkedin }}" target="_blank">LinkedIn Profile</a>
                </p>
            @endif

            {{-- Personal Website --}}
            @if ($alumni->basicDetails && $alumni->basicDetails->website)
                <p class="flex gap-3 text-sm mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                        <path d="M2 12h20" />
                    </svg>
                    <a href="{{ $alumni->basicDetails->website }}" target="_blank">Personal Website</a>
                </p>
            @endif
        </x-white-card>


        {{-- Right Content --}}
        <div>
            {{-- About --}}
            @if ($alumni->basicDetails && $alumni->basicDetails->about)
                <x-white-card class="mb-4 p-6">
                    <h1 class="font-bold mb-3">About</h1>
                    <p>{{ $alumni->basicDetails->about }}</p>
                </x-white-card>
            @endif

            {{-- Experience --}}
            <x-white-card class="mb-4 p-6">
                <h1 class="font-bold mb-3">Experience</h1>
                {{-- First Employment --}}
                @if ($alumni->firstEmployment)
                    <div class="mb-4 border-l-4 border-green-600 pl-3">
                        <h3 class="text-plp-green">{{ $alumni->firstEmployment->position_title }}</h3>
                        <p>{{ $alumni->firstEmployment->company_name }}</p>
                        <p>{{ $alumni->firstEmployment->start_date?->format('Y') }} -
                            {{ $alumni->firstEmployment->end_date?->format('Y') ?? 'Present' }}</p>
                    </div>
                @endif
                {{-- Current Employment --}}
                @if ($alumni->currentEmployment)
                    <div class="mb-4 border-l-4 border-green-600 pl-3">
                        <h3 class="text-plp-green">{{ $alumni->currentEmployment->position_title }}</h3>
                        <p>{{ $alumni->currentEmployment->company_name }}</p>
                        <p>{{ $alumni->currentEmployment->start_date?->format('Y') }} - Present</p>
                    </div>
                @endif
                {{-- Past Employments --}}
                @foreach ($alumni->pastEmployments ?? [] as $past)
                    <div class="mb-4 border-l-4 border-green-600 pl-3">
                        <h3 class="text-plp-green">{{ $past->position_title }}</h3>
                        <p>{{ $past->company_name }}</p>
                        <p>{{ $past->inclusive_years }}</p>
                    </div>
                @endforeach
            </x-white-card>

            @if ($alumni->skills->count())
                <x-white-card class="p-6">
                    <h1 class="font-bold mb-3">Skills</h1>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($alumni->skills as $skill)
                            <p
                                class="inline-flex items-center border border-green-300 rounded-full px-2 py-2 bg-green-100 text-sm text-green-800">
                                {{ $skill->name }}
                            </p>
                        @endforeach
                    </div>
                </x-white-card>
            @endif
        </div>
    </div>
</x-app-layout>
