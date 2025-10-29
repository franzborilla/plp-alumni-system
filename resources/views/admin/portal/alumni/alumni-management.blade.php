<x-app-layout :title="'Alumni Management'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <circle cx="9" cy="7" r="4" />
            </svg>
            {{ __('Alumni Management') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">
            Manage and view alumni records
        </p>
    </x-slot>


    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif


    <x-filter title="Alumni Filters" :formId="'filterForm'" :resetRoute="route('alumni.management')">
        <form id="filterForm" method="GET" action="{{ route('alumni.management') }}" class="contents">


            <!-- Search -->
            <div class="relative w-full col-span-3 flex items-center">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search alumni by name, email, industry, or employment status..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base" />
            </div>


            <!-- Year Graduated -->
            <x-select-input class="col-span-2" name="year_graduated" :options="[
                '' => 'All Year Graduated',
                '2016' => '2016',
                '2017' => '2017',
                '2018' => '2018',
                '2019' => '2019',
                '2020' => '2020',
                '2021' => '2021',
                '2022' => '2022',
                '2023' => '2023',
                '2024' => '2024',
                '2025' => '2025',
            ]"
                selected="{{ request('year_graduated') }}" />


            <!-- Degree -->
            <x-select-input class="col-span-2" name="degree" :options="[
                '' => 'All Degrees',
                'BSIT' => 'BS Information Technology',
                'BSBA' => 'BS Business Administration',
                'BSACCOUNTANCY' => 'BS Accountancy',
                'BSCS' => 'BS Computer Science',
                'BSN' => 'BS Nursing',
                'BSED' => 'BSEd English',
            ]" selected="{{ request('degree') }}" />
        </form>
    </x-filter>

    <!-- ✅ Alumni Table -->
    <x-white-card class="p-6 mb-4" id="alumniTableContainer">
        <h3 class="text-3xl font-bold mb-2">Alumni Records</h3>
        <p class="text-base text-gray-700 mb-4">
            Showing {{ $alumni->count() }} of {{ $alumni->total() }} alumni
        </p>

        <table class="w-full text-left border-collapse">
            <thead class="text-xs uppercase font-semibold border-b">
                <tr>
                    <th class="p-2">ID</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Industry</th>
                    <th class="p-2">Degree</th>
                    <th class="p-2">Year Graduated</th>
                    <th class="p-2">Employment</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($alumni as $a)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $a->id }}</td>
                        <td class="p-2">{{ $a->first_name ?? '' }} {{ $a->middle_name ?? '' }}
                            {{ $a->last_name ?? '' }} {{ $a->suffix ?? '' }}</td>
                        <td class="p-2">{{ $a->email }}</td>
                        <td class="p-2">{{ $a->firstEmployment->industry->industry_name ?? 'N/A' }}</td>
                        <td class="p-2">{{ $a->education->course->course_name ?? 'N/A' }}</td>
                        <td class="p-2">{{ $a->education->year_graduated ?? 'N/A' }}</td>
                        <td class="p-2">{{ $a->basicDetails->employment_status ?? 'N/A' }}</td>
                        <td class="p-2">
                            <x-action-buttons :viewRoute="route('alumni.view', $a->id)" :deleteRoute="route('alumni.management.destroy', $a->id)" itemName="alumni" />
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">No alumni found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        <!-- Pagination -->
        <div class="mt-4">
            {{ $alumni->links() }}
        </div>
    </x-white-card>


    <!-- Export -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 pb-6 mb-7 shadow-sm">
        <h3 class="font-bold text-2xl mb-1 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 15V3" />
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <path d="m7 10 5 5 5-5" />
            </svg>
            Export
        </h3>
        <p>Export alumni records</p>
        <div class="flex space-x-4 mt-4">
            <x-export-button :href="route('alumni.management.export')">Export CSV</x-export-button>
        </div>
    </div>

    <script>
        const search = document.getElementById('searchInput'),
            form = document.getElementById('filterForm'),
            tableBox = document.getElementById('alumniTableContainer');
        let timer;


        search.addEventListener('input', e => {
            clearTimeout(timer);
            timer = setTimeout(async () => {
                const q = new URLSearchParams(new FormData(form)).toString();
                const res = await fetch(`{{ route('alumni.management') }}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = await res.text();
                const doc = new DOMParser().parseFromString(html, 'text/html');
                tableBox.innerHTML = doc.querySelector('#alumniTableContainer').innerHTML;
            }, 400);
        });

        search.addEventListener('keydown', e => e.key === 'Enter' && e.preventDefault());
    </script>
</x-app-layout>
