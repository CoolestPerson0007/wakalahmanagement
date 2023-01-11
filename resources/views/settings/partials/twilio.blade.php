@if (setting('reg_phone_confirmation') && ! (config('twilio.auth_token') && config('twilio.auth_token') && config('twilio.app_sid') && config('twilio.from')))

<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-1">
            Twilio SMS
        </h5>

        <small class="text-muted d-block mb-4">
            @lang('app.enable_disable_phone_verification_during_registration')
        </small>

        <div class="alert alert-warning">
            @lang('app.to_utilize_twilio_please_update') <code>TWILIO_AUTH_TOKEN</code> @lang('app.and') <code>TWILIO_ACCOUNT_SID</code> @lang('app.and') <code>TWILIO_APP_SID</code>  @lang('app.and') <code>TWILIO_FROM</code>
            @lang('app.environment_variables_inside') <code>.env</code> @lang('app.file').
        </div>
    </div>
</div>
@endif
