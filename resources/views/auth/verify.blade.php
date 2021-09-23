@extends('layouts.app')

@section('content')
<div class="container" style='text-align:center'>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card blog-header">
                <h1>{{ __('Verify Your Email Address') }}</h1>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success para" role="alert">
                            {{ __('New verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p  class='para'>{{ __('Before proceeding, please check your mailbox for the verification link.') }}</p>
                    <p class='para'>{{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button style='color: blue;text-decoration: underline' type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Click here to resend the verification mail') }}</button>.
                    </form> </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
