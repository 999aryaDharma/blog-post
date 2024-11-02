<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <style>
        .toast {
            width: 10000px;
            /* Atur lebar sesuai kebutuhan */
            max-width: 100%;
            /* Agar tidak melebihi 90% dari lebar tampilan */
        }

        .img-container {
            width: 100%;
            /* Atur sesuai kebutuhan */
            max-width: 750px;
            /* Atur lebar maksimum */
            height: 200px;
            /* Ganti dengan tinggi tetap yang Anda inginkan */
            overflow: hidden;
            /* Untuk menghindari overflow dari gambar */
        }

        .toast-error {
            background-color: #dc3545;
            /* Merah */
            color: #fff;
            width: ;
        }
    </style>
    </style>

    <article class="pb-20 px-4 sm:px-8 lg:px-16 xl:px-80 bg-white antialiased">
        <div class="flex flex-col lg:flex-row justify-between mx-auto max-w-screen-xl">
            <article class="w-full pr-2 sm:px-6 lg:px-8 mx-auto max-w-5xl format format-sm sm:format-base lg:format-lg">
                <header class="mb-4 lg:mb-6 not-format">
                    <a href="/" class="pl-2 sm:pl-4 lg:pl-10 font-medium text-sm text-gr-600 hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </a>
                    <div class="pl-2 sm:pl-4 lg:pl-11">
                        <!-- Title Section -->
                        <h3
                            class="text-3xl md:text-5xl font-nunito sm:text-4xl lg:text-5xl font-bold text-black lg:mb-2 mt-2 sm:mt-4 md:leading-[4rem] sm:leding-8 lg:leading-[3.5rem]">
                            {{ $post['title'] }}
                        </h3>

                        <!-- Category Section -->
                        <div class=" flex items-center flex-wrap gap-2">
                            @foreach ($post->categories as $category)
                                <span
                                    class="bg-{{ $category->color }}-100 text-gray-500 text-xs rounded mb-1 py-1 px-2">
                                    <a href="/categories/{{ $category->slug }}" class="text-primary-800">
                                        {{ $category->name }}
                                    </a>
                                </span>
                            @endforeach
                        </div>


                        <!-- Author Section -->
                        <address class="flex items-center my-4 sm:my-6 not-italic">
                            <div class="inline-flex items-center mr-3 text-sm text-gray-900">
                                <img src="{{ $post->author->profile_photo ? asset('storage/' . $post->author->profile_photo) : asset('images/default.png') }}"
                                    alt="{{ $post->author->name }}"
                                    class="w-8 sm:w-10 h-8 sm:h-10 rounded-full object-cover">
                                <div class="ml-2 sm:ml-3">
                                    <a href="{{ '/authors/' . $post->author->username }}" rel="author"
                                        class="text-sm font-bold text-gray-900">{{ $post->author->name }}</a>
                                    <p class="text-xs sm:text-md text-gray-500">{{ $post->created_at->format('M d') }}
                                    </p>
                                </div>
                            </div>
                        </address>

                        {{-- up/down vote --}}
                        <div class="flex items-center space-x-2 border-y py-2">
                            <button id="upvote-{{ $post->id }}" class="flex items-center p-2 hover:text-black"
                                onclick="submitVote({{ $post->id }}, 'up')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#5C5C5C"
                                    viewBox="0 0 256 256" class="hover:fill-black text-gray-100 hover:shadow-xl">
                                    <path
                                        d="M231,82.76A20,20,0,0,0,216,76H156V56a36,36,0,0,0-36-36,4,4,0,0,0-3.58,2.21L77.53,100H32a12,12,0,0,0-12,12v88a12,12,0,0,0,12,12H204a20,20,0,0,0,19.85-17.52l12-96A20,20,0,0,0,231,82.76ZM76,204H32a4,4,0,0,1-4-4V112a4,4,0,0,1,4-4H76ZM227.91,97.49l-12,96A12,12,0,0,1,204,204H84V104.94L122.42,28.1A28,28,0,0,1,148,56V80a4,4,0,0,0,4,4h64a12,12,0,0,1,11.91,13.49Z">
                                    </path>
                                </svg>
                                <span id="upvote-count-{{ $post->id }}"
                                    class="ml-2 font-nunito text-xs">{{ $post->upvotes() }}</span>
                            </button>

                            <button id="downvote-{{ $post->id }}" class="flex items-center p-2 hover:text-black"
                                onclick="submitVote({{ $post->id }}, 'down')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#5C5C5C"
                                    viewBox="0 0 256 256" class="hover:fill-black hover:shadow-xl">
                                    <path
                                        d="M235.85,157.52l-12-96A20,20,0,0,0,204,44H32A12,12,0,0,0,20,56v88a12,12,0,0,0,12,12H77.53l38.89,77.79A4,4,0,0,0,120,236a36,36,0,0,0,36-36V180h60a20,20,0,0,0,19.85-22.48ZM76,148H32a4,4,0,0,1-4-4V56a4,4,0,0,1,4-4H76Zm149,19.94a12,12,0,0,1-9,4.06H152a4,4,0,0,0-4,4v24a28,28,0,0,1-25.58,27.9L84,151.06V52H204a12,12,0,0,1,11.91,10.51l12,96A12,12,0,0,1,225,167.94Z">
                                    </path>
                                </svg>
                                <span id="downvote-count-{{ $post->id }}"
                                    class="ml-2 font-nunito text-xs">{{ $post->downvotes() }}</span>
                            </button>
                        </div>



                        {{-- Excerpt --}}
                        <p class="mt-6 text-xl font-serif flex-shrink-0">
                            {{ $post->excerpt }}</p>
                    </div>

                    <div
                        class="ml-2 sm:ml-4 lg:ml-11 max-w-full h-auto flex-shrink-0 order-last md:order-none mt-4 md:mt-10">
                        @if ($post->thumbnail)
                            <img src="{{ $post->thumbnailUrl }}" alt="Thumbnail of {{ $post->title }}"
                                class="w-full md:w-[750px] h-48 sm:h-60 md:h-80 object-contain shadow-md" />
                        @endif
                    </div>
                </header>

                <!-- Content Section -->
                <div
                    class="content-body px-2 sm:px-4 lg:px-11 font-lora text-base sm:text-lg lg:text-xl text-gray-700 leading-10">
                    <p>{!! $post->body !!}</p>
                </div>

            </article>
        </div>
    </article>
</x-layout>


<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "5000",
        "hideDuration": "5000",
        "timeOut": "5000",
        "extendedTimeOut": "3000",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    function submitVote(post_id, voteType) {
        fetch(`/posts/${post_id}/vote`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    vote: voteType
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        // Menampilkan pesan error menggunakan Toastr
                        toastr.error(errorData.error || 'Terjadi kesalahan. Silakan coba lagi.');
                        throw new Error(errorData.error);
                    });
                }
                return response.json();
            })
            .then(data => {
                // Memperbarui jumlah vote di antarmuka
                document.getElementById(`upvote-count-${post_id}`).innerText = data.upvotes;
                document.getElementById(`downvote-count-${post_id}`).innerText = data.downvotes;

            })
            .catch(error => {
                // Menampilkan pesan kesalahan dengan Toastr
                toastr.error('You need to login to vote.');
                console.error('Error:', error);
            });
    }
</script>
