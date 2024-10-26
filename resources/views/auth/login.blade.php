<div class="absolute top-8 left-0 z-50 w-full text-3xl font-light py-2 text-center mt-4  text-black  font-[Noto] antialiased">
    {{ __('Welcome Back.') }}
</div>

<x-guest-layout>

    <!-- Tombol Close -->
    <div class="absolute top-4 right-4 z-50">
        <button onclick="window.location.href='{{ url('/') }}'" class="transition-all text-gray-600 hover:text-gray-900">
            <!-- Ikon Close -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>


    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}"
        class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg ring-1 ring-gray-200">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Remember Me and Forgot Password -->
        <div class="flex items-center justify-between mb-14">
            <label for="remember_me" class="inline-flex items-center text-sm">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="ms-2 text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-gray-900 hover:underline"
                    href="{{ route('password.request') }}">
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
            <x-primary-button class="ms-4">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
