@extends('layouts.admin-master')

@section('page-title', trans('app.general_settings'))
@section('page-heading', trans('app.general_settings'))

@section('breadcrumbs')
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item">
            <a href="{{ route('settings.general') }}">@lang('app.settings')</a>
        </div>
        <div class="breadcrumb-item active">
            @lang('app.general')
        </div>
    </div>
@stop

@section('content')

@include('partials.messages')

{!! Form::open(['route' => 'settings.general.update', 'id' => 'general-settings-form']) !!}

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="app_name"
                    text-white name="app_name" value="{{ setting('app_name') }}">
                </div>
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">
    @lang('app.update_settings')
</button>

{{ Form::close() }}
@stop