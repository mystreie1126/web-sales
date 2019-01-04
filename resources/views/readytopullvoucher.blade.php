@extends('template')

{{-- @include('layouts.searchnav') --}}

@section('content')

@if(count($vouchers) == 0)

<p class="cyan-text">this customer doesn't has any voucher available from his/her online accoount</p>

@else
<ul class="collection">
	@foreach($vouchers as $v)
	<li class="collection-item">
		<p class="flow-text">
			<span class="cyan-text">Firstname:</span>
			{{$v->firstname}}
		</p>

		<p class="flow-text">
			<span class="cyan-text">lastname:</span>
			{{$v->lastname}}
		</p>

		<p class="flow-text">
			<span class="cyan-text">Email:</span>
			{{$v->email}}
		</p>

		<p class="flow-text">
			<span class="orange-text">Total Reduction Value:</span>
			{{$v->credits}}
		</p>

		<form action="{{route('pull_from_online')}}" method="POST">
			<input type="hidden" value="{{$v->id_customer}}" name="id_customer">
			<input type="hidden" value="{{$v->firstname}}" name="firstname">
			<input type="hidden" value="{{$v->lastname}}" name="lastname">
			<input type="hidden" value="{{$v->email}}" name="email">
			<input type="hidden" value="{{$v->credits}}" name="credits">
			<input type="submit" value="Pull the Voucher"  class="btn">
			{{csrf_field()}}
		</form>
	</li>
	@endforeach
</ul>

@endif
@endsection