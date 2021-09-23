@extends('auth.auth_app')

@section('title', 'Reset password | Databroker ')

@section('content')
<div class="container-fluid app-wapper">
    <div class="container">
        <div class="row justify-content-center auth-section">
            <div class="col-md-8">
                <div class="card">
                    <h1 class="h1-smaller color-primary text-center text-primary" id="login_title">Please choose a new password</h1>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <label class="pure-material-textfield-outlined">
                                <input type="password" id="password" name="password" class="form-control input_data @error('password')  is-invalid @enderror" placeholder=" "  value="" autofocus>
                                <span>{{ trans('auth.password') }}</span>
                                <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Password']) }}</div>
                                <span class="feedback @error('password') invalid-feedback @enderror" role="alert">
                                    <strong>
                                        Your password must contain at least <span class="has8letters">8 characters</span>, including <span class="hasupperletter">1 uppercase letter</span> and <span class="hasdigit">1 digit</span>.
                                    </strong>
                                </span>
                            </label>

                            <label class="pure-material-textfield-outlined">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control input_data @error('password_confirmation')  is-invalid @enderror" placeholder=" "  value="" autofocus>
                                <span>{{ trans('auth.confirm_password') }}</span>
                                <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Password']) }}</div>
                                <span class="feedback @error('password_confirmation') invalid-feedback @enderror" role="alert">
                                    <strong>
                                        @if($errors->has('password_confirmation')) {{$errors->first('password_confirmation')}} 
                                        @endif
                                    </strong>
                                </span>
                            </label>

                            <div class="register-actions form-group mb-0">
                                <button type="submit" class="customize-btn">{{ __('Reset Password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection
@section('additional_javascript')
    <script type="text/javascript">
        $("input[name='password']").on("keyup", function(e){
            var has8letters = false;
            var hasupperletter = false;
            var hasdigit = false;
            var text = $(this).val();
            if(text.length >= 8) has8letters = true;
            else has8letters = false;
            if(text.length!=0){
                for(var i=0; i<text.length; i++){
                    if(text[i]>='A' && text[i]<='Z')
                        hasupperletter = true;
                    if(text[i]>='0' && text[i]<='9')
                        hasdigit = true;
                }
            }
            if(has8letters) $(this).siblings('.feedback').find('.has8letters').addClass('passed');
            else $(this).siblings('.feedback').find('.has8letters').removeClass('passed');
            if(hasupperletter) $(this).siblings('.feedback').find('.hasupperletter').addClass('passed');
            else $(this).siblings('.feedback').find('.hasupperletter').removeClass('passed');
            if(hasdigit) $(this).siblings('.feedback').find('.hasdigit').addClass('passed');
            else $(this).siblings('.feedback').find('.hasdigit').removeClass('passed');
            if(has8letters && hasupperletter && hasdigit) $(this).siblings('.feedback').addClass('text-green');
            else $(this).siblings('.feedback').removeClass('text-green');
        });
        $("input[name='password_confirmation']").on("keyup", function(e){
            var password = $("input[name='password']").val();
            var confirm = $(this).val();
            console.log(password.indexOf(confirm));
            if(confirm == password) {
                $(this).siblings('.feedback').html("<strong class='text-green'>Passwords match.</strong>");
            }else if(password.indexOf(confirm)){
                $(this).siblings('.feedback').html("<strong class='text-red'>Passwords do not match.</strong>");
            }else{
                $(this).siblings('.feedback').html("<strong class='text-red'></strong>");
            }
        });
    </script>
@endsection