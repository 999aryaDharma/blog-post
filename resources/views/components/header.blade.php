<header class="bg-white shadow w-full">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 sm:mb-0">{{ $slot }}</h1>

            <div class="flex w-full max-w-screen-md">
                <form action="{{ url()->current() }}" class="flex w-full">
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if (request('author'))
                        <input type="hidden" name="author" value="{{ request('author') }}">
                    @endif

                    {{-- Search Bar --}}
                    <div class="flex items-center w-full space-x-1">
                        <div class="relative flex-1 ml-14">
                            <label for="search" class="hidden text-sm font-medium text-gray-900 dark:text-gray-300">Search</label>
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" autocomplete="off" placeholder="Search for article" type="search" id="search" name="search" value="{{ request('search') }}">
                        </div>
                        <div>
                            <button type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-gray-700 border-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
