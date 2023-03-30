@extends('workshop.layout')

@section('content')
    <section class="section">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        <a href="{{ route('workshop.dashboard') }}">
                            @icon(\App\Http\Controllers\Workshop\DashboardController::ICON)
                            <span>@lang('dashboard.title')</span>
                        </a>
                    </h1>
                </div>
            </div>

            <div class="level-right"></div>
        </div>

        <hr />
    </section>
@endsection
