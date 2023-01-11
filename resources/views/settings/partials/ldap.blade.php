<div class="card">
    <div class="card-body">
        <h5 class="card-title">@lang('app.authentication_ldap')</h5>

        {!! Form::open(['route' => 'settings.auth.update', 'id' => 'auth-ldap-settings-form']) !!}

        <div class="form-group my-4">
            <div class="d-flex align-items-center">
                <label for="switch-ldap" class="control-label">
                    <input type="hidden" value="0" name="ldap_enabled">
                    {!! Form::checkbox('ldap_enabled', 1, setting('ldap_enabled'), ['class' => 'custom-switch-input', 'id' => 'switch-ldap']) !!}
                    <span class="custom-switch-indicator"></span>
                </label>
                <div class="ml-3 d-flex flex-column">
                    <label class="mb-0">@lang('app.ldap_authentication')</label>
                    <small class="text-muted">
                        @lang('app.should_the_system_using_ldap_for_authentication')
                    </small>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <label for="switch-ldap" class="control-label">
                    <input type="hidden" value="0" name="ldap_create_user">
                    {!! Form::checkbox('ldap_create_user', 1, setting('ldap_create_user'), ['class' => 'custom-switch-input', 'id' => 'switch-ldap-user']) !!}
                    <span class="custom-switch-indicator"></span>
                </label>
                <div class="ml-3 d-flex flex-column">
                    <label class="mb-0">@lang('app.ldap_create_user')</label>
                    <small class="text-muted">
                        @lang('app.should_the_system_create_user_after_ldap_login')
                    </small>
                </div>
            </div>
        </div>

        @if (! config('ldap.host'))
            <div class="alert alert-warning">
                @lang('app.in_order_to_enable_ldap'),
                @lang('app.and_update_your') <code>LDAP_HOST</code>, <code>LDAP_PORT</code>, <code>LDAP_ORG</code>, <code>LDAP_ADMIN_USER</code>, <code>LDAP_ADMIN_PASS</code>, <code>LDAP_ADMIN_ORG</code>  @lang('app.environment_variable_inside') <code>.env</code> @lang('app.file').
            </div>
        @endif

        <button type="submit" class="btn btn-primary">
            @lang('app.update_settings')
        </button>

        {!! Form::close() !!}
    </div>
</div>