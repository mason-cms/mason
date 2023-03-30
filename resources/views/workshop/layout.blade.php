<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="backend">
        @include('workshop.partials.navbar')

        <main id="content">
            @yield('content')
        </main>

        @include('workshop.partials.scripts')
    </body>
</html>
