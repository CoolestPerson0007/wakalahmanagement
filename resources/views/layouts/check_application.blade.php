@extends('layouts.admin-master')
@section('content')
@include('partials.messages')
<head>
<style>
h1 {text-align: center;
    color: #000000;}
</style>
</head>
<h1 class="bg-corporate">Check Application</h1>
<table class="table bg-corporate">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Wakalah type</th>
            <th scope="col">State</th>
            <th scope="col">Submitted at</th>
            <th scope="col">Status</th>
            <th scope="col">View application</th>
            
            
        </tr>
    </thead>
    <tbody>
        @forelse($wakalahApplication as $item)

        <tr>
            <th scope="row"> {!! $item->id !!}</th>
            <td>
                {!! $item->first_name !!} {!! $item->last_name !!}
            </td>
            <td>
                {!! $item->wakalah_type !!}
            </td>
            <td>
                {!! $item->state !!}
            </td>
            <td>
                {!! $item->created_at !!}
            </td>
            <td>
            
            
            <div class="badge badge-{!! $item->status->status_color !!}">{!! $item->status->display_name !!}</div>
            
            
            </td>
            <td style="width:20%">
                <a href="{{ route('va',$item->id) }}" type="button" class="btn btn-info">View application</a>
            </td>

        </tr>
        @empty
        @endforelse
        
    </tbody>
    
</table>
{{ $wakalahApplication->links() }}
@stop