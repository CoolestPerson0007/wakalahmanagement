<div class="card">
    <div class="card-body">
        <h5 class="card-title">@lang('app.general')</h5>

        {!! Form::open(['route' => 'settings.auth.update', 'id' => 'registration-settings-form']) !!}

        <div class="form-group my-4">
            <div class="d-flex align-items-center">
                <label for="switch-reg-enabled" class="control-label">
                    <input type="hidden" value="0" name="reg_enabled">

                    <input
                        type="checkbox" name="reg_enabled"
                        id="switch-reg-enabled"
                        class="custom-switch-input" value="1"
                        {{ setting('reg_enabled') ? 'checked' : '' }}>
                    <span class="custom-switch-indicator"></span>
                </label>
                <div class="ml-3 d-flex flex-column">
                    <label class="mb-0">@lang('app.allow_registration')</label>
                </div>
            </div>
        </div>

        <div class="form-group my-4">
            <div class="d-flex align-items-center">
                <label for="switch-tos" class="control-label">
                    <input type="hidden" value="0" name="tos">
                    {!! Form::checkbox('tos', 1, setting('tos'), ['class' => 'custom-switch-input', 'id' => 'switch-tos']) !!}
                    <span class="custom-switch-indicator"></span>
                </label>
                <div class="ml-3 d-flex flex-column">
                    <label class="mb-0">@lang('app.terms_and_conditions')</label>
                    <small class="pt-0 text-muted">
                        @lang('app.the_user_has_to_confirm')
                    </small>
                </div>
            </div>
        </div>

        <div class="form-group my-4">
            <div class="d-flex align-items-center">
                <label for="switch-reg-email-confirm" class="control-label">
                    <input type="hidden" value="0" name="reg_email_confirmation">
                    {!! Form::checkbox('reg_email_confirmation', 1, setting('reg_email_confirmation'), ['class' => 'custom-switch-input', 'id' => 'switch-reg-email-confirm']) !!}
                    <span class="custom-switch-indicator"></span>
                </label>
                <div class="ml-3 d-flex flex-column">
                    <label class="mb-0">@lang('app.email_confirmation')</label>
                    <small class="text-muted">
                        @lang('app.require_email_confirmation')
                    </small>
                </div>
            </div>
        </div>
        
        <div class="form-group my-4">
            <div class="d-flex align-items-center">
                <label for="switch-reg-phone-confirm" class="control-label">
                    <input type="hidden" value="0" name="reg_phone_confirmation">
                    {!! Form::checkbox('reg_phone_confirmation', 1, setting('reg_phone_confirmation'), ['class' => 'custom-switch-input', 'id' => 'switch-reg-phone-confirm']) !!}
                    <span class="custom-switch-indicator"></span>
                </label>
                <div class="ml-3 d-flex flex-column">
                    <label class="mb-0">@lang('app.phone_confirmation')</label>
                    <small class="text-muted">
                        @lang('app.require_phone_confirmation')
                    </small>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            @lang('app.update_settings')
        </button>
        {!! Form::close() !!}
    </div>
</div>