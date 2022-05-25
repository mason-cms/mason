<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="backend">
        @include('backend.partials.navbar')

        <main id="content">
            @yield('content')
        </main>
    </body>
</html>
