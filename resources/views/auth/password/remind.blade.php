@extends('layouts.auth-master')

@section('page-title', trans('app.reset_password'))
@section('content')
<div class="card card-primary">
    <div class="card-header"><h4>@lang('app.forgot_your_password')</h4></div>
    @include('partials.messages')
    <div class="card-body">
        
        <form role="form" action="<?= url('password/remind') ?>" method="POST" id="remind-password-form" autocomplete="off">
            {{ csrf_field() }}
            
            <p class="text-muted mb-4 text-center font-weight-light">
                @lang('app.please_provide_your_email_below')
            </p>
                    
            <div class="form-group">
                <label for="email">@lang('app.email')</label>
                <input aria-describedby="emailHelpBlock" 
                        id="email" 
                        type="text" 
                        class="form-control" 
                        name="email" 
                        placeholder="@lang('app.your_email')" 
                        tabindex="1" 
                        autofocus>
            </div> 

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="2">
                    @lang('app.reset_password')
                </button>
            </div>
        </form>
    </div>    
</div>

@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Auth\PasswordRemindRequest', '#remind-password-form') !!}
@stop