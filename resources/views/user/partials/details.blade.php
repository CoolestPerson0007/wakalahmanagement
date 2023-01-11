<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">@lang('app.role')</label>
            {!! Form::select('role_id', $roles, $edit ? $user->role->id : '',
                ['class' => 'form-control', 'id' => 'role_id', $profile ? 'disabled' : '']) !!}
        </div>
        <div class="form-group">
            <label for="status">@lang('app.status')</label>
            {!! Form::select('status', $statuses, $edit ? $user->status : '',
                ['class' => 'form-control', 'id' => 'status', $profile ? 'disabled' : '']) !!}
        </div>
        <div class="form-group">
            <label for="first_name">@lang('app.first_name')</label>
            <input type="text" class="form-control" id="first_name"
                   name="first_name" placeholder="@lang('app.first_name')" value="{{ $edit ? $user->first_name : '' }}">
        </div>
        <div class="form-group">
            <label for="last_name">@lang('app.last_name')</label>
            <input type="text" class="form-control" id="last_name"
                   name="last_name" placeholder="@lang('app.last_name')" value="{{ $edit ? $user->last_name : '' }}">
        </div>
        <div class="form-group">
            <label for="email">@lang('app.email')</label>
            <input type="text" class="form-control" id="email"
                   name="email" placeholder="@lang('app.email')" value="{{ $edit ? $user->email : '' }}">
        </div>
        <div class="form-group">
            <label for="ic_number">IC Number</label>
            <input type="text" class="form-control" id="ic_number"
                   name="ic_number" placeholder="IC Number" value="{{ $edit ? $user->ic_number : '' }}">
        </div>
 
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="birthday">@lang('app.date_of_birth')</label>
            <div class="form-group">
                <input type="text"
                       name="birthday"
                       id='birthday'
                       value="{{ $edit && $user->birthday ? $user->present()->birthday : '' }}"
                       class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label for="phone">@lang('app.phone')</label>
            <input type="text" class="form-control" id="phone"
                   name="phone" placeholder="@lang('app.phone')" value="{{ $edit ? $user->phone : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('app.address')</label>
            <input type="text" class="form-control" id="address"
                   name="address" placeholder="@lang('app.address')" value="{{ $edit ? $user->address : '' }}">
        </div>
        
         
        <div class="form-group">
            <label for="bank_account">Bank Account</label>
            <input type="text" class="form-control" id="bank_account"
                   name="bank_account" placeholder="Bank Account" value="{{ $edit ? $user->bank_account : '' }}">
        </div>
        <div class="form-group">
            <label for="bank_name">Bank Name</label>
            <input type="text" class="form-control" id="bank_name"
                   name="bank_name" placeholder="Bank Name" value="{{ $edit ? $user->bank_name : '' }}">
        </div>
    </div>

    @if ($edit)
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                @lang('app.update_details')
            </button>
        </div>
    @endif
</div>
