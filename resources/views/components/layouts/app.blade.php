@props(['title', 'description', 'noFollow' => false])

<!DOCTYPE html>
<html lang="pl">

<head>
    @include('partials.meta')
    @include('partials.fonts')
    @include('partials.favicon')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-black ">


    {{-- <x-shared.nav.navbar /> --}}



    {{ $slot }}

{{-- <x-shared.footer /> --}}

</body>

</html>