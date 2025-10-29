<x-onboard-layout :title="'Forgot Password'" :pageTitle="'Forgot your Password?'" :loginMessage="'Enter your registered e-mail address'" :showBackButton="true" :backUrl="url('/')"
    :centered="true">

    <form method="GET" action="{{ route('password.code') }}">
        @csrf

        <div class="mt-7">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                placeholder="Enter your email" required autofocus autocomplete="off" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-7">
            <x-primary-button class="w-full text-sm">
                {{ __('NEXT') }}
            </x-primary-button>

            <p class="text-sm mt-3">Back to <a href="{{ route('alumni.login') }}"
                    class="font-extrabold hover:underline">Login</a> </p>
        </div>
    </form>
</x-onboard-layout>
