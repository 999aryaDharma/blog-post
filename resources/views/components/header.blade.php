<header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between"> <!-- Menambahkan flex untuk menyelaraskan elemen -->
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $slot }}</h1>

            <div class="flex">
                <div class="mx-auto max-w-screen-md sm:text-center">
                    <form action="{{ url()->current() }}">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if (request('author'))
                            <input type="hidden" name="author" value="{{ request('author') }}">
                        @endif

                        {{-- Search Bar --}}
                        <div class="items-end  max-w-screen-sm sm:flex sm:space-y-0">
                            <div class="relative w-full">
                                <label for="search" class="hidden text-sm font-medium text-gray-900 dark:text-gray-300">Search</label>
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input class="block p-3 pl-10 w-[320px] text-sm  text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" autocomplete="off" placeholder="Search for article" type="search" id="search" name="search" value="{{ request('search') }}">
                            </div>
                            <div>
                                <button type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-primary-700 border-primary-600 sm:rounded-none sm:rounded-r-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
