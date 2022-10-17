<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')

        @if ($tinyMceApiKey = config('services.tinymce.api.key'))
            <script src="https://cdn.tiny.cloud/1/{{ $tinyMceApiKey }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
                tinymce.init({
                    selector: '.tinymce',
                    plugins: 'code',
                    toolbar: 'code'
                });
            </script>
        @endif
    </head>
    <body class="backend">
        @include('backend.partials.navbar')

        <main id="content">
            @yield('content')
        </main>
    </body>
</html>
