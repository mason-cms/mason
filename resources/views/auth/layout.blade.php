<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>

    <body class="auth">
        <header id="header" class="section has-text-centered">
            <h1 id="brand">
                <a href="{{ route('login') }}">
                    <strong>Mason</strong><span class="has-text-success">&times;</span>CMS
                </a>
            </h1>
        </header>

        <main id="content" class="section">
            @yield('content')
        </main>

        <footer id="footer" class="section has-text-centered">
            <p id="copy">&copy; <a href="https://limestone.dev/" target="_blank" rel="nofollow">Limestone Software</a></p>
        </footer>
    </body>
</html>
