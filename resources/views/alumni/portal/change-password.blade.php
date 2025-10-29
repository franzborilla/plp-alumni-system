<x-app-layout :title="'Settings'" :navType="'alumni'">
    <x-slot name="header">
        <h2 class="font-extrabold text-4xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
        <p class="text-sm text-gray-600 mb-6">
            Change your account password
        </p>
    </x-slot>

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

    <x-white-card class="py-6 px-8" x-data="passwordForm()">
        <h2 class="font-bold text-2xl">Change Password</h2>
        <p class="text-sm text-gray-500">Ensure your account is using a long, random password to stay secure.</p>

        <form id="password-form" method="POST" action="{{ route('alumni.update.password') }}">
            @csrf
            @method('PUT')

            <div class="mt-4 space-y-4">
                <div>
                    <x-input-label :value="__('Current Password')" />
                    <x-text-input type="password" name="current_password" placeholder="Enter your current password"
                        class="block w-full" required />
                </div>

                <div>
                    <x-input-label :value="__('New Password')" />
                    <x-text-input type="password" name="new_password" placeholder="Enter your new password"
                        class="block w-full" required />
                </div>

                {{-- ✅ Password Requirements with Examples --}}
                <div class="mt-4 space-y-1">
                    <p class="font-semibold text-gray-700">Password must include:</p>
                    <p>• At least <strong>8 characters</strong></p>
                    <p>• At least <strong>one uppercase letter (A–Z)</strong></p>
                    <p>• At least <strong>one lowercase letter (a–z)</strong></p>
                    <p>• At least <strong>one number (0–9)</strong></p>
                    <p>• At least <strong>one special character</strong> such as <code>! @ # $ % ^ & *</code></p>
                    <p>• Passwords must match</p>
                </div>

                <div>
                    <x-input-label :value="__('Confirm Password')" />
                    <x-text-input type="password" name="new_password_confirmation"
                        placeholder="Re-type your new password" class="block w-full" required />
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="cursor-pointer inline-flex justify-center items-center px-4 py-2 bg-plp-green border border-transparent rounded-md font-semibold text-white tracking-wide hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2 transition ease-in-out duration-150">
                    Change Password
                </button>
            </div>
        </form>

        {{-- Optional success message for Alpine --}}
        <template x-if="successMessage">
            <div x-text="successMessage"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4"></div>
        </template>
    </x-white-card>

    <script>
        // ✅ Clears all password fields when there are validation errors
        document.addEventListener('DOMContentLoaded', () => {
            const hasErrors = document.querySelector('#error-box');
            if (hasErrors) {
                const passwordFields = document.querySelectorAll('input[type="password"]');
                passwordFields.forEach(field => field.value = '');
            }
        });

        // Optional Alpine helper for success fade-out
        function passwordForm() {
            return {
                successMessage: null,
            }
        }
    </script>
</x-app-layout>
