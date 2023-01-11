@extends('layouts.auth-master')

@section('page-title', trans('app.login'))
@section('content')
<div class="card card-primary">
    <div class="card-header"><h4>@lang('app.login')</h4></div>

        <div class="card-body">
            @include('partials.messages')
        <form method="POST" action="<?= url('login') ?>" id="login-form" autocomplete="off">
            <input type="hidden" value="<?= csrf_token() ?>" name="_token">
            <div class="form-group">
                <label for="username">@lang('app.email_or_username')</label>
                <input aria-describedby="emailHelpBlock" 
                        id="username" 
                        type="text" 
                        class="form-control" 
                        name="username" 
                        placeholder="@lang('app.email_or_username')" 
                        tabindex="1" 
                        autofocus>
            </div>

            <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">@lang('app.password')</label>
                    <div class="float-right">
                        <a href="<?= url('password/remind') ?>" class="text-small">
                            @lang('app.i_forgot_my_password')
                        </a>
                    </div>
                </div>
                <input aria-describedby="passwordHelpBlock" 
                        id="password" 
                        type="password" 
                        placeholder="@lang('app.password')" 
                        class="form-control" 
                        name="password" 
                        tabindex="2">     
            </div>

            @if (setting('remember_me'))
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember">
                      <label class="custom-control-label" for="remember">@lang('app.remember_me')</label>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    @lang('app.log_in')
                </button>
            </div>
            @include('auth.social.buttons')
        </form>
        <div class="mt-4 text-muted text-center">
            @if (setting('reg_enabled'))
                @lang('app.dont_have_an_account') <a class="font-weight-bold" href="<?= url("register") ?>">Sign Up</a>
            @endif
        </div>
    </div>    
</div>

@endsection

@section('scripts')
    {!! HTML::script('assets/js/as/login.js') !!}
    {!! JsValidator::formRequest('App\Http\Requests\Auth\LoginRequest', '#login-form') !!}
@stop