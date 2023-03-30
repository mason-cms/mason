@extends('workshop.layout')

@section('content')
    <section class="section">
        <div class="columns">
            <div class="column is-2">
                @include('workshop.configuration.partials.menu')
            </div>

            <div class="column">
                @yield('main')
            </div>
        </div>
    </section>
@endsection
