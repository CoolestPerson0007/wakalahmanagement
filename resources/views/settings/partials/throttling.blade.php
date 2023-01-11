<div class="card">
    <div class="card-body">
        <h5 class="card-title">@lang('app.authentication_throttling')</h5>

        {!! Form::open(['route' => 'settings.auth.update', 'id' => 'auth-throttle-settings-form']) !!}

        <div class="form-group my-4">
            <div class="d-flex align-items-center">
                <label for="switch-throttle" class="control-label">
                    <input type="hidden" value="0" name="throttle_enabled">
                    {!! Form::checkbox('throttle_enabled', 1, setting('throttle_enabled'), ['class' => 'custom-switch-input', 'id' => 'switch-throttle']) !!}
                    <span class="custom-switch-indicator"></span>
                </label>
                <div class="ml-3 d-flex flex-column">
                    <label class="mb-0">@lang('app.throttle_authentication')</label>
                    <small class="text-muted">
                        @lang('app.should_the_system_throttle_authentication_requests')
                    </small>
                </div>
            </div>
        </div>

        <div class="form-group my-4">
            <label for="throttle_attempts">
                @lang('app.maximum_number_of_attempts') <br>
                <small class="text-muted">@lang('app.max_number_of_incorrect_login_attempts')</small>
            </label>
            <input type="text" name="throttle_attempts" class="form-control"
                   value="{{ setting('throttle_attempts', 10) }}">
        </div>

        <div class="form-group my-4">
            <label for="throttle_lockout_time">
                @lang('app.lockout_time') <br>
                <small class="text-muted">@lang('app.num_of_minutes_to_lock_the_user')</small>
            </label>
            <input type="text" name="throttle_lockout_time" class="form-control"
                   value="{{ setting('throttle_lockout_time', 1) }}">
        </div>

        <button type="submit" class="btn btn-primary">
            @lang('app.update_settings')
        </button>

        {!! Form::close() !!}
    </div>
</div>