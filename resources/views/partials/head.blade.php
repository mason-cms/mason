<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name') }}</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet">

@if ($fontawesomeKit = config('services.fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{!! $fontawesomeKit !!}.js" crossorigin="anonymous"></script>
@endif

<link rel="stylesheet" href="{{ mix('css/app.css') }}">

<script src="{{ mix('js/app.js') }}" defer></script>
