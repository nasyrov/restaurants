<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.partials.head')

    <body class="antialiased text-gray-900">
        @yield('body')
    </body>
</html>
