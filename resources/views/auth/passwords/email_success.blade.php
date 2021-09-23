@extends('auth.auth_app')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side">
    <div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8">
                <h1 class="text-primary text-center text-bold">{{ $message }}</h1>
            </div>
        </div>
    </div>
</div>
@endsection
