<div class="absolute mb-10 top-0 left-0 z-50 w-full text-3xl font-light py-2 text-center mt-4  text-black  font-[Noto] antialiased">
    {{ __('Join Medium.') }}
</div>

<x-guest-layout>

    <!-- Tombol Close -->
    <div class="absolute top-4 right-4 z-50">
        <button onclick="window.location.href='{{ url('/') }}'" class="close transition-all text-gray-600 hover:text-gray-900">
            <!-- Ikon Close -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <form method="POST" action="{{ route('register') }}" 
    class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg ring-1 ring-gray-200">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name"
                class="block mt-1 w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 shadow-sm hover:shadow-lg transition-shadow duration-300"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Username --}}
        <div class="mt-3">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username"
                class="block mt-1 w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 shadow-sm hover:shadow-lg transition-shadow duration-300"
                type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                class="block mt-1 w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 shadow-sm hover:shadow-lg transition-shadow duration-300"
                type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input 
                class="password block mt-1 w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 shadow-sm hover:shadow-lg transition-shadow duration-300"
                type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation"
                class="block mt-1 w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 shadow-sm hover:shadow-lg transition-shadow duration-300"
                type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-indigo-500 text-sm hover:underline hover:text-gray-900 rounded-md focus:outline-none"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
