<x-app-layout :active="'career'" :title="'Career'" :navType="'alumni'" x-data="{ showUnemployedModal: false }">
    <x-slot name="header">
        <h2 class="font-extrabold text-4xl text-gray-800 leading-tight">
            {{ __('Education and Career') }}
        </h2>
        <p class="text-sm text-gray-600 mb-6">
            Your dashboard to update records, find jobs, join events, and stay connected with PLP.
        </p>
    </x-slot>

    <div class="grid grid-cols-2 gap-4 mb-5">
        <div class="col-span-1">
            <a class="block text-center bg-neutral-300 h-full shadow rounded p-2" href="{{ route('alumni.education') }}">
                Education Information
            </a>
        </div>
        <div class="col-span-1">
            <a class="block text-white text-center bg-plp-green h-full shadow rounded p-2"
                href="{{ route('alumni.career') }}">
                Career Information
            </a>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- EMPLOYMENT STATUS WITH ALPINE --}}
    <div x-data="employmentModal('{{ strtolower($details->employment_status ?? '') }}')" class="bg-white rounded-lg shadow p-6 my-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Current Employment Status</h2>

        <form id="employment-status-form" x-ref="statusForm" @submit.prevent="saveStatus">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div class="col-span-1">
                    <x-input-label :value="__('Employment Status')" />
                    <x-select-input id="employment_status" name="employment_status" class="col-span-2" :options="[
                        '' => '-- Select Employment Status --',
                        'full-time' => 'Full Time',
                        'part-time' => 'Part Time',
                        'freelance' => 'Freelance',
                        'self-employed' => 'Self-Employed',
                        'unemployed' => 'Unemployed',
                    ]"
                        :selected="strtolower($details->employment_status ?? '')" />
                </div>
            </div>
            <div class="col-span-1 flex justify-end gap-2 mt-4">
                <x-primary-button type="submit">Save</x-primary-button>
            </div>
        </form>

        {{-- MODAL --}}
        <div x-show="showUnemployedModal" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                <h2 class="text-lg font-semibold mb-4">Notice</h2>
                <p class="mb-4">
                    Since you are unemployed, the Current Employment section has been cleared and disabled.
                </p>
                <div class="flex justify-end">
                    <button @click="closeModal" class="px-4 py-2 bg-plp-green text-white rounded hover:bg-green-600">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- FIRST, CURRENT, AND PAST EMPLOYMENT --}}
    @include('alumni.portal.education-career.career-partials.first-employment')
    @include('alumni.portal.education-career.career-partials.current-employment')
    @include('alumni.portal.education-career.career-partials.past-employment')
</x-app-layout>
