@extends('template')
@include('navtop')
{{-- @include('layouts.searchnav') --}}

@section('content')

<ul class="collection">
	@foreach($vouchers as $v)
	<li class="collection-item">
		{{$v->email}}
	</li>
	@endforeach
</ul>
@endsection