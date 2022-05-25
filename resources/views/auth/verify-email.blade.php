@extends('layouts.auth')

@section('content')
    <div
        id="verify-email"
        class="card block is-narrow"
    >
        <div class="card-content">
            <p>
                {{ __('auth.verify_email.intro') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <p>
                    {{ __('auth.verify_email.verification_link_sent') }}
                </p>
            @endif

            <form
                id="resend-verification-email-form"
                method="POST"
                action="{{ route('verification.send') }}"
            >
                @csrf

                <button>
                    {{ __('auth.verify_email.resend_verification_email') }}
                </button>
            </form>

            <form
                id="logout-form"
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button class="button" type="submit">
                    {{ __('auth.log_out') }}
                </button>
            </form>
        </div>
    </div>
@endsection
