<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.partials.head')

    <body class="font-sans py-6 bg-gray-100 antialiased">
        <main class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @yield('body')
        </main>
    </body>
</html>
