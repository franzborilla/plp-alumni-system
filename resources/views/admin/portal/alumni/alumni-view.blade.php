<x-app-layout :title="'Alumni View'" :navType="'admin'">
    <x-slot name="header">
        <div class="flex flex-row gap-4">
            <a href="{{ route('alumni.management') }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-10 h-10 mt-2 text-gray-700 hover:text-plp-green transition" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <img src="{{ $alumni->image_path ? asset('storage/' . $alumni->image_path) : asset('images/sample-dp.jpg') }}"
                alt="{{ $alumni->first_name }}"
                class="w-14 h-14 rounded-full object-cover border border-gray-300 shadow-sm">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">
                    {{ $alumni->first_name }} {{ $alumni->middle_name ?? '' }} {{ $alumni->last_name }}
                    {{ $alumni->suffix ?? '' }}
                </h2>
                <p class="text-gray-600 text-sm">Alumni Profile Details</p>
            </div>
        </div>
    </x-slot>


    <!-- PERSONAL & ACADEMIC -->
    <div class="grid grid-cols-2 gap-5">
        <!-- Personal -->
        <x-white-card class="p-6">
            <h2 class="text-lg font-semibold text-plp-green mb-4">Personal Information</h2>


            <div class="grid grid-cols-2 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Last Name</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->last_name }}</p>
                </div>
                <div>
                    <p class="text-gray-500">First Name</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->first_name }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Middle Name</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->middle_name ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Suffix</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->suffix ?? '--' }}</p>
                </div>
            </div>


            <hr class="my-4">


            <div class="grid grid-cols-2 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Age</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->age ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Birthdate</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->birthdate ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Sex</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->sex ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Civil Status</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->civil_status ?? 'N/A' }}</p>
                </div>
            </div>


            <hr class="my-4">


            <div class="grid grid-cols-1 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Mobile Number</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->mobile_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Student Number</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->student_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Email</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->email }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Address</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->address ?? 'N/A' }}</p>
                </div>
            </div>
        </x-white-card>


        <!-- Academic -->
        <x-white-card class="p-6">
            <h2 class="text-lg font-semibold text-plp-green mb-3">Academic Information</h2>
            <div class="text-sm space-y-3">
                <div>
                    <p class="text-gray-500">College Department</p>
                    <p class="font-semibold text-gray-800">
                        {{ $alumni->education->course->department->department_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Degree</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->education->course->course_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Year Graduated</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->education->year_graduated ?? 'N/A' }}</p>
                </div>


                <hr class="my-4">
                <h3 class="font-semibold text-gray-700">Post Graduate Studies</h3>


                <div>
                    <p class="text-gray-500">Masteral</p>
                    <p class="font-semibold text-gray-800">
                        @if ($alumni->educationMasteral)
                            {{ $alumni->educationMasteral->degree_title ?? '' }}
                            @if (!empty($alumni->educationMasteral->school))
                                , {{ $alumni->educationMasteral->school }}
                            @endif
                            @if (!empty($alumni->educationMasteral->inclusive_years))
                                , {{ $alumni->educationMasteral->inclusive_years }}
                            @endif
                        @else
                            --
                        @endif
                    </p>
                </div>


                <div>
                    <p class="text-gray-500">Doctoral</p>
                    <p class="font-semibold text-gray-800">
                        @if ($alumni->educationDoctoral)
                            {{ $alumni->educationDoctoral->degree_title ?? '' }}
                            @if (!empty($alumni->educationDoctoral->school))
                                , {{ $alumni->educationDoctoral->school }}
                            @endif
                            @if (!empty($alumni->educationDoctoral->inclusive_years))
                                , {{ $alumni->educationDoctoral->inclusive_years }}
                            @endif
                        @else
                            --
                        @endif
                    </p>
                </div>
            </div>
        </x-white-card>
    </div>


    <!-- Profile -->
    <x-white-card class="p-6 mt-4">
        <h2 class="text-lg font-semibold text-plp-green mb-3">Profile</h2>


        @if (!empty($alumni->basicDetails->about))
            <div class="text-sm space-y-2">
                <p class="text-gray-500">About</p>
                <p class="font-semibold text-gray-800 leading-relaxed">
                    {{ $alumni->basicDetails->about }}
                </p>
            </div>
        @else
            <div class="flex justify-center items-center h-10">
                <p class="text-gray-500 text-sm italic text-center">
                    No about available.
                </p>
            </div>
        @endif
    </x-white-card>




    <!-- Employment Status -->
    <x-white-card class="p-6 mt-4">
        <h2 class="text-lg font-semibold text-plp-green mb-3">Employment Status</h2>
        <p class="text-gray-500 text-sm">Employment Status</p>
        <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->employment_status ?? 'N/A' }}</p>
    </x-white-card>


    <!-- First Job -->
    <x-white-card class="p-6 mt-4">
        <h2 class="text-lg font-semibold text-plp-green mb-3">First Job Information</h2>


        @if ($alumni->firstEmployment)
            <div class="grid grid-cols-3 text-sm gap-y-3">
                <div>
                    <p class="text-gray-500">Company Name</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->firstEmployment->company_name }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Position Title</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->firstEmployment->position_title }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Industry</p>
                    <p class="font-semibold text-gray-800">
                        {{ $alumni->firstEmployment->industry->industry_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Job Relevance</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->firstEmployment->job_alignment ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Job Type</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->firstEmployment->job_type }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Location</p>
                    <p class="font-semibold text-gray-800">
                        {{ $alumni->firstEmployment->location->location_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Start Date</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->firstEmployment->start_date }}</p>
                </div>
                <div>
                    <p class="text-gray-500">End Date</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->firstEmployment->end_date }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Employment Waiting Period</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->firstEmployment->waiting_period }}</p>
                </div>
            </div>
        @else
            <div class="flex justify-center items-center h-10">
                <p class="text-gray-500 text-sm italic text-center">No first job available.</p>
            </div>
        @endif
    </x-white-card>


    <!-- Current Employment -->
    <x-white-card class="p-6 mt-4">
        <h2 class="text-lg font-semibold text-plp-green mb-3">Current Employment</h2>
        @if ($alumni->employment)
            <div class="grid grid-cols-3 text-sm gap-y-3">
                <div>
                    <p class="text-gray-500">Company Name</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->employment->company_name }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Position Title</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->employment->position_title }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Industry</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->employment->industry->industry_name ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Job Type</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->employment->job_type }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Start Date</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->employment->start_date }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Location</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->employment->location->location_name ?? 'N/A' }}
                    </p>
                </div>
            </div>
        @else
            <div class="flex justify-center items-center h-10">
                <p class="text-gray-500 text-sm italic text-center">No current employment available.</p>
            </div>
        @endif
    </x-white-card>


    <!-- Career History -->
    <x-white-card class="p-6 mt-4">
        <h2 class="text-lg font-semibold text-plp-green mb-3">Career History</h2>
        @if ($alumni->pastEmployment && $alumni->pastEmployment->count())
            @foreach ($alumni->pastEmployment as $index => $past)
                <div class="mb-3 font-semibold">
                    <h3 class="text-gray-700">Past Employment #{{ $index + 1 }}</h3>
                </div>
                <div class="grid grid-cols-3 text-sm gap-y-3 mb-4">
                    <div>
                        <p class="text-gray-500">Company Name</p>
                        <p class="font-semibold text-gray-800">{{ $past->company_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Position Title</p>
                        <p class="font-semibold text-gray-800">{{ $past->position_title ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Industry</p>
                        <p class="font-semibold text-gray-800">{{ $past->industry->industry_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Inclusive Years</p>
                        <p class="font-semibold text-gray-800">{{ $past->inclusive_years ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Job Type</p>
                        <p class="font-semibold text-gray-800">{{ $past->job_type ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Location</p>
                        <p class="font-semibold text-gray-800">{{ $past->location->location_name ?? 'N/A' }}</p>
                    </div>
                </div>
                @if (!$loop->last)
                    <hr class="my-4">
                @endif
            @endforeach
        @else
            <div class="flex justify-center items-center h-10">
                <p class="text-gray-500 text-sm italic text-center">No career history available.</p>
            </div>
        @endif
    </x-white-card>


    <!-- Skills -->
    <x-white-card class="p-6 mt-4 mb-6">
        <h2 class="text-lg font-semibold text-plp-green mb-3">Skills</h2>
        @if ($alumni->skills && $alumni->skills->count())
            <div class="flex flex-wrap gap-2 text-sm">
                @foreach ($alumni->skills as $skill)
                    <x-tag name="{{ $skill->skill_name }}" />
                @endforeach
            </div>
        @else
            <div class="flex justify-center items-center h-10">
                <p class="text-gray-500 text-sm italic text-center">No skills listed.</p>
            </div>
        @endif
    </x-white-card>
</x-app-layout>
