@extends('layouts.backend')

@section('content')
    <section class="section">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <div>
                        <h1 class="title is-1">
                            <a href="{{ route('backend.configuration.general') }}">
                                {{ __('configuration.title') }}
                            </a>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="level-right">

            </div>
        </div>

        <hr />
    </section>
@endsection
