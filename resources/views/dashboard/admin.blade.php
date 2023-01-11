@extends('layouts.admin-master')

@section('page-title', trans('app.dashboard'))
@section('page-heading', trans('app.dashboard'))

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>@lang('app.total_users')</h4>
                </div>
                <div class="card-body">
                    {{ number_format($stats['total']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>@lang('app.new_users_this_month')</h4>
                </div>
                <div class="card-body">
                    {{ number_format($stats['new']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>@lang('app.unconfirmed_users')</h4>
                </div>
                <div class="card-body">
                    {{ number_format($stats['unconfirmed']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-user-lock"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>@lang('app.banned_users')</h4>
                </div>
                <div class="card-body">
                    {{ number_format($stats['banned']) }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>@lang('app.registration_history')</h5>
            </div>
            <div class="card-body">
                <div class="pt-4 px-3">
                    <canvas id="myChart" height="365"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>@lang('app.latest_registrations')</h5>
            </div>
            <div class="card-body">
                @if (count($latestRegistrations))
                    <ul class="list-group list-group-flush">
                        @foreach ($latestRegistrations as $user)
                            <li class="list-group-item list-group-item-action">
                                <a href="{{ route('user.show', $user->id) }}" class="d-flex text-dark no-decoration">
                                    <img class="rounded-circle" width="40" height="40" src="{{ $user->present()->avatar }}">
                                    <div class="ml-2" style="line-height: 1.2;">
                                        <span class="d-block p-0">{{ $user->present()->nameOrEmail }}</span>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">@lang('app.no_records_found')</p>
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script>
        var users = {!! json_encode(array_values($usersPerMonth)) !!};
        var months = {!! json_encode(array_keys($usersPerMonth)) !!};
        var trans = {
            chartLabel: "{{ trans('app.registration_history')  }}",
            new: "{{ trans('app.new_sm') }}",
            user: "{{ trans('app.user_sm') }}",
            users: "{{ trans('app.users_sm') }}"
        };
    </script>
    {!! HTML::script('assets/js/chart.min.js') !!}
    {!! HTML::script('assets/js/as/dashboard-admin.js') !!}
@stop