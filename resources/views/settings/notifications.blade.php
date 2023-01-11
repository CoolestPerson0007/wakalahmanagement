@extends('layouts.admin-master')

@section('page-title', trans('app.notification_settings'))
@section('page-heading', trans('app.notification_settings'))

@section('breadcrumbs')
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item">
            <a href="{{ route('settings.general') }}">@lang('app.settings')</a>
        </div>
        <div class="breadcrumb-item active">
            @lang('app.notifications')
        </div>
    </div>
@stop

@section('content')

@include('partials.messages')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="panel-heading"></div>
            <div class="card-body">
                <h5 class="card-title">
                    @lang('app.email_notifications')
                </h5>

                {!! Form::open(['route' => 'settings.notifications.update', 'id' => 'notification-settings-form']) !!}

                    <div class="form-group my-4">
                        <div class="d-flex align-items-center">
                            <label for="switch-signup-email" class="control-label">
                                <input type="hidden" value="0" name="notifications_signup_email">

                                <input type="checkbox"
                                       name="notifications_signup_email"
                                       class="custom-switch-input"
                                       value="1"
                                       id="switch-signup-email"
                                       {{ setting('notifications_signup_email') ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                            </label>
                            
                            <div class="ml-3 d-flex flex-column">
                                <label class="mb-0">@lang('app.sign_up_notification')</label>
                                <small class="pt-0 text-muted">
                                    @lang('app.notify_admin_when_user_signs_up')
                                </small>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        @lang('app.update_settings')
                    </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop