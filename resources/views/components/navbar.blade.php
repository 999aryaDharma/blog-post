<nav class="top-0 left-0 right-0 border-2 border-t-0 border-x-0 border-gray-100 shadow-md bg-transparent z-50"
    x-data="{ isOpen: false, isProfileOpen: false }">
    <div class="mx-auto max-w-full px-4 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Logo (Left) -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <p class="text-4xl font-bold font-playfair"><a href="{{ route('posts') }}">Medium</a></p>
                </div>
                <!-- Search Bar di kanan -->
                <div class="flex max-w-screen-md ml-3.5">
                    <form action="{{ url()->current() }}" class="flex w-full justify-end">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if (request('author'))
                            <input type="hidden" name="author" value="{{ request('author') }}">
                        @endif

                        <div class="flex space-x-1">
                            <div class="relative flex-1">
                                <label for="search"
                                    class="hidden text-sm font-medium text-gray-900 dark:text-gray-300">Search</label>
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input
                                    class="block pl-10 w-56 text-md h-10 text-gray-900 bg-gray-50 rounded-full border border-gray-100 focus:ring-gray-400 focus:border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                    autocomplete="off" placeholder="Search" type="search" id="search"
                                    name="search" value="{{ request('search') }}">
                            </div>
                            {{-- <div>
                                <button type="submit"
                                    class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-gray-700 border-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Search</button>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>


            <!-- Desktop Navigation Links (Center) -->
            <div class="hidden md:flex absolute right-7 transform -translate-x-1/2 space-x-8 text-black">
                @auth
                    <x-nav-link href="{{ route('my-posts', Auth::user()->username) }}"
                        class="border border-transparent hover:border-black transition relative group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-7 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>

                        <span
                            class="absolute left-0 -bottom-1 w-full h-1 bg-black transition-transform duration-300 transform scale-x-0 group-hover:scale-x-100"></span>
                    </x-nav-link>
                @else
                    <x-nav-link onclick="openModal('loginModal')" :active
                        class="border border-transparent hover:border-black transition relative group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>

                        <span
                            class="absolute left-0 -bottom-1 w-full h-1 bg-black transition-transform duration-300 transform scale-x-0 group-hover:scale-x-100"></span>
                    </x-nav-link>
                @endauth
            </div>

            <!-- Desktop User Menu (Right) -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                @auth
                    <div class="relative" @click.away="isProfileOpen = false">
                        <button @click="isProfileOpen = !isProfileOpen" class="flex items-center">
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full object-cover">
                            {{-- <span class="ml-2 hover:underline">{{ auth()->user()->name }}</span> --}}
                        </button>

                        <!-- Profile Dropdown -->
                        <div x-show="isProfileOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                            <a href="{{ route('profile.show') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">Sign
                                    out</button>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="isOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div x-show="isOpen" x-transition:enter="transform transition-transform ease-in-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition-transform ease-in-out duration-300"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 w-64 bg-white border border-black overflow-y-auto md:hidden z-50">

        <!-- Mobile Menu Content -->
        <div class="px-2 pt-10 pb-3 space-y-1">
            <x-nav-link href="{{ route('posts') }}" :active="request()->routeIs('home')"
                class="block px-3 py-2 rounded-md text-base font-medium text-black border border-transparent hover:border-black transition hover:text-black">
                Home
            </x-nav-link>
            <x-nav-link href="{{ route('my-posts', Auth::check() ? Auth::user()->username : '') }}" :active="request()->routeIs('blog')"
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
<div class="h-2"></div>
