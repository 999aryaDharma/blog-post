<!DOCTYPE html>
<html lang="en" class="h-full w-full bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css', 'resources/js/app.js')
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <title>{{ $title }}</title>
  {{ csrf_token() }}
  {{-- trix editor --}}
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
  <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


  {{-- <style>
    trix-toolbar [data-trix-button-group="file-tools"] {
      display: none;
    }
  </style> --}}

</head>
<body class="h-full">
  
  <!--
  This example requires updating your template:

  ```
  ```
-->
  <div class="min-h-full">
    <x-navbar></x-navbar>

    <x-header>{{ $title }}</x-header>

    <main>
      <div class="mx-auto max-w-full px-0 py-6">
        {{ $slot }}
      </div>
    </main>

  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>