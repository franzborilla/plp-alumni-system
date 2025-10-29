<x-onboard-layout :title="'Verification Code'" :pageTitle="'Verification Code'" :loginMessage="'Enter the code sent in your email account'" :showBackButton="true" :backUrl="url('/')"
    :centered="true">

    <form method="GET" action="{{ route('password.store') }}">
        @csrf

        {{-- OTP Boxes --}}
        <div class="flex justify-center gap-4 mt-7">
            <x-otp-input id="otp1" next="otp2" autofocus />
            <x-otp-input id="otp2" next="otp3" />
            <x-otp-input id="otp3" next="otp4" />
            <x-otp-input id="otp4" />
        </div>

        <div class="flex flex-col items-center justify-end mt-7">
            <x-primary-button class="w-full text-sm">
                {{ __('VERIFY') }}
            </x-primary-button>

            <p class="text-sm text-gray-600 mt-4">
                Didn't receive the code? <a href="{{ route('alumni.login') }}"
                    class="font-semibold text-black hover:underline">Click to
                    resend</a>
            </p>
            <p class="text-sm text-gray-600 mt-2">
                Back to <a href="{{ route('alumni.login') }}" class="font-semibold text-black hover:underline">Login</a>
            </p>
        </div>
    </form>

    {{-- Simple JS to auto-focus next input --}}
    <script>
        function moveNext(current, nextId) {
            if (current.value.length === 1) {
                document.getElementById(nextId)?.focus();
            }
        }
    </script>

</x-onboard-layout>
