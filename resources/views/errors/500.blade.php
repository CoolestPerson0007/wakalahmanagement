@extends('layouts.errors')

@section('title', 'Whoops, something went wrong...')

@section('content')
	<div class="page-inner">
		<h1>Sorry!</h1>
		<div class="page-description">
			Something went wrong and we could not proceed... <br /> Please try again or contact website owner.<br />
			(Code: 500)
		</div>
	</div>
@stop