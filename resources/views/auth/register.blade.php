@extends('layouts.auth-master')

@section('page-title', trans('app.sign_up'))

@if (setting('registration.captcha.enabled'))
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endif
@section('content')
<div class="card card-primary">
    <div class="card-header"><h4>@lang('app.register')</h4></div>

        <div class="card-body">
            @include('partials.messages')
        <form method="POST" action="<?= url('register') ?>" method="post" id="registration-form" autocomplete="off">
            <input type="hidden" value="<?= csrf_token() ?>" name="_token">
            <div class="form-group">
                <input aria-describedby="emailHelpBlock" 
                        id="email" 
                        type="text" 
                        class="form-control" 
                        name="email" 
                        placeholder="@lang('app.email')" 
                        tabindex="1"
                        value="{{ old('email') }}"
                        autofocus>
            </div>

            <div class="form-group">
                <input aria-describedby="usernameHelpBlock" 
                        id="username" 
                        type="text" 
                        class="form-control" 
                        name="username" 
                        placeholder="@lang('app.username')" 
                        tabindex="2"
                        value="{{ old('username') }}"
                        autofocus>
            </div>

            <div class="form-group">
                <input aria-describedby="passwordHelpBlock" 
                        id="password" 
                        type="password" 
                        placeholder="@lang('app.password')" 
                        class="form-control" 
                        name="password" 
                        tabindex="3">     
            </div>

            <div class="form-group">
                <input aria-describedby="passwordHelpBlock" 
                        id="password_confirmation" 
                        type="password" 
                        placeholder="@lang('app.confirm_password')"
                        class="form-control" 
                        name="password_confirmation" 
                        tabindex="4">     
            </div>

            @if (setting('tos'))
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="tos" id="tos" value="1"/>
                    <label class="custom-control-label font-weight-normal" for="tos">
                        @lang('app.i_accept')
                        <a href="#tos-modal" data-toggle="modal">@lang('app.terms_of_service')</a>
                    </label>
                </div>
            </div>
            @endif

            {{-- Only display captcha if it is enabled --}}
            @if (setting('registration.captcha.enabled'))
                <div class="form-group">
                    {!! app('captcha')->display() !!}
                </div>
            @endif
            {{-- end captcha --}}

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    @lang('app.register')
                </button>
            </div>
            @include('auth.social.buttons')
        </form>
        <div class="mt-4 text-center text-muted">
            @if (setting('reg_enabled'))
                @lang('app.already_have_an_account')
                <a class="font-weight-bold" href="<?= url("login") ?>">@lang('app.login')</a>
            @endif
        </div>
    </div>    
</div>

@if (setting('tos'))
        <div class="modal fade" id="tos-modal" tabindex="-1" role="dialog" aria-labelledby="tos-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tos-label">@lang('app.terms_of_service')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>1. Terms</h4>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Donec quis lacus porttitor, dignissim nibh sit amet, fermentum felis.
                            Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
                            cubilia Curae; In ultricies consectetur viverra. Nullam velit neque,
                            placerat condimentum tempus tincidunt, placerat eu lectus. Nam molestie
                            porta purus, et pretium risus vehicula in. Cras sem ipsum, varius sagittis
                            rhoncus nec, dictum maximus diam. Duis ac laoreet est. In turpis velit, placerat
                            eget nisi vitae, dignissim tristique nisl. Curabitur sollicitudin, nunc ut
                            viverra interdum, lacus...
                        </p>

                        <h4>2. Use License</h4>

                        <ol type="a">
                            <li>
                                Aenean vehicula erat eu nisi scelerisque, a mattis purus blandit. Curabitur congue
                                ollis nisl malesuada egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit:
                            </li>
                        </ol>

                        <p>...</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('app.close')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Auth\RegisterRequest', '#registration-form') !!}
@stop