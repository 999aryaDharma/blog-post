<nav class="bg-gray-800" x-data="{ isOpen: false }">
   <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between">
        <!-- Logo (Left) -->
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
            </div>
        </div>

        <!-- Desktop Navigation Links (Center) -->
        <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 md:space-x-4">
            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
            <x-nav-link href="{{ Auth::check() ? route('my-posts', Auth::user()->username) : route('login') }}" 
                :active="request()->is('my-posts/' . (Auth::check() ? Auth::user()->username : ''))">
                My Blog
            </x-nav-link>
            <x-nav-link href="/about" :active="request()->is('/about')">About</x-nav-link>
        </div>

        <!-- Desktop User Menu (Right) -->
        <div class="hidden md:flex md:items-center">
            @auth
            <div class="relative">
                <button type="button" @click="isOpen = !isOpen"
                    class="relative flex items-center text-white focus:outline-none">
                    @if (auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="rounded-full w-11 h-11 bg-transparent object-fit">
                    @endif
                    <span class="ml-2">{{ Auth::user()->username }}</span>
                </button>
                <div x-show="isOpen"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75 transform"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5">
                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700">Your Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block px-4 py-2 text-sm text-gray-700 w-full text-left">Sign out</button>
                    </form>
                </div>
            </div>
            @else
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                <a href="{{ route('register') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
            </div>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
            <button type="button" @click="isOpen = !isOpen" class="p-2 text-gray-400 hover:text-white">
                <svg :class="{'block': !isOpen, 'hidden': isOpen }" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M3 12h18M3 19h18" />
                </svg>
                <svg :class="{'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>


    <!-- Mobile Menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden">
        <div class="space-y-1 px-2 pt-2 pb-3">
            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
            <x-nav-link href="{{ route('my-posts', Auth::check() ? Auth::user()->username : '') }}" :active="request()->is('my-posts/' . (Auth::check() ? Auth::user()->username : ''))">My Blog</x-nav-link>

            <x-nav-link href="/about" :active="request()->is('/about')">About</x-nav-link>
            <x-nav-link href="/contact" :active="request()->is('/contact')">Contact</x-nav-link>
            @auth
            <a href="{{ route('profile.show') }}" class="block px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white w-full text-left">Sign out</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Login</a>
            <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Register</a>
            @endauth
        </div>
    </div>
</nav>
