@extends('template')

@include('navtop')
@section('content')

<form method="post">
	@foreach($customer_details as $detail)
		<ul class="collection">
			<li class="collection-item">
				<p class="flow-text"><span class="cyan-text">Customer firstname: </span>{{$detail->firstname}}</p>
				<p class="flow-text"><span class="cyan-text">Customer lastname: </span>{{$detail->lastname}}</p>
				<p class="flow-text"><span class="cyan-text">Customer Email: </span>{{$detail->email}}</p>
				<p class="flow-text"><span class="cyan-text">Order Reference: </span>{{$reference}}</p>
				<p class="flow-text"><span class="cyan-text">Product: </span>{{$product_name}}</p>
				<p class="flow-text"><span class="cyan-text">Has Rewards: </span>{{$credits}} euro</p>
				<input type="show" value="{{$id_order}}" name="id_order">
				<input type="show" value="{{$id_customer}}" name="id_customer">
				<input type="show" value="{{$credits}}" name="credits">
				<input type="show" value="{{$detail->firstname}}" name="firstname">
				<input type="show" value="{{$detail->lastname}}" name="lastname">
				<input type="show" value="{{$detail->email}}" name="email">
			</li>
		</ul>
		<div class="button-rewards">

			
			@if(Auth::User()->user_type == 2)
				<input type="submit" value="Generate rewards on Rockpos" class="btn waves-effect red" formaction="{{route('pos_reward')}}" onclick="return confirm('Are you sure to use rewards on rockpos?')">
			@else
				<input type="submit" value="Generate rewards on Website" class="btn waves-effect waves-light" formaction="{{route('online_reward')}}" onclick="return confirm('Are you sure you want to generate rewards on Funtech.ie?')" >
			@endif
		</div>

		{{csrf_field()}}
	@endforeach


</form>

@endsection