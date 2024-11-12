<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    @section('tittle', $title)

    {{-- searching for --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-14">
        @if (request('search'))
            <div class=" border border-lime-100 text-gray-600 rounded-lg p-4 flex items-center space-x-2 mt-4 shadow-md">
                <!-- Icon Search -->
                <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M21 21l-4.35-4.35a7.5 7.5 0 10-1.06 1.06L21 21zM10.5 17a6.5 6.5 0 110-13 6.5 6.5 0 010 13z" />
                </svg>
                <!-- Text -->
                <p class="text-lg font-semibold">Searching for "<span class="font-bold">{{ request('search') }}</span>"
                </p>
            </div>
        @endif
    </div>


    <div class="py-2 mx-auto max-w-screen-xl lg:py-10 p-6">
        {{-- Carousel (Featured Post) --}}
        @include('posts.components.popularPost', ['popularPosts' => $popularPosts])

        {{-- Latest Post (ambil 3) --}}
        @isset($latestPosts)
            @include('posts.components.latestPost', ['latestPosts' => $latestPosts])
        @endisset


        <!-- Regular Post -->
        @include('posts.components.regularPost', ['posts' => $posts])

    </div>

    <!-- Floating action button with better mobile positioning -->
    @auth
        <button><a href="{{ route('posts.create') }}"
                class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 bg-[#373737] text-white rounded-full p-3 sm:p-4 shadow-lg hover:bg-[#272727] focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a></button>
    @else
        <button onclick="openModal('loginModal')"
            class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 bg-[#373737] text-white rounded-full p-3 sm:p-4 shadow-lg hover:bg-[#272727] focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    @endauth



</x-layout>

<!-- Toastr Notifications -->



{{-- dropdwon category --}}
<script>
    // Ambil elemen tombol dan konten accordion
    const accordionButton = document.getElementById('accordionButton');
    const accordionContent = document.getElementById('accordionContent');

    // Fungsi untuk toggle konten
    function toggleAccordion() {
        const isHidden = accordionContent.classList.contains('hidden');
        if (isHidden) {
            accordionContent.classList.remove('hidden');
            requestAnimationFrame(() => {
                accordionContent.classList.add('max-h-screen', 'opacity-100', 'scale-100');
                accordionContent.classList.remove('max-h-0', 'opacity-0', 'scale-95');
            });
        } else {
            accordionContent.classList.add('max-h-0', 'opacity-0', 'scale-95');
            accordionContent.classList.remove('max-h-screen', 'opacity-100', 'scale-100');
            setTimeout(() => {
                accordionContent.classList.add('hidden');
            }, 200); // Waktu sesuai dengan duration di Tailwind (300ms)
        }
    }

    // Event listener untuk tombol
    accordionButton.addEventListener('click', (event) => {
        event.stopPropagation(); // Mencegah event bubble saat klik pada tombol
        toggleAccordion();
    });

    // Menutup accordion jika mengklik di luar elemen
    document.addEventListener('click', (event) => {
        if (!accordionContent.classList.contains('hidden') && !accordionButton.contains(event.target)) {
            toggleAccordion();
        }
    });
</script>
