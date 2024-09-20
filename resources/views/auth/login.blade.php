<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg ring-1 ring-gray-200">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 shadow-sm hover:shadow-lg transition-shadow duration-300" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 shadow-sm hover:shadow-lg transition-shadow duration-300" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Remember Me and Forgot Password -->
        <div class="flex items-center justify-between mb-14">
            <label for="remember_me" class="inline-flex items-center text-sm">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-gray-900 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button and Register Link -->
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600 flex items-center">
                <span>{{ __('Don\'t have an account?') }}</span>
                <a class="text-indigo-600 hover:text-indigo-900 ml-1 hover:underline" href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            </div>
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-500/50 hover:shadow-lg transition-shadow duration-300">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
