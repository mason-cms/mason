<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')

        <!-- Ace Editor -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.12.1/ace.min.js" integrity="sha512-5rJEyoleRpqGQiEviKvrKQscsMACeHCyrr73ojwMbq5MCHIFEGMN6rxBvvUkZysfYM52M3TqBCYAcNYMlA+HBg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.12.1/ext-beautify.min.js" integrity="sha512-uXfi0GwpQZcHIhGOMMHeNYtBSjt7qDXjXHmjShWSp+RWMSmjdy69N7M/pufinvQLv6rSYlpbSXqSnLRzWE952w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- End Ace Editor -->

        @if ($tinyMceApiKey = config('services.tinymce.api.key'))
            <!-- TinyMCE -->
            <script src="https://cdn.tiny.cloud/1/{{ $tinyMceApiKey }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
                tinymce.init({
                    selector: '.tinymce'
                });
            </script>
            <!-- End TinyMCE -->
        @endif
    </head>
    <body class="backend">
        @include('backend.partials.navbar')

        <main id="content">
            @yield('content')
        </main>
    </body>
</html>
