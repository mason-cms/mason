<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>{{ config('app.name') }}</title>

<link
    rel="icon"
    type="image/png"
    href="{{ asset('img/favicon.png') }}"
/>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" />

@if ($fontawesomeKit = config('services.fontawesome.kit'))
    <script
        src="https://kit.fontawesome.com/{!! $fontawesomeKit !!}.js"
        crossorigin="anonymous"
    ></script>
@endif

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
    integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
/>

<link
    rel="stylesheet"
    href="{{ mix('css/app.css') }}"
/>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
    integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>

<script
    src="{{ mix('js/app.js') }}"
></script>
