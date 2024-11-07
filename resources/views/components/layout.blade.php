<!DOCTYPE html>
<html lang="en" class="h-full w-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css', 'resources/js/app.js')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.1/flowbite.min.css" rel="stylesheet">
    <title>{{ $title }}</title>

    {{-- Trix editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>

<body class="h-full ">
    <div class="min-h-full">
        <x-navbar></x-navbar>

        <main>
            <div class="mx-auto max-w-full px-0 py-6 selection:bg-lime-300 selection:text-black">
                {{ $slot }}
            </div>
        </main>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.1/flowbite.min.js"></script>

    <!-- Modal Components -->
    <x-modal name="loginModal" class="modal">
        @include('auth.login')
    </x-modal>

    <x-modal name="registerModal" class="modal">
        @include('auth.register')
    </x-modal>


    {{-- fungsi close modal --}}
    <script>
        function openModal(modalName, route) {
            history.pushState(null, "", route);
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: modalName
            }));
        }
    </script>

    <!-- Di bagian bawah sebelum </body> -->
    @stack('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


</body>

</html>
