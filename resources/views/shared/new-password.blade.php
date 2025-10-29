<x-onboard-layout :title="'Forgot Password'" :pageTitle="'Set New Password'" :loginMessage="'Enter your new password'" :showBackButton="true" :backUrl="url('/')"
    :centered="true">

    <div x-data="{ showModal: false, message: '', success: false }">
        <form
            @submit.prevent="
                if ($refs.newPassword.value === $refs.confirmPassword.value) {
                    message = '✅ Your password has been changed successfully.';
                    success = true;
                } else {
                    message = '❌ Passwords do not match. Please try again.';
                    success = false;
                }
                showModal = true;
            ">
            <!-- New Password -->
            <div class="mt-7">
                <x-input-label for="new-password" :value="__('New Password')" />
                <x-text-input x-ref="newPassword" id="new-password" class="block mt-1 w-full" type="password"
                    placeholder="Enter your new password" required autocomplete="off" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-7">
                <x-input-label for="confirm-password" :value="__('Confirm Password')" />
                <x-text-input x-ref="confirmPassword" id="confirm-password" class="block mt-1 w-full" type="password"
                    placeholder="Re-enter your new password" required autocomplete="off" />
            </div>

            <!-- Submit -->
            <div class="flex flex-col items-center justify-end mt-7">
                <x-primary-button class="w-full text-sm"> {{ __('Change Password') }}
                </x-primary-button>

                <p class="text-sm mt-3">
                    Back to
                    <a href="{{ route('alumni.login') }}" class="font-extrabold hover:underline">Login</a>
                </p>
            </div>
        </form>

        <!-- Modal -->
        <div x-show="showModal" x-transition
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 w-80 text-center shadow-lg">
                <p x-text="message" :class="success ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold'">
                </p>

                <button
                    @click="
                        showModal = false;
                        if(success) window.location.href='{{ route('alumni.login') }}';
                    "
                    class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    OK
                </button>
            </div>
        </div>
    </div>
</x-onboard-layout>
