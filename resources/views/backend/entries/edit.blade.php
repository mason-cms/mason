@extends('layouts.backend')

@section('content')
    <section class="section">
        <div class="columns">
            <div class="column">
                <form
                    action="{{ route('backend.entries.update', [$entryType, $entry]) }}"
                    method="POST"
                >
                    @method('PATCH')
                    @csrf

                    <div class="block">
                        @include('backend.partials.entries.fields')
                    </div>

                    <div class="buttons">
                        <button class="button is-dark" type="submit">
                            <span class="icon"><i class="fa-light fa-floppy-disk"></i></span>
                            <span>{{ __('entries.actions.save.label') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
