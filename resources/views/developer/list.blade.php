@extends('layouts.admin-master')

@section('page-title', trans('app.developer_tool'))
@section('page-heading', trans('app.developer_tool'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('app.developer_tool')
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        @lang('app.optimize')<br />
                        <small class="pt-0 text-muted">
                            @lang('app.optimize_desc')
                        </small>
                    </h5>

                    <a href="{{ route('developer.optimize') }}" class="btn btn-primary">
                       @lang('app.artisan_optimize')
                    </a>
                </div>
            </div>            
        </div>        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">
                        @lang('app.migration')<br />
                        <small class="pt-0 text-muted">
                            @lang('app.migration_desc')
                        </small>
                    </h5>

                    <div class="table-responsive bg-corporate" id="migration-table-wrapper">
                        @if (count($unique))
                        <table class="table table-borderless table-striped">
                            <thead>
                            <tr>
                                <th>@lang('app.migration_file')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($unique as $row)
                                <tr>
                                    <td class="align-middle">{{ $row }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <a href="{{ route('developer.migrate') }}" class="btn btn-primary">
                           @lang('app.artisan_migrate')
                        </a>
                        @else
                        <a href="{{ route('developer.rollback') }}" onclick="return confirm('Are you sure to do migration roleback?')" class="btn btn-outline-danger">
                           @lang('app.artisan_migrate_rollback')
                        </a>
                        <br />
                        <small class="pt-0 text-danger">
                            @lang('app.artisan_warning')
                        </small>     
                        @endif
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
@stop