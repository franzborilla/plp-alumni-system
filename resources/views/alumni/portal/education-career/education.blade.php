    <x-app-layout :active="'education'" :title="'Education'" :navType="'alumni'"> <x-slot name="header">
            <h2 class="font-extrabold text-4xl text-gray-800 leading-tight"> {{ __('Education and Career') }} </h2>
            <p class="text-sm text-gray-600 mb-6"> Your dashboard to update records, find jobs, join events, and stay
                connected with PLP. </p>
        </x-slot>
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-1">
                <a class="block text-white text-center bg-plp-green h-full shadow rounded p-2"
                    href="{{ route('alumni.education') }}">
                    Education Information
                </a>
            </div>
            <div class="col-span-1">
                <a class="block text-center bg-neutral-300 h-full shadow rounded p-2" href="{{ route('alumni.career') }}">
                    Career Information
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 my-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Degree Earned and Graduated Year</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label :value="__('Degree Completed in University')" />
                    <x-text-input readonly disabled name="course_name"
                        value="{{ $education->course->course_name ?? 'N/A' }}" />
                </div>


                <div>
                    <x-input-label :value="__('Year Graduated')" />
                    <x-text-input readonly name="year_graduated" value="{{ $education->year_graduated ?? 'N/A' }}" />
                </div>
            </div>


            <div class="mt-4">
                <x-input-label :value="__('College Department')" />
                <x-text-input readonly disabled name="department_name"
                    value="{{ $education->course->college->department_name ?? 'N/A' }}" />
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 my-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Masteral & Doctoral Degree</h2>
            </div>


            <form method="POST" action="{{ route('alumni.update.education') }}">
                @csrf


                {{-- Masteral Section --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <x-input-label :value="__('Masteral Degree')" />
                        <x-text-input name="masteral_degree" value="{{ $masteral?->degree_title ?? 'N/A' }}" />
                    </div>
                    @error('masteral_degree')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror


                    <div>
                        <x-input-label :value="__('University')" />
                        <x-text-input name="masteral_university" value="{{ $masteral?->school ?? 'N/A' }}" />
                    </div>
                    @error('masteral_university')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror


                    <div>
                        <x-input-label :value="__('Inclusive Years')" />
                        <x-text-input name="masteral_years" value="{{ $masteral?->inclusive_years ?? 'N/A' }}" />
                    </div>
                    @error('masteral_years')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Doctoral Section --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <x-input-label :value="__('Doctoral Degree')" />
                        <x-text-input name="doctoral_degree" value="{{ $doctoral?->degree_title ?? 'N/A' }}" />
                    </div>
                    @error('doctoral_degree')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror


                    <div>
                        <x-input-label :value="__('University')" />
                        <x-text-input name="doctoral_university" value="{{ $doctoral?->school ?? 'N/A' }}" />
                    </div>


                    @error('doctoral_university')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror


                    <div>
                        <x-input-label :value="__('Inclusive Years')" />
                        <x-text-input name="doctoral_years" value="{{ $doctoral?->inclusive_years ?? 'N/A' }}" />
                    </div>
                    @error('doctoral_years')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex justify-end gap-2">
                    <x-primary-button type="submit">Save</x-primary-button>
                </div>
            </form>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const yearInputs = document.querySelectorAll(
                    'input[name="masteral_years"], input[name="doctoral_years"]');


                yearInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        // Allow only digits and dash
                        this.value = this.value.replace(/[^0-9\-]/g, '');
                    });
                });
            });
        </script>
    </x-app-layout>
