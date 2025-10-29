<x-app-layout :title="'Profile'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-extrabold text-4xl text-gray-800 leading-tight">Settings</h2>
        <p class="text-sm text-gray-600 mb-6">Manage profile, account settings, records and audit logs.</p>
    </x-slot>

    <x-settings-tab />

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <x-white-card class="p-6" x-data="{ preview: '{{ $user->image_path ? asset('storage/' . $user->image_path) : '' }}' }">

        <h2 class="font-bold text-2xl">Profile</h2>
        <p class="text-sm text-gray-500">Admin Information</p>

        <form method="POST" action="{{ route('settings.update.profile') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex flex-col sm:flex-row items-center gap-6 mt-4">
                <!-- Image Preview -->
                <div class="relative w-32 h-32">
                    <img x-show="preview" :src="preview"
                        class="w-32 h-32 rounded-full object-cover border-4 border-gray-200" alt="Profile Picture">
                    <div x-show="!preview"
                        class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                </div>

                <!-- Styled Choose File -->
                <div>
                    <x-input-label :value="__('Profile Picture')" />
                    <label
                        class="inline-flex items-center mt-2 px-4 py-2 bg-plp-green text-white text-sm font-semibold rounded-lg cursor-pointer hover:bg-green-700 transition">
                        <i class="fa-solid fa-upload mr-2"></i> Choose File
                        <input type="file" name="profile_picture" accept="image/*" class="hidden"
                            @change="preview = URL.createObjectURL($event.target.files[0])" />
                    </label>
                    <p class="text-xs text-gray-500 mt-2">Allowed: JPG, JPEG, PNG • Max: 2MB</p>
                </div>
            </div>

            <div class="grid grid-cols-2 mt-6 gap-4">
                <div>
                    <x-input-label :value="__('Last Name')" />
                    <x-text-input name="last_name" :value="$user->last_name" />
                </div>
                <div>
                    <x-input-label :value="__('First Name')" />
                    <x-text-input name="first_name" :value="$user->first_name" />
                </div>
                <div>
                    <x-input-label :value="__('Middle Name')" />
                    <x-text-input name="middle_name" :value="$user->middle_name" />
                </div>
                <div>
                    <x-input-label :value="__('Suffix')" />
                    <x-select-input class="col-span-2" name="suffix" :options="[
                        '' => '-- Select Suffix --',
                        'jr' => 'Jr.',
                        'sr' => 'Sr.',
                        'ii' => 'II',
                        'iii' => 'III',
                        'iv' => 'IV',
                        'v' => 'V',
                    ]" :selected="$user->suffix" />
                </div>
                <div>
                    <x-input-label :value="__('Email')" />
                    <x-text-input name="email" :value="$user->email" />
                </div>
                <div>
                    <x-input-label :value="__('Username')" />
                    <x-text-input name="username" :value="$user->username" />
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <x-primary-button class="px-6" type="submit">Save</x-primary-button>
            </div>
        </form>
    </x-white-card>
</x-app-layout>
