<nav class="top-0 left-0 right-0 border-2 border-t-0 border-x-0 border-black bg-transparent z-50" x-data="{ isOpen: false, isProfileOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Logo (Left) -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <p class="text-4xl font-bold font-[Noto]">Medium</p>
                </div>
            </div>

            <!-- Desktop Navigation Links (Center) -->
            <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 space-x-8 text-black">
                <x-nav-link href="{{ route('posts') }}" :active="request()->routeIs('home')" class="border border-transparent hover:border-black transition relative group">
                    Home
                    <span class="absolute left-0 -bottom-1 w-full h-1 bg-black transition-transform duration-300 transform scale-x-0 group-hover:scale-x-100"></span>
                </x-nav-link>
                @auth
                    <x-nav-link href="{{ route('my-posts', Auth::user()->username) }}" :active="request()->is('my-posts/' . Auth::user()->username)" class="border border-transparent hover:border-black transition relative group">
                        My Blog
                        <span class="absolute left-0 -bottom-1 w-full h-1 bg-black transition-transform duration-300 transform scale-x-0 group-hover:scale-x-100"></span>
                    </x-nav-link>
                @else
                    <x-nav-link href="{{ route('login') }}" class="border border-transparent hover:border-black transition relative group">
                        My Blog
                        <span class="absolute left-0 -bottom-1 w-full h-1 bg-black transition-transform duration-300 transform scale-x-0 group-hover:scale-x-100"></span>
                    </x-nav-link>
                @endauth
                <x-nav-link href="{{ route('posts') }}" :active="request()->routeIs('about')" class="border border-transparent hover:border-black transition relative group">
                    About
                    <span class="absolute left-0 -bottom-1 w-full h-1 bg-black transition-transform duration-300 transform scale-x-0 group-hover:scale-x-100"></span>
                </x-nav-link>
            </div>

            <!-- Desktop User Menu (Right) -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                @auth
                    <div class="relative" @click.away="isProfileOpen = false">
                        <button @click="isProfileOpen = !isProfileOpen" class="flex items-center">
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="h-10 w-10 rounded-full object-cover">
                            <span class="ml-2 hover:underline">{{ auth()->user()->name }}</span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div x-show="isProfileOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <x-primary-button onclick="openModal('loginModal')">Login</x-primary-button>
                    <x-primary-button onclick="openModal('registerModal')">Register</x-primary-button>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex md:hidden">
                <button @click="isOpen = !isOpen" class="text-black hover:text-gray-600">
                    <svg x-show="!isOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="isOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div x-show="isOpen" 
         x-transition:enter="transform transition-transform ease-in-out duration-300"
         x-transition:enter-start="translate-x-full" 
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition-transform ease-in-out duration-300"
         x-transition:leave-start="translate-x-0" 
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 w-64 bg-white border border-black overflow-y-auto md:hidden z-50">

        <!-- Mobile Menu Content -->
        <div class="px-2 pt-10 pb-3 space-y-1">
            <x-nav-link href="{{ route('posts') }}" 
                        :active="request()->routeIs('home')"
                        class="block px-3 py-2 rounded-md text-base font-medium text-black border border-transparent hover:border-black transition hover:text-black">
                    Home
            </x-nav-link>
            <x-nav-link href="{{ route('my-posts', Auth::check() ? Auth::user()->username : '') }}" 
                        :active="request()->routeIs('blog')"
                        class="block px-3 py-2 rounded-md text-base font-medium text-black border border-transparent hover:border-black transition hover:text-black">
                    Blog
            </x-nav-link>
            <x-nav-link href="/about" 
                        class="block px-3 py-2 rounded-md text-base font-medium text-black border border-transparent hover:border-black transition hover:text-black">
                    About
            </x-nav-link>

            @auth
                <div class="border-t border-gray-700 pt-4 mt-4">
                    <div class="px-3 py-2 text-gray-400">
                        {{ auth()->user()->name }}
                    </div>
                    <a href="{{ route('profile.show') }}"
                       class="block px-3 py-2 rounded-md text-base font-medium text-black hover:text-white hover:bg-gray-700">
                        Your Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-black hover:text-white hover:bg-gray-700">
                            Sign out
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-700 pt-4 mt-4">
                    <a href="{{ route('login') }}"
                       class="block px-3 py-2 rounded-md text-base font-medium text-black hover:text-white hover:bg-gray-700">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="block px-3 py-2 rounded-md text-base font-medium text-black hover:text-white hover:bg-gray-700">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Overlay -->
    <div x-show="isOpen" @click="isOpen = false" class="fixed inset-0 bg-black bg-opacity-50 md:hidden z-40"></div>
</nav>

<!-- Spacer to prevent content from hiding under fixed navbar -->
<div class="h-4"></div>
